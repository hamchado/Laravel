<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();
        $user->load('role', 'courses');

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'student_id' => $user->student_id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role->name,
                'role_label' => $user->role->label,
                'courses' => $user->courses->map(fn($c) => [
                    'id' => $c->id,
                    'name' => $c->name,
                    'code' => $c->code,
                ]),
                'created_at' => $user->created_at->format('Y-m-d'),
            ],
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'كلمة المرور الحالية غير صحيحة',
            ], 422);
        }

        // Use forceFill to bypass the 'hashed' cast issue with update
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        AuditLog::log('password_changed', 'User', $user->id);

        return response()->json([
            'success' => true,
            'message' => 'تم تغيير كلمة المرور بنجاح',
        ]);
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
        ]);

        $user = $request->user();
        $user->update(['phone' => $request->phone]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث رقم الهاتف',
        ]);
    }
}
