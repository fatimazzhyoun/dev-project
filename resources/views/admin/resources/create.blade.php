<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une ressource - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root { --primary: #2549ebff; --bg-body: #f3f4f6; --bg-card: #ffffff; --text-main: #1f2937; --border: #e5e7eb; }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-body); color: var(--text-main); display: flex; justify-content: center; padding: 40px 20px; }
        
        .form-card {
            background: var(--bg-card);
            width: 100%;
            max-width: 600px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid var(--border);
        }

        h1 { margin-top: 0; color: var(--primary); font-size: 1.5rem; border-bottom: 1px solid var(--border); padding-bottom: 15px; margin-bottom: 20px; }

        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 500; margin-bottom: 8px; font-size: 0.95rem; }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 1rem;
            box-sizing: border-box; /* Important pour ne pas dépasser */
            font-family: inherit;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .row { display: flex; gap: 20px; }
        .col { flex: 1; }

        .btn-submit {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 1rem;
            width: 100%;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn-submit:hover { background-color: #1d4ed8; }

        .back-link { display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #6b7280; font-size: 0.9rem; }
        .back-link:hover { color: var(--text-main); }
    </style>
</head>
<body>

    <div class="form-card">
        <h1>➕ Ajouter une nouvelle ressource</h1>

        <form action="{{ route('admin.resources.store') }}" method="POST">
            @csrf 
            <div class="form-group">
                <label for="name">Nom de la ressource *</label>
                <input type="text" name="name" id="name" placeholder="Ex: Serveur Dell PowerEdge R740" required>
            </div>
            
            <div class="form-group">
        <label for="type">Type de ressource *</label>
        <select name="type" id="type" required>
            <option value="">-- Choisir un type --</option>
            <option value="serveur">Serveur</option>
            <option value="vm">Machine Virtuelle</option>
            <option value="stockage">Stockage</option>
            <option value="reseau">Équipement Réseau</option>
        </select>
    </div>
            <div class="row">
                <div class="col form-group">
                    <label for="category_id">Catégorie *</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">-- Choisir --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col form-group">
                    <label for="status">État initial</label>
                    <select name="status" id="status">
                        <option value="disponible">Disponible</option>
                        <option value="maintenance">Maintenance</option>
                        <option value="reserve">Réservé</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col form-group">
                    <label for="cpu">CPU (Cores)</label>
                    <input type="number" name="cpu" placeholder="Ex: 8">
                </div>
                <div class="col form-group">
                    <label for="ram">RAM (GB)</label>
                    <input type="number" name="ram" placeholder="Ex: 32">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description / Notes</label>
                <textarea name="description" rows="4" placeholder="Détails supplémentaires..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Enregistrer la ressource</button>
        </form>

        <a href="/resources" class="back-link">← Retour à la liste</a>
    </div>

</body>
</html>