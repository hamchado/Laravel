<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientTooth extends Model
{
    protected $table = 'patient_teeth';

    protected $fillable = [
        'patient_id', 'tooth_number', 'condition', 'sub_condition',
        'label', 'is_primary',
    ];

    protected function casts(): array
    {
        return [
            'tooth_number' => 'integer',
            'is_primary' => 'boolean',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
