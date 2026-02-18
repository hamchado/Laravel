<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'code', 'slug', 'name', 'supervisors', 'schedule',
        'location', 'max_reservations', 'session_limit', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'max_reservations' => 'integer',
            'session_limit' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_student');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function cases()
    {
        return $this->hasMany(DentalCase::class);
    }

    public function works()
    {
        return $this->hasMany(CourseWork::class);
    }

    public function schedules()
    {
        return $this->hasMany(CourseSchedule::class);
    }

    public function rule()
    {
        return $this->hasOne(CourseRule::class);
    }

    public function evaluationStages()
    {
        return $this->hasMany(CourseEvaluationStage::class);
    }

    public function grants()
    {
        return $this->hasMany(CaseGrant::class);
    }

    public function activeReservationsCount(int $userId): int
    {
        return $this->reservations()
            ->where('user_id', $userId)
            ->whereIn('status', ['temporary', 'confirmed'])
            ->count();
    }

    /**
     * Check if any schedule for this course is active right now
     */
    public function isInSession(?string $groupName = null): bool
    {
        $query = $this->schedules();
        if ($groupName) {
            $query->where('group_name', $groupName);
        }
        return $query->get()->contains(fn($s) => $s->isActiveNow());
    }

    /**
     * Get max cases per session from course rules (default 2)
     */
    public function getSessionLimit(): int
    {
        return $this->rule?->max_cases_per_session ?? $this->session_limit ?? 2;
    }
}
