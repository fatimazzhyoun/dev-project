<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Créer l'administrateur principal
        User::create([
            'name' => 'Administrateur Principal',
            'email' => 'admin@datacenter.ma',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
            'phone' => '+212 600-000001',
            'department' => 'Administration',
        ]);

        // 2. Créer des responsables techniques
        $responsables = [
            [
                'name' => 'Dr. Khalid Amrani',
                'email' => 'khalid.amrani@datacenter.ma',
                'password' => Hash::make('password'),
                'role' => 'responsable',
                'status' => 'active',
                'phone' => '+212 600-000002',
                'department' => 'Serveurs & VMs',
            ],
            [
                'name' => 'Dr. Fatima Zahra',
                'email' => 'fatima.zahra@datacenter.ma',
                'password' => Hash::make('password'),
                'role' => 'responsable',
                'status' => 'active',
                'phone' => '+212 600-000003',
                'department' => 'Stockage',
            ],
            [
                'name' => 'Pr. Mohammed Bennani',
                'email' => 'mohammed.bennani@datacenter.ma',
                'password' => Hash::make('password'),
                'role' => 'responsable',
                'status' => 'active',
                'phone' => '+212 600-000004',
                'department' => 'Réseau',
            ],
        ];

        foreach ($responsables as $responsable) {
            User::create($responsable);
        }

        // 3. Créer des utilisateurs normaux
        $users = [
            [
                'name' => 'Ahmed Benjelloun',
                'email' => 'ahmed.benjelloun@university.ma',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '+212 600-111001',
                'department' => 'Informatique',
            ],
            [
                'name' => 'Sanae El Amrani',
                'email' => 'sanae.elamrani@university.ma',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '+212 600-111002',
                'department' => 'Intelligence Artificielle',
            ],
            [
                'name' => 'Youssef Alaoui',
                'email' => 'youssef.alaoui@university.ma',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '+212 600-111003',
                'department' => 'Systèmes Distribués',
            ],
            [
                'name' => 'Imane Chakir',
                'email' => 'imane.chakir@university.ma',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '+212 600-111004',
                'department' => 'Cybersécurité',
            ],
            [
                'name' => 'Karim Bennani',
                'email' => 'karim.bennani@university.ma',
                'password' => Hash::make('password'),
                'role' => 'user',
                'status' => 'active',
                'phone' => '+212 600-111005',
                'department' => 'Big Data',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        // 4. Créer quelques utilisateurs invités (pour les demandes de compte)
        User::create([
            'name' => 'Guest User',
            'email' => 'guest@example.com',
            'password' => Hash::make('password'),
            'role' => 'guest',
            'status' => 'active',
        ]);

        echo "✅ " . User::count() . " utilisateurs créés\n";
    }
}
