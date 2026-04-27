@extends('layouts.admin')

@section('title', 'Tableau de bord')

@section('content')
    <div class="mb-4">
        <h1 class="top-title mb-1">Tableau de bord</h1>
        <p class="top-subtitle mb-0">Vue globale de l'activite administrative.</p>
    </div>
    <div class="row g-3">
        <div class="col-md-4">
            <div class="page-card p-4 kpi-card">
                <p class="text-muted mb-1">Clients</p>
                <p class="display-6 fw-bold mb-0">{{ $stats['clients'] }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="page-card p-4 kpi-card orange">
                <p class="text-muted mb-1">Demandes</p>
                <p class="display-6 fw-bold mb-0">{{ $stats['offers'] }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="page-card p-4 kpi-card purple">
                <p class="text-muted mb-1">Missions</p>
                <p class="display-6 fw-bold mb-0">{{ $stats['missions'] }}</p>
            </div>
        </div>
    </div>
@endsection
