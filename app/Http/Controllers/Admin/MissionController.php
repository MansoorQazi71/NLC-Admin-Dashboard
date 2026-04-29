<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMissionStatusRequest;
use App\Models\Client;
use App\Models\Mission;
use App\Models\MissionStatusHistory;
use App\Models\User;
use Illuminate\Http\Request;

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

        $showCreateForm = request()->boolean('new') || request()->session()->has('errors');

        $clients = Client::query()->orderBy('full_name')->get();
        $assignees = User::query()->orderBy('name')->get();

        return view('admin.missions.index', [
            'search' => $search,
            'missions' => $missions,
            'showCreateForm' => $showCreateForm,
            'clients' => $clients,
            'assignees' => $assignees,
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'assignee_id' => ['nullable', 'integer', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:assignee,personnelle,automatique,en_cours,en_retard,terminee_24h'],
            'deadline' => ['nullable', 'date'],
        ]);

        Mission::query()->create($validated);

        return redirect()->route('admin.missions.index')->with('status', 'Mission creee.');
    }

    public function update(Request $request, Mission $mission)
    {
        $validated = $request->validate([
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'assignee_id' => ['nullable', 'integer', 'exists:users,id'],
            'title' => ['required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', 'in:assignee,personnelle,automatique,en_cours,en_retard,terminee_24h'],
            'deadline' => ['nullable', 'date'],
        ]);

        $oldStatus = $mission->status;
        $mission->update($validated);

        if ($oldStatus !== $mission->status) {
            MissionStatusHistory::create([
                'mission_id' => $mission->id,
                'changed_by' => $request->user()->id,
                'old_status' => $oldStatus,
                'new_status' => $mission->status,
            ]);
        }

        return redirect()->route('admin.missions.index')->with('status', 'Mission mise a jour.');
    }

    public function destroy(Request $request, Mission $mission)
    {
        $mission->delete();

        return redirect()->route('admin.missions.index')->with('status', 'Mission supprimee.');
    }
}
