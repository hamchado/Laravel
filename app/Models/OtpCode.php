<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    protected $fillable = [
        'user_id', 'code', 'ip_address', 'expires_at',
        'used', 'used_at', 'attempts',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
            'used' => 'boolean',
            'attempts' => 'integer',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isValid(): bool
    {
        return !$this->used && $this->expires_at->isFuture() && $this->attempts < 5;
    }

    public static function generate(int $userId): static
    {
        // Invalidate previous codes
        static::where('user_id', $userId)->where('used', false)->update(['used' => true]);

        return static::create([
            'user_id' => $userId,
            'code' => str_pad(random_int(0, 99999999), 8, '0', STR_PAD_LEFT),
            'ip_address' => request()->ip(),
            'expires_at' => now()->addMinutes(2),
        ]);
    }
}
