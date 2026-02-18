<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaseImage;
use App\Models\Course;
use App\Models\DentalCase;
use Illuminate\Http\Request;

class CaseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = DentalCase::with([
            'patient:id,full_name,record_number',
            'course:id,code,name',
            'reservation:id,status',
            'evaluations',
            'grant',
            'images',
        ]);

        // Supervisors see all cases for their courses, students see their own
        if ($user->isSupervisor()) {
            if ($request->course_id) {
                $query->where('course_id', $request->course_id);
            }
            if ($request->student_id) {
                $query->whereHas('user', fn($q) => $q->where('student_id', $request->student_id));
            }
        } else {
            $query->where('user_id', $user->id);
        }

        if ($request->course_id && !$user->isSupervisor()) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $cases = $query->orderByDesc('created_at')->get();

        return response()->json([
            'success' => true,
            'cases' => $cases,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'course_id' => 'required|exists:courses,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'tooth_number' => 'nullable|integer',
            'treatment_type' => 'nullable|string|max:100',
            'treatment_label' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:2000',
        ]);

        $user = $request->user();
        $course = Course::with('rule')->findOrFail($request->course_id);
        $today = now()->toDateString();

        // Check session limit (non-grant cases only)
        $sessionLimit = $course->getSessionLimit();
        $todayCases = DentalCase::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('is_grant', false)
            ->whereDate('session_date', $today)
            ->count();

        if ($todayCases >= $sessionLimit) {
            return response()->json([
                'success' => false,
                'message' => "تم الوصول لحد الجلسة ({$sessionLimit} حالات). يمكنك استخدام المنح.",
                'limit_reached' => true,
            ], 422);
        }

        // Check tooth duplication
        if ($request->tooth_number && ($course->rule?->prevent_duplicate_tooth ?? true)) {
            $duplicate = DentalCase::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('tooth_number', $request->tooth_number)
                ->where('treatment_type', $request->treatment_type)
                ->whereNotIn('status', ['rejected'])
                ->exists();

            if ($duplicate) {
                return response()->json([
                    'success' => false,
                    'message' => 'هذا السن مسجل مسبقاً بنفس نوع المعالجة',
                ], 422);
            }
        }

        $case = DentalCase::create([
            'patient_id' => $request->patient_id,
            'user_id' => $user->id,
            'course_id' => $course->id,
            'reservation_id' => $request->reservation_id,
            'tooth_number' => $request->tooth_number,
            'treatment_type' => $request->treatment_type,
            'treatment_label' => $request->treatment_label,
            'description' => $request->description,
            'status' => 'pending',
            'is_grant' => false,
            'session_date' => $today,
        ]);

        $case->load(['patient:id,full_name,record_number', 'course:id,code,name']);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الحالة بنجاح',
            'case' => $case,
        ], 201);
    }

    public function show(DentalCase $case)
    {
        $case->load(['patient', 'course.evaluationStages', 'images', 'evaluations.evaluator:id,name', 'grant', 'user:id,name,student_id']);
        return response()->json(['success' => true, 'case' => $case]);
    }

    public function qr(DentalCase $case, Request $request)
    {
        $case->load(['patient', 'course', 'user']);

        $data = [
            'case_id' => $case->id,
            'patient' => $case->patient->full_name,
            'record' => $case->patient->record_number,
            'course' => $case->course->name,
            'course_id' => $case->course->id,
            'treatment' => $case->treatment_label,
            'tooth' => $case->tooth_number,
            'status' => $case->status,
            'evaluation_count' => $case->evaluation_count,
            'date' => $case->created_at->format('Y-m-d'),
            'student' => $case->user->name,
            'student_id' => $case->user->student_id,
        ];

        $encoded = base64_encode(json_encode($data, JSON_UNESCAPED_UNICODE));

        return response()->json([
            'success' => true,
            'qr_data' => $encoded,
            'case_info' => $data,
        ]);
    }

    /**
     * Check session limit status for a course
     */
    public function sessionStatus(Request $request)
    {
        $request->validate(['course_id' => 'required|exists:courses,id']);

        $user = $request->user();
        $course = Course::with('rule')->findOrFail($request->course_id);
        $today = now()->toDateString();

        $sessionLimit = $course->getSessionLimit();
        $todayCases = DentalCase::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('is_grant', false)
            ->whereDate('session_date', $today)
            ->count();

        return response()->json([
            'success' => true,
            'session_limit' => $sessionLimit,
            'used' => $todayCases,
            'remaining' => max(0, $sessionLimit - $todayCases),
            'limit_reached' => $todayCases >= $sessionLimit,
            'in_session' => $course->isInSession(),
        ]);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'case_id' => 'required|exists:cases,id',
            'image' => 'required|image|max:20480',
            'type' => 'nullable|in:before,after,xray',
        ]);

        $path = $request->file('image')->store('case-images', 'public');

        $image = CaseImage::create([
            'case_id' => $request->case_id,
            'path' => $path,
            'type' => $request->type,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم رفع الصورة بنجاح',
            'image' => $image,
        ]);
    }
}
