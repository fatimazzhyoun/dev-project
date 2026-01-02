<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maintenance;
use App\Models\Resource; // On a besoin des ressources pour la liste déroulante

class AdminMaintenanceController extends Controller
{
    // Affiche la liste des maintenances
    public function index()
    {
        // On récupère les maintenances avec les infos de la ressource associée
        // 'with' permet d'optimiser la requête (Eager Loading)
        $maintenances = Maintenance::with('resource')->orderBy('start_date', 'desc')->get();

        return view('admin.maintenances.index', compact('maintenances'));
    }

    // Affiche le formulaire pour planifier une maintenance
    public function create()
    {
        // On a besoin de la liste des ressources pour choisir laquelle est en panne
        $resources = Resource::all();

        return view('admin.maintenances.create', compact('resources'));
    }

    // Enregistre la maintenance dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'resource_id' => 'required|exists:resources,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date', // La fin doit être APRES le début
            'reason' => 'required|string|max:500',
        ]);

        Maintenance::create([
            'resource_id' => $request->resource_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'planifie',
        ]);

        return redirect()->route('admin.maintenances.index')->with('success', 'Maintenance planifiée avec succès !');
    }
}
