<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;

class PublicResourceController extends Controller
{
    /**
     * Liste des ressources disponibles (pour les invités)
     */
    public function index()
    {
        $resources = Resource::where('status', 'disponible')
            ->with('category')
            ->orderBy('name')
            ->get();
       
        $stats = [
            'total' => Resource::count(),
            'disponibles' => Resource::where('status', 'disponible')->count(),
            'reserves' => Resource::where('status', 'reserve')->count(),
            'maintenance' => Resource::where('status', 'maintenance')->count(),
        ];
        
        return view('public.resources.index', compact('resources', 'stats'));
    }

    /**
     * Détails d'une ressource
     */
    public function show(Resource $resource)
    {
        $resource->load('category', 'responsable');
        
        return view('public.resources.show', compact('resource'));
    }

    /**
     * Règles d'utilisation des ressources
     */
    public function rules()
    {
        return view('public.rules');
    }
}
