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
        'role' // 'admin' ou 'user'
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // Ajouter ces méthodes à la classe User
public function isAdmin(): bool
{
    return $this->role === 'admin';
}

public function ownsEvent(Event $event): bool
{
    return $this->id === $event->user_id;
}
}