@extends('layouts.admin')

@section('title', 'Demandes d\'offres')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h1 class="top-title mb-1">Demandes d'offres</h1>
            <p class="top-subtitle mb-0">Gerez vos demandes d'offres d'assurance</p>
        </div>
        <a class="btn btn-warning text-white rounded-pill px-4 d-flex align-items-center gap-2" href="{{ route('admin.offers.index', ['new' => 1]) }}">
            <i class="bi bi-plus-lg"></i><span>Nouvelle demande</span>
        </a>
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

        @if($showCreateForm)
            <div class="page-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 d-flex align-items-center gap-2"><i class="bi bi-plus-circle text-success"></i><span>Nouvelle demande</span></h4>
                    <a class="btn btn-outline-secondary btn-sm rounded-pill" href="{{ route('admin.offers.index') }}">Fermer</a>
                </div>
                <form method="POST" action="{{ route('admin.offers.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Client (optionnel)</label>
                            <select name="client_id" class="form-select">
                                <option value="">—</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" @selected(old('client_id') == $c->id)>{{ $c->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Titre</label>
                            <input name="title" class="form-control" value="{{ old('title') }}" maxlength="255" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select" required>
                                @foreach(['brouillon'=>'Brouillon','envoyee'=>'Envoyee','en_cours'=>'En cours','terminee'=>'Terminee','annulee'=>'Annulee'] as $key => $label)
                                    <option value="{{ $key }}" @selected(old('status') === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-success rounded-pill" type="submit">Creer</button>
                    </div>
                </form>
            </div>
        @endif

        @if($editingOffer)
            <div class="page-card p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="mb-0 d-flex align-items-center gap-2"><i class="bi bi-pencil text-primary"></i><span>Modifier la demande</span></h4>
                    <a class="btn btn-outline-secondary btn-sm rounded-pill" href="{{ route('admin.offers.index') }}">Fermer</a>
                </div>
                <form method="POST" action="{{ route('admin.offers.update', $editingOffer) }}">
                    @csrf
                    @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Client (optionnel)</label>
                            <select name="client_id" class="form-select">
                                <option value="">—</option>
                                @foreach($clients as $c)
                                    <option value="{{ $c->id }}" @selected(old('client_id', $editingOffer->client_id) == $c->id)>{{ $c->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Titre</label>
                            <input name="title" class="form-control" value="{{ old('title', $editingOffer->title) }}" maxlength="255" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Statut</label>
                            <select name="status" class="form-select" required>
                                @foreach(['brouillon'=>'Brouillon','envoyee'=>'Envoyee','en_cours'=>'En cours','terminee'=>'Terminee','annulee'=>'Annulee'] as $key => $label)
                                    <option value="{{ $key }}" @selected(old('status', $editingOffer->status) === $key)>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description', $editingOffer->description) }}</textarea>
                        </div>
                    </div>
                    <div class="mt-3 d-flex justify-content-end">
                        <button class="btn btn-primary rounded-pill" type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
        @endif

        @if($offers->isEmpty())
            <div class="text-center py-5 text-muted">
                <i class="bi bi-file-earmark fs-1 d-block mb-2"></i>
                <div class="fs-5">Aucune demande d'offre</div>
                <div>Commencez par creer votre premiere demande d'offre.</div>
                <a class="btn btn-warning text-white rounded-pill mt-3 px-4 d-flex align-items-center gap-2" href="{{ route('admin.offers.index', ['new' => 1]) }}">
                    <i class="bi bi-plus-lg"></i><span>Creer une demande</span>
                </a>
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
                            <td class="text-end">
                                <a class="btn btn-sm btn-outline-primary rounded-pill d-flex align-items-center gap-1 px-2" href="{{ route('admin.offers.index', ['edit' => $offer->id]) }}">
                                    <i class="bi bi-pencil"></i><span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.offers.destroy', $offer) }}" class="d-inline" onsubmit="return confirm('Supprimer definitivement cette demande ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger rounded-pill d-flex align-items-center gap-2" type="submit">
                                        <i class="bi bi-trash3"></i><span>Delete</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="pt-2">{{ $offers->links('pagination::bootstrap-5') }}</div>
        @endif
    </div>
@endsection
