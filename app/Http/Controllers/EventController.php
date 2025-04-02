<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\EventCollection;
use App\Http\Resources\EventResource;
use Barryvdh\DomPDF\Facade\Pdf;



class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
        $this->middleware('can:create,App\Models\Event')->only('store');
        $this->middleware('can:update,event')->only('update');
        $this->middleware('can:delete,event')->only('destroy');
    }

    public function index(Request $request)
    {
        $query = Event::with(['user', 'registrations']);

        // Filtrage
        if ($request->has('upcoming')) {
            $query->where('date', '>=', now());
        }

        if ($request->has('past')) {
            $query->where('date', '<', now());
        }

        if ($request->has('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        // Tri
        $sortField = $request->get('sort_by', 'date');
        $sortDirection = $request->get('sort_dir', 'asc');

        $events = $query->orderBy($sortField, $sortDirection)->paginate(10);

        return EventResource::collection($events);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date|after_or_equal:today',
            'location' => 'required|string',
            'image' => 'sometimes|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('event_images');
        }

        // Création de l'événement en associant l'utilisateur connecté
        $validated['user_id'] = Auth::id();
        $event = Event::create($validated);

        return new EventResource($event->load('user'));
    }

    public function show(Event $event)
    {
        return response()->json($event->load('user', 'registrations.user'));
    }

    public function update(Request $request, Event $event)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403, 'Unauthorized');

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'location' => 'sometimes|string'
        ]);

        $event->update($validated);
        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403, 'Unauthorized');

        $event->delete();
        return response()->json(null, 204);
    }

    public function attendeesPdf(Event $event)
{
    $event->load('registrations.user');

    $pdf = Pdf::loadView('pdf.attendees', [
        'event' => $event,
        'attendees' => $event->registrations
    ]);

    return $pdf->download('attendees-'.$event->id.'.pdf');
}
}
