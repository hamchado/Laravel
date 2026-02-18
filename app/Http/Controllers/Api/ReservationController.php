<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\CancelReason;
use App\Models\Course;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Reservation::with([
            'patient:id,full_name,record_number,phone,age',
            'course:id,code,name,schedule,location',
        ])->where('user_id', $user->id);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $reservations = $query->orderByDesc('created_at')->get();

        // Expire temporary reservations that passed 24h
        $reservations->each(function ($r) {
            if ($r->isExpired()) {
                $r->update(['status' => 'cancelled', 'cancelled_at' => now()]);
                CancelReason::create([
                    'reservation_id' => $r->id,
                    'user_id' => $r->user_id,
                    'reason' => 'انتهاء مدة الحجز المؤقت (24 ساعة)',
                ]);
            }
        });

        // Re-fetch after expiration
        $reservations = Reservation::with([
            'patient:id,full_name,record_number,phone,age',
            'course:id,code,name,schedule,location',
            'cancelReason',
        ])
            ->where('user_id', $user->id)
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'reservations' => $reservations,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'course_id' => 'required|exists:courses,id',
        ]);

        $user = $request->user();
        $course = Course::findOrFail($request->course_id);

        // Check if already reserved by this user in this course
        $existing = Reservation::where('patient_id', $request->patient_id)
            ->where('user_id', $user->id)
            ->where('course_id', $request->course_id)
            ->whereIn('status', ['temporary', 'confirmed'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'هذا المريض محجوز لديك مسبقاً في هذا المقرر',
            ], 422);
        }

        // Check reservation limit
        $currentCount = $course->activeReservationsCount($user->id);
        if ($currentCount >= $course->max_reservations) {
            return response()->json([
                'success' => false,
                'message' => 'تم تجاوز السقف الأقصى للحجز في هذا المقرر',
            ], 422);
        }

        $reservation = Reservation::create([
            'patient_id' => $request->patient_id,
            'user_id' => $user->id,
            'course_id' => $request->course_id,
            'status' => 'temporary',
            'expires_at' => now()->addHours(24),
        ]);

        $reservation->load(['patient:id,full_name,record_number', 'course:id,code,name']);

        return response()->json([
            'success' => true,
            'message' => 'تم الحجز المؤقت بنجاح',
            'reservation' => $reservation,
        ], 201);
    }

    public function confirm(Reservation $reservation, Request $request)
    {
        $user = $request->user();

        if ($reservation->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        if ($reservation->status !== 'temporary') {
            return response()->json(['success' => false, 'message' => 'لا يمكن تثبيت هذا الحجز'], 422);
        }

        if ($reservation->isExpired()) {
            $reservation->update(['status' => 'cancelled', 'cancelled_at' => now()]);
            return response()->json(['success' => false, 'message' => 'انتهت صلاحية الحجز المؤقت'], 422);
        }

        $old = $reservation->toArray();
        $reservation->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
            'expires_at' => null,
        ]);

        AuditLog::log('confirmed', 'Reservation', $reservation->id, $old, $reservation->toArray());

        return response()->json([
            'success' => true,
            'message' => 'تم تثبيت الحجز بنجاح',
            'reservation' => $reservation->load(['patient:id,full_name,record_number', 'course:id,code,name']),
        ]);
    }

    public function cancel(Reservation $reservation, Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ]);

        $user = $request->user();

        if ($reservation->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح'], 403);
        }

        if ($reservation->status === 'cancelled') {
            return response()->json(['success' => false, 'message' => 'الحجز ملغى مسبقاً'], 422);
        }

        // Check if reservation has cases (cannot cancel confirmed with cases)
        if ($reservation->isConfirmed() && $reservation->hasCases()) {
            return response()->json([
                'success' => false,
                'message' => 'لا يمكن إلغاء حجز مثبت تمت إضافة حالات عليه',
            ], 422);
        }

        $old = $reservation->toArray();
        $reservation->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
        ]);

        CancelReason::create([
            'reservation_id' => $reservation->id,
            'user_id' => $user->id,
            'reason' => $request->reason,
        ]);

        AuditLog::log('cancelled', 'Reservation', $reservation->id, $old, $reservation->toArray());

        return response()->json([
            'success' => true,
            'message' => 'تم إلغاء الحجز بنجاح',
        ]);
    }
}
