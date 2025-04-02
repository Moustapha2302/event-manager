<!DOCTYPE html>
<html>
<head>
    <title>Liste des participants - {{ $event->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1 { color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Participants: {{ $event->title }}</h1>
    <p>Date: {{ $event->date->format('d/m/Y H:i') }}</p>
    <p>Lieu: {{ $event->location }}</p>
    
    <h2>Liste des inscrits ({{ $attendees->count() }})</h2>
    
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Date d'inscription</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendees as $registration)
            <tr>
                <td>{{ $registration->user->name }}</td>
                <td>{{ $registration->user->email }}</td>
                <td>{{ $registration->created_at->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>