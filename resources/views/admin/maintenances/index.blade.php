<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Maintenance - Data Center</title>
    
    <link rel="stylesheet" href="{{ asset('css/admin-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .modal {
            display: none; position: fixed; z-index: 999; left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5);
            justify-content: center; align-items: center;
        }
        .modal-content {
            background-color: white; padding: 25px; border-radius: 12px;
            width: 500px; max-width: 90%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown { from {transform: translateY(-50px); opacity:0;} to {transform: translateY(0); opacity:1;} }
        
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; color: #2c3e50; }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; outline: none;
        }
        
        /* Bach l'input readonly yban gris chwia */
        input[readonly] {
            background-color: #f8f9fa;
            color: #7f8c8d;
            cursor: not-allowed;
        }

        .btn-secondary {
            padding: 8px 20px; border: 1px solid #ddd; background: white; 
            border-radius: 20px; margin-right: 10px; cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        
        <aside class="sidebar">
            <div class="logo"><h2>DC Admin</h2></div>
            <nav>
                <ul>
                    <li><a href="{{ url('/admin/dashboard') }}"><i class='bx bx-home'></i> Dashboard</a></li>
                    <li><a href="{{ url('/admin/users') }}"><i class='bx bx-user'></i> Utilisateurs</a></li>
                    <li><a href="{{ url('/admin/reservations') }}"><i class='bx bx-calendar-check'></i> Réservations</a></li>
                    <li>
                        <a href="{{ url('/maintenance') }}" class="active" 
                           style="background: linear-gradient(90deg, rgba(46, 204, 113, 0.15), transparent); color: var(--primary-color); border-left: 3px solid var(--primary-color);">
                           <i class='bx bx-wrench'></i> Maintenance
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <h3>Planification des Maintenances</h3>
                <div class="header-actions">
                    <div class="user-info"><span>Admin Principal</span><div style="width: 35px; height: 35px; background: #ddd; border-radius: 50%;"></div></div>
                </div>
            </header>
            
            <div class="content-wrapper">
                
                <button class="btn-primary" onclick="openModal()">
                    <i class='bx bx-calendar-plus'></i> Planifier une maintenance
                </button>

                <div class="card" style="margin-top: 25px;">
                    <table class="data-table" id="tableMaintenance">
                        <thead>
                            <tr>
                                <th>Ressource Ciblée</th>
                                <th>Responsable</th>
                                <th>Période</th>
                                <th>Raison</th>
                                <th>État</th>
                                <th>Actions</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($maintenances as $m)
                            <tr>
                                <td><b>{{ $m->resource->name }}</b></td>
                                <td>{{ $m->responsable }}</td>
                                <td>Du {{ $m->date_debut }} au {{ $m->date_fin }}</td>
                                <td>{{ $m->raison }}</td>
                                <td>
                                    <span class="status {{ $m->etat == 'planifiée' ? 'inactive' : 'active' }}">
                                        {{ ucfirst($m->etat) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="action-btn delete-btn">
                                        <i class='bx bx-trash'></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>

                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="maintenanceModal" class="modal">
        <div class="modal-content">
            <div style="display:flex; justify-content:space-between; margin-bottom:20px;">
                <h3>Nouvelle Maintenance</h3>
                <span onclick="closeModal()" style="cursor:pointer; font-size:24px;">&times;</span>
            </div>
            
            <form onsubmit="ajouterMaintenance(event)">
                @csrf
                
                <div class="form-group">
                    <label>Catégorie</label>
                    <select id="cat_select" onchange="updateResources()" required>
                        <option value="" disabled selected>Choisir une catégorie...</option>
                        <option value="serveurs">Serveurs & Cloud</option>
                        <option value="vms">machines virtuelles</option>
                        <option value="reseau">Réseau & Connectivité</option>
                        <option value="stockage">Stockage & Baies</option>
                        
                    </select>
                </div>

                <div class="form-group">
                    <label>Ressource</label>
               <select name="resource_id" id="res_select" required>
    <option value="" disabled selected>-- Sélectionnez d'abord une catégorie --</option>
</select>

                </div>

                <div class="form-group">
                    <label>Responsable Technique (Auto)</label>
                    <input type="text" id="resp_input" name="technician" placeholder="S'affiche automatiquement..." readonly required>
                </div>

                <div style="display:grid; grid-template-columns:1fr 1fr; gap:10px;">
                    <div class="form-group">
                        <label>Début</label>
                        <input type="date" id="date_deb" name="start_date" required>
                    </div>
                    <div class="form-group">
                        <label>Fin</label>
                        <input type="date" id="date_fin" name="end_date" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Raison</label>
                    <input type="text" id="raison" name="reason" placeholder="Ex: Mise à jour..." required>
                </div>

                <div style="text-align:right; margin-top:20px;">
                    <button type="button" onclick="closeModal()" class="btn-secondary">Annuler</button>
                    <button type="submit" class="btn-primary">Confirmer</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // --- DATA CONFIGURATION ---
        // Hna fin kan7etto les règles (Chkon responsable 3la ach, w chno homa les ressources)
        const categoriesData = {
            serveurs: {
                responsable: "Mr Khalid Amrani", // Responsable dyal Serveurs
                ressources: ["Serveur-PROD-001", "Serveur-PROD-002", "Serveur-DEV-001"]
            },
            serveurs: {
                responsable: "Mr Khalid Amrani", // Responsable dyal  mvs
                ressources: [ "VM-PROD-WEB-01","VM-PROD-DB-01","VM-TEST-APP-01"]
            },
            reseau: {
                responsable: "Mohamed Bennani", // Responsable dyal Réseau
                ressources: ["SWITCH-CORE-01", "SWITCH-ACCESS-01", "FIREWALL-MAIN-01"]
            },
            stockage: {
                responsable: "fatima zahra", // Responsable dyal Stockage
                ressources: ["SAN-STORAGE-01", "NAS-BACKUP-01", "NAS-ARCHIVE-01"]
            }
        };

        // Fonction bach tbdel les ressources mli tbedel l categorie
        function updateResources() {
            const catSelect = document.getElementById('cat_select');
            const resSelect = document.getElementById('res_select');
            const respInput = document.getElementById('resp_input');
            
            const selectedCat = catSelect.value;
            const data = categoriesData[selectedCat];

            if (data) {
                // 1. Mettre à jour le Responsable Automatiquement
                respInput.value = data.responsable;

                // 2. Mettre à jour la liste des Ressources
                resSelect.innerHTML = '<option value="" disabled selected>Choisir une ressource...</option>'; // Reset
                
                data.ressources.forEach(res => {
                    let option = document.createElement('option');
                    option.value = res;
                    option.text = res;
                    resSelect.appendChild(option);
                });
            }
        }

        // --- FONCTIONS MODAL ET TABLEAU ---

        function openModal() {
            document.getElementById('maintenanceModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('maintenanceModal').style.display = 'none';
        }
        function deleteRow(btn) {
    if (confirm("Voulez-vous vraiment supprimer cette maintenance ?")) {
        btn.closest("tr").remove();
    }
}

        
function ajouterMaintenance(e) {
    e.preventDefault(); 

    // Récupération des valeurs
    let resSelect = document.getElementById('res_select');
    let res = resSelect.value;

    let resp = document.getElementById('resp_input').value;

    let dateDeb = document.getElementById('date_deb').value;
    let dateFin = document.getElementById('date_fin').value;
    let date = `Du ${dateDeb} au ${dateFin}`;

    let raison = document.getElementById('raison').value;

    // Sécurité : vérifier que tout est rempli
    if (!res || !resp || !dateDeb || !dateFin || !raison) {
        alert("Merci de remplir tous les champs.");
        return;
    }

    // Création de la ligne HTML
    let row = `
        <tr>
            <td><b>${res}</b></td>
            <td>${resp}</td>
            <td>${date}</td>
            <td>${raison}</td>
            <td>
                <span class="status inactive" style="background:#3498db; color:white;">
                    Planifiée
                </span>
            </td>
            <td>
                <button class="action-btn delete-btn" onclick="deleteRow(this)">
                    <i class='bx bx-trash'></i>
                </button>
            </td>
        </tr>
    `;

    // Ajout dans le tableau
    document.querySelector('#tableMaintenance tbody').insertAdjacentHTML('beforeend', row);

    // Fermer le modal
    closeModal();

    // Reset du formulaire
    e.target.reset();

    // Reset manuel du select ressources
    document.getElementById('res_select').innerHTML =
        '<option value="" disabled selected>-- Sélectionnez d\'abord une catégorie --</option>';

    // Reset responsable
    document.getElementById('resp_input').value = '';
}


    </script>
</body>
</html>