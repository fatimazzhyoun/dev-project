<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incident;
use App\Models\User;
use App\Models\Resource;
use App\Models\Reservation;
use Carbon\Carbon;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ahmed = User::where('email', 'ahmed.benjelloun@university.ma')->first();
        $youssef = User::where('email', 'youssef.alaoui@university.ma')->first();
        $khalid = User::where('email', 'khalid.amrani@datacenter.ma')->first();
        
        $serveur2 = Resource::where('name', 'Serveur-PROD-002')->first();
        $vm2 = Resource::where('name', 'VM-PROD-DB-01')->first();
        $storage1 = Resource::where('name', 'SAN-STORAGE-01')->first();

        $incidents = [
            // Incident ouvert (critique)
            [
                'user_id' => $youssef->id,
                'resource_id' => $serveur2->id,
                'reservation_id' => 3, // Sa réservation active
                'title' => 'Serveur ne répond plus',
                'description' => 'Le serveur Serveur-PROD-002 ne répond plus depuis 15 minutes. Impossible de se connecter en SSH. Les applications hébergées sont inaccessibles.',
                'priority' => 'critical',
                'status' => 'open',
                'resolved_by' => null,
                'resolved_at' => null,
                'resolution_notes' => null,
                'created_at' => Carbon::now()->subMinutes(15),
            ],
            
            // Incident en cours de traitement
            [
                'user_id' => $ahmed->id,
                'resource_id' => $vm2->id,
                'reservation_id' => 4,
                'title' => 'Performance dégradée',
                'description' => 'La VM-PROD-DB-01 a des performances très dégradées. Les requêtes SQL prennent 10x plus de temps que d\'habitude.',
                'priority' => 'high',
                'status' => 'in_progress',
                'resolved_by' => null,
                'resolved_at' => null,
                'resolution_notes' => null,
                'created_at' => Carbon::now()->subHours(2),
            ],
            
            // Incident résolu
            [
                'user_id' => $youssef->id,
                'resource_id' => $vm2->id,
                'reservation_id' => null,
                'title' => 'Disque plein',
                'description' => 'Le disque de la VM est plein à 99%. Impossible d\'écrire de nouvelles données.',
                'priority' => 'high',
                'status' => 'resolved',
                'resolved_by' => $khalid->id,
                'resolved_at' => Carbon::now()->subHours(1),
                'resolution_notes' => 'Nettoyage des logs anciens effectué. 50GB d\'espace libéré. Mise en place d\'une rotation automatique des logs.',
                'created_at' => Carbon::now()->subHours(3),
            ],
            
            // Incident résolu (ancien)
            [
                'user_id' => $ahmed->id,
                'resource_id' => $storage1->id,
                'reservation_id' => null,
                'title' => 'Lenteur d\'accès au stockage',
                'description' => 'Les accès au SAN-STORAGE-01 sont très lents. Temps de réponse supérieur à 500ms.',
                'priority' => 'medium',
                'status' => 'resolved',
                'resolved_by' => $khalid->id,
                'resolved_at' => Carbon::now()->subDays(2),
                'resolution_notes' => 'Problème de câble fibre optique détecté et remplacé. Performances revenues à la normale.',
                'created_at' => Carbon::now()->subDays(3),
            ],
            
            // Incident fermé
            [
                'user_id' => $youssef->id,
                'resource_id' => $serveur2->id,
                'reservation_id' => null,
                'title' => 'Erreur de connexion SSH',
                'description' => 'Impossible de se connecter en SSH au serveur. Message d\'erreur: Connection refused.',
                'priority' => 'low',
                'status' => 'closed',
                'resolved_by' => $khalid->id,
                'resolved_at' => Carbon::now()->subDays(5),
                'resolution_notes' => 'Le service SSH n\'était pas démarré. Service redémarré et configuré pour démarrage automatique.',
                'created_at' => Carbon::now()->subDays(5),
            ],
        ];

        foreach ($incidents as $incident) {
            Incident::create($incident);
        }

        echo "✅ " . Incident::count() . " incidents créés\n";
    }
}
