<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMissionStatusRequest;
use App\Models\Mission;
use App\Models\MissionStatusHistory;

class MissionController extends Controller
{
    public function index()
    {
        $search = request('search');

        $missions = Mission::query()
            ->with(['client', 'assignee'])
            ->when($search, fn ($q) => $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
                    ->orWhereHas('client', fn ($c) => $c->where('full_name', 'like', "%{$search}%"));
            }))
            ->latest()
            ->get();

        return view('admin.missions.index', [
            'search' => $search,
            'missions' => $missions,
            'stats' => [
                'en_cours' => Mission::where('status', 'en_cours')->count(),
                'en_retard' => Mission::where('status', 'en_retard')->count(),
                'terminee_24h' => Mission::where('status', 'terminee_24h')->count(),
            ],
        ]);
    }

    public function updateStatus(UpdateMissionStatusRequest $request, Mission $mission)
    {
        $oldStatus = $mission->status;
        $newStatus = $request->validated('status');
        $mission->update(['status' => $newStatus]);

        MissionStatusHistory::create([
            'mission_id' => $mission->id,
            'changed_by' => $request->user()->id,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
        ]);

        return back()->with('status', 'Statut mis a jour.');
    }
}
