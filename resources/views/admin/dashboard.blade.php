@extends('layouts.admin')

@section('title', 'Tableau de bord')
@section('header-title', 'Vue d\'ensemble & Statistiques')

@section('content')
    <div class="kpi-grid">
        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:start;">
                <div>
                    <h4>Total Utilisateurs</h4>
                    <div class="number">{{ $totalUsers ?? 124 }}</div>
                </div>
                <div style="background:#e8f8f5; padding:10px; border-radius:50%; color:#2ecc71;">
                    <i class='bx bxs-user-group' style="font-size:24px;"></i>
                </div>
            </div>
            <small style="color:#2ecc71;"><i class='bx bx-up-arrow-alt'></i> +12% ce mois</small>
        </div>

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:start;">
                <div>
                    <h4>Ressources Totales</h4>
                    <div class="number">{{ $totalResources ?? 85 }}</div>
                </div>
                <div style="background:#eaf2f8; padding:10px; border-radius:50%; color:#3498db;">
                    <i class='bx bxs-server' style="font-size:24px;"></i>
                </div>
            </div>
            <small style="color:#7f8c8d;">Dont 5 en maintenance</small>
        </div>

        <div class="card">
            <div style="display:flex; justify-content:space-between; align-items:start;">
                <div>
                    <h4>Catégories</h4>
                    <div class="number">{{ $totalCategories ?? 6 }}</div>
                </div>
                <div style="background:#fef5e7; padding:10px; border-radius:50%; color:#f39c12;">
                    <i class='bx bxs-category' style="font-size:24px;"></i>
                </div>
            </div>
            <small style="color:#7f8c8d;">Catalogue à jour</small>
        </div>

        <div class="card" style="border-left-color: #e74c3c;">
            <div style="display:flex; justify-content:space-between; align-items:start;">
                <div>
                    <h4>Alertes Critiques</h4>
                    <div class="number" style="color: #e74c3c;">2</div>
                </div>
                <div style="background:#fadbd8; padding:10px; border-radius:50%; color:#e74c3c;">
                    <i class='bx bxs-error-circle' style="font-size:24px;"></i>
                </div>
            </div>
            <small style="color:#e74c3c;">Action requise</small>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 25px; margin-bottom: 40px; margin-top: 25px;">
        
        <div class="card">
            <h3 style="margin-bottom: 20px;">Évolution des Réservations</h3>
            <canvas id="reservationsChart" style="height: 300px; width: 100%;"></canvas>
        </div>

        <div class="card">
            <h3 style="margin-bottom: 20px;">Taux d'Occupation</h3>
            <div style="position: relative; height: 250px;">
                <canvas id="occupationChart"></canvas>
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                    <span style="font-size: 24px; font-weight: bold; color: #2c3e50;">85%</span><br>
                    <small style="color: #7f8c8d;">Utilisé</small>
                </div>
            </div>
            <div style="text-align:center; margin-top:20px;">
                <span class="status active" style="background:#fadbd8; color:#c0392b; padding: 5px 10px; border-radius: 5px;">État: Surchargé</span>
            </div>
        </div>
    </div>

    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
            <h3>Dernières Activités</h3>
            <button class="btn-primary" style="padding:8px 15px; font-size:12px; background:#95a5a6; color:white; border:none; border-radius:4px; cursor:pointer;">Voir Tout</button>
        </div>
        <table class="data-table" style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="text-align:left; border-bottom:1px solid #eee;">
                    <th style="padding:10px;">Utilisateur</th>
                    <th>Action</th>
                    <th>Ressource</th>
                    <th>Date</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>
                <tr style="border-bottom:1px solid #f9f9f9;">
                    <td style="padding:10px; display:flex; align-items:center; gap:10px;">
                        <div style="width:30px; height:30px; background:#3498db; border-radius:50%; color:white; display:flex; justify-content:center; align-items:center; font-size:12px;">AA</div>
                        <b>Ahmed Admin</b>
                    </td>
                    <td>Ajout Ressource</td>
                    <td>Server Dell R740</td>
                    <td>02 Jan 2026</td>
                    <td><span style="background:#d4efdf; color:#27ae60; padding:4px 8px; border-radius:4px; font-size:12px;">Succès</span></td>
                </tr>
                <tr>
                    <td style="padding:10px; display:flex; align-items:center; gap:10px;">
                        <div style="width:30px; height:30px; background:#e67e22; border-radius:50%; color:white; display:flex; justify-content:center; align-items:center; font-size:12px;">ST</div>
                        <b>Sarah Tech</b>
                    </td>
                    <td>Maintenance</td>
                    <td>Baie Stockage 04</td>
                    <td>01 Jan 2026</td>
                    <td><span style="background:#fcf3cf; color:#f1c40f; padding:4px 8px; border-radius:4px; font-size:12px;">En cours</span></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        // --- GRAPHIQUE 1 : RÉSERVATIONS ---
        const ctx1 = document.getElementById('reservationsChart').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Réservations Confirmées',
                    data: [12, 19, 3, 5, 2, 3],
                    backgroundColor: '#2ecc71',
                    borderRadius: 5
                }, {
                    label: 'Demandes Refusées',
                    data: [2, 3, 1, 0, 1, 0],
                    backgroundColor: '#e74c3c',
                    borderRadius: 5
                }]
            },
            options: { responsive: true, plugins: { legend: { position: 'top' } } }
        });

        // --- GRAPHIQUE 2 : OCCUPATION ---
        const ctx2 = document.getElementById('occupationChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Utilisé', 'Libre'],
                datasets: [{
                    data: [85, 15],
                    backgroundColor: ['#2c3e50', '#ecf0f1'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: { responsive: true, cutout: '75%', plugins: { legend: { display: false } } }
        });
    </script>
@endsection