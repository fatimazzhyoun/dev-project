<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ahmed = User::where('email', 'ahmed.benjelloun@university.ma')->first();
        $sanae = User::where('email', 'sanae.elamrani@university.ma')->first();
        $youssef = User::where('email', 'youssef.alaoui@university.ma')->first();
        $khalid = User::where('email', 'khalid.amrani@datacenter.ma')->first();

        $notifications = [
            // Notifications pour Ahmed
            [
                'user_id' => $ahmed->id,
                'type' => 'approbation',
                'title' => 'Réservation approuvée',
                'message' => 'Votre réservation du Serveur-PROD-001 a été approuvée par Dr. Khalid Amrani.',
                'related_id' => 1,
                'related_type' => 'reservation',
                'read_at' => Carbon::now()->subHours(5),
                'created_at' => Carbon::now()->subHours(6),
            ],
            [
                'user_id' => $ahmed->id,
                'type' => 'expiration',
                'title' => 'Réservation bientôt expirée',
                'message' => 'Votre réservation de VM-PROD-DB-01 expire dans 24 heures. Pensez à sauvegarder vos données.',
                'related_id' => 2,
                'related_type' => 'reservation',
                'read_at' => null, // Non lue
                'created_at' => Carbon::now()->subHours(1),
            ],
            
            // Notifications pour Sanae
            [
                'user_id' => $sanae->id,
                'type' => 'refus',
                'title' => 'Réservation refusée',
                'message' => 'Votre demande de réservation du SAN-STORAGE-01 a été refusée. Raison: Ressource en maintenance durant cette période.',
                'related_id' => 5,
                'related_type' => 'reservation',
                'read_at' => Carbon::now()->subMinutes(30),
                'created_at' => Carbon::now()->subHours(1),
            ],
            [
                'user_id' => $sanae->id,
                'type' => 'approbation',
                'title' => 'Réservation approuvée',
                'message' => 'Votre réservation de VM-PROD-WEB-01 a été approuvée. Début: dans 5 jours.',
                'related_id' => 2,
                'related_type' => 'reservation',
                'read_at' => Carbon::now()->subHours(2),
                'created_at' => Carbon::now()->subHours(2),
            ],
            
            // Notifications pour Youssef
            [
                'user_id' => $youssef->id,
                'type' => 'maintenance',
                'title' => 'Maintenance planifiée',
                'message' => 'Une maintenance est planifiée sur le Serveur-PROD-002 dans 48h. Durée estimée: 2 heures.',
                'related_id' => null,
                'related_type' => null,
                'read_at' => null,
                'created_at' => Carbon::now()->subMinutes(15),
            ],
            
            // Notifications pour le responsable Khalid
            [
                'user_id' => $khalid->id,
                'type' => 'demande',
                'title' => 'Nouvelle demande de réservation',
                'message' => 'Ahmed Benjelloun a fait une demande de réservation pour Serveur-PROD-001. En attente de votre approbation.',
                'related_id' => 1,
                'related_type' => 'reservation',
                'read_at' => null,
                'created_at' => Carbon::now()->subMinutes(5),
            ],
            [
                'user_id' => $khalid->id,
                'type' => 'incident',
                'title' => 'Nouvel incident signalé',
                'message' => 'Un incident a été signalé sur VM-PROD-DB-01 par Youssef Alaoui. Priorité: High.',
                'related_id' => 1,
                'related_type' => 'incident',
                'read_at' => Carbon::now()->subMinutes(10),
                'created_at' => Carbon::now()->subMinutes(20),
            ],
            
            // Plus de notifications non lues pour tester
            [
                'user_id' => $ahmed->id,
                'type' => 'conflit',
                'title' => 'Conflit de réservation',
                'message' => 'Votre demande de réservation entre en conflit avec une maintenance planifiée.',
                'related_id' => null,
                'related_type' => null,
                'read_at' => null,
                'created_at' => Carbon::now()->subMinutes(45),
            ],
        ];

        foreach ($notifications as $notification) {
            Notification::create($notification);
        }

        echo "✅ " . Notification::count() . " notifications créées\n";
    }
}
