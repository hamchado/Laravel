<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseRule extends Model
{
    protected $fillable = [
        'course_id', 'max_cases_per_session', 'allow_grants',
        'grant_unlimited', 'prevent_duplicate_tooth', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'max_cases_per_session' => 'integer',
            'allow_grants' => 'boolean',
            'grant_unlimited' => 'boolean',
            'prevent_duplicate_tooth' => 'boolean',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
