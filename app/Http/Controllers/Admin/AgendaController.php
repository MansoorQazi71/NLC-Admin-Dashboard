<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AgendaEvent;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $month = (int) request('month', now()->month);
        $year = (int) request('year', now()->year);
        $current = Carbon::create($year, $month, 1);

        $events = AgendaEvent::query()
            ->whereBetween('event_date', [$current->copy()->startOfMonth(), $current->copy()->endOfMonth()])
            ->get()
            ->groupBy(fn ($event) => $event->event_date->format('Y-m-d'));

        return view('admin.agenda.index', [
            'current' => $current,
            'events' => $events,
            'daysInMonth' => $current->daysInMonth,
            'startsOn' => $current->copy()->startOfMonth()->dayOfWeekIso,
        ]);
    }
}
