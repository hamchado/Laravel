<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\DentalCase;
use App\Models\Reservation;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $courses = $user->courses()
            ->with(['works', 'schedules', 'rule', 'evaluationStages'])
            ->get();

        $courses->each(function ($course) use ($user) {
            $course->current_reserved = $course->activeReservationsCount($user->id);
            $course->in_session = $course->isInSession();
            $course->effective_session_limit = $course->getSessionLimit();
        });

        return response()->json([
            'success' => true,
            'courses' => $courses,
        ]);
    }

    public function works(Course $course, Request $request)
    {
        $user = $request->user();

        $courseWorks = $course->works;

        $confirmedPatients = Reservation::with('patient:id,full_name,record_number,phone,age')
            ->where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->where('status', 'confirmed')
            ->get()
            ->pluck('patient');

        $worksData = $courseWorks->map(function ($work) use ($user, $course) {
            $completed = DentalCase::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('treatment_label', $work->name)
                ->whereIn('status', ['accepted', 'completed'])
                ->count();

            $inProgress = DentalCase::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->where('treatment_label', $work->name)
                ->where('status', 'pending')
                ->count();

            return [
                'id' => $work->id,
                'name' => $work->name,
                'required' => $work->required_count,
                'completed' => $completed,
                'in_progress' => $inProgress,
                'evaluation_stages' => $work->evaluation_stages,
                'required_images' => $work->required_images,
                'requires_panorama' => $work->requires_panorama,
            ];
        });

        return response()->json([
            'success' => true,
            'course' => [
                'id' => $course->id,
                'code' => $course->code,
                'name' => $course->name,
                'session_limit' => $course->getSessionLimit(),
                'in_session' => $course->isInSession(),
            ],
            'works' => $worksData,
            'confirmed_patients' => $confirmedPatients,
        ]);
    }
}
