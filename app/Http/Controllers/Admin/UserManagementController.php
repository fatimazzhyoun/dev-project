<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * Liste de tous les utilisateurs
     */
    public function index()
    {
        $users = User::with('resources')->orderBy('created_at', 'desc')->get();
        
        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'responsables' => User::where('role', 'responsable')->count(),
            'users' => User::where('role', 'user')->count(),
            'active' => User::where('status', 'active')->count(),
            'inactive' => User::where('status', 'inactive')->count(),
        ];
        
        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Formulaire de création d'utilisateur
     */
    public function create()
    {
        $resources = Resource::all();
        return view('admin.users.create', compact('resources'));
    }

    /**
     * Enregistrer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,responsable,user',
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
            'phone' => $validated['phone'] ?? null,
            'department' => $validated['department'] ?? null,
        ]);

        // Si responsable, assigner des ressources
        if ($validated['role'] === 'responsable' && $request->has('resources')) {
            Resource::whereIn('id', $request->resources)->update(['responsable_id' => $user->id]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur créé avec succès !');
    }

    /**
     * Formulaire de modification
     */
    public function edit(User $user)
    {
        $resources = Resource::all();
        $userResources = $user->resources->pluck('id')->toArray();
        
        return view('admin.users.edit', compact('user', 'resources', 'userResources'));
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:admin,responsable,user',
            'status' => 'required|in:active,inactive',
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'status' => $validated['status'],
            'phone' => $validated['phone'] ?? null,
            'department' => $validated['department'] ?? null,
        ]);

        // Mettre à jour le mot de passe si fourni
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        // Réassigner les ressources si responsable
        if ($validated['role'] === 'responsable') {
            // Retirer l'ancien responsable
            Resource::where('responsable_id', $user->id)->update(['responsable_id' => null]);
            
            // Assigner les nouvelles ressources
            if ($request->has('resources')) {
                Resource::whereIn('id', $request->resources)->update(['responsable_id' => $user->id]);
            }
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur mis à jour avec succès !');
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleStatus(User $user)
    {
        // Empêcher de se désactiver soi-même
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas modifier votre propre statut !');
        }

        $newStatus = $user->status === 'active' ? 'inactive' : 'active';
        $user->update(['status' => $newStatus]);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Statut mis à jour avec succès !');
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy(User $user)
    {
        // Empêcher de se supprimer soi-même
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte !');
        }

        // Retirer les ressources assignées
        Resource::where('responsable_id', $user->id)->update(['responsable_id' => null]);
        
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès !');
    }
}
