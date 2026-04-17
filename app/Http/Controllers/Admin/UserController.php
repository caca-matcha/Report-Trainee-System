<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->where('role', 'admin')
            ->where('department', 'Learning & Development');

        if ($request->filled('q')) {
            $search = $request->get('q');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('npk', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->get('role'));
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'npk' => 'nullable|string|max:20|unique:users,npk',
            'email' => 'nullable|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin',
            'department' => 'nullable|string|max:255',
            'subco' => 'nullable|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'npk' => ['nullable', 'string', 'max:20', Rule::unique('users')->ignore($user->id)],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|in:admin',
            'department' => 'nullable|string|max:255',
            'subco' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'signature' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:6144',
        ]);

        if ($request->hasFile('signature')) {
            // Delete old signature if exists
            if ($user->signature && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->signature)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->signature);
            }
            $path = $request->file('signature')->store('signatures', 'public');
            $validated['signature'] = $path;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function quickAddAdmin(Request $request)
    {
        $request->validate(['npk' => 'required|string']);
        
        $user = User::where('npk', $request->npk)->first();
        
        if (!$user) {
            return back()->with('error', 'User dengan NPK tersebut tidak ditemukan di database.');
        }

        if ($user->role !== 'trainee' && $user->role !== null) {
            return back()->with('info', 'User tersebut sudah memiliki hak akses ' . $user->role . '.');
        }

        // Promote to admin
        $user->update([
            'role' => 'admin',
            'password' => $user->password ?: Hash::make('password123') // Ensure password exists
        ]);

        return redirect()->route('admin.users.index')->with('success', "{$user->name} berhasil ditambahkan sebagai Admin.");
    }
}
