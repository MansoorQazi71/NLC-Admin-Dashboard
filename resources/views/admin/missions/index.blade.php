@extends('layouts.admin')

@section('title', 'Missions')

@section('content')
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-end gap-3">
            <div>
                <h1 class="top-title mb-1">Mes missions</h1>
                <p class="top-subtitle mb-0">Vue d'ensemble de vos missions actives</p>
            </div>
            <a class="btn btn-success rounded-pill px-4 d-flex align-items-center gap-2" href="{{ route('admin.missions.index', ['new' => 1]) }}">
                <i class="bi bi-plus-lg"></i><span>Nouvelle mission</span>
            </a>
        </div>
    </div>

    @if($showCreateForm)
        <div class="page-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 d-flex align-items-center gap-2"><i class="bi bi-plus-circle text-success"></i><span>Creer une mission</span></h4>
                <a class="btn btn-outline-secondary btn-sm rounded-pill" href="{{ route('admin.missions.index') }}">Fermer</a>
            </div>
            <form method="POST" action="{{ route('admin.missions.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Titre</label>
                        <input name="title" class="form-control" maxlength="255" required value="{{ old('title') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-select" required>
                            @foreach(['assignee'=>'Assignee','personnelle'=>'Personnelle','automatique'=>'Automatique','en_cours'=>'En cours','en_retard'=>'En retard','terminee_24h'=>'Terminee (24h)'] as $key => $label)
                                <option value="{{ $key }}" @selected(old('status') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Echeance</label>
                        <input name="deadline" type="date" class="form-control" value="{{ old('deadline') }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Client</label>
                        <select name="client_id" class="form-select">
                            <option value="">—</option>
                            @foreach($clients as $c)
                                <option value="{{ $c->id }}" @selected(old('client_id') == $c->id)>{{ $c->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Assignee</label>
                        <select name="assignee_id" class="form-select">
                            <option value="">—</option>
                            @foreach($assignees as $a)
                                <option value="{{ $a->id }}" @selected(old('assignee_id') == $a->id)>{{ $a->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Notes</label>
                        <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    <button class="btn btn-success rounded-pill" type="submit">Creer</button>
                </div>
            </form>
        </div>
    @endif

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
                        <!-- <div class="d-flex justify-content-between align-items-center gap-2 mb-2"> -->
                            <form method="POST" action="{{ route('admin.missions.status', $mission) }}" class="d-flex gap-2">
                                @csrf @method('PATCH')
                                <select name="status" class="form-select form-select-sm rounded-pill">
                                    @foreach(['assignee','personnelle','automatique','en_cours','en_retard','terminee_24h'] as $s)
                                        <option value="{{ $s }}" @selected($mission->status===$s)>{{ str($s)->replace('_', ' ') }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-outline-primary rounded-pill btn-admin-action">Maj</button>
                            </form>
                        <!-- </div> -->
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
