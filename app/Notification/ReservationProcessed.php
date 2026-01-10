<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationProcessed extends Notification
{
    use Queueable;

    public function __construct(private Reservation $reservation) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => 'reservation_processed',
            'reservation_id' => $this->reservation->id,
            'resource_id' => $this->reservation->resource_id,
            'status' => $this->reservation->status,
            'response_message' => $this->reservation->response_message,
            'message' => "Votre demande #{$this->reservation->id} a été {$this->reservation->status}",
        ];
    }
}
