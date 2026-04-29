@extends('layouts.admin')

@section('title', 'Mes Clients')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="top-title mb-1">Gestion des clients</h1>
            <p class="top-subtitle mb-0">Gerez vos clients, prospects et contrats</p>
        </div>
        <a class="btn btn-success rounded-pill px-4 d-flex align-items-center gap-2" href="{{ route('admin.clients.index', ['new' => 1] + array_filter(['search' => $search, 'type' => $typeFilter])) }}">
            <i class="bi bi-plus-lg"></i><span>Nouveau client</span>
        </a>
    </div>

    <div class="page-card p-3 p-md-4">
        <form method="GET" class="row g-2 align-items-center mb-3">
            <div class="col-md-7">
                <input class="form-control form-control-lg rounded-pill" name="search" placeholder="Rechercher un client, prospect..." value="{{ $search }}">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select form-select-lg rounded-pill">
                    <option value="">Tous</option>
                    <option value="client" @selected($typeFilter==='client')>Clients</option>
                    <option value="prospect" @selected($typeFilter==='prospect')>Prospects</option>
                    <option value="professionnel" @selected($typeFilter==='professionnel')>Professionnels</option>
                </select>
            </div>
            <div class="col-md-2 d-grid">
                <button class="btn btn-primary btn-lg rounded-pill">Filtrer</button>
            </div>
        </form>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="page-card kpi-card p-3 h-100">
                    <div class="text-muted small">Total clients</div>
                    <div class="fs-2 fw-bold">{{ $totalClients }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="page-card kpi-card orange p-3 h-100">
                    <div class="text-muted small">Contrats actifs</div>
                    <div class="fs-2 fw-bold">{{ $activeContracts }}</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="page-card kpi-card purple p-3 h-100">
                    <div class="text-muted small">Prospects</div>
                    <div class="fs-2 fw-bold">{{ $prospects }}</div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Mes Clients et Prospects</h5>
            <span class="badge text-bg-light">{{ $clients->total() }} resultat(s)</span>
        </div>

        @if($showCreateForm)
            <div class="page-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 d-flex align-items-center gap-2"><i class="bi bi-plus-circle text-success"></i><span>Nouveau client</span></h4>
                    <a class="btn btn-outline-secondary btn-sm rounded-pill" href="{{ route('admin.clients.index', array_filter(['search' => $search, 'type' => $typeFilter])) }}">Fermer</a>
                </div>
                <form method="POST" action="{{ route('admin.clients.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom complet</label>
                            <input name="full_name" class="form-control" value="{{ old('full_name') }}" maxlength="255" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email') }}" maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telephone</label>
                            <input name="phone" class="form-control" value="{{ old('phone') }}" maxlength="50">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                @foreach(['client'=>'Client','prospect'=>'Prospect','professionnel'=>'Professionnel'] as $k => $label)
                                    <option value="{{ $k }}" @selected(old('type') === $k)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select" required>
                                <option value="actif" @selected(old('status') === 'actif')>Actif</option>
                                <option value="inactif" @selected(old('status') === 'inactif')>Inactif</option>
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

        @if($editingClient)
            <div class="page-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 d-flex align-items-center gap-2"><i class="bi bi-pencil text-primary"></i><span>Modifier client</span></h4>
                    <a class="btn btn-outline-secondary btn-sm rounded-pill" href="{{ route('admin.clients.index', array_filter(['search' => $search, 'type' => $typeFilter])) }}">Fermer</a>
                </div>
                <form method="POST" action="{{ route('admin.clients.update', $editingClient) }}">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom complet</label>
                            <input name="full_name" class="form-control" value="{{ old('full_name', $editingClient->full_name) }}" maxlength="255" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input name="email" type="email" class="form-control" value="{{ old('email', $editingClient->email) }}" maxlength="255">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telephone</label>
                            <input name="phone" class="form-control" value="{{ old('phone', $editingClient->phone) }}" maxlength="50">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select" required>
                                @foreach(['client'=>'Client','prospect'=>'Prospect','professionnel'=>'Professionnel'] as $k => $label)
                                    <option value="{{ $k }}" @selected(old('type', $editingClient->type) === $k)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select" required>
                                <option value="actif" @selected(old('status', $editingClient->status) === 'actif')>Actif</option>
                                <option value="inactif" @selected(old('status', $editingClient->status) === 'inactif')>Inactif</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ old('notes', $editingClient->notes) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-primary rounded-pill" type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Telephone</th>
                    <th>Type</th>
                    <th class="text-end">Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($clients as $client)
                    <tr>
                        <td class="fw-semibold">{{ $client->full_name }}</td>
                        <td>{{ $client->email }}</td>
                        <td>{{ $client->phone }}</td>
                        <td><span class="badge rounded-pill text-bg-success-subtle text-success">{{ ucfirst($client->type) }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('admin.clients.show', $client) }}" class="btn btn-sm btn-outline-secondary rounded-pill d-flex align-items-center gap-2">
                                <i class="bi bi-eye"></i><span>Voir</span>
                            </a>
                            <a href="{{ route('admin.clients.index', ['edit' => $client->id] + array_filter(['search' => $search, 'type' => $typeFilter])) }}" class="btn btn-sm btn-outline-primary rounded-pill ms-1 d-flex align-items-center gap-1 px-2">
                                <i class="bi bi-pencil"></i><span>Edit</span>
                            </a>
                            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" class="d-inline ms-1" onsubmit="return confirm('Supprimer definitivement ce client ?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-pill d-flex align-items-center gap-2" type="submit">
                                    <i class="bi bi-trash3"></i><span>Delete</span>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-5">Aucun client trouve.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">{{ $clients->links('pagination::bootstrap-5') }}</div>
    </div>

@endsection
