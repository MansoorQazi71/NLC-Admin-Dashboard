@extends('layouts.admin')

@section('title', 'Mes Clients')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="top-title mb-1">Gestion des clients</h1>
            <p class="top-subtitle mb-0">Gerez vos clients, prospects et contrats</p>
        </div>
        <a class="btn btn-success rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i>Nouveau client</a>
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
                            <a href="{{ route('admin.clients.show', $client) }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                                <i class="bi bi-eye me-1"></i>Voir
                            </a>
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
