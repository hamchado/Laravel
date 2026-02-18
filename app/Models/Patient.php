<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'record_number', 'full_name', 'phone', 'birth_year', 'age',
        'gender', 'age_type', 'access_type', 'governorate', 'address',
        'notes', 'parent_name', 'parent_phone', 'parent_birth_year',
        'added_by',
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
        ];
    }

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function teeth()
    {
        return $this->hasMany(PatientTooth::class);
    }

    public function perio()
    {
        return $this->hasMany(PatientPerio::class);
    }

    public function health()
    {
        return $this->hasOne(PatientHealth::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function cases()
    {
        return $this->hasMany(DentalCase::class);
    }

    public function accessUsers()
    {
        return $this->belongsToMany(User::class, 'patient_access');
    }

    public function panoramaImages()
    {
        return $this->hasMany(PanoramaImage::class)->orderByDesc('taken_at');
    }

    public static function generateRecordNumber(): string
    {
        $year = date('Y');
        $last = static::where('record_number', 'like', "MED-{$year}-%")
            ->orderByDesc('id')
            ->value('record_number');

        $num = 1;
        if ($last) {
            $num = (int) substr($last, -4) + 1;
        }

        return "MED-{$year}-" . str_pad($num, 4, '0', STR_PAD_LEFT);
    }
}
