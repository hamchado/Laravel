<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PanoramaImage extends Model
{
    protected $fillable = [
        'patient_id', 'uploaded_by', 'path', 'notes', 'taken_at',
    ];

    protected function casts(): array
    {
        return [
            'taken_at' => 'date',
        ];
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
