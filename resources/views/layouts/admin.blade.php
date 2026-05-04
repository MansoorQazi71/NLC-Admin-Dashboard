<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    @include('partials.admin-theme')
    <style>
        .admin-shell {
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 280px;
            background: var(--nlc-surface);
            border-right: 1px solid rgba(105, 114, 125, 0.18);
            position: sticky;
            top: 0;
            height: 100vh;
            padding: 1.25rem 1rem;
            display: flex;
            flex-direction: column;
        }
        .admin-content {
            flex: 1;
            padding: 1.5rem;
        }
        .brand-box {
            border: 1px solid rgba(105, 114, 125, 0.2);
            border-radius: 14px;
            padding: .75rem;
            margin-bottom: 1rem;
            background: var(--nlc-surface);
        }
        .section-label {
            font-size: .7rem;
            text-transform: uppercase;
            color: var(--nlc-muted);
            letter-spacing: .04em;
            font-weight: 700;
            margin: .75rem .5rem .35rem;
        }
        .nav-item-admin {
            display: flex;
            align-items: center;
            gap: .6rem;
            border-radius: 12px;
            padding: .58rem .7rem;
            color: var(--nlc-text);
            text-decoration: none;
            font-weight: 500;
            opacity: 0.88;
        }
        .nav-item-admin:hover {
            background: rgba(105, 114, 125, 0.1);
            color: var(--nlc-text);
            opacity: 1;
        }
        .nav-item-admin.active {
            background: rgba(105, 114, 125, 0.14);
            color: var(--nlc-primary);
            opacity: 1;
            font-weight: 600;
        }
        .page-card {
            border: 1px solid rgba(105, 114, 125, 0.18);
            border-radius: 16px;
            background: var(--nlc-surface);
            box-shadow: 0 8px 30px rgba(31, 33, 36, .06);
        }
        .kpi-card {
            border-left: 4px solid var(--nlc-success);
        }
        .kpi-card.orange {
            border-left-color: var(--nlc-warning);
        }
        .kpi-card.purple {
            border-left-color: var(--nlc-info);
        }
        .top-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--nlc-text);
        }
        .top-subtitle {
            color: var(--nlc-muted);
        }
    </style>
</head>
<body>
    <div class="admin-shell d-flex">
        @include('admin.partials.sidebar')
        <main class="admin-content">
            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
