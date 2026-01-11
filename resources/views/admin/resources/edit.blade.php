@extends('layouts.admin')

@section('content')
<style>
    
</style>
<div class="container">
    <h1>Modifier la ressource : {{ $resource->name }}</h1>

    <form action="{{ route('admin.resources.update', $resource->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label class="form-label">Nom de la ressource</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $resource->name) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Type</label>
            <select name="type" class="form-select" required>
                <option value="serveur" {{ $resource->type == 'serveur' ? 'selected' : '' }}>Serveur</option>
                <option value="vm" {{ $resource->type == 'vm' ? 'selected' : '' }}>Machine Virtuelle</option>
                <option value="stockage" {{ $resource->type == 'stockage' ? 'selected' : '' }}>Stockage</option>
                <option value="reseau" {{ $resource->type == 'reseau' ? 'selected' : '' }}>Réseau</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="category_id" class="form-select">
                <option value="">-- Aucune --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $resource->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">CPU (Cores)</label>
            <input type="number" name="cpu" class="form-control" value="{{ old('cpu', $resource->cpu) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">RAM (Go)</label>
            <input type="number" name="ram" class="form-control" value="{{ old('ram', $resource->ram) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Stockage</label>
            <input type="text" name="storage" class="form-control" value="{{ old('storage', $resource->storage) }}" placeholder="Ex: 500GB SSD">
        </div>

        <div class="mb-3">
            <label class="form-label">Bande passante</label>
            <input type="text" name="bandwidth" class="form-control" value="{{ old('bandwidth', $resource->bandwidth) }}" placeholder="Ex: 10Gbps">
        </div>

        <div class="mb-3">
            <label class="form-label">Système d'exploitation</label>
            <input type="text" name="os" class="form-control" value="{{ old('os', $resource->os) }}" placeholder="Ex: Ubuntu 22.04">
        </div>

        <div class="mb-3">
            <label class="form-label">Adresse IP</label>
            <input type="text" name="ip_address" class="form-control" value="{{ old('ip_address', $resource->ip_address) }}" placeholder="Ex: 192.168.1.10">
        </div>

        <div class="mb-3">
            <label class="form-label">Emplacement</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', $resource->location) }}" placeholder="Ex: Rack A1">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="disponible" {{ $resource->status == 'disponible' ? 'selected' : '' }}>Disponible</option>
                <option value="reserve" {{ $resource->status == 'reserve' ? 'selected' : '' }}>Réservé</option>
                <option value="maintenance" {{ $resource->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                <option value="desactive" {{ $resource->status == 'desactive' ? 'selected' : '' }}>Désactivé</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Responsable</label>
            <select name="responsable_id" class="form-select">
                <option value="">-- Aucun --</option>
                @foreach($responsables as $responsable)
                    <option value="{{ $responsable->id }}" {{ $resource->responsable_id == $responsable->id ? 'selected' : '' }}>
                        {{ $responsable->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $resource->description) }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">Mettre à jour</button>
        <a href="{{ route('admin.resources.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection