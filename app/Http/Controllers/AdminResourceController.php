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
        // --- MAINTENANT (Ce qu'il faut mettre) ---
        // On ajoute "with('maintenances')" pour que Laravel charge aussi les infos de pannes
        $resources = Resource::with('maintenances')->get();

        // Si tu as gardé le tableau de bord avec la liste des pannes en bas :
        $maintenances = Maintenance::with('resource')->orderBy('start_date', 'asc')->get();

        // 2. On envoie ces données à une vue (qu'on va créer juste après)
        return view('admin.resources.index', compact('resources'));
    }
    
    // Affiche le formulaire de création
    public function create()
    {
        // On récupère les catégories actives pour la liste déroulante
        $categories = ResourceCategory::where('is_active', true)->get();

        return view('admin.resources.create', compact('categories'));
    }

public function store(Request $request)
{
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
    $responsables = User::where('role', 'responsable')->get();
    
    return view('admin.resources.edit', compact('resource', 'categories', 'responsables'));
}

/**
 * Sauvegarder les modifications
 */
public function update(Request $request, Resource $resource)
{
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
        'location' => 'nullable|string|max:255',
        'status' => 'required|in:disponible,reserve,maintenance,desactive',
        'responsable_id' => 'nullable|exists:users,id',
        'description' => 'nullable|string',
    ]);
    
    $resource->update($validated);
    
    return redirect()->route('admin.resources.index')
        ->with('success', 'Ressource mise à jour avec succès !');
}


// HADI HIYA LI KANT NAQSA
    public function updateStatus(Request $request, Resource $resource)
    {
        $request->validate([
            'status' => 'required|in:disponible,reserve,maintenance,desactive'
        ]);

        $resource->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Statut modifié avec succès !');
    }
}