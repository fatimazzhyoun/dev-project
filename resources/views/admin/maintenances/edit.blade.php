@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier la maintenance #{{ $maintenance->id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.maintenances.update', $maintenance) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="resource_id" class="form-label">Ressource *</label>
            <select name="resource_id" id="resource_id" class="form-select" required>
                <option value="">-- Sélectionner une ressource --</option>
                @foreach($resources as $resource)
                    <option value="{{ $resource->id }}" 
                        {{ $maintenance->resource_id == $resource->id ? 'selected' : '' }}>
                        {{ $resource->name }} ({{ $resource->type }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="start_date" class="form-label">Date de début *</label>
                <input type="datetime-local" name="start_date" id="start_date" 
                       class="form-control" 
                       value="{{ $maintenance->start_date->format('Y-m-d\TH:i') }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label for="end_date" class="form-label">Date de fin *</label>
                <input type="datetime-local" name="end_date" id="end_date" 
                       class="form-control" 
                       value="{{ $maintenance->end_date->format('Y-m-d\TH:i') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="reason" class="form-label">Raison de la maintenance *</label>
            <input type="text" name="reason" id="reason" class="form-control" 
                   value="{{ $maintenance->reason }}" required>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes supplémentaires</label>
            <textarea name="notes" id="notes" class="form-control" rows="4">{{ $maintenance->notes }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">✏️ Mettre à jour</button>
        <a href="{{ route('admin.maintenances.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection