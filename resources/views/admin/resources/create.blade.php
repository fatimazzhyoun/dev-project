<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une ressource - Admin</title>

    <link rel="stylesheet" href="{{ asset('css/admin-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .form-container { max-width: 900px; margin: 0 auto; }
        .form-row { display: flex; gap: 20px; margin-bottom: 5px; }
        .form-col { flex: 1; }
        
        textarea.custom-input {
            width: 100%; padding: 12px; border: 2px solid #ecf0f1; border-radius: 8px; outline: none; font-family: inherit; resize: vertical; transition: 0.3s;
        }
        textarea.custom-input:focus { border-color: var(--primary-color); }
        
        .back-link { display: inline-block; margin-top: 20px; color: var(--gray-color); text-decoration: none; font-weight: 600; font-size: 14px; }
        .back-link:hover { color: var(--primary-color); }

        @media (max-width: 768px) { .form-row { flex-direction: column; gap: 0; } }
    </style>
</head>
<body>

    <div class="admin-container">
        
        <aside class="sidebar">
            <div class="logo"><h2>AdminPanel</h2></div>
            <nav>
                <ul>
                    <li><a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i> Tableau de bord</a></li>
                    <li>
                        <a href="{{ route('admin.resources.index') }}" style="background: linear-gradient(90deg, rgba(46, 204, 113, 0.15), transparent); color: var(--primary-color); border-left: 3px solid var(--primary-color);">
                            <i class="fa-solid fa-server"></i> Ressources
                        </a>
                    </li>
                    <li><a href="#"><i class="fa-solid fa-users"></i> Utilisateurs</a></li>
                </ul>
            </nav>
            <div class="logout-section"><a href="#"><i class="fa-solid fa-right-from-bracket"></i> Déconnexion</a></div>
        </aside>

        <main class="main-content">
            <header class="top-bar">
                <h3>Gestion des Ressources</h3>
                <div class="header-actions">
                    <div class="notif-box"><i class="fa-regular fa-bell"></i><span class="notif-count">3</span></div>
                    <div class="user-info"><span>Admin</span></div>
                </div>
            </header>

            <div class="content-wrapper">
                <div class="form-container">
                    <div class="card">
                        <h4>➕ Ajouter une nouvelle ressource</h4>
                        
                        <form action="{{ route('admin.resources.store') }}" method="POST">
                            @csrf 
                            
                            <div class="form-row">
                                <div class="form-col form-group">
                                    <label for="name">Nom de la ressource *</label>
                                    <input type="text" name="name" id="name" placeholder="Ex: Serveur Dell PowerEdge R740" required>
                                </div>
                                <div class="form-col form-group">
                                    <label for="type">Type de ressource *</label>
                                    <select name="type" id="type-select" required>
                                        <option value="">-- Choisir un type --</option>
                                        <option value="serveur">Serveur</option>
                                        <option value="vm">Machine Virtuelle</option>
                                        <option value="stockage">Stockage</option>
                                        <option value="reseau">Équipement Réseau</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col form-group">
                                    <label for="category_id">Catégorie</label>
                                    <select name="category_id" id="category-select">
                                        <option value="">-- Choisir une catégorie --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" data-type="{{ $category->resource_type ?? 'all' }}">
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-col form-group">
                                    <label for="responsable_id">Responsable</label>
                                    <select name="responsable_id" id="responsable-select">
                                        <option value="">-- Aucun --</option>
                                        @foreach($responsables as $responsable)
                                            <option value="{{ $responsable->id }}" data-specialite="{{ $responsable->specialite ?? 'all' }}">
                                                {{ $responsable->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col form-group">
                                    <label for="cpu">CPU (Cores)</label>
                                    <input type="number" name="cpu" placeholder="Ex: 8">
                                </div>
                                <div class="form-col form-group">
                                    <label for="ram">RAM (Go)</label>
                                    <input type="number" name="ram" placeholder="Ex: 32">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col form-group">
                                    <label for="storage">Stockage</label>
                                    <input type="text" name="storage" placeholder="Ex: 500GB SSD">
                                </div>
                                <div class="form-col form-group">
                                    <label for="bandwidth">Bande passante</label>
                                    <input type="text" name="bandwidth" placeholder="Ex: 10Gbps">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col form-group">
                                    <label for="os">Système d'exploitation</label>
                                    <input type="text" name="os" placeholder="Ex: Ubuntu 22.04">
                                </div>
                                <div class="form-col form-group">
                                    <label for="ip_address">Adresse IP</label>
                                    <input type="text" name="ip_address" placeholder="Ex: 192.168.1.10">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-col form-group">
                                    <label for="location">Emplacement</label>
                                    <input type="text" name="location" placeholder="Ex: Rack A1 - U01">
                                </div>
                                <div class="form-col form-group">
                                    <label for="status">État initial *</label>
                                    <select name="status" id="status" required>
                                        <option value="disponible">Disponible</option>
                                        <option value="reserve">Réservé</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="desactive">Désactivé</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description / Notes</label>
                                <textarea name="description" rows="3" class="custom-input" placeholder="Détails supplémentaires..."></textarea>
                            </div>

                            <button type="submit" class="btn-primary">
                                <i class="fa-solid fa-floppy-disk"></i> Enregistrer la ressource
                            </button>
                        </form>
                    </div>
                    
                    <a href="{{ route('admin.resources.index') }}" class="back-link">← Retour à la liste</a>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type-select');
            const categorySelect = document.getElementById('category-select');
            const responsableSelect = document.getElementById('responsable-select');

            const allCategories = Array.from(categorySelect.options).map(opt => opt.cloneNode(true));
            const allResponsables = Array.from(responsableSelect.options).map(opt => opt.cloneNode(true));

            function filterOptions() {
                const selectedType = typeSelect.value.toLowerCase().trim();

                // 1. FILTRAGE CATEGORIES
                categorySelect.innerHTML = '';
                allCategories.forEach(option => {
                    // resource_type récupéré depuis data-type
                    const catType = (option.dataset.type || '').toLowerCase().trim();
                    const val = option.value;
                    if (val === "" || catType === selectedType || catType === 'all' || !selectedType) {
                        categorySelect.appendChild(option.cloneNode(true));
                    }
                });
                categorySelect.value = "";

                // 2. FILTRAGE RESPONSABLES
                responsableSelect.innerHTML = '';
                allResponsables.forEach(option => {
                    const userSpec = (option.dataset.specialite || '').toLowerCase().trim();
                    const val = option.value;
                    if (val === "" || userSpec === selectedType || userSpec === 'all' || !selectedType) {
                        responsableSelect.appendChild(option.cloneNode(true));
                    }
                });
                responsableSelect.value = "";
            }

            typeSelect.addEventListener('change', filterOptions);
            if(typeSelect.value) filterOptions();
        });
    </script>
</body>
</html>