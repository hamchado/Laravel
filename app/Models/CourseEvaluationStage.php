<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEvaluationStage extends Model
{
    protected $fillable = [
        'course_id', 'stage_number', 'stage_name',
        'required_images', 'requires_panorama', 'description',
    ];

    protected function casts(): array
    {
        return [
            'stage_number' => 'integer',
            'required_images' => 'integer',
            'requires_panorama' => 'boolean',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
