<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseImage extends Model
{
    protected $fillable = ['case_id', 'path', 'type'];

    public function dentalCase()
    {
        return $this->belongsTo(DentalCase::class, 'case_id');
    }
}
