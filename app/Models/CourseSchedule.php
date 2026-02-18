<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSchedule extends Model
{
    protected $fillable = [
        'course_id', 'group_name', 'day_of_week',
        'start_time', 'end_time', 'location',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Check if current time falls within this schedule
     */
    public function isActiveNow(): bool
    {
        $dayMap = [
            'saturday' => 6, 'sunday' => 0, 'monday' => 1,
            'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5,
        ];

        $today = (int) date('w');
        if (($dayMap[$this->day_of_week] ?? -1) !== $today) {
            return false;
        }

        $now = date('H:i:s');
        return $now >= $this->start_time && $now <= $this->end_time;
    }
}
