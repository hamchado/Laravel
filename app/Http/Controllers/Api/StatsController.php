<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CaseGrant;
use App\Models\DentalCase;
use App\Models\Patient;
use App\Models\Reservation;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $completedCases = DentalCase::where('user_id', $user->id)
            ->where('status', 'accepted')
            ->count();

        $pendingCases = DentalCase::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $rejectedCases = DentalCase::where('user_id', $user->id)
            ->where('status', 'rejected')
            ->count();

        $treatedPatients = Patient::whereHas('cases', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->count();

        $activeReservations = Reservation::where('user_id', $user->id)
            ->whereIn('status', ['temporary', 'confirmed'])
            ->count();

        $totalGrants = CaseGrant::where('granter_id', $user->id)->count();
        $receivedGrants = CaseGrant::where('grantee_id', $user->id)
            ->where('status', 'accepted')
            ->count();

        return response()->json([
            'success' => true,
            'stats' => [
                'completed_cases' => $completedCases,
                'pending_cases' => $pendingCases,
                'rejected_cases' => $rejectedCases,
                'treated_patients' => $treatedPatients,
                'active_reservations' => $activeReservations,
                'total_grants' => $totalGrants,
                'received_grants' => $receivedGrants,
            ],
        ]);
    }
}
