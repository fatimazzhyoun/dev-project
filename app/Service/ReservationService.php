<?php

namespace App\Services;

use App\Notifications\ReservationRequested;
use App\Notifications\ReservationProcessed;
use App\Models\Reservation;
use App\Models\AuditLog; //AuditLog enregistrer qui a fait qoui ,quand et avec quelle donnes
use App\Models\Resource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;


class ReservationService
{
    public function __construct(
        private AvailabilityService $availability
    ) {}

    /**
     * Création d'une demande de réservation (status pending).
     */
    public function create(User $user, array $data): Reservation
    {
        // data attendu: resource_id, start_date, end_date, justification

        $check = $this->availability->isResourceAvailable(
            (int) $data['resource_id'],
            $data['start_date'],
            $data['end_date']
        );

        if (!$check['ok']) {
            // On lève une exception pour que le controller gère proprement
            throw new \RuntimeException($check['message']);
        }

        return DB::transaction(function () use ($user, $data) {
            $reservation = Reservation::create([
                'user_id' => $user->id,
                'resource_id' => (int) $data['resource_id'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => 'pending',
                'justification' => $data['justification'],
            ]);

            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'reservation_created',
                'entity_type' => 'reservation',
                'entity_id' => $reservation->id,
                'meta' => json_encode([
                    'resource_id' => $reservation->resource_id,
                    'start' => $reservation->start_date,
                    'end' => $reservation->end_date,
                ]),
            ]);
              $resource = Resource::findOrFail((int) $data['resource_id']);
                // 1) notifier le technicien responsable de la ressource
                if ($resource->responsable_id) {
                    $technician = User::find($resource->responsable_id);
                    if ($technician) {
                        $technician->notify(new ReservationRequested($reservation));
                    }
                }
            return $reservation;
        });
    }

    /**
     * Approve par responsable/admin
     */
    public function approve(Reservation $reservation, User $approver, ?string $message = null): Reservation
    {
        // Re-check dispo avant approve (important)
        $check = $this->availability->isResourceAvailable(
            $reservation->resource_id,
            $reservation->start_date,
            $reservation->end_date,
            $reservation->id
        );

        if (!$check['ok']) {
            throw new \RuntimeException("Impossible d'approuver: " . $check['message']);
        }

        return DB::transaction(function () use ($reservation, $approver, $message) {
            $reservation->update([
                'status' => 'approved',
                'approved_by' => $approver->id,
                'approved_at' => now(),
                'response_message' => $message,
            ]);
            //refresh()
            $reservation->refresh();
            $reservation->user->notify(new ReservationProcessed($reservation));//notification

            AuditLog::create([
                'user_id' => $approver->id,
                'action' => 'reservation_approved',
                'entity_type' => 'reservation',
                'entity_id' => $reservation->id,
                'meta' => json_encode(['message' => $message]),
            ]);


            return $reservation;
        });
    }

    /**
     * Reject par responsable/admin
     */
    public function reject(Reservation $reservation, User $approver, string $reason): Reservation
    {
        return DB::transaction(function () use ($reservation, $approver, $reason) {
            $reservation->update([
                'status' => 'refused',
                'approved_by' => $approver->id,
                'approved_at' => now(),
                'response_message' => $reason,
            ]);
            //utilise refreshe
            $reservation->refresh();
            $reservation->user->notify(new ReservationProcessed($reservation));
            AuditLog::create([
                'user_id' => $approver->id,
                'action' => 'reservation_rejected',
                'entity_type' => 'reservation',
                'entity_id' => $reservation->id,
                'meta' => json_encode(['reason' => $reason]),
            ]);

            // $reservation->user->notify(new ReservationRejected($reservation));

            return $reservation;
        });
    }
}
