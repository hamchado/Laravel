<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\PanoramaImage;
use App\Models\Patient;
use Illuminate\Http\Request;

class PanoramaController extends Controller
{
    public function index(Patient $patient)
    {
        $panoramas = $patient->panoramaImages()
            ->with('uploader:id,name')
            ->orderByDesc('taken_at')
            ->get();

        return response()->json([
            'success' => true,
            'panoramas' => $panoramas,
        ]);
    }

    public function store(Patient $patient, Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:20480',
            'notes' => 'nullable|string|max:500',
            'taken_at' => 'nullable|date',
        ]);

        $path = $request->file('image')->store('panorama-images', 'public');

        $panorama = PanoramaImage::create([
            'patient_id' => $patient->id,
            'uploaded_by' => $request->user()->id,
            'path' => $path,
            'notes' => $request->notes,
            'taken_at' => $request->taken_at ?? now()->toDateString(),
        ]);

        AuditLog::log('panorama_uploaded', 'PanoramaImage', $panorama->id);

        return response()->json([
            'success' => true,
            'message' => 'تم رفع صورة البانوراما بنجاح',
            'panorama' => $panorama->load('uploader:id,name'),
        ]);
    }
}
