<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <link rel="stylesheet" href="{{ asset('css/admin-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="admin-container">
        <aside class="sidebar">
            <div class="logo"><h2>DC Admin</h2></div>
            <nav>
                    <ul class="side-menu">
        <li class="{{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Dashboard</span>
            </a>
        </li>

        <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
            <a href="#"> 
                <i class='bx bxs-group'></i>
                <span class="text">Utilisateurs</span>
            </a>
        </li>

        <li class="{{ Request::routeIs('admin.resources.*') ? 'active' : '' }}">
    <a href="{{ route('admin.resources.index') }}">
        <i class='bx bxs-server'></i>
        <span class="text">Ressources</span>
    </a>
        </li>

        <li class="{{ Request::is('admin/categories*') ? 'active' : '' }}">
            <a href="#">
                <i class='bx bxs-category'></i>
                <span class="text">Catégories</span>
            </a>
        </li>

        <li class="{{ Request::is('admin/reservations*') ? 'active' : '' }}">
            <a href="#">
                <i class='bx bxs-calendar-check'></i>
                <span class="text">Réservations</span>
            </a>
        </li>
    </ul>

    <ul class="side-menu">
        <li>
            <a href="#" class="logout">
                <i class='bx bxs-log-out-circle'></i>
                <span class="text">Déconnexion</span>
            </a>
        </li>
    </ul>
            </nav> </aside>

        <main class="main-content">
            <header class="top-bar">
                <h3>@yield('header-title')</h3>
                <div class="user-info">
                    <span>{{ Auth::user()->name ?? 'Admin Principal' }}</span>
                    <div style="width: 35px; height: 35px; background: #ddd; border-radius: 50%;"></div>
                </div>
            </header>
            
            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/menu.js') }}"></script>
    
    @yield('scripts')
</body>
</html>