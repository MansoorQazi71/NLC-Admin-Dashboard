<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function index()
    {
        $month = (int) request('month', now()->month);
        $year = (int) request('year', now()->year);
        $current = Carbon::create($year, $month, 1);

        $monthEvents = AgendaEvent::query()
            ->whereBetween('event_date', [$current->copy()->startOfMonth(), $current->copy()->endOfMonth()])
            ->orderBy('event_date')
            ->get();

        $calendarEvents = $monthEvents->groupBy(fn ($event) => $event->event_date->format('Y-m-d'));

        $showCreateForm = request()->boolean('new') || request()->session()->has('errors');
        $editingEvent = null;
        if (request()->filled('edit')) {
            $editingEvent = AgendaEvent::query()->whereKey((int) request('edit'))->first();
        }

        return view('admin.agenda.index', [
            'current' => $current,
            'events' => $calendarEvents,
            'monthEvents' => $monthEvents,
            'daysInMonth' => $current->daysInMonth,
            'startsOn' => $current->copy()->startOfMonth()->dayOfWeekIso,
            'showCreateForm' => $showCreateForm,
            'editingEvent' => $editingEvent,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'color' => ['nullable', 'string', 'max:20'],
            'label' => ['nullable', 'string', 'max:255'],
        ]);

        $event = AgendaEvent::query()->create([
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'color' => $validated['color'] ?? '#69727d',
            'label' => $validated['label'] ?? null,
        ]);

        $month = Carbon::parse($event->event_date)->month;
        $year = Carbon::parse($event->event_date)->year;

        return redirect()->route('admin.agenda.index', compact('month', 'year'))->with('status', 'Evenement cree.');
    }

    public function update(Request $request, AgendaEvent $event)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date'],
            'color' => ['nullable', 'string', 'max:20'],
            'label' => ['nullable', 'string', 'max:255'],
        ]);

        $event->update([
            'title' => $validated['title'],
            'event_date' => $validated['event_date'],
            'color' => $validated['color'] ?? $event->color,
            'label' => $validated['label'] ?? null,
        ]);

        $month = Carbon::parse($event->event_date)->month;
        $year = Carbon::parse($event->event_date)->year;

        return redirect()->route('admin.agenda.index', compact('month', 'year'))->with('status', 'Evenement mis a jour.');
    }

    public function destroy(AgendaEvent $event)
    {
        $month = Carbon::parse($event->event_date)->month;
        $year = Carbon::parse($event->event_date)->year;

        $event->delete();

        return redirect()->route('admin.agenda.index', compact('month', 'year'))->with('status', 'Evenement supprime.');
    }
}
