<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_login_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");
        });
    }

    public function scopeFilterByRole($query, $roleId)
    {
        return $query->when($roleId, function ($q) use ($roleId) {
            return $q->where('role_id', $roleId);
        });
    }

    public function scopeFilterByDateRange($query, $startDate, $endDate)
    {
        return $query->when($startDate, function ($q) use ($startDate) {
            return $q->whereDate('created_at', '>=', $startDate);
        })->when($endDate, function ($q) use ($endDate) {
            return $q->whereDate('created_at', '<=', $endDate);
        });
    }

    public function scopeApplyOrder($query, $orderBy, $direction)
    {
        $allowedFields = ['name', 'email', 'created_at'];
        $direction = in_array(strtolower($direction), ['asc', 'desc']) ? $direction : 'asc';

        return $query->when(in_array($orderBy, $allowedFields), function ($q) use ($orderBy, $direction) {
            return $q->orderBy($orderBy, $direction);
        });
    }

    public function hasRole(string $roleName): bool
    {
        return optional($this->role)->nombre === $roleName;
    }

    public function updateLastLogin(): void
    {
        $this->update(['last_login_at' => now()]);
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }
}
