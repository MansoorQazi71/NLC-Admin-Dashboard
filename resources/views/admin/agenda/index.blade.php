@extends('layouts.admin')

@section('title', 'Agenda')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="top-title mb-1">Agenda</h1>
            <p class="top-subtitle mb-0">{{ $current->translatedFormat('F Y') }}</p>
        </div>
        <div class="btn-group">
            <a class="btn btn-outline-secondary rounded-start-pill" href="{{ route('admin.agenda.index', ['month' => $current->copy()->subMonth()->month, 'year' => $current->copy()->subMonth()->year]) }}">Mois precedent</a>
            <a class="btn btn-outline-secondary rounded-end-pill" href="{{ route('admin.agenda.index', ['month' => $current->copy()->addMonth()->month, 'year' => $current->copy()->addMonth()->year]) }}">Mois suivant</a>
        </div>
    </div>

    @if($showCreateForm)
        <div class="page-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 d-flex align-items-center gap-2"><i class="bi bi-plus-circle text-success"></i><span>Nouvel evenement</span></h4>
                <a class="btn btn-outline-secondary btn-sm rounded-pill" href="{{ route('admin.agenda.index', ['month' => $current->month, 'year' => $current->year]) }}">Annuler</a>
            </div>
            <form method="POST" action="{{ route('admin.agenda.events.store') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Titre</label>
                        <input name="title" class="form-control" value="{{ old('title') }}" maxlength="255" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input name="event_date" type="date" class="form-control" value="{{ old('event_date') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Couleur</label>
                        <input name="color" class="form-control" value="{{ old('color') ?? '#69727d' }}" placeholder="#69727d" maxlength="20">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Label (optionnel)</label>
                        <input name="label" class="form-control" value="{{ old('label') }}" maxlength="255">
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <a class="btn btn-outline-secondary rounded-pill" href="{{ route('admin.agenda.index', ['month' => $current->month, 'year' => $current->year]) }}">Cancel</a>
                    <button type="submit" class="btn btn-primary rounded-pill">Creer</button>
                </div>
            </form>
        </div>
    @endif

    @if($editingEvent)
        <div class="page-card p-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0 d-flex align-items-center gap-2"><i class="bi bi-pencil text-primary"></i><span>Modifier evenement</span></h4>
                <a class="btn btn-outline-secondary btn-sm rounded-pill" href="{{ route('admin.agenda.index', ['month' => $current->month, 'year' => $current->year]) }}">Fermer</a>
            </div>
            <form method="POST" action="{{ route('admin.agenda.events.update', $editingEvent) }}">
                @csrf
                @method('PATCH')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Titre</label>
                        <input name="title" class="form-control" value="{{ old('title', $editingEvent->title) }}" maxlength="255" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Date</label>
                        <input name="event_date" type="date" class="form-control" value="{{ old('event_date', $editingEvent->event_date->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Couleur</label>
                        <input name="color" class="form-control" value="{{ old('color', $editingEvent->color) }}" placeholder="#69727d" maxlength="20">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Label (optionnel)</label>
                        <input name="label" class="form-control" value="{{ old('label', $editingEvent->label) }}" maxlength="255">
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary rounded-pill">Enregistrer</button>
                </div>
            </form>
        </div>
    @endif

    <div class="mb-3">
        <a class="btn btn-success rounded-pill d-flex align-items-center gap-2" href="{{ route('admin.agenda.index', ['month' => $current->month, 'year' => $current->year, 'new' => 1]) }}">
            <i class="bi bi-plus-lg"></i><span>Nouvel evenement</span>
        </a>
    </div>

    <div class="page-card p-3">
        <div class="row g-1 small">
            @foreach (['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'] as $name)
                <div class="col border-bottom py-2 fw-semibold text-muted text-center">{{ $name }}</div>
            @endforeach
        </div>
        <div class="d-grid gap-1" style="grid-template-columns: repeat(7, minmax(0, 1fr));">
            @for ($i = 1; $i < $startsOn; $i++)
                <div>
                    <div class="border rounded-3 bg-light" style="min-height:130px"></div>
                </div>
            @endfor
            @for ($day = 1; $day <= $daysInMonth; $day++)
                @php $dateKey = $current->copy()->day($day)->format('Y-m-d'); $dayEvents = $events->get($dateKey, collect()); @endphp
                <div>
                    <div class="border rounded-3 p-2 bg-white" style="min-height:130px">
                        <div class="fw-semibold mb-1">{{ $day }}</div>
                        @foreach($dayEvents->take(2) as $event)
                            <div class="rounded-pill px-2 py-1 text-white small mb-1 text-truncate" style="background-color: {{ $event->color }}">{{ $event->title }}</div>
                        @endforeach
                        @if($dayEvents->count() > 2)
                            <span class="badge rounded-pill text-bg-light">+{{ $dayEvents->count() - 2 }} RDV</span>
                        @endif
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="page-card p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 d-flex align-items-center gap-2"><i class="bi bi-list-ul text-muted"></i><span>Evenements du mois</span></h4>
            <span class="text-muted small">{{ $monthEvents->count() }} evenement(s)</span>
        </div>
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Titre</th>
                        <th>Label</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monthEvents as $ev)
                        <tr>
                            <td class="text-muted">{{ $ev->event_date->format('d/m/Y') }}</td>
                            <td class="fw-semibold">
                                <span class="badge rounded-pill text-white" style="background-color: {{ $ev->color }};">{{ $ev->title }}</span>
                            </td>
                            <td>{{ $ev->label }}</td>
                            <td class="text-end">
                                <div class="admin-table-actions justify-content-end">
                                <a class="btn btn-outline-primary rounded-pill btn-admin-action" href="{{ route('admin.agenda.index', ['month' => $current->month, 'year' => $current->year, 'edit' => $ev->id]) }}">
                                    <i class="bi bi-pencil"></i><span>Edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.agenda.events.destroy', $ev) }}" onsubmit="return confirm('Supprimer definitivement cet evenement ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger rounded-pill btn-admin-action" type="submit">
                                        <i class="bi bi-trash3"></i><span>Delete</span>
                                    </button>
                                </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted py-4">Aucun evenement ce mois-ci.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
