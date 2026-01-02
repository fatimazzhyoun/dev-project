@extends('layouts.app') 
{{-- Ou @extends('admin.layout') selon comment s'appelle ton fichier principal --}}

@section('content')
<div class="container mt-4">
    <h1>Planifier une Maintenance 🔧</h1>

    <form action="{{ route('admin.maintenances.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Ressource (Machine) concernée</label>
            <select name="resource_id" class="form-control" required>
                @foreach($resources as $resource)
                    <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Date de début</label>
            <input type="datetime-local" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Date de fin estimée (Optionnel)</label>
            <input type="datetime-local" name="end_date" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Raison de la maintenance</label>
            <textarea name="reason" class="form-control" rows="3" placeholder="Ex: Remplacement du disque dur..." required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Planifier</button>
        <a href="{{ route('admin.maintenances.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection