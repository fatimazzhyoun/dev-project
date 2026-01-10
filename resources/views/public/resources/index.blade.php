<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ressources DataCenter - Consultation publique</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .hero { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 60px 0; }
        .resource-card { transition: transform 0.2s; }
        .resource-card:hover { transform: translateY(-5px); }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">🏢 DataCenter</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('public.resources.index') }}">Ressources</a>
                <a class="nav-link" href="{{ route('public.rules') }}">Règles</a>
                <a class="nav-link btn btn-primary text-white ms-2" href="{{ route('account.request.create') }}">
                    Demander un compte
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero">
        <div class="container text-center">
            <h1 class="display-4">📦 Ressources DataCenter</h1>
            <p class="lead">Consultez les ressources disponibles pour vos projets</p>
        </div>
    </div>

    <!-- Stats -->
    <div class="container my-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Total</h5>
                        <h2 class="text-primary">{{ $stats['total'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Disponibles</h5>
                        <h2 class="text-success">{{ $stats['disponibles'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Réservées</h5>
                        <h2 class="text-warning">{{ $stats['reserves'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h5>Maintenance</h5>
                        <h2 class="text-danger">{{ $stats['maintenance'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ressources -->
    <div class="container my-5">
        <h2 class="mb-4">Ressources disponibles</h2>
        
        <div class="row">
            @forelse($resources as $resource)
                <div class="col-md-4 mb-4">
                    <div class="card resource-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $resource->name }}</h5>
                            <p class="text-muted mb-2">
                                <span class="badge bg-info">{{ $resource->type }}</span>
                                @if($resource->category)
                                    <span class="badge bg-secondary">{{ $resource->category->name }}</span>
                                @endif
                            </p>
                            
                            @if($resource->cpu || $resource->ram)
                                <p class="mb-2">
                                    @if($resource->cpu)
                                        <strong>CPU:</strong> {{ $resource->cpu }} Cores<br>
                                    @endif
                                    @if($resource->ram)
                                        <strong>RAM:</strong> {{ $resource->ram }} GB
                                    @endif
                                </p>
                            @endif
                            
                            <span class="badge bg-success">✅ Disponible</span>
                            
                            <a href="{{ route('public.resources.show', $resource) }}" class="btn btn-sm btn-outline-primary mt-3">
                                Voir détails →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Aucune ressource disponible pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- CTA -->
    <div class="container my-5 text-center">
        <div class="card bg-light">
            <div class="card-body py-5">
                <h3>Besoin d'utiliser une ressource ?</h3>
                <p class="text-muted">Demandez un compte pour réserver des ressources</p>
                <a href="{{ route('account.request.create') }}" class="btn btn-primary btn-lg">
                    Demander un compte →
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>