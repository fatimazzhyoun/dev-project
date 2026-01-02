@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Calendrier des Maintenances 📅</h1>
    
    <a href="{{ route('admin.maintenances.create') }}" class="btn btn-warning mb-3">
        + Planifier une maintenance
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Machine</th>
                <th>Début</th>
                <th>Fin prévue</th>
                <th>Raison</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($maintenances as $maintenance)
            <tr>
                <td><strong>{{ $maintenance->resource->name }}</strong></td>
                <td>{{ $maintenance->start_date->format('d/m/Y H:i') }}</td>
                <td>
                    {{ $maintenance->end_date ? $maintenance->end_date->format('d/m/Y H:i') : 'Inconnue' }}
                </td>
                <td>{{ $maintenance->reason }}</td>
                <td>
                    <span class="badge bg-secondary">{{ $maintenance->status }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection