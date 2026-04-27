@extends('layouts.admin')

@section('title', 'Demandes d\'offres')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="top-title mb-1">Demandes d'offres</h1>
            <p class="top-subtitle mb-0">Gerez vos demandes d'offres d'assurance</p>
        </div>
        <button class="btn btn-warning text-white rounded-pill px-4"><i class="bi bi-plus-lg me-1"></i>Nouvelle demande</button>
    </div>

    <div class="page-card p-4">
        <form method="GET" class="row g-2 mb-4">
            <div class="col-md-8">
                <input name="search" value="{{ $search }}" placeholder="Rechercher par client, createur, ou contenu..." class="form-control form-control-lg rounded-pill">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select form-select-lg rounded-pill">
                    <option value="">Tous les statuts</option>
                    @foreach(['brouillon'=>'Brouillon','envoyee'=>'Envoyee','en_cours'=>'En cours','terminee'=>'Terminee','annulee'=>'Annulee'] as $key => $label)
                        <option value="{{ $key }}" @selected($status===$key)>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1 d-grid">
                <button class="btn btn-primary rounded-pill"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <h4 class="mb-3 d-flex align-items-center gap-2"><i class="bi bi-file-earmark-text"></i>Demandes d'offres <span class="badge text-bg-dark rounded-pill">{{ $offers->total() }}</span></h4>
        @if($offers->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-file-earmark fs-1 d-block mb-2"></i>
                <div class="fs-5">Aucune demande d'offre</div>
                <div>Commencez par creer votre premiere demande d'offre.</div>
                <button class="btn btn-warning text-white rounded-pill mt-3 px-4"><i class="bi bi-plus-lg me-1"></i>Creer une demande</button>
            </div>
        @else
            <div class="table-responsive">
            <table class="table align-middle">
                <thead><tr><th>Titre</th><th>Client</th><th>Statut</th></tr></thead>
                <tbody>
                    @foreach($offers as $offer)
                        <tr>
                            <td class="fw-semibold">{{ $offer->title }}</td>
                            <td>{{ $offer->client?->full_name ?? '-' }}</td>
                            <td><span class="badge rounded-pill text-bg-warning">{{ str($offer->status)->replace('_', ' ') }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="pt-2">{{ $offers->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
