<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseGrant extends Model
{
    protected $fillable = [
        'case_id', 'granter_id', 'grantee_id', 'course_id',
        'status', 'cancel_reason', 'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }

    public function dentalCase()
    {
        return $this->belongsTo(DentalCase::class, 'case_id');
    }

    public function granter()
    {
        return $this->belongsTo(User::class, 'granter_id');
    }

    public function grantee()
    {
        return $this->belongsTo(User::class, 'grantee_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function canCancel(): bool
    {
        return $this->status === 'pending';
    }
}
