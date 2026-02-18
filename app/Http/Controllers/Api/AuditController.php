<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        // Only admins and ayham can view audit logs
        if (!$request->user()->isAdmin() && !$request->user()->isAyham()) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        $query = AuditLog::with('user:id,name,student_id')
            ->orderByDesc('created_at');

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->action) {
            $query->where('action', $request->action);
        }

        if ($request->model) {
            $query->where('model', $request->model);
        }

        $logs = $query->paginate($request->per_page ?? 50);

        return response()->json([
            'success' => true,
            'logs' => $logs,
        ]);
    }
}
