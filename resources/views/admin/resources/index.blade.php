@extends('layouts.admin')

@section('title', 'Catalogue Ressources')
@section('header-title', 'Gestion des Ressources')

<style>
    /* Design dyal Select bach yban bhal Badge */
    .status-select {
        padding: 6px 15px;
        border-radius: 20px;
        border: none;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        text-align: center;
        appearance: none; /* Kanhydo l-fleche standard */
        -webkit-appearance: none;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        width: 140px; /* 3ard fix */
    }

    .status-select:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    /* Les Couleurs 3la 7ssab Status */
    .status-disponible { background-color: #d4efdf !important; color: #27ae60 !important; border: 1px solid #27ae60; }
    .status-reserve { background-color: #eaf2f8 !important; color: #3498db !important; border: 1px solid #3498db; }
    .status-maintenance { background-color: #fef9e7 !important; color: #f39c12 !important; border: 1px solid #f39c12; }
    .status-desactive { background-color: #fadbd8 !important; color: #e74c3c !important; border: 1px solid #e74c3c; }
</style>
@section('content')
    @if(session('success'))
        <div style="background: #d4efdf; color: #27ae60; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            <i class='bx bx-check-circle'></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <a href="{{ route('admin.resources.create') }}" class="btn-primary" style="padding: 10px 20px; background: var(--primary-color); color: white; border-radius: 5px; text-decoration: none; display: flex; align-items: center; gap: 8px;">
            <i class='bx bx-plus-circle'></i> Nouvelle Ressource
        </a>
    </div>

    <div class="card">
        <table class="data-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9f9f9; text-align: left;">
                    <th style="padding: 12px;">Nom / IP</th>
                    <th>Type</th>
                    <th>Specs</th>
                    <th>Responsable</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($resources as $resource)
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;">
                        <b>{{ $resource->name }}</b><br>
                        <small style="color: #777;">{{ $resource->ip_address ?? 'Non attribuée' }}</small>
                    </td>

                    <td>
                        <span style="background: #eaf2f8; color: var(--primary-color); padding: 4px 8px; border-radius: 4px; font-size: 12px; text-transform: uppercase;">
                            {{ $resource->type }}
                        </span>
                    </td>

                    <td>
                        <small>
                            <i class='bx bx-chip'></i> {{ $resource->cpu ?? '-' }} Cores<br>
                            <i class='bx bx-memory-card'></i> {{ $resource->ram ?? '-' }} GB
                        </small>
                    </td>

                    <td>
                        @if($resource->responsable)
                            {{ $resource->responsable->name }}
                        @else
                            <span style="color: #ccc;">--</span>
                        @endif
                    </td>

                    <td>
                        <form action="{{ route('admin.resources.updateStatus', $resource->id) }}" method="POST">
                             @csrf
                             <select name="status" onchange="this.form.submit()" class="status-select status-{{ $resource->status }}">
                             <option value="disponible" {{ $resource->status == 'disponible' ? 'selected' : '' }}>🟢 Disponible</option>
                             <option value="reserve" {{ $resource->status == 'reserve' ? 'selected' : '' }}>🔵 Réservé</option>
                             <option value="maintenance" {{ $resource->status == 'maintenance' ? 'selected' : '' }}>🟠 Maintenance</option>
                             <option value="desactive" {{ $resource->status == 'desactive' ? 'selected' : '' }}>🔴 Désactivé</option>
                             </select>
                        </form>
                    </td>

                    <td>
                        <a href="{{ route('admin.resources.edit', $resource->id) }}" style="color: #3498db; margin-right: 10px;">
                            <i class='bx bx-edit' style="font-size: 20px;"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 20px; color: #777;">
                        Aucune ressource trouvée. Cliquez sur "Nouvelle Ressource".
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const selects = document.querySelectorAll('.status-select');
        
        selects.forEach(select => {
            // Fonction bach tbdl l-couleur
            function updateColor() {
                // Kanms7o ga3 l-couleurs l-9dam
                select.classList.remove('status-disponible', 'status-reserve', 'status-maintenance', 'status-desactive');
                // Kanzido l-couleur jdida
                select.classList.add('status-' + select.value);
            }
            
            // Appliquer couleur f l-bdaya
            updateColor();
            
            // Appliquer couleur mli tbdl l-choix
            select.addEventListener('change', updateColor);
        });
    });
</script>
@endsection