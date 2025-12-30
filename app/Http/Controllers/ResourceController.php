<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    // Afficher toutes les ressources
    public function index()
    {
        // 1. On récupère toutes les catégories pour le menu de filtre
        $categories = ResourceCategory::where('is_active', true)
                                      ->orderBy('display_order')
                                      ->get();

        // 2. On récupère toutes les ressources disponibles
        // On utilise 'with' pour optimiser la requête (Eager Loading)
        $resources = Resource::with('category')
                             ->where('status', '!=', 'desactive') // On masque les désactivés
                             ->get();

        return view('resources.index', compact('categories', 'resources'));
    }

    // Afficher les ressources d'une catégorie spécifique
    public function byCategory($id)
    {
        // 1. On récupère les catégories pour le menu (toujours nécessaire)
        $categories = ResourceCategory::where('is_active', true)
                                      ->orderBy('display_order')
                                      ->get();

        // 2. On récupère la catégorie choisie (pour afficher son nom en titre par exemple)
        $currentCategory = ResourceCategory::findOrFail($id);

        // 3. On récupère SEULEMENT les ressources de cette catégorie
        $resources = Resource::where('category_id', $id)
                             ->where('status', '!=', 'desactive')
                             ->with('category')
                             ->get();

        // On retourne la même vue, mais avec des données filtrées
        return view('resources.index', compact('categories', 'resources', 'currentCategory'));
    }
}