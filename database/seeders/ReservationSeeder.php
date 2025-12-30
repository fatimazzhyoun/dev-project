<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Resource;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer des utilisateurs et ressources
        $ahmed = User::where('email', 'ahmed.benjelloun@university.ma')->first();
        $sanae = User::where('email', 'sanae.elamrani@university.ma')->first();
        $youssef = User::where('email', 'youssef.alaoui@university.ma')->first();
        $khalid = User::where('email', 'khalid.amrani@datacenter.ma')->first();
        
        $serveur1 = Resource::where('name', 'Serveur-PROD-001')->first();
        $serveur2 = Resource::where('name', 'Serveur-PROD-002')->first();
        $vm1 = Resource::where('name', 'VM-PROD-WEB-01')->first();
        $vm2 = Resource::where('name', 'VM-PROD-DB-01')->first();
        $storage1 = Resource::where('name', 'SAN-STORAGE-01')->first();

        $reservations = [
            // Réservation en attente
            [
                'user_id' => $ahmed->id,
                'resource_id' => $serveur1->id,
                'start_date' => Carbon::now()->addDays(2),
                'end_date' => Carbon::now()->addDays(7),
                'status' => 'pending',
                'justification' => 'Tests de performance pour le projet de recherche sur l\'optimisation des bases de données distribuées. Besoin d\'un serveur haute performance pour simuler des charges importantes.',
                'response_message' => null,
                'approved_by' => null,
                'approved_at' => null,
            ],
            
            // Réservation approuvée (future)
            [
                'user_id' => $sanae->id,
                'resource_id' => $vm1->id,
                'start_date' => Carbon::now()->addDays(5),
                'end_date' => Carbon::now()->addDays(10),
                'status' => 'approved',
                'justification' => 'Développement et tests d\'une application web pour le traitement d\'images médicales avec deep learning.',
                'response_message' => 'Réservation approuvée. Pensez à libérer la ressource à temps.',
                'approved_by' => $khalid->id,
                'approved_at' => Carbon::now()->subHours(2),
            ],
            
            // Réservation active (en cours)
            [
                'user_id' => $youssef->id,
                'resource_id' => $serveur2->id,
                'start_date' => Carbon::now()->subDays(2),
                'end_date' => Carbon::now()->addDays(3),
                'status' => 'active',
                'justification' => 'Déploiement d\'un cluster Kubernetes pour tests de scalabilité dans le cadre de ma thèse de doctorat.',
                'response_message' => 'Approuvé. Contact moi si tu as besoin de ressources supplémentaires.',
                'approved_by' => $khalid->id,
                'approved_at' => Carbon::now()->subDays(3),
            ],
            
            // Réservation terminée
            [
                'user_id' => $ahmed->id,
                'resource_id' => $vm2->id,
                'start_date' => Carbon::now()->subDays(10),
                'end_date' => Carbon::now()->subDays(3),
                'status' => 'terminated',
                'justification' => 'Migration de base de données MySQL vers PostgreSQL pour projet Big Data.',
                'response_message' => 'Réservation approuvée.',
                'approved_by' => $khalid->id,
                'approved_at' => Carbon::now()->subDays(11),
            ],
            
            // Réservation refusée
            [
                'user_id' => $sanae->id,
                'resource_id' => $storage1->id,
                'start_date' => Carbon::now()->addDays(1),
                'end_date' => Carbon::now()->addDays(15),
                'status' => 'refused',
                'justification' => 'Stockage pour dataset de 30TB pour entraînement de modèles de machine learning.',
                'response_message' => 'Désolé, cette ressource est déjà réservée pour une maintenance planifiée durant cette période. Merci de choisir une autre date.',
                'approved_by' => $khalid->id,
                'approved_at' => Carbon::now()->subHours(1),
            ],
            
            // Autres réservations pour avoir plus de données
            [
                'user_id' => $youssef->id,
                'resource_id' => $vm1->id,
                'start_date' => Carbon::now()->subDays(20),
                'end_date' => Carbon::now()->subDays(15),
                'status' => 'terminated',
                'justification' => 'Tests de compatibilité pour nouvelle version de l\'application.',
                'response_message' => 'Approuvé.',
                'approved_by' => $khalid->id,
                'approved_at' => Carbon::now()->subDays(21),
            ],
            
            [
                'user_id' => $ahmed->id,
                'resource_id' => $serveur1->id,
                'start_date' => Carbon::now()->subDays(30),
                'end_date' => Carbon::now()->subDays(25),
                'status' => 'terminated',
                'justification' => 'Benchmark des performances CPU pour analyse comparative.',
                'response_message' => 'Approuvé. Merci de documenter vos résultats.',
                'approved_by' => $khalid->id,
                'approved_at' => Carbon::now()->subDays(31),
            ],
        ];

        foreach ($reservations as $reservation) {
            Reservation::create($reservation);
        }

        echo "✅ " . Reservation::count() . " réservations créées\n";
    }
}
