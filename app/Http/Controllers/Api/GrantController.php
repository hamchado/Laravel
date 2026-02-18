<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\CaseGrant;
use App\Models\Course;
use App\Models\DentalCase;
use App\Models\User;
use Illuminate\Http\Request;

class GrantController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = CaseGrant::with([
            'dentalCase.patient:id,full_name,record_number',
            'dentalCase.course:id,code,name',
            'granter:id,name,student_id',
            'grantee:id,name,student_id',
        ]);

        if ($request->type === 'sent') {
            $query->where('granter_id', $user->id);
        } elseif ($request->type === 'received') {
            $query->where('grantee_id', $user->id);
        } else {
            $query->where(fn($q) => $q->where('granter_id', $user->id)->orWhere('grantee_id', $user->id));
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $grants = $query->orderByDesc('created_at')->get();

        return response()->json([
            'success' => true,
            'grants' => $grants,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'case_id' => 'required|exists:cases,id',
            'grantee_student_id' => 'required|string',
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = $request->user();
        $case = DentalCase::findOrFail($request->case_id);
        $course = Course::with('rule')->findOrFail($request->course_id);

        // Verify grant is allowed for this course
        if (!($course->rule?->allow_grants ?? true)) {
            return response()->json([
                'success' => false,
                'message' => 'المنح غير مسموح لهذا المقرر',
            ], 422);
        }

        // Verify case belongs to granter
        if ($case->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكنك منح حالة لا تملكها',
            ], 403);
        }

        // Find grantee
        $grantee = User::where('student_id', $request->grantee_student_id)->first();
        if (!$grantee) {
            return response()->json([
                'success' => false,
                'message' => 'الطالب غير موجود',
            ], 404);
        }

        // Can't grant to self
        if ($grantee->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكنك منح حالة لنفسك',
            ], 422);
        }

        // Verify grantee is enrolled in the course
        $enrolled = $grantee->courses()->where('courses.id', $course->id)->exists();
        if (!$enrolled) {
            return response()->json([
                'success' => false,
                'message' => 'الطالب غير مسجل في هذا المقرر',
            ], 422);
        }

        // Check if case already has a pending/accepted grant
        $existingGrant = CaseGrant::where('case_id', $case->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->exists();

        if ($existingGrant) {
            return response()->json([
                'success' => false,
                'message' => 'هذه الحالة لديها منح فعال مسبقاً',
            ], 422);
        }

        $grant = CaseGrant::create([
            'case_id' => $case->id,
            'granter_id' => $user->id,
            'grantee_id' => $grantee->id,
            'course_id' => $course->id,
            'status' => 'pending',
        ]);

        $case->update(['is_grant' => true]);

        AuditLog::log('grant_created', 'CaseGrant', $grant->id);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال المنح بنجاح',
            'grant' => $grant->load(['grantee:id,name,student_id']),
        ]);
    }

    public function accept(CaseGrant $grant, Request $request)
    {
        $user = $request->user();

        if ($grant->grantee_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        if (!$grant->isPending()) {
            return response()->json(['success' => false, 'message' => 'المنح ليس بانتظار الموافقة'], 422);
        }

        $grant->update([
            'status' => 'accepted',
            'responded_at' => now(),
        ]);

        // Transfer case ownership to grantee
        $grant->dentalCase->update([
            'user_id' => $user->id,
            'is_grant' => true,
            'session_date' => now()->toDateString(),
        ]);

        AuditLog::log('grant_accepted', 'CaseGrant', $grant->id);

        return response()->json([
            'success' => true,
            'message' => 'تم قبول المنح',
        ]);
    }

    public function reject(CaseGrant $grant, Request $request)
    {
        $user = $request->user();

        if ($grant->grantee_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        if (!$grant->isPending()) {
            return response()->json(['success' => false, 'message' => 'المنح ليس بانتظار الموافقة'], 422);
        }

        $grant->update([
            'status' => 'rejected',
            'responded_at' => now(),
        ]);

        // Return case to original owner
        $grant->dentalCase->update(['is_grant' => false]);

        AuditLog::log('grant_rejected', 'CaseGrant', $grant->id);

        return response()->json([
            'success' => true,
            'message' => 'تم رفض المنح',
        ]);
    }

    public function cancel(CaseGrant $grant, Request $request)
    {
        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $user = $request->user();

        // Only granter can cancel, and only before acceptance
        if ($grant->granter_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'فقط مانح الحالة يمكنه الإلغاء'], 403);
        }

        if (!$grant->canCancel()) {
            return response()->json(['success' => false, 'message' => 'لا يمكن إلغاء المنح بعد القبول'], 422);
        }

        $grant->update([
            'status' => 'cancelled',
            'cancel_reason' => $request->reason,
            'responded_at' => now(),
        ]);

        // Return case to normal
        $grant->dentalCase->update(['is_grant' => false]);

        AuditLog::log('grant_cancelled', 'CaseGrant', $grant->id);

        return response()->json([
            'success' => true,
            'message' => 'تم إلغاء المنح',
        ]);
    }
}
