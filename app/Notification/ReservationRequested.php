<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationRequested extends Notification
{
    use Queueable;

    public function __construct(private Reservation $reservation) {}

    public function via($notifiable): array
    {
        return ['database']; // + 'mail' si tu veux email plus tard
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'reservation_requested',
            'reservation_id' => $this->reservation->id,
            'resource_id' => $this->reservation->resource_id,
            'user_id' => $this->reservation->user_id,
            'status' => $this->reservation->status,
            'message' => "Nouvelle demande de réservation #{$this->reservation->id}",
        ];
    }
}
