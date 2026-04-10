<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Training;
use App\Models\TrainingAtmosphere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ImageHelper;

class TrainingAtmosphereController extends Controller
{
    public function store(Request $request, Training $training)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        $path = ImageHelper::compressAndStore($request->file('image'), 'training_atmospheres');
        $path = $path ?: $request->file('image')->store('training_atmospheres', 'public');

        $training->atmospheres()->create([
            'image_path' => $path,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Dokumentasi berhasil ditambahkan.');
    }

    public function destroy(TrainingAtmosphere $atmosphere)
    {
        Storage::disk('public')->delete($atmosphere->image_path);
        $atmosphere->delete();

        return back()->with('success', 'Dokumentasi berhasil dihapus.');
    }
}