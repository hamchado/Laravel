<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseEvaluation extends Model
{
    protected $fillable = [
        'case_id', 'evaluator_id', 'stage', 'stage_name',
        'grade', 'notes', 'evaluated_at',
    ];

    protected function casts(): array
    {
        return [
            'stage' => 'integer',
            'evaluated_at' => 'datetime',
        ];
    }

    public function dentalCase()
    {
        return $this->belongsTo(DentalCase::class, 'case_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }
}
