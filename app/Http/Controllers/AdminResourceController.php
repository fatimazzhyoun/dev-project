<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory; 
use App\Models\User;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class AdminResourceController extends Controller
{
    public function index()
    {
        // On charge les ressources avec leurs maintenances
        $resources = Resource::with('maintenances')->get();

        // Pour le tableau de bord des pannes (si utilisé dans l'index)
        // $maintenances = Maintenance::with('resource')->orderBy('start_date', 'asc')->get();

        return view('admin.resources.index', compact('resources'));
    }
    
    // Affiche le formulaire de création
    public function create()
    {
        // 1. Catégories
        $categories = ResourceCategory::where('is_active', true)->get();

        // 2. Responsables (CORRECTION ICI : On récupère les utilisateurs)
        // J'utilise all() pour être sûr que ça s'affiche. 
        // Si vous avez un système de rôles, remplacez par : User::where('role', 'responsable')->get();
        $responsables = User::all();

        // 3. On envoie les deux variables à la vue
        return view('admin.resources.create', compact('categories', 'responsables'));
    }

    public function store(Request $request)
    {
        // Validation : J'ai retiré 'location' comme demandé
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:serveur,vm,stockage,reseau',
            'category_id' => 'nullable|exists:resource_categories,id',
            'cpu' => 'nullable|integer',
            'ram' => 'nullable|integer',
            'storage' => 'nullable|string',
            'bandwidth' => 'nullable|string',
            'os' => 'nullable|string',
            'ip_address' => 'nullable|string',
            'location' => 'nullable|string', 
            'status' => 'required|in:disponible,reserve,maintenance,desactive',
            'responsable_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);
        
        Resource::create($validated);
        
        return redirect()->route('admin.resources.index')
            ->with('success', 'Ressource créée avec succès!');
    }

    public function toggleStatus(Resource $resource)
    {
        $newStatus = $resource->status === 'disponible' ? 'desactive' : 'disponible';
        
        $resource->update([
            'status' => $newStatus
        ]);
        
        return redirect()->route('admin.resources.index')
            ->with('success', 'Status mis à jour avec succès!');
    }

    /**
     * Afficher le formulaire de modification
     */
    public function edit(Resource $resource)
    {
        $categories = ResourceCategory::all();
        
        // CORRECTION : Même logique que create, on récupère les users
        $responsables = User::all(); 
        
        return view('admin.resources.edit', compact('resource', 'categories', 'responsables'));
    }

    /**
     * Sauvegarder les modifications
     */
    public function update(Request $request, Resource $resource)
    {
        // Validation : J'ai retiré 'location' ici aussi
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:serveur,vm,stockage,reseau',
            'category_id' => 'nullable|exists:resource_categories,id',
            'cpu' => 'nullable|integer',
            'ram' => 'nullable|integer',
            'storage' => 'nullable|string|max:255',
            'bandwidth' => 'nullable|string|max:255',
            'os' => 'nullable|string|max:255',
            'ip_address' => 'nullable|string|max:45',
            // 'location' => 'nullable|string|max:255', // SUPPRIMÉ
            'status' => 'required|in:disponible,reserve,maintenance,desactive',
            'responsable_id' => 'nullable|exists:users,id',
            'description' => 'nullable|string',
        ]);
        
        $resource->update($validated);
        
        return redirect()->route('admin.resources.index')
            ->with('success', 'Ressource mise à jour avec succès !');
    }

    /**
     * Mettre à jour le status d'une ressource (via Ajax ou formulaire spécifique)
     */
    public function updateStatus(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'status' => 'required|in:disponible,reserve,maintenance,desactive',
        ]);
        
        $resource->update(['status' => $validated['status']]);
        
        return redirect()->route('admin.resources.index')
            ->with('success', 'Status mis à jour avec succès !');
    }
}