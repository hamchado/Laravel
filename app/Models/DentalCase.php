<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DentalCase extends Model
{
    protected $table = 'cases';

    protected $fillable = [
        'patient_id', 'user_id', 'course_id', 'reservation_id',
        'tooth_number', 'treatment_type', 'treatment_label',
        'description', 'status', 'is_grant', 'evaluation_count',
        'session_date', 'supervisor_notes',
        'evaluated_at', 'evaluated_by',
    ];

    protected function casts(): array
    {
        return [
            'tooth_number' => 'integer',
            'is_grant' => 'boolean',
            'evaluation_count' => 'integer',
            'session_date' => 'date',
            'evaluated_at' => 'datetime',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }

    public function images()
    {
        return $this->hasMany(CaseImage::class, 'case_id');
    }

    public function evaluations()
    {
        return $this->hasMany(CaseEvaluation::class, 'case_id')->orderBy('stage');
    }

    public function grant()
    {
        return $this->hasOne(CaseGrant::class, 'case_id');
    }

    public function isGranted(): bool
    {
        return $this->is_grant;
    }
}
