<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        $search = request('search');
        $typeFilter = request('type');

        $clients = Client::query()
            ->when($search, fn ($q) => $q->where(function ($sub) use ($search) {
                $sub->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            }))
            ->when($typeFilter, fn ($q) => $q->where('type', $typeFilter))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.clients.index', [
            'clients' => $clients,
            'search' => $search,
            'typeFilter' => $typeFilter,
            'totalClients' => Client::count(),
            'activeContracts' => Client::where('status', 'actif')->where('type', 'client')->count(),
            'prospects' => Client::where('type', 'prospect')->count(),
        ]);
    }

    public function store(StoreClientRequest $request)
    {
        Client::create($request->validated());

        return back()->with('status', 'Client cree avec succes.');
    }

    public function show(Client $client)
    {
        $client->load(['filiations.relatedClient']);

        return view('admin.clients.show', compact('client'));
    }

    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        return back()->with('status', 'Client mis a jour.');
    }

    public function destroy(Client $client)
    {
        DB::transaction(function () use ($client) {
            $client->filiations()->delete();
            $client->delete();
        });

        return redirect()->route('admin.clients.index')->with('status', 'Client supprime.');
    }
}
