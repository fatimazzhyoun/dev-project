<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Paramètres généraux
            [
                'key' => 'site_name',
                'value' => 'DataCenter Management System',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Nom du site',
                'description' => 'Nom affiché dans l\'application',
                'default_value' => 'DataCenter Management',
                'options' => null,
                'is_editable' => true,
            ],
            [
                'key' => 'site_description',
                'value' => 'Système de gestion et réservation des ressources du datacenter universitaire',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Description du site',
                'description' => 'Description courte de l\'application',
                'default_value' => '',
                'options' => null,
                'is_editable' => true,
            ],
            [
                'key' => 'maintenance_mode',
                'value' => 'false',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Mode maintenance',
                'description' => 'Activer le mode maintenance (seuls les admins peuvent accéder)',
                'default_value' => 'false',
                'options' => null,
                'is_editable' => true,
            ],
            
            // Paramètres de réservation
            [
                'key' => 'max_reservation_duration',
                'value' => '30',
                'type' => 'integer',
                'group' => 'reservation',
                'label' => 'Durée maximale de réservation (jours)',
                'description' => 'Nombre maximum de jours pour une réservation',
                'default_value' => '30',
                'options' => null,
                'is_editable' => true,
            ],
            [
                'key' => 'min_reservation_duration',
                'value' => '1',
                'type' => 'integer',
                'group' => 'reservation',
                'label' => 'Durée minimale de réservation (jours)',
                'description' => 'Nombre minimum de jours pour une réservation',
                'default_value' => '1',
                'options' => null,
                'is_editable' => true,
            ],
            [
                'key' => 'reservation_approval_required',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'reservation',
                'label' => 'Approbation requise',
                'description' => 'Les réservations doivent être approuvées par un responsable',
                'default_value' => 'true',
                'options' => null,
                'is_editable' => true,
            ],
            [
                'key' => 'max_concurrent_reservations',
                'value' => '5',
                'type' => 'integer',
                'group' => 'reservation',
                'label' => 'Réservations simultanées max',
                'description' => 'Nombre maximum de réservations actives par utilisateur',
                'default_value' => '5',
                'options' => null,
                'is_editable' => true,
            ],
            
            // Paramètres de notification
            [
                'key' => 'notification_expiration_days',
                'value' => '2',
                'type' => 'integer',
                'group' => 'notification',
                'label' => 'Rappel avant expiration (jours)',
                'description' => 'Envoyer une notification X jours avant la fin de réservation',
                'default_value' => '2',
                'options' => null,
                'is_editable' => true,
            ],
            [
                'key' => 'email_notifications_enabled',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'notification',
                'label' => 'Notifications email activées',
                'description' => 'Envoyer des emails en plus des notifications internes',
                'default_value' => 'false',
                'options' => null,
                'is_editable' => true,
            ],
            
            // Paramètres de contact
            [
                'key' => 'support_email',
                'value' => 'support@datacenter.ma',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Email de support',
                'description' => 'Email de contact pour le support technique',
                'default_value' => '',
                'options' => null,
                'is_editable' => true,
            ],
            [
                'key' => 'support_phone',
                'value' => '+212 5XX-XXXXXX',
                'type' => 'string',
                'group' => 'contact',
                'label' => 'Téléphone de support',
                'description' => 'Numéro de téléphone du support',
                'default_value' => '',
                'options' => null,
                'is_editable' => true,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }

        echo "✅ " . Setting::count() . " paramètres créés\n";
    }
}
