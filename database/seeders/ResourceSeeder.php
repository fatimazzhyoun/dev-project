<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resource;
use App\Models\User;
use App\Models\ResourceCategory;

class ResourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les responsables
        $khalid = User::where('email', 'khalid.amrani@datacenter.ma')->first();
        $fatima = User::where('email', 'fatima.zahra@datacenter.ma')->first();
        $mohammed = User::where('email', 'mohammed.bennani@datacenter.ma')->first();

        // Récupérer les catégories
        $catServeursProd = ResourceCategory::where('slug', 'serveurs-production')->first();
        $catServeursDev = ResourceCategory::where('slug', 'serveurs-developpement')->first();
        $catVMsProd = ResourceCategory::where('slug', 'vms-production')->first();
        $catVMsTests = ResourceCategory::where('slug', 'vms-tests')->first();
        $catSAN = ResourceCategory::where('slug', 'san-storage')->first();
        $catNAS = ResourceCategory::where('slug', 'nas-storage')->first();
        $catSwitches = ResourceCategory::where('slug', 'switches-core')->first();
        $catFirewalls = ResourceCategory::where('slug', 'firewalls')->first();

        // Serveurs de production (gérés par Khalid)
        $serveurs = [
            [
                'name' => 'Serveur-PROD-001',
                'type' => 'serveur',
                'description' => 'Serveur principal de production - Applications critiques',
                'cpu' => 32,
                'ram' => 256,
                'storage' => '2TB SSD NVMe',
                'bandwidth' => '10Gbps',
                'os' => 'Ubuntu Server 22.04 LTS',
                'ip_address' => '192.168.1.10',
                'location' => 'Rack A1 - U01',
                'status' => 'disponible',
                'responsable_id' => $khalid->id,
                'category_id' => $catServeursProd->id,
            ],
            [
                'name' => 'Serveur-PROD-002',
                'type' => 'serveur',
                'description' => 'Serveur de base de données principal',
                'cpu' => 64,
                'ram' => 512,
                'storage' => '4TB SSD',
                'bandwidth' => '10Gbps',
                'os' => 'Red Hat Enterprise Linux 9',
                'ip_address' => '192.168.1.11',
                'location' => 'Rack A1 - U05',
                'status' => 'reserve',
                'responsable_id' => $khalid->id,
                'category_id' => $catServeursProd->id,
            ],
            [
                'name' => 'Serveur-DEV-001',
                'type' => 'serveur',
                'description' => 'Serveur de développement et tests',
                'cpu' => 16,
                'ram' => 64,
                'storage' => '1TB SSD',
                'bandwidth' => '1Gbps',
                'os' => 'Ubuntu Server 24.04 LTS',
                'ip_address' => '192.168.2.10',
                'location' => 'Rack B2 - U10',
                'status' => 'disponible',
                'responsable_id' => $khalid->id,
                'category_id' => $catServeursDev->id,
            ],
        ];

        foreach ($serveurs as $serveur) {
            Resource::create($serveur);
        }

        // Machines virtuelles (gérées par Khalid)
        $vms = [
            [
                'name' => 'VM-PROD-WEB-01',
                'type' => 'vm',
                'description' => 'Serveur web de production - Apache',
                'cpu' => 8,
                'ram' => 32,
                'storage' => '500GB',
                'os' => 'Ubuntu Server 22.04',
                'ip_address' => '192.168.10.20',
                'location' => 'Hyperviseur ESXi-01',
                'status' => 'disponible',
                'responsable_id' => $khalid->id,
                'category_id' => $catVMsProd->id,
            ],
            [
                'name' => 'VM-PROD-DB-01',
                'type' => 'vm',
                'description' => 'Base de données MySQL production',
                'cpu' => 16,
                'ram' => 64,
                'storage' => '1TB',
                'os' => 'Ubuntu Server 22.04',
                'ip_address' => '192.168.10.21',
                'location' => 'Hyperviseur ESXi-01',
                'status' => 'reserve',
                'responsable_id' => $khalid->id,
                'category_id' => $catVMsProd->id,
            ],
            [
                'name' => 'VM-TEST-APP-01',
                'type' => 'vm',
                'description' => 'VM pour tests applicatifs',
                'cpu' => 4,
                'ram' => 16,
                'storage' => '200GB',
                'os' => 'Windows Server 2022',
                'ip_address' => '192.168.20.10',
                'location' => 'Hyperviseur ESXi-02',
                'status' => 'disponible',
                'responsable_id' => $khalid->id,
                'category_id' => $catVMsTests->id,
            ],
        ];

        foreach ($vms as $vm) {
            Resource::create($vm);
        }

        // Stockage (géré par Fatima)
        $stockages = [
            [
                'name' => 'SAN-STORAGE-01',
                'type' => 'stockage',
                'description' => 'SAN principal - Données critiques',
                'storage' => '50TB',
                'bandwidth' => '16Gbps FC',
                'location' => 'Rack C1 - U01-U04',
                'status' => 'disponible',
                'responsable_id' => $fatima->id,
                'category_id' => $catSAN->id,
            ],
            [
                'name' => 'NAS-BACKUP-01',
                'type' => 'stockage',
                'description' => 'NAS pour sauvegardes quotidiennes',
                'storage' => '100TB',
                'bandwidth' => '10Gbps',
                'ip_address' => '192.168.100.10',
                'location' => 'Rack C2 - U01-U05',
                'status' => 'disponible',
                'responsable_id' => $fatima->id,
                'category_id' => $catNAS->id,
            ],
            [
                'name' => 'NAS-ARCHIVE-01',
                'type' => 'stockage',
                'description' => 'NAS pour archivage long terme',
                'storage' => '200TB',
                'bandwidth' => '10Gbps',
                'ip_address' => '192.168.100.11',
                'location' => 'Rack C2 - U10-U15',
                'status' => 'maintenance',
                'responsable_id' => $fatima->id,
                'category_id' => $catNAS->id,
            ],
        ];

        foreach ($stockages as $stockage) {
            Resource::create($stockage);
        }

        // Équipements réseau (gérés par Mohammed)
        $reseaux = [
            [
                'name' => 'SWITCH-CORE-01',
                'type' => 'reseau',
                'description' => 'Switch core principal - Cisco Catalyst 9500',
                'bandwidth' => '400Gbps',
                'ip_address' => '192.168.254.1',
                'location' => 'Rack D1 - U20',
                'status' => 'disponible',
                'responsable_id' => $mohammed->id,
                'category_id' => $catSwitches->id,
            ],
            [
                'name' => 'SWITCH-ACCESS-01',
                'type' => 'reseau',
                'description' => 'Switch d\'accès - 48 ports 1Gbps',
                'bandwidth' => '48Gbps',
                'ip_address' => '192.168.254.10',
                'location' => 'Rack A1 - U42',
                'status' => 'disponible',
                'responsable_id' => $mohammed->id,
                'category_id' => $catSwitches->id,
            ],
            [
                'name' => 'FIREWALL-MAIN-01',
                'type' => 'reseau',
                'description' => 'Pare-feu principal - Fortinet FortiGate',
                'bandwidth' => '40Gbps',
                'ip_address' => '192.168.254.254',
                'location' => 'Rack D1 - U25',
                'status' => 'disponible',
                'responsable_id' => $mohammed->id,
                'category_id' => $catFirewalls->id,
            ],
        ];

        foreach ($reseaux as $reseau) {
            Resource::create($reseau);
        }

        echo "✅ " . Resource::count() . " ressources créées\n";
    }
}
