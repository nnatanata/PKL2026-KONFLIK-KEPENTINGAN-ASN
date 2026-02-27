<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SIMAKK ASN')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --main-red: #b11217;
            --active-red: #7a0c10;
            --hover-red: rgba(255, 255, 255, 0.1);
        }

        body {
            background-color: #f4f6f9;
        }

        /*sidebar*/
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 250px;
            height: 100vh;
            background: var(--main-red);
            padding: 20px 0;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 12px rgba(0,0,0,0.15);
            transition: width 0.3s ease-in-out;
            z-index: 1000;
            border-radius: 0;
        }

        .sidebar.mini {
            width: 70px;
        }

        .sidebar.mini .menu-text,
        .sidebar.mini .brand-text,
        .sidebar.mini .collapse {
            display: none;
        }

        .sidebar.mini a {
            justify-content: center;
        }

        .sidebar a {
            color: #fff;
            padding: 12px 22px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            transition: background 0.2s ease;
            position: relative;
            background: transparent;
        }

        .sidebar a i {
            font-size: 1.1rem;
        }

        .sidebar a:hover:not(.active) {
            background: var(--hover-red);
        }

        .sidebar > a.active,
        .sidebar .collapse a.active {
            background: #7a0c10 !important;
            font-weight: 600;
        }

        .sidebar > a[data-bs-toggle="collapse"] {
            background: transparent !important;
        }

        .sidebar > a[data-bs-toggle="collapse"]:hover {
            background: var(--hover-red) !important;
        }

        .sidebar > a[data-bs-toggle="collapse"].active {
            background: #7a0c10 !important;
        }
        
        .sidebar .collapse:has(a.active) ~ a[data-bs-toggle="collapse"],
        .sidebar a[data-bs-toggle="collapse"]:has(~ .collapse a.active) {
            background: transparent !important;
        }

        .sidebar-bottom {
            margin-top: auto;
        }

        .sidebar .collapse a {
            padding-left: 45px;
            font-size: 0.95rem;
            background: transparent;
        }

        .sidebar .collapse a:hover:not(.active) {
            background: var(--hover-red);
        }

        .sidebar .collapse a.active {
            background: #7a0c10 !important;
            font-weight: 600;
        }

        .sidebar.mini .collapse a {
            padding-left: 22px;
        }

        /*navbar*/
        .topbar {
            margin-left: 280px;
            margin-right: 30px;
            margin-top: 20px;
            height: 60px;
            background: var(--main-red);
            color: white;
            border-radius: 14px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: margin-left 0.3s ease-in-out;
        }

        .topbar.full {
            margin-left: 100px;
        }

        .topbar .page-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .dropdown-toggle::after {
            margin-left: 0.5em;
        }

        .dropdown-menu {
            border-radius: 10px;
            border: none;
            margin-top: 10px;
        }

        .dropdown-item {
            padding: 10px 20px;
            transition: 0.2s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fa;
        }

        .dropdown-item i {
            margin-right: 8px;
        }

        .topbar .dropdown > a {
            transition: 0.3s;
        }

        .topbar .dropdown > a:hover i {
            opacity: 0.8;
        }
        
        .topbar .bi-caret-down-fill {
            transition: transform 0.3s ease;
        }
        
        .topbar .dropdown.show .bi-caret-down-fill {
            transform: rotate(180deg);
        }

        /*content*/
        .content {
            margin-left: 280px;
            margin-right: 30px;
            margin-top: 25px;
            padding-bottom: 40px;
            transition: margin-left 0.3s ease-in-out;
        }

        .content.full {
            margin-left: 100px;
        }

        .content.no-navbar {
            margin-top: 0;
        }

        /*card*/
        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            font-weight: 600;
            box-shadow: 0 6px 18px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .stat-card:hover {
            transform: translateY(-6px);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 10px 0;
        }

        .stat-label {
            color: #6c757d;
            font-size: 0.95rem;
            font-weight: 500;
        }
    </style>

    @stack('styles')
</head>
<body>

{{--sidebar--}}
<div id="sidebar" class="sidebar">
    <div class="px-4 mb-4 text-white fw-bold fs-5 d-flex align-items: center gap-2">
        <i class="bi bi-list fs-4" onclick="toggleSidebar()" style="cursor:pointer;"></i>
        <span class="brand-text">SIMAKK ASN</span>
    </div>

    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door"></i>
        <span class="menu-text">Dashboard</span>
    </a>

    <a data-bs-toggle="collapse" href="#menuKonflik" 
       onclick="handleMenuKonflikClick(event)">
        <i class="bi bi-folder"></i>
        <span class="menu-text">Data Konflik</span>
    </a>

    <div class="collapse {{ request()->is('konflik-*') ? 'show' : '' }}" id="menuKonflik">
        <a href="{{ route('konflik-aktual.index') }}" 
           class="{{ request()->routeIs('konflik-aktual.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i> 
            <span class="menu-text">Konflik Aktual</span>
        </a>
        <a href="{{ route('konflik-potensial.index') }}" 
           class="{{ request()->routeIs('konflik-potensial.*') ? 'active' : '' }}">
            <i class="bi bi-dot"></i> 
            <span class="menu-text">Konflik Potensial</span>
        </a>
    </div>

    {{--logout--}}
    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn w-100 text-start text-white px-4">
                <i class="bi bi-box-arrow-left"></i>
                <span class="menu-text">Logout</span>
            </button>
        </form>
    </div>
</div>

{{--navbar--}}
@if(!isset($hideNavbar) || !$hideNavbar)
<div id="topbar" class="topbar">
    <span class="page-title">@yield('breadcrumb', 'Dashboard')</span>

    @if(!isset($hideProfileIcon) || !$hideProfileIcon)
    <div class="dropdown">
        <a href="#" class="text-white text-decoration-none d-flex align-items-center gap-2" 
           id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" 
           style="cursor: pointer;">
            <i class="bi bi-person-circle fs-4"></i>
            <i class="bi bi-caret-down-fill" style="font-size: 0.85rem;"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="dropdownUser">
            <li>
                <a class="dropdown-item" href="{{ route('profile.index') }}">
                    <i class="bi bi-person"></i> Profil
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="bi bi-box-arrow-left"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
    @endif
</div>
@endif

{{--content--}}
<div id="content" class="content {{ (!isset($hideNavbar) || !$hideNavbar) ? '' : 'no-navbar' }}">
    @yield('content')
</div>

<script>
    function getSidebarState() {
        return localStorage.getItem('sidebarState') || 'expanded';
    }

    function setSidebarState(state) {
        localStorage.setItem('sidebarState', state);
    }

    function applySidebarState() {
        const state = getSidebarState();
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const content = document.getElementById('content');

        if (state === 'mini') {
            sidebar.classList.add('mini');
            if (topbar) topbar.classList.add('full');
            content.classList.add('full');
        } else {
            sidebar.classList.remove('mini');
            if (topbar) topbar.classList.remove('full');
            content.classList.remove('full');
        }
    }

    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const topbar = document.getElementById('topbar');
        const content = document.getElementById('content');
        
        sidebar.classList.toggle('mini');
        if (topbar) {
            topbar.classList.toggle('full');
        }
        content.classList.toggle('full');

        const newState = sidebar.classList.contains('mini') ? 'mini' : 'expanded';
        setSidebarState(newState);
    }

    function handleMenuKonflikClick(event) {
        const sidebar = document.getElementById('sidebar');
        const menuKonflik = event.currentTarget;
        
        if (sidebar.classList.contains('mini')) {
            event.preventDefault();
            event.stopPropagation();
            
            menuKonflik.classList.remove('active');
            
            sidebar.classList.remove('mini');
            const topbar = document.getElementById('topbar');
            if (topbar) topbar.classList.remove('full');
            document.getElementById('content').classList.remove('full');
            setSidebarState('expanded');
            
            setTimeout(() => {
                const collapseElement = document.getElementById('menuKonflik');
                if (collapseElement && !collapseElement.classList.contains('show')) {
                    const collapse = new bootstrap.Collapse(collapseElement, {
                        toggle: true
                    });
                }
                menuKonflik.classList.remove('active');
            }, 300);
        } else {
            setTimeout(() => {
                const collapseElement = document.getElementById('menuKonflik');
                const hasActiveSubmenu = collapseElement.querySelector('a.active');
                
                if (!hasActiveSubmenu) {
                    if (collapseElement.classList.contains('show')) {
                        menuKonflik.classList.add('active');
                    } else {
                        menuKonflik.classList.remove('active');
                    }
                } else {

                    menuKonflik.classList.remove('active');
                }
            }, 50);
        }
    }

    function initMenuKonflikHighlight() {
        const menuKonflikLink = document.querySelector('[data-bs-toggle="collapse"][href="#menuKonflik"]');
        const collapseElement = document.getElementById('menuKonflik');
        
        if (!menuKonflikLink || !collapseElement) return;
        
        const hasActiveSubmenu = collapseElement.querySelector('a.active');
        
        console.log('Init Menu Konflik:', {
            hasActiveSubmenu: !!hasActiveSubmenu,
            collapseShown: collapseElement.classList.contains('show')
        });
        
        menuKonflikLink.classList.remove('active');
        
        if (collapseElement.classList.contains('show') && !hasActiveSubmenu) {
            menuKonflikLink.classList.add('active');
            console.log('Added active class to Data Konflik');
        } else {
            console.log('No active class for Data Konflik');
        }
        
        collapseElement.addEventListener('show.bs.collapse', function() {
            const hasActiveSubmenu = this.querySelector('a.active');
            if (!hasActiveSubmenu) {
                menuKonflikLink.classList.add('active');
                console.log('Collapse shown - added active');
            } else {
                menuKonflikLink.classList.remove('active');
                console.log('Collapse shown - but submenu active, no highlight');
            }
        });
        
        collapseElement.addEventListener('hide.bs.collapse', function() {
            menuKonflikLink.classList.remove('active');
            console.log('Collapse hidden - removed active');
        });
        
        const submenuLinks = collapseElement.querySelectorAll('a');
        submenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                menuKonflikLink.classList.remove('active');
                console.log('Submenu clicked - removed active from Data Konflik');
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        applySidebarState();
        initMenuKonflikHighlight();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

@stack('scripts')

</body>
</html>