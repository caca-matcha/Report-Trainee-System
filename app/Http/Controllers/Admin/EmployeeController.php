<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Helpers\ImageHelper;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'trainee');

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('npk', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('subco')) {
            $query->where('subco', $request->get('subco'));
        }

        if ($request->filled('department')) {
            $query->where('department', $request->get('department'));
        }

        if ($request->filled('status')) {
            $query->where('employee_status', $request->get('status'));
        }

        $employees = $query->latest()->paginate(15)->withQueryString();
        $subcos = User::where('role', 'trainee')->whereNotNull('subco')->distinct()->pluck('subco');
        $departments = User::where('role', 'trainee')->whereNotNull('department')->distinct()->pluck('department');
        $statuses = User::where('role', 'trainee')->whereNotNull('employee_status')->distinct()->pluck('employee_status');
        $totalUsers = User::count();

        return view('admin.employees.index', compact('employees', 'subcos', 'departments', 'statuses', 'totalUsers'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'npk' => 'required|string|max:20|unique:users,npk',
            'email' => 'nullable|string|max:255|unique:users,email',
            'department' => 'nullable|string|max:255',
            'subco' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $path = ImageHelper::compressAndStore($request->file('photo'), 'photos');
            $validated['photo'] = $path ?: $request->file('photo')->store('photos', 'public');
        }

        $validated['role'] = 'trainee';
        $validated['employee_status'] = 'active';
        $validated['password'] = Hash::make('password'); // Default password

        User::create($validated);

        return redirect()->route('admin.employees.index')->with('success', 'Trainee berhasil ditambahkan.');
    }

    public function edit(User $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, User $employee)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'npk' => ['required', 'string', 'max:20', Rule::unique('users')->ignore($employee->id)],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($employee->id)],
            'department' => 'nullable|string|max:255',
            'subco' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($employee->photo) {
                Storage::disk('public')->delete($employee->photo);
            }
            $path = ImageHelper::compressAndStore($request->file('photo'), 'photos');
            $validated['photo'] = $path ?: $request->file('photo')->store('photos', 'public');
        }

        $employee->update($validated);

        return redirect()->route('admin.employees.index')->with('success', 'Data trainee berhasil diperbarui.');
    }

    public function bulkPhotoStore(Request $request)
    {
        $request->validate([
            'photos.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!$request->hasFile('photos')) {
            return back()->with('error', 'Tidak ada foto yang dipilih.');
        }

        $successCount = 0;
        $failCount = 0;
        $failedNames = [];

        foreach ($request->file('photos') as $file) {
            $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            // NPK is the filename. We look for trainee with this NPK
            $employee = User::where('role', 'trainee')
                ->where(function ($q) use ($filename) {
                    $q->where('npk', $filename)
                        ->orWhere('email', $filename); // Fallback if NPK is still in email col
                })->first();

            if ($employee) {
                // Delete old photo
                if ($employee->photo) {
                    Storage::disk('public')->delete($employee->photo);
                }

                $path = ImageHelper::compressAndStore($file, 'photos');
                $employee->update(['photo' => $path ?: $file->store('photos', 'public')]);
                $successCount++;
            } else {
                $failCount++;
                $failedNames[] = $filename;
            }
        }

        $message = "Berhasil mengupdate $successCount foto.";
        if ($failCount > 0) {
            $message .= " Gagal mencocokkan $failCount file: " . implode(', ', $failedNames);
        }

        return redirect()->route('admin.employees.index')->with($failCount > 0 ? 'warning' : 'success', $message);
    }

    public function destroy(User $employee)
    {
        if ($employee->photo) {
            Storage::disk('public')->delete($employee->photo);
        }
        $employee->delete();

        return redirect()->route('admin.employees.index')->with('success', 'User trainee berhasil dihapus.');
    }
}
