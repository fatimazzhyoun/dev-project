<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ResourceMaintenance;
use App\Models\User;
use App\Models\Resource;
use Carbon\Carbon;

class ResourceMaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $khalid = User::where('email', 'khalid.amrani@datacenter.ma')->first();
        $fatima = User::where('email', 'fatima.zahra@datacenter.ma')->first();
        $mohammed = User::where('email', 'mohammed.bennani@datacenter.ma')->first();
        
        $serveur1 = Resource::where('name', 'Serveur-PROD-001')->first();
        $storage3 = Resource::where('name', 'NAS-ARCHIVE-01')->first();
        $switch1 = Resource::where('name', 'SWITCH-CORE-01')->first();

        $maintenances = [
            // Maintenance passée
            [
                'resource_id' => $serveur1->id,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(10)->addHours(4),
                'reason' => 'Mise à jour firmware BIOS et contrôleurs RAID',
                'notes' => 'Mise à jour effectuée avec succès. Aucun problème rencontré.',
                'created_by' => $khalid->id,
                'created_at' => Carbon::now()->subDays(15),
            ],
            
            // Maintenance en cours
            [
                'resource_id' => $storage3->id,
                'start_date' => Carbon::now()->subHours(2),
                'end_date' => Carbon::now()->addHours(4),
                'reason' => 'Remplacement de disques défectueux et vérification RAID',
                'notes' => '3 disques à remplacer. Rebuild du RAID en cours.',
                'created_by' => $fatima->id,
                'created_at' => Carbon::now()->subDays(3),
            ],
            
            // Maintenance future (proche)
            [
                'resource_id' => $switch1->id,
                'start_date' => Carbon::now()->addDays(2),
                'end_date' => Carbon::now()->addDays(2)->addHours(3),
                'reason' => 'Mise à jour IOS Cisco et configuration de nouvelles VLANs',
                'notes' => 'Interruption de service prévue. Notification envoyée aux utilisateurs.',
                'created_by' => $mohammed->id,
                'created_at' => Carbon::now()->subDays(7),
            ],
            
            // Maintenance future (lointaine)
            [
                'resource_id' => $serveur1->id,
                'start_date' => Carbon::now()->addDays(15),
                'end_date' => Carbon::now()->addDays(15)->addHours(2),
                'reason' => 'Maintenance préventive trimestrielle - Nettoyage et vérification hardware',
                'notes' => 'Maintenance de routine planifiée.',
                'created_by' => $khalid->id,
                'created_at' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($maintenances as $maintenance) {
            ResourceMaintenance::create($maintenance);
        }

        echo "✅ " . ResourceMaintenance::count() . " maintenances créées\n";
    }
}
