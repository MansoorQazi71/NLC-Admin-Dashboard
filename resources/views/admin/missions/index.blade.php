@extends('layouts.admin')

@section('title', 'Missions')

@section('content')
    <div class="mb-4">
        <h1 class="top-title mb-1">Mes missions</h1>
        <p class="top-subtitle mb-0">Vue d'ensemble de vos missions actives</p>
    </div>
    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="page-card p-3 kpi-card orange">En cours <span class="fs-2 fw-bold d-block">{{ $stats['en_cours'] }}</span></div></div>
        <div class="col-md-4"><div class="page-card p-3 kpi-card">En retard <span class="fs-2 fw-bold d-block">{{ $stats['en_retard'] }}</span></div></div>
        <div class="col-md-4"><div class="page-card p-3 kpi-card purple">Terminees (24h) <span class="fs-2 fw-bold d-block">{{ $stats['terminee_24h'] }}</span></div></div>
    </div>
    <form method="GET" class="mb-3">
        <input name="search" value="{{ $search }}" class="form-control form-control-lg rounded-pill" placeholder="Rechercher une mission par nom, notes ou client...">
    </form>
    <div class="row g-3">
        @foreach (['assignee' => 'Assignees', 'personnelle' => 'Personnelles', 'automatique' => 'Automatiques'] as $status => $label)
            <div class="col-lg-4">
            <div class="page-card p-3 h-100">
                <div class="d-flex justify-content-between mb-3">
                    <h5 class="mb-0">{{ $label }}</h5>
                    <span class="badge text-bg-light">{{ $missions->where('status', $status)->count() }}</span>
                </div>
                @foreach($missions->where('status', $status) as $mission)
                    <div class="page-card p-3 mb-2">
                        <p class="fw-semibold mb-1">{{ $mission->title }}</p>
                        <p class="small text-muted mb-2">{{ $mission->client?->full_name }}</p>
                        <form method="POST" action="{{ route('admin.missions.status', $mission) }}" class="d-flex gap-2">
                            @csrf @method('PATCH')
                            <select name="status" class="form-select form-select-sm rounded-pill">
                                @foreach(['assignee','personnelle','automatique','en_cours','en_retard','terminee_24h'] as $s)
                                    <option value="{{ $s }}" @selected($mission->status===$s)>{{ str($s)->replace('_', ' ') }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-sm btn-outline-primary rounded-pill">Maj</button>
                        </form>
                    </div>
                @endforeach
                @if($missions->where('status', $status)->isEmpty())
                    <div class="text-muted text-center py-5">Aucune mission</div>
                @endif
            </div>
            </div>
        @endforeach
    </div>
@endsection
