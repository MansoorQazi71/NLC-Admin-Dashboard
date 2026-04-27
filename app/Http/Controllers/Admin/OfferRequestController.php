<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferRequest;

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

        return view('admin.offers.index', compact('offers', 'search', 'status'));
    }
}
