<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AccountRequest;
use App\Models\User;
use Carbon\Carbon;

class AccountRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@datacenter.ma')->first();

        $requests = [
            // Demande en attente
            [
                'name' => 'Omar Tazi',
                'email' => 'omar.tazi@university.ma',
                'phone' => '+212 600-222001',
                'department' => 'Cloud Computing',
                'requested_role' => 'user',
                'justification' => 'Doctorant en Cloud Computing. J\'ai besoin d\'accéder aux ressources du datacenter pour mes recherches sur l\'optimisation des conteneurs Docker.',
                'status' => 'pending',
                'reviewed_by' => null,
                'reviewed_at' => null,
                'review_notes' => null,
                'created_user_id' => null,
                'created_at' => Carbon::now()->subHours(3),
            ],
            
            // Demande en attente (plus ancienne)
            [
                'name' => 'Leila Benkirane',
                'email' => 'leila.benkirane@university.ma',
                'phone' => '+212 600-222002',
                'department' => 'IoT et Systèmes Embarqués',
                'requested_role' => 'user',
                'justification' => 'Étudiante en Master 2. Projet de fin d\'études sur l\'IoT industriel. Besoin de ressources pour déployer et tester mon architecture.',
                'status' => 'pending',
                'reviewed_by' => null,
                'reviewed_at' => null,
                'review_notes' => null,
                'created_user_id' => null,
                'created_at' => Carbon::now()->subDays(1),
            ],
            
            // Demande approuvée
            [
                'name' => 'Rachid Alami',
                'email' => 'rachid.alami@university.ma',
                'phone' => '+212 600-222003',
                'department' => 'Blockchain',
                'requested_role' => 'user',
                'justification' => 'Chercheur en technologie Blockchain. Besoin de ressources pour déployer un réseau de test Ethereum.',
                'status' => 'approved',
                'reviewed_by' => $admin->id,
                'reviewed_at' => Carbon::now()->subDays(2),
                'review_notes' => 'Demande approuvée. Compte créé avec accès standard.',
                'created_user_id' => 5, // Ahmed (exemple)
                'created_at' => Carbon::now()->subDays(5),
            ],
            
            // Demande rejetée
            [
                'name' => 'Sarah Mansouri',
                'email' => 'sarah.external@gmail.com',
                'phone' => '+212 600-222004',
                'department' => 'Externe',
                'requested_role' => 'user',
                'justification' => 'Je voudrais utiliser vos serveurs pour mon projet personnel.',
                'status' => 'rejected',
                'reviewed_by' => $admin->id,
                'reviewed_at' => Carbon::now()->subDays(3),
                'review_notes' => 'Demande rejetée. Le datacenter est réservé aux membres de l\'université uniquement.',
                'created_user_id' => null,
                'created_at' => Carbon::now()->subDays(4),
            ],
            
            // Demande de responsable (en attente)
            [
                'name' => 'Dr. Karim Idrissi',
                'email' => 'karim.idrissi@university.ma',
                'phone' => '+212 600-222005',
                'department' => 'Directeur Département IA',
                'requested_role' => 'responsable',
                'justification' => 'Directeur du département IA. Je souhaite superviser les ressources dédiées aux projets de recherche en intelligence artificielle.',
                'status' => 'pending',
                'reviewed_by' => null,
                'reviewed_at' => null,
                'review_notes' => null,
                'created_user_id' => null,
                'created_at' => Carbon::now()->subHours(12),
            ],
        ];

        foreach ($requests as $request) {
            AccountRequest::create($request);
        }

        echo "✅ " . AccountRequest::count() . " demandes de compte créées\n";
    }
}