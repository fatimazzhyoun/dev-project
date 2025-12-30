<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResourceCategory;

class ResourceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Catégories Serveurs
            [
                'name' => 'Serveurs Production',
                'slug' => 'serveurs-production',
                'description' => 'Serveurs haute performance pour les applications en production',
                'icon' => 'server',
                'color' => '#3B82F6',
                'resource_type' => 'serveur',
                'display_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Serveurs Développement',
                'slug' => 'serveurs-developpement',
                'description' => 'Serveurs pour tests et développement',
                'icon' => 'code',
                'color' => '#10B981',
                'resource_type' => 'serveur',
                'display_order' => 2,
                'is_active' => true,
            ],
            
            // Catégories VMs
            [
                'name' => 'VMs Production',
                'slug' => 'vms-production',
                'description' => 'Machines virtuelles pour production',
                'icon' => 'cloud',
                'color' => '#8B5CF6',
                'resource_type' => 'vm',
                'display_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'VMs Tests',
                'slug' => 'vms-tests',
                'description' => 'Machines virtuelles pour environnement de test',
                'icon' => 'flask',
                'color' => '#F59E0B',
                'resource_type' => 'vm',
                'display_order' => 4,
                'is_active' => true,
            ],
            
            // Catégories Stockage
            [
                'name' => 'SAN Storage',
                'slug' => 'san-storage',
                'description' => 'Storage Area Network haute performance',
                'icon' => 'database',
                'color' => '#EF4444',
                'resource_type' => 'stockage',
                'display_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'NAS Storage',
                'slug' => 'nas-storage',
                'description' => 'Network Attached Storage pour partage de fichiers',
                'icon' => 'folder',
                'color' => '#EC4899',
                'resource_type' => 'stockage',
                'display_order' => 6,
                'is_active' => true,
            ],
            
            // Catégories Réseau
            [
                'name' => 'Switches Core',
                'slug' => 'switches-core',
                'description' => 'Switches de coeur de réseau',
                'icon' => 'network',
                'color' => '#06B6D4',
                'resource_type' => 'reseau',
                'display_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Firewalls',
                'slug' => 'firewalls',
                'description' => 'Pare-feu et sécurité réseau',
                'icon' => 'shield',
                'color' => '#DC2626',
                'resource_type' => 'reseau',
                'display_order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            ResourceCategory::create($category);
        }

        echo "✅ " . ResourceCategory::count() . " catégories créées\n";
    }
}
