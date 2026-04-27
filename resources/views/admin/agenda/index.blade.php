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
@endsection
