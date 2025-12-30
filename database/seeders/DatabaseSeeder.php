<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "\n🚀 Démarrage du seeding de la base de données...\n\n";

        // Ordre important : les seeders doivent être exécutés dans le bon ordre
        // à cause des dépendances (foreign keys)
        
        $this->call([
            UserSeeder::class,                    // D'abord les utilisateurs
            ResourceCategorySeeder::class,        // Puis les catégories
            ResourceSeeder::class,                // Puis les ressources (dépend de users et categories)
            ReservationSeeder::class,             // Puis les réservations (dépend de users et resources)
            NotificationSeeder::class,            // Puis les notifications
            IncidentSeeder::class,                // Puis les incidents
            ResourceMaintenanceSeeder::class,     // Puis les maintenances
            AccountRequestSeeder::class,          // Puis les demandes de compte
            SettingSeeder::class,                 // Enfin les paramètres
        ]);

        echo "\n✅ Seeding terminé avec succès !\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📊 Résumé de la base de données:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }
}
