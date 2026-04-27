<aside class="admin-sidebar">
    <div class="brand-box">
        <div class="fw-bold">GM Assurances</div>
        <div class="text-muted small">Powered by Horizon</div>
    </div>
    <div class="section-label">Tableau de bord</div>
    <nav>
        @php
            $links = [
                ['label' => 'Tableau de bord', 'route' => 'admin.dashboard', 'icon' => 'bi-grid-1x2'],
                ['label' => 'Mes Clients', 'route' => 'admin.clients.index', 'icon' => 'bi-people'],
                ['label' => 'Demandes d\'offres', 'route' => 'admin.offers.index', 'icon' => 'bi-file-earmark-text'],
                ['label' => 'Agenda', 'route' => 'admin.agenda.index', 'icon' => 'bi-calendar3'],
                ['label' => 'Mes missions', 'route' => 'admin.missions.index', 'icon' => 'bi-bullseye'],
                ['label' => 'Chat', 'route' => 'admin.chat.index', 'icon' => 'bi-chat-left'],
            ];
        @endphp
        @foreach ($links as $item)
            <a href="{{ route($item['route']) }}" class="nav-item-admin {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                <i class="bi {{ $item['icon'] }}"></i>
                {{ $item['label'] }}
            </a>
        @endforeach
    </nav>
    <div class="section-label mt-2">Acces client</div>
    <a class="nav-item-admin" href="#">
        <i class="bi bi-box-arrow-up-right"></i>
        Portail Client
    </a>
    <div class="mt-auto border-top pt-3">
        <div class="small text-muted mb-2">Session</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-danger btn-sm w-100">Se deconnecter</button>
        </form>
    </div>
</aside>
