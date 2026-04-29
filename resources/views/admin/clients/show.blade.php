@extends('layouts.admin')

@section('title', 'Dossier client')

@section('content')
    <div class="page-card p-4 p-md-5">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div>
                <h2 class="fw-bold mb-1">Dossier de {{ $client->full_name }}</h2>
                <p class="text-muted mb-0">{{ $client->email }} - {{ $client->phone }}</p>
            </div>
            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Supprimer definitivement ?\n\nCette action est irreversible et supprimera:\n- informations client\n- contrats associes\n- notes et suivis');">
                @csrf @method('DELETE')
                <button class="btn btn-danger rounded-pill d-flex align-items-center gap-2"><i class="bi bi-trash3"></i><span>Supprimer definitivement</span></button>
            </form>
        </div>

        <ul class="nav nav-pills nav-fill mb-4">
            <li class="nav-item"><a class="nav-link" href="#">Dossier client</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contrats</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Rapports de visites</a></li>
            <li class="nav-item"><a class="nav-link active" href="#">Filiation</a></li>
        </ul>

        <div class="page-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-1 d-flex align-items-center gap-2"><i class="bi bi-diagram-3 text-success"></i><span>Filiations</span></h4>
                    <p class="mb-0 text-muted">Gestion des liens entre clients prives et professionnels</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-success rounded-pill d-flex align-items-center gap-2"><i class="bi bi-buildings"></i><span>Lier a un professionnel</span></button>
                    <button class="btn btn-outline-secondary rounded-pill d-flex align-items-center gap-2"><i class="bi bi-people"></i><span>Lier a un autre prive</span></button>
                </div>
            </div>

            <h6 class="fw-bold mb-3">Filiation client prive/professionnel</h6>
            <div class="list-group">
                @forelse($client->filiations as $link)
                    <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                        <div>
                            <div class="fw-semibold">{{ $link->relatedClient?->full_name }}</div>
                            <div class="text-muted small">Relation: {{ $link->relation_type }}</div>
                        </div>
                        @if($link->relatedClient)
                            <a class="btn btn-sm btn-outline-primary rounded-pill d-flex align-items-center gap-2" href="{{ route('admin.clients.show', $link->relatedClient) }}">
                                <i class="bi bi-eye"></i><span>Voir le dossier</span>
                            </a>
                        @endif
                    </div>
                @empty
                    <div class="text-muted">Aucune filiation enregistree.</div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
