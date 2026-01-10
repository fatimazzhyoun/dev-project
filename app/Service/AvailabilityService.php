<?php

namespace App\Services;

use App\Models\ResourceMaintenance;
use App\Models\Reservation;
use Carbon\Carbon;

class AvailabilityService
{
    /**
     * Valide la période (start < end).
     */
    public function validatePeriod(string|\DateTimeInterface $start, string|\DateTimeInterface $end): array
    {
        $startAt = Carbon::parse($start);
        $endAt   = Carbon::parse($end);

        if ($startAt->greaterThanOrEqualTo($endAt)) {
            return [
                'ok' => false,
                'message' => 'La date de début doit être avant la date de fin.',
            ];
        }

        return ['ok' => true, 'start' => $startAt, 'end' => $endAt];
    }

    /**
     * Vérifie si une ressource est dispo (maintenance + réservations).
     * $ignoreReservationId utile si tu modifies une réservation existante.
     */
    public function isResourceAvailable(int $resourceId, string $start, string $end, ?int $ignoreReservationId = null): array
    {
        $period = $this->validatePeriod($start, $end);
        if (!$period['ok']) return $period;

        $startAt = $period['start'];
        $endAt   = $period['end'];

        // 1) Conflit avec une maintenance ?
        $maintenanceConflict = ResourceMaintenance::query()
            ->where('resource_id', $resourceId)
            ->where('start_date', '<', $endAt)
            ->where('end_date',   '>', $startAt)
            ->orderBy('start_date')
            ->first();

        if ($maintenanceConflict) {
            return [
                'ok' => false,
                'type' => 'maintenance',
                'message' => 'Ressource en maintenance durant cette période.',
                'conflict' => $maintenanceConflict,
            ];
        }

        // 2) Conflit avec une réservation approuvée/active ?
        $reservationQuery = Reservation::query()
            ->where('resource_id', $resourceId)
            ->whereIn('status', ['approved', 'active']) // pending ne bloque pas
            ->where('start_date', '<', $endAt)
            ->where('end_date',   '>', $startAt);

        if ($ignoreReservationId) {
            $reservationQuery->where('id', '!=', $ignoreReservationId);
        }

        $reservationConflict = $reservationQuery
            ->orderBy('start_date')
            ->first();

        if ($reservationConflict) {
            return [
                'ok' => false,
                'type' => 'reservation',
                'message' => 'Ressource déjà réservée sur cette période.',
                'conflict' => $reservationConflict,
            ];
        }

        return ['ok' => true];
    }
}
