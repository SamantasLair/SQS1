<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasUuids;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_premium',
        'ai_usage_count',
        'last_ai_usage_date',
        'google_id',
        'avatar',
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
            'is_premium' => 'boolean',
            'last_ai_usage_date' => 'date',
        ];
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function getQuizLimit(): int
    {
        return match ($this->role) {
            'premium' => 999999,
            'pro' => 50,
            'academic' => 25,
            default => 10,
        };
    }

    public function getAiDailyLimit(): int
    {
        return match ($this->role) {
            'premium' => 999999,
            'pro' => 50,
            'academic' => 5,
            default => 3,
        };
    }

    public function consumeAiCredit(): bool
    {
        if ($this->role === 'premium') {
            return true;
        }

        $today = Carbon::today();

        if ($this->last_ai_usage_date === null || $this->last_ai_usage_date->ne($today)) {
            $this->update([
                'ai_usage_count' => 0,
                'last_ai_usage_date' => $today,
            ]);
        }

        if ($this->ai_usage_count >= $this->getAiDailyLimit()) {
            return false;
        }

        $this->increment('ai_usage_count');
        return true;
    }

    public function getAnalysisLevel(): string
    {
        return match ($this->role) {
            'premium' => 'full_insight',
            'pro' => 'remedial',
            'academic' => 'diagnostic',
            default => 'none',
        };
    }
}