<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'patient_id', 'user_id', 'course_id', 'status',
        'confirmed_at', 'cancelled_at', 'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'confirmed_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'expires_at' => 'datetime',
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

    public function cancelReason()
    {
        return $this->hasOne(CancelReason::class);
    }

    public function dentalCases()
    {
        return $this->hasMany(DentalCase::class);
    }

    public function isExpired(): bool
    {
        return $this->status === 'temporary' && $this->expires_at && $this->expires_at->isPast();
    }

    public function isTemporary(): bool
    {
        return $this->status === 'temporary';
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function hasCases(): bool
    {
        return $this->dentalCases()->exists();
    }

    public function scopeActive($query)
    {
        return $query->whereIn('status', ['temporary', 'confirmed']);
    }

    public function scopeTemporary($query)
    {
        return $query->where('status', 'temporary');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
}
