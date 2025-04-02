<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EventRegistrationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $event;
    protected $user;

    public function __construct($event, $user)
    {
        $this->event = $event;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle inscription à votre événement')
            ->line('Une nouvelle personne s\'est inscrite à votre événement.')
            ->line('Événement: ' . $this->event->title)
            ->line('Date: ' . $this->event->date->format('d/m/Y H:i'))
            ->line('Participant: ' . $this->user->name . ' (' . $this->user->email . ')')
            ->action('Voir l\'événement', url('/events/'.$this->event->id))
            ->line('Merci d\'utiliser notre application!');
    }
}