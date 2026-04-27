<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body {
            background: #f4f5f9;
            color: #23262f;
        }
        .admin-shell {
            min-height: 100vh;
        }
        .admin-sidebar {
            width: 280px;
            background: #ffffff;
            border-right: 1px solid #e8e9ef;
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
            border: 1px solid #eceef4;
            border-radius: 14px;
            padding: .75rem;
            margin-bottom: 1rem;
            background: #fff;
        }
        .section-label {
            font-size: .7rem;
            text-transform: uppercase;
            color: #8d93a6;
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
            color: #4b5568;
            text-decoration: none;
            font-weight: 500;
        }
        .nav-item-admin:hover {
            background: #f2f4f9;
            color: #1f2937;
        }
        .nav-item-admin.active {
            background: #ebf2ff;
            color: #2f5cd5;
        }
        .page-card {
            border: 1px solid #eceef4;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 8px 30px rgba(38, 53, 90, .04);
        }
        .kpi-card {
            border-left: 4px solid #2fa34a;
        }
        .kpi-card.orange {
            border-left-color: #f07c2b;
        }
        .kpi-card.purple {
            border-left-color: #7b61ff;
        }
        .top-title {
            font-size: 2rem;
            font-weight: 700;
        }
        .top-subtitle {
            color: #80879a;
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
