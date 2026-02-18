<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseWork extends Model
{
    protected $fillable = [
        'course_id', 'name', 'required_count',
        'evaluation_stages', 'required_images', 'requires_panorama', 'description',
    ];

    protected function casts(): array
    {
        return [
            'required_count' => 'integer',
            'evaluation_stages' => 'integer',
            'required_images' => 'integer',
            'requires_panorama' => 'boolean',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
