<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'role',
        'is_blocked',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_blocked' => 'boolean',
    ];

    // Relationships
    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Car::class, 'favorites');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Helper Methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isModerator()
    {
        return $this->role === 'moderator';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    public function canManageCars()
    {
        return in_array($this->role, ['admin', 'moderator']);
    }
}
