<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'date' => $this->date->toIso8601String(),
            'location' => $this->location,
            'is_upcoming' => $this->is_upcoming,
            'image_url' => $this->image_path ? asset('storage/'.$this->image_path) : null,
            'organizer' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email
            ],
            'attendees_count' => $this->registrations_count ?? $this->registrations->count(),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String()
        ];
    }
}