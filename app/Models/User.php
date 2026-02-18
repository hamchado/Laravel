<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'student_id',
        'name',
        'email',
        'phone',
        'password',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function cases()
    {
        return $this->hasMany(DentalCase::class);
    }

    public function patients()
    {
        return $this->hasMany(Patient::class, 'added_by');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_student');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }

    public function otpCodes()
    {
        return $this->hasMany(OtpCode::class);
    }

    public function grantedCases()
    {
        return $this->hasMany(CaseGrant::class, 'granter_id');
    }

    public function receivedGrants()
    {
        return $this->hasMany(CaseGrant::class, 'grantee_id');
    }

    public function hasRole(string $roleName): bool
    {
        return $this->role && $this->role->name === $roleName;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isAyham(): bool
    {
        return $this->hasRole('ayham');
    }

    public function isStudent(): bool
    {
        return $this->hasRole('student');
    }

    public function isSupervisor(): bool
    {
        return $this->hasRole('supervisor');
    }

    public function getRedirectRoute(): string
    {
        if ($this->isAyham()) return '/ayham/home';
        if ($this->isAdmin()) return '/admin/home';
        if ($this->isSupervisor()) return '/tash/home';
        return '/student/home';
    }

    public function getSectionName(): string
    {
        if ($this->isAyham()) return 'ayham';
        if ($this->isAdmin()) return 'admin';
        if ($this->isSupervisor()) return 'tash';
        return 'student';
    }
}
