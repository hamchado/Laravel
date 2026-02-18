<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPerio extends Model
{
    protected $table = 'patient_perio';

    protected $fillable = [
        'patient_id', 'segment', 'grade', 'pockets',
    ];

    protected function casts(): array
    {
        return [
            'pockets' => 'array',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
