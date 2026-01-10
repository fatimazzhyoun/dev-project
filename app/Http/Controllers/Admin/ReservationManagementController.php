<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\Resource;
use Illuminate\Http\Request;

class ReservationManagementController extends Controller
{
    /**
     * Liste de toutes les réservations
     */
    public function index()
    {
        $reservations = Reservation::with(['user', 'resource', 'approver'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $stats = [
            'total' => Reservation::count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'approved' => Reservation::where('status', 'approved')->count(),
            'active' => Reservation::where('status', 'active')->count(),
            'refused' => Reservation::where('status', 'refused')->count(),
            'terminated' => Reservation::where('status', 'terminated')->count(),
        ];
        
        return view('admin.reservations.index', compact('reservations', 'stats'));
    }

    /**
     * Voir les détails d'une réservation
     */
    public function show(Reservation $reservation)
    {
        $reservation->load('user', 'resource', 'approver');
        return view('admin.reservations.show', compact('reservation'));
    }

    /**
     * Approuver une réservation
     */
    public function approve(Request $request, Reservation $reservation)
    {
        // Vérifier que la réservation est en attente
        if ($reservation->status !== 'pending') {
            return redirect()->route('admin.reservations.index')
                ->with('error', 'Cette réservation a déjà été traitée.');
        }

        // Vérifier que la ressource est disponible pour cette période
        $resource = $reservation->resource;
        
        if (!$resource->isAvailableForPeriod($reservation->start_date, $reservation->end_date)) {
            return redirect()->route('admin.reservations.index')
                ->with('error', 'La ressource n\'est pas disponible pour cette période.');
        }

        // Approuver la réservation
        $reservation->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'response_message' => $request->input('message', 'Réservation approuvée.'),
        ]);

        // Mettre à jour le statut de la ressource si la réservation commence maintenant
        if ($reservation->start_date <= now() && $reservation->end_date >= now()) {
            $resource->update(['status' => 'reserve']);
            $reservation->update(['status' => 'active']);
        }

        // Créer une notification pour l'utilisateur
        Notification::create([
            'user_id' => $reservation->user_id,
            'type' => 'reservation_approved',
            'title' => '✅ Réservation approuvée',
            'message' => "Votre réservation de {$resource->name} du {$reservation->start_date->format('d/m/Y')} au {$reservation->end_date->format('d/m/Y')} a été approuvée.",
            'related_id' => $reservation->id,
            'related_type' => 'reservation',
            'is_read' => false,
        ]);

        // Notifier le responsable de la ressource (si différent de l'admin)
        if ($resource->responsable_id && $resource->responsable_id !== auth()->id()) {
            Notification::create([
                'user_id' => $resource->responsable_id,
                'type' => 'reservation_approved',
                'title' => 'Réservation approuvée',
                'message' => "La réservation de {$resource->name} par {$reservation->user->name} a été approuvée.",
                'related_id' => $reservation->id,
                'related_type' => 'reservation',
                'is_read' => false,
            ]);
        }

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Réservation approuvée avec succès !');
    }

    /**
     * Refuser une réservation
     */
    public function reject(Request $request, Reservation $reservation)
    {
        // Vérifier que la réservation est en attente
        if ($reservation->status !== 'pending') {
            return redirect()->route('admin.reservations.index')
                ->with('error', 'Cette réservation a déjà été traitée.');
        }

        $validated = $request->validate([
            'reason' => 'required|string|min:10',
        ], [
            'reason.required' => 'Vous devez fournir une raison pour le refus.',
            'reason.min' => 'La raison doit contenir au moins 10 caractères.',
        ]);

        // Refuser la réservation
        $reservation->update([
            'status' => 'refused',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'response_message' => $validated['reason'],
        ]);

        // Créer une notification pour l'utilisateur
        Notification::create([
            'user_id' => $reservation->user_id,
            'type' => 'reservation_refused',
            'title' => '❌ Réservation refusée',
            'message' => "Votre réservation de {$reservation->resource->name} a été refusée. Raison: {$validated['reason']}",
            'related_id' => $reservation->id,
            'related_type' => 'reservation',
            'is_read' => false,
        ]);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Réservation refusée avec succès.');
    }

    /**
     * Terminer une réservation manuellement
     */
    public function terminate(Reservation $reservation)
    {
        // Vérifier que la réservation est active ou approuvée
        if (!in_array($reservation->status, ['approved', 'active'])) {
            return redirect()->route('admin.reservations.index')
                ->with('error', 'Seules les réservations actives ou approuvées peuvent être terminées.');
        }

        // Terminer la réservation
        $reservation->update([
            'status' => 'terminated',
        ]);

        // Remettre la ressource en disponible
        $reservation->resource->update(['status' => 'disponible']);

        // Créer une notification pour l'utilisateur
        Notification::create([
            'user_id' => $reservation->user_id,
            'type' => 'reservation_terminated',
            'title' => 'Réservation terminée',
            'message' => "Votre réservation de {$reservation->resource->name} a été terminée.",
            'related_id' => $reservation->id,
            'related_type' => 'reservation',
            'is_read' => false,
        ]);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Réservation terminée avec succès !');
    }

    /**
     * Supprimer une réservation
     */
    public function destroy(Reservation $reservation)
    {
        // Si la réservation est active, remettre la ressource en disponible
        if ($reservation->status === 'active') {
            $reservation->resource->update(['status' => 'disponible']);
        }

        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Réservation supprimée avec succès.');
    }

    /**
     * Filtrer les réservations par statut
     */
    public function filterByStatus($status)
    {
        $reservations = Reservation::with(['user', 'resource', 'approver'])
            ->where('status', $status)
            ->orderBy('created_at', 'desc')
            ->get();
        
        $stats = [
            'total' => Reservation::count(),
            'pending' => Reservation::where('status', 'pending')->count(),
            'approved' => Reservation::where('status', 'approved')->count(),
            'active' => Reservation::where('status', 'active')->count(),
            'refused' => Reservation::where('status', 'refused')->count(),
            'terminated' => Reservation::where('status', 'terminated')->count(),
        ];
        
        return view('admin.reservations.index', compact('reservations', 'stats'));
    }
}