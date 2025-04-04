<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    // Ajouter ces méthodes et propriétés
protected $casts = [
    'date' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
];

public function scopeUpcoming($query)
{
    return $query->where('date', '>=', now());
}

public function scopePast($query)
{
    return $query->where('date', '<', now());
}

public function getIsUpcomingAttribute(): bool
{
    return $this->date->isFuture();
}
}
