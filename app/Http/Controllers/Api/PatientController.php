<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\PatientHealth;
use App\Models\PatientPerio;
use App\Models\PatientTooth;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Patient::with(['teeth', 'perio', 'health', 'addedBy:id,name,student_id',
            'reservations' => function ($q) {
                $q->whereIn('status', ['temporary', 'confirmed'])
                    ->select('id', 'patient_id', 'user_id', 'course_id', 'status', 'confirmed_at', 'expires_at', 'created_at');
            }]);

        // Filter by access type
        if ($request->filter === 'private') {
            $query->where('access_type', 'private')->where('added_by', $user->id);
        } elseif ($request->filter === 'public') {
            $query->where('access_type', 'public');
        } else {
            // Show all: private (own) + public + custom (shared with user)
            $query->where(function ($q) use ($user) {
                $q->where('added_by', $user->id)
                    ->orWhere('access_type', 'public')
                    ->orWhereHas('accessUsers', fn($q2) => $q2->where('users.id', $user->id));
            });
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('record_number', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->course_id) {
            $query->whereHas('reservations', function ($q) use ($request) {
                $q->where('course_id', $request->course_id)->where('status', 'confirmed');
            });
        }

        $patients = $query->orderByDesc('created_at')->get();

        // Mark patients that are reserved by others
        $patients->each(function ($patient) use ($user) {
            $patient->is_reserved = $patient->reservations->where('user_id', '!=', $user->id)->isNotEmpty();
        });

        return response()->json([
            'success' => true,
            'patients' => $patients,
            'counts' => [
                'all' => $patients->count(),
                'private' => $patients->where('access_type', 'private')->where('added_by', $user->id)->count(),
                'public' => $patients->where('access_type', 'public')->count(),
            ],
        ]);
    }

    public function show(Patient $patient)
    {
        $patient->load(['teeth', 'perio', 'health', 'addedBy:id,name,student_id',
            'panoramaImages' => fn($q) => $q->with('uploader:id,name')->orderByDesc('taken_at'),
            'reservations' => function ($q) {
                $q->whereIn('status', ['temporary', 'confirmed'])
                    ->select('id', 'patient_id', 'user_id', 'course_id', 'status', 'confirmed_at', 'expires_at', 'created_at');
            }]);
        return response()->json(['success' => true, 'patient' => $patient]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'birth_year' => 'required|integer|min:1900|max:' . date('Y'),
            'gender' => 'required|in:male,female',
            'age_type' => 'required|in:adult,child',
            'access_type' => 'required|in:private,public,custom',
            'phone' => 'nullable|string|max:20',
            'governorate' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:2000',
            'parent_name' => 'required_if:age_type,child|nullable|string|max:255',
            'parent_phone' => 'required_if:age_type,child|nullable|string|max:20',
            'teeth' => 'nullable|array',
            'teeth.*.tooth_number' => 'required|integer',
            'teeth.*.condition' => 'required|string',
            'perio' => 'nullable|array',
            'health' => 'nullable|array',
            'access_students' => 'nullable|array',
        ]);

        $age = date('Y') - $request->birth_year;

        $patient = Patient::create([
            'record_number' => Patient::generateRecordNumber(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'birth_year' => $request->birth_year,
            'age' => $age,
            'gender' => $request->gender,
            'age_type' => $request->age_type,
            'access_type' => $request->access_type,
            'governorate' => $request->governorate,
            'address' => $request->address,
            'notes' => $request->notes,
            'parent_name' => $request->parent_name,
            'parent_phone' => $request->parent_phone,
            'parent_birth_year' => $request->parent_birth_year,
            'added_by' => $request->user()->id,
        ]);

        // Save teeth data
        if ($request->teeth) {
            foreach ($request->teeth as $tooth) {
                PatientTooth::create([
                    'patient_id' => $patient->id,
                    'tooth_number' => $tooth['tooth_number'],
                    'condition' => $tooth['condition'],
                    'sub_condition' => $tooth['sub_condition'] ?? null,
                    'label' => $tooth['label'] ?? null,
                    'is_primary' => $tooth['is_primary'] ?? false,
                ]);
            }
        }

        // Save periodontal data
        if ($request->perio) {
            foreach ($request->perio as $data) {
                PatientPerio::create([
                    'patient_id' => $patient->id,
                    'segment' => $data['segment'],
                    'grade' => $data['grade'],
                    'pockets' => $data['pockets'] ?? [],
                ]);
            }
        }

        // Save health data
        if ($request->health) {
            PatientHealth::create([
                'patient_id' => $patient->id,
                'diseases' => $request->health['diseases'] ?? [],
                'diabetes_controlled' => $request->health['diabetes_controlled'] ?? null,
                'bp_controlled' => $request->health['bp_controlled'] ?? null,
            ]);
        }

        // Save access permissions
        if ($request->access_type === 'custom' && $request->access_students) {
            $userIds = \App\Models\User::whereIn('student_id', $request->access_students)->pluck('id');
            $patient->accessUsers()->sync($userIds);
        }

        $patient->load(['teeth', 'perio', 'health']);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المريض بنجاح',
            'patient' => $patient,
        ], 201);
    }
}
