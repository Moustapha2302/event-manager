<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\EventRegistrationNotification;


class RegistrationController extends Controller
{
    public function register(Request $request, Event $event)
    {
        if (Registration::where('user_id', Auth::id())->where('event_id', $event->id)->exists()) {
            return response()->json(['message' => 'Already registered'], 400);
        }

        $registration = Registration::create([
            'user_id' => Auth::id(),
            'event_id' => $event->id
        ]);


        // Envoyer une notification à l'organisateur
    if ($event->user->id !== Auth::id()) {
        $event->user->notify(new EventRegistrationNotification($event, Auth::user()));
    }

    return response()->json($registration, 201);
}

    public function unregister(Request $request, Event $event)
    {
        $registration = Registration::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->first();

        if (!$registration) {
            return response()->json(['message' => 'Not registered'], 404);
        }

        $registration->delete();
        return response()->json(null, 204);
    }

    public function attendees(Event $event)
    {
        $attendees = $event->registrations()->with('user')->get();
        return response()->json($attendees);
    }
}
