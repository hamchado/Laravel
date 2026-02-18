<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\CaseEvaluation;
use App\Models\DentalCase;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function store(DentalCase $case, Request $request)
    {
        $request->validate([
            'stage' => 'required|integer|min:1|max:10',
            'stage_name' => 'nullable|string|max:255',
            'grade' => 'required|string|max:50',
            'notes' => 'nullable|string|max:2000',
        ]);

        $user = $request->user();

        // Only supervisors can evaluate
        if (!$user->isSupervisor() && !$user->isAyham()) {
            return response()->json(['success' => false, 'message' => 'غير مصرح لك بالتقييم'], 403);
        }

        // Check if this stage already evaluated
        $existing = CaseEvaluation::where('case_id', $case->id)
            ->where('stage', $request->stage)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'تم تقييم هذه المرحلة مسبقاً',
            ], 422);
        }

        $evaluation = CaseEvaluation::create([
            'case_id' => $case->id,
            'evaluator_id' => $user->id,
            'stage' => $request->stage,
            'stage_name' => $request->stage_name,
            'grade' => $request->grade,
            'notes' => $request->notes,
            'evaluated_at' => now(),
        ]);

        // Update case evaluation count
        $case->increment('evaluation_count');
        $case->refresh();

        // First evaluation: move from pending to accepted (in_progress)
        if ($case->status === 'pending') {
            $case->update(['status' => 'accepted']);
        }

        // Get total required stages from course evaluation stages or course work
        $totalStages = $case->course->evaluationStages()->count();
        if ($totalStages === 0) {
            $totalStages = 3; // default
        }

        // If all stages evaluated, mark case as completed
        if ($case->evaluation_count >= $totalStages) {
            $case->update([
                'status' => 'completed',
                'evaluated_at' => now(),
                'evaluated_by' => $user->id,
            ]);
        }

        AuditLog::log('evaluation_created', 'CaseEvaluation', $evaluation->id);

        return response()->json([
            'success' => true,
            'message' => 'تم حفظ التقييم بنجاح',
            'evaluation' => $evaluation->load('evaluator:id,name'),
            'case_status' => $case->fresh()->status,
            'evaluation_count' => $case->evaluation_count,
            'total_stages' => $totalStages,
        ]);
    }

    public function index(DentalCase $case)
    {
        $evaluations = $case->evaluations()->with('evaluator:id,name')->get();

        return response()->json([
            'success' => true,
            'evaluations' => $evaluations,
            'case_status' => $case->status,
        ]);
    }

    /**
     * Supervisor: lookup case from QR data (decode only, no evaluation)
     */
    public function lookupQr(Request $request)
    {
        $request->validate(['qr_data' => 'required|string']);

        $decoded = json_decode(base64_decode($request->qr_data), true);
        if (!$decoded || !isset($decoded['case_id'])) {
            return response()->json(['success' => false, 'message' => 'رمز QR غير صالح'], 422);
        }

        $case = DentalCase::with(['patient', 'course.evaluationStages', 'evaluations.evaluator:id,name', 'user:id,name,student_id'])
            ->findOrFail($decoded['case_id']);

        return response()->json([
            'success' => true,
            'case' => $case,
        ]);
    }

    /**
     * Supervisor: evaluate case from QR scan
     */
    public function evaluateFromQr(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string',
            'stage' => 'required|integer|min:1|max:10',
            'stage_name' => 'nullable|string|max:255',
            'grade' => 'required|string|max:50',
            'notes' => 'nullable|string|max:2000',
        ]);

        // Decode QR data
        $decoded = json_decode(base64_decode($request->qr_data), true);
        if (!$decoded || !isset($decoded['case_id'])) {
            return response()->json(['success' => false, 'message' => 'رمز QR غير صالح'], 422);
        }

        $case = DentalCase::findOrFail($decoded['case_id']);

        // Delegate to store method
        $request->merge(['case' => $case->id]);
        return $this->store($case, $request);
    }
}
