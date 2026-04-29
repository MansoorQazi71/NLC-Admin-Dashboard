<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MissionController;
use App\Http\Controllers\Admin\OfferRequestController;

Route::get('/', function () {
    if (! Auth::check()) {
        return redirect()->route('login');
    }

    return redirect()->route('admin.dashboard');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, (bool) $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Identifiants invalides.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    })->name('login.attempt');
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('/clients', ClientController::class)->except(['create', 'edit']);
    Route::get('/demandes-offres', [OfferRequestController::class, 'index'])->name('offers.index');
    Route::post('/demandes-offres', [OfferRequestController::class, 'store'])->name('offers.store');
    Route::patch('/demandes-offres/{offer}', [OfferRequestController::class, 'update'])->name('offers.update');
    Route::delete('/demandes-offres/{offer}', [OfferRequestController::class, 'destroy'])->name('offers.destroy');

    Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
    Route::post('/agenda/events', [AgendaController::class, 'store'])->name('agenda.events.store');
    Route::patch('/agenda/events/{event}', [AgendaController::class, 'update'])->name('agenda.events.update');
    Route::delete('/agenda/events/{event}', [AgendaController::class, 'destroy'])->name('agenda.events.destroy');

    Route::get('/missions', [MissionController::class, 'index'])->name('missions.index');
    Route::post('/missions', [MissionController::class, 'store'])->name('missions.store');
    Route::patch('/missions/{mission}/status', [MissionController::class, 'updateStatus'])->name('missions.status');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::post('/chat/{chatConversation}/messages', [ChatController::class, 'sendMessage'])->name('chat.messages.store');
});
