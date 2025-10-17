<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIJEMBAT - Dinas PUPR Tanggamus</title>

    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6fa;
            overflow-x: hidden;
        }

        /* === SIDEBAR === */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #0052D4, #4364F7, #6FB1FC);
            color: white;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.15);
            z-index: 100;
            overflow-x: hidden;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        /* === HEADER LOGO === */
        .sidebar-header {
            text-align: center;
            padding: 25px 10px 15px;
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .sidebar-header img {
            width: 70px;
            height: auto;
            object-fit: contain;
            margin-bottom: 8px;
            user-select: none;
            -webkit-user-drag: none;
            transition: all 0.3s ease;
        }

        .sidebar-header h4 {
            font-weight: 700;
            font-size: 1.15rem;
            margin-bottom: 3px;
            color: #fff;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .sidebar-header p {
            font-size: 0.75rem;
            color: #e3f2ff;
            line-height: 1.3;
            transition: opacity 0.3s ease;
        }

        .sidebar.collapsed .sidebar-header img {
            width: 45px;
            margin-bottom: 0;
        }

        .sidebar.collapsed .sidebar-header p {
            opacity: 0;
            pointer-events: none;
            height: 0;
            overflow: hidden;
        }

        /* === LINK MENU === */
        .sidebar a {
            color: #e8f0ff;
            text-decoration: none;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
            border-radius: 10px;
            margin: 4px 12px;
            font-weight: 500;
            white-space: nowrap;
        }

        .sidebar a i {
            width: 22px;
            text-align: center;
            margin-right: 12px;
            font-size: 1rem;
            transition: margin 0.3s ease;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
            transform: translateX(4px);
        }

        .sidebar.collapsed a {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed a i {
            margin-right: 0;
        }

        .sidebar.collapsed .sidebar-text {
            display: none;
        }

        /* === TOGGLE BUTTON === */
        .toggle-btn {
            position: absolute;
            top: 50%;
            right: -12px;
            transform: translateY(-50%);
            background-color: #0052D4;
            color: white;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            z-index: 1100;
        }

        .toggle-btn:hover {
            background: #006ae6;
            transform: translateY(-50%) scale(1.1);
        }

        /* === HEADER BAR === */
        .header-bar {
            position: fixed;
            top: 0;
            left: 250px;
            right: 0;
            height: 70px;
            background: linear-gradient(90deg, #0052D4, #4364F7, #6FB1FC);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            z-index: 900;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed~.header-bar {
            left: 80px;
        }

        /* === TEKS BERJALAN === */
        .scrolling-title {
            width: 100%;
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            flex: 1;
        }

        .header-text {
            display: inline-block;
            font-size: 1.4rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #fff;
            animation: scrollText 20s linear infinite;
        }

        @keyframes scrollText {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* === USER INFO === */
        .header-user {
            white-space: nowrap;
            font-size: 1rem;
            font-weight: 500;
            color: #f1f1f1;
            display: flex;
            align-items: center;
            gap: 5px;
            padding-left: 15px;
        }

        .header-user i {
            font-size: 1.3rem;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .header-text {
                font-size: 1rem;
                animation-duration: 12s;
            }

            .header-bar {
                left: 80px;
                padding: 0 15px;
            }
        }

        /* === MAIN CONTENT === */
        .main-content {
            margin-left: 250px;
            padding: 100px 25px 25px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.collapsed {
            margin-left: 80px;
        }

        /* === LOGOUT === */
        .logout {
            margin-top: auto;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding: 12px 20px;
            color: #e0e0e0;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .logout:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* === RESPONSIVE === */
        @media (max-width: 768px) {
            .sidebar {
                width: 80px;
            }

            .main-content {
                margin-left: 80px;
            }

            .header-bar {
                left: 80px;
            }
        }
    </style>
</head>

<body>
    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('image/logo-tanggamus.png') }}" alt="Logo Tanggamus">
            <h4 id="sidebarTitle">SIJEMBAT</h4>
            <p>Sistem Informasi Jembatan<br>Kabupaten Tanggamus</p>
        </div>

        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> <span class="sidebar-text">Dashboard</span>
        </a>
        <a href="{{ route('bridges.index') }}" class="{{ request()->routeIs('bridges.*') ? 'active' : '' }}">
            <i class="fas fa-database"></i> <span class="sidebar-text">Data Jembatan</span>
        </a>
        <a href="{{ route('bridges.import.view') }}" class="{{ request()->is('bridges/import') ? 'active' : '' }}">
            <i class="fas fa-file-import"></i> <span class="sidebar-text">Import Data</span>
        </a>
        <a href="{{ route('export.data') }}" class="{{ request()->is('export-data') ? 'active' : '' }}">
            <i class="fas fa-file-export"></i> <span class="sidebar-text">Export Data</span>
        </a>
        <a href="{{ route('public.jembatan') }}">
            <i class="fas fa-globe"></i> <span class="sidebar-text">Halaman Publik</span>
        </a>
        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="fas fa-user"></i> <span class="sidebar-text">Profil Admin</span>
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout w-100 bg-transparent border-0 text-start">
                <i class="fas fa-sign-out-alt"></i> <span class="sidebar-text">Logout</span>
            </button>
        </form>

        <button class="toggle-btn" id="toggleSidebar"><i class="fas fa-chevron-left"></i></button>
    </div>

    <!-- HEADER BAR -->
    <div class="header-bar" id="headerBar">
        <div class="scrolling-title">
            <span class="header-text">
                SISTEM INFORMASI JEMBATAN KABUPATEN TANGGAMUS
            </span>
        </div>
        <div class="header-user">
            <i class="fas fa-user-circle me-2"></i>
            {{ Auth::user()->name ?? 'Administrator' }}
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content" id="mainContent">
        @yield('content')
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');
        const toggleBtn = document.getElementById('toggleSidebar');
        const icon = toggleBtn.querySelector('i');
        const title = document.getElementById('sidebarTitle');
        const headerBar = document.getElementById('headerBar');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('collapsed');

            if (sidebar.classList.contains('collapsed')) {
                icon.classList.replace('fa-chevron-left', 'fa-chevron-right');
                title.textContent = "S.I.J";
            } else {
                icon.classList.replace('fa-chevron-right', 'fa-chevron-left');
                title.textContent = "SIJEMBAT";
            }
        });
    </script>
</body>

</html>
