<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

class OfferRequestController extends Controller
{
    public function index()
    {
        $search = request('search');
        $status = request('status');

        $offers = OfferRequest::query()
            ->with('client')
            ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $showCreateForm = request()->boolean('new') || request()->session()->has('errors');
        $editingOffer = null;
        if (request()->filled('edit')) {
            $editingOffer = OfferRequest::query()->whereKey((int) request('edit'))->first();
        }

        $clients = Client::query()->orderBy('full_name')->get();

        return view('admin.offers.index', compact('offers', 'search', 'status', 'showCreateForm', 'editingOffer', 'clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:brouillon,envoyee,en_cours,terminee,annulee'],
            'description' => ['nullable', 'string'],
        ]);

        OfferRequest::query()->create($validated);

        return redirect()
            ->route('admin.offers.index')
            ->with('status', 'Demande d’offre creee.');
    }

    public function update(Request $request, OfferRequest $offer)
    {
        $validated = $request->validate([
            'client_id' => ['nullable', 'integer', 'exists:clients,id'],
            'title' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:brouillon,envoyee,en_cours,terminee,annulee'],
            'description' => ['nullable', 'string'],
        ]);

        $offer->update($validated);

        return redirect()
            ->route('admin.offers.index')
            ->with('status', 'Demande d’offre mise a jour.');
    }

    public function destroy(OfferRequest $offer)
    {
        DB::transaction(function () use ($offer) {
            $offer->delete();
        });

        return redirect()->route('admin.offers.index')->with('status', 'Demande d’offre supprimee.');
    }
}
