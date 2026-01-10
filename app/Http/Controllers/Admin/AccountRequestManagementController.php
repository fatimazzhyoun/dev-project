<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountRequest;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountRequestManagementController extends Controller
{
    /**
     * Liste des demandes de compte (pour l'admin)
     */
    public function index()
    {
        $requests = AccountRequest::with('reviewer')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $stats = [
            'pending' => AccountRequest::where('status', 'pending')->count(),
            'approved' => AccountRequest::where('status', 'approved')->count(),
            'rejected' => AccountRequest::where('status', 'rejected')->count(),
            'total' => AccountRequest::count(),
        ];
        
        return view('admin.account-requests.index', compact('requests', 'stats'));
    }

    /**
     * Voir les détails d'une demande
     */
    public function show(AccountRequest $accountRequest)
    {
        return view('admin.account-requests.show', compact('accountRequest'));
    }

    /**
     * Approuver une demande de compte
     */
    public function approve(AccountRequest $accountRequest)
    {
        // Vérifier que la demande est encore en attente
        if ($accountRequest->status !== 'pending') {
            return redirect()->route('admin.account-requests.index')
                ->with('error', 'Cette demande a déjà été traitée.');
        }

        // Vérifier que l'email n'existe pas déjà
        if (User::where('email', $accountRequest->email)->exists()) {
            return redirect()->route('admin.account-requests.index')
                ->with('error', 'Un utilisateur avec cet email existe déjà.');
        }

        // Générer un mot de passe temporaire
        $temporaryPassword = Str::random(12);
        
        // Créer le compte utilisateur
        $user = User::create([
            'name' => $accountRequest->name,
            'email' => $accountRequest->email,
            'password' => Hash::make($temporaryPassword),
            'role' => 'user',
            'status' => 'active',
            'phone' => $accountRequest->phone,
            'department' => $accountRequest->department,
        ]);

        // Mettre à jour la demande
        $accountRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => 'Compte créé avec succès.',
        ]);

        // Créer une notification pour l'utilisateur
        Notification::create([
            'user_id' => $user->id,
            'type' => 'account_approved',
            'title' => '✅ Compte approuvé',
            'message' => "Votre demande de compte a été approuvée ! Email: {$user->email} | Mot de passe temporaire: {$temporaryPassword}. Veuillez le changer dès votre première connexion.",
            'is_read' => false,
        ]);

        return redirect()->route('admin.account-requests.index')
            ->with('success', "Compte créé avec succès ! Email: {$user->email} | Mot de passe: {$temporaryPassword}");
    }

    /**
     * Refuser une demande de compte
     */
    public function reject(Request $request, AccountRequest $accountRequest)
    {
        // Vérifier que la demande est encore en attente
        if ($accountRequest->status !== 'pending') {
            return redirect()->route('admin.account-requests.index')
                ->with('error', 'Cette demande a déjà été traitée.');
        }

        $validated = $request->validate([
            'reason' => 'required|string|min:10',
        ], [
            'reason.required' => 'Vous devez fournir une raison pour le refus.',
            'reason.min' => 'La raison doit contenir au moins 10 caractères.',
        ]);

        $accountRequest->update([
            'status' => 'rejected',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
            'review_notes' => $validated['reason'],
        ]);

        return redirect()->route('admin.account-requests.index')
            ->with('success', 'Demande refusée avec succès.');
    }

    /**
     * Supprimer une demande
     */
    public function destroy(AccountRequest $accountRequest)
    {
        $accountRequest->delete();

        return redirect()->route('admin.account-requests.index')
            ->with('success', 'Demande supprimée avec succès.');
    }
}
