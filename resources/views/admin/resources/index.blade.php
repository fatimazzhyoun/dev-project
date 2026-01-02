<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Ressources</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">

    <div class="container">
        <h1 class="mb-4">📦 Inventaire des Ressources</h1>

        <a href="{{ route('admin.resources.create') }}" class="btn btn-primary mb-3">
            + Ajouter une nouvelle ressource
        </a>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>CPU</th>
                    <th>RAM</th>
                    <th>Status</th>
                    <th>action</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($resources as $resource)
                <tr>
                    <td>{{ $resource->id }}</td>
                    <td>{{ $resource->name }}</td>
                    <td>{{ $resource->resourceCategory->name ?? 'Aucune' }}</td>
                    <td>{{ $resource->cpu }} Cores</td>
                    <td>{{ $resource->ram }} Go</td>
                    <td>
                        <span class="badge bg-success">{{ $resource->status }}</span>
                    </td>
                   <td class="d-flex gap-2"> 
                    

    <a href="{{ route('admin.resources.edit', $resource->id) }}" class="btn btn-warning btn-sm">
        ✏️ Modifier
    </a>

    <form action="{{ route('admin.resources.toggle', $resource->id) }}" method="POST">
        @csrf
        
        @if($resource->status === 'desactive')
            <button type="submit" class="btn btn-success btn-sm">
                ✅ Activer
            </button>
        @else
            <button type="submit" class="btn btn-secondary btn-sm">
                ⛔ Désactiver
            </button>
        @endif
    </form>

</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>