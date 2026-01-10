<?php

namespace App\Http\Controllers;

use App\Models\ResourceMaintenance;
use App\Models\Resource;
use Illuminate\Http\Request;

class AdminMaintenanceController extends Controller
{
   public function index()
{
    // Charger TOUTES les maintenances avec leurs relations
    $maintenances = ResourceMaintenance::with(['resource.responsable', 'creator'])
        ->orderBy('created_at', 'desc')
        ->get();
     logger('Nombre de maintenances: ' . $maintenances->count());
    return view('admin.maintenances.index', compact('maintenances'));
}


    public function create()
    {
        $resources = Resource::all();
        return view('admin.maintenances.create', compact('resources'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'resource_id' => 'required|exists:resources,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'reason' => 'required|string',
        'notes' => 'nullable|string',
    ]);

    $validated['created_by'] = 1;

    // Créer la maintenance
    $maintenance = ResourceMaintenance::create($validated);

    //  CHANGER LE STATUS DE LA RESSOURCE
    $resource = Resource::find($validated['resource_id']);
    $resource->update(['status' => 'maintenance']);

    return redirect()->route('admin.maintenances.index')
        ->with('success', 'Maintenance planifiée et ressource mise en maintenance !');
}

    public function edit(ResourceMaintenance $maintenance)
    {
        $resources = Resource::all();
        return view('admin.maintenances.edit', compact('maintenance', 'resources'));
    }

   public function update(Request $request, ResourceMaintenance $maintenance)
{
    $validated = $request->validate([
        'resource_id' => 'required|exists:resources,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'reason' => 'required|string',
        'notes' => 'nullable|string',
    ]);

    //  Si la ressource change, remettre l'ancienne en "disponible"
    if ($maintenance->resource_id != $validated['resource_id']) {
        $oldResource = Resource::find($maintenance->resource_id);
        $oldResource->update(['status' => 'disponible']);
        
        // Mettre la nouvelle ressource en maintenance
        $newResource = Resource::find($validated['resource_id']);
        $newResource->update(['status' => 'maintenance']);
    }

    $maintenance->update($validated);

    return redirect()->route('admin.maintenances.index')
        ->with('success', 'Maintenance mise à jour avec succès !');
}

   public function destroy(ResourceMaintenance $maintenance)
{
    // 🔥 Remettre la ressource en "disponible" quand on supprime la maintenance
    $resource = Resource::find($maintenance->resource_id);
    $resource->update(['status' => 'disponible']);
    
    $maintenance->delete();

    return redirect()->route('admin.maintenances.index')
        ->with('success', 'Maintenance supprimée et ressource remise en disponible !');
}
}


