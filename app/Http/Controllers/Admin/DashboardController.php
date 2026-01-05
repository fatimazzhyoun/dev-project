<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hna kanjibo les statistiques s7a7 mn database
        $totalUsers = User::count();
        $totalResources = DB::table('resources')->count();
        $totalCategories = DB::table('resource_categories')->count();
        
        // Hado ghir exemple bach may3tich erreur ila makanch tables
        // $totalUsers = 124; 
        
        return view('admin.dashboard', compact('totalUsers', 'totalResources', 'totalCategories'));
    }
}