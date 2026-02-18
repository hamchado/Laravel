<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientHealth extends Model
{
    protected $table = 'patient_health';

    protected $fillable = [
        'patient_id', 'diseases', 'diabetes_controlled', 'bp_controlled',
    ];

    protected function casts(): array
    {
        return [
            'diseases' => 'array',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
