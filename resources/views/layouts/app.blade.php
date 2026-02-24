
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Management System</title>

    

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">



    <!-- Google Font - Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- <style>
        .sidebar {
            min-height: 100vh;
            transition: all 0.3s;
            background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        .nav-link {
            color: #4a5568;
            border-radius: 0.75rem;
            margin: 0.3rem 0;
            padding: 0.85rem 1.2rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 500;
        }

        .nav-link i {
            font-size: 1.3rem;
            color: #64748b;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: linear-gradient(90deg, #eef2ff 0%, #f8f9fa 100%);
            color: #3b82f6;
            transform: translateX(5px);
        }

        .nav-link:hover i {
            color: #3b82f6;
            transform: scale(1.1);
        }

        .nav-link.active {
            background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3);
        }

        .nav-link.active i {
            color: white;
        }

        .navbar-brand {
            font-weight: 700;
            background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.5rem;
            letter-spacing: -0.5px;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            background: #f8fafc;
            border-radius: 50px;
            border: 1px solid #e2e8f0;
        }

        .user-profile i {
            font-size: 1.2rem;
            color: #3b82f6;
        }

        .logout-btn {
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(220, 38, 38, 0.3);
        }

        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .menu-section {
            padding: 1rem 0.5rem;
        }

        .menu-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            padding: 0 1rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
    </style> --}}
</head>

<body class="bg-gray-50 font-[ Poppins]">

    <div class="d-flex min-vh-100">

        <!-- Sidebar -->
        <aside class="sidebar shadow-lg" style="width: 280px;">

            <div class="sidebar-header">
                <h4 class="navbar-brand mb-0">
                    <i></i> LeadCRM
                </h4>

                <p class="text-muted small mt-2 mb-0" style="letter-spacing: 0.5px;">Lead Management System</p>
            </div>

            <div class="menu-section">
                <div class="menu-title">Main Menu</div>

                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="bi bi-speedometer2"></i>
                            <span>Dashboard</span>
                            {{-- <span class="ms-auto bg-primary text-white px-2 py-1 rounded-pill small"
                                style="font-size: 0.7rem;">3</span> --}}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('leads.index') }}"
                            class="nav-link {{ request()->routeIs('leads.*') ? 'active' : '' }}">
                            <i class="bi bi-people-fill"></i>
                            <span>Leads</span>
                            <span class="ms-auto bg-success text-white px-2 py-1 rounded-pill small"
                                style="font-size: 0.7rem;">12</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('quotations.index') }}"
                            class="nav-link {{ request()->routeIs('quotations.*') ? 'active' : '' }}">
                            <i class="bi bi-file-text-fill"></i>
                            <span>Quotations</span>
                            {{-- <span class="ms-auto bg-info text-white px-2 py-1 rounded-pill small"
                                style="font-size: 0.7rem;">8</span> --}}
                        </a>
                    </li>

                    @auth
                    @if(auth()->user()->role === 'admin')
                    <a href="{{ route('sales.index') }}" class="nav-link">
                        <i class="bi bi-person-badge-fill"></i>
                        <span>Sales Person</span>
                        <span class="ms-auto bg-warning text-white px-2 py-1 rounded-pill small"
                            style="font-size: 0.7rem;">
                            {{ \App\Models\User::where('role','sales')->count() }}
                        </span>
                    </a>
                    @endif
                    @endauth

                </ul>
            </div>

            {{-- <div class="menu-section">
                <div class="menu-title">Analytics</div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-graph-up"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="bi bi-pie-chart-fill"></i>
                            <span>Analytics</span>
                        </a>
                    </li>
                </ul>
            </div> --}}



            <!-- User Profile Section in Sidebar (Optional) -->
            <div class="mt-auto p-3 border-top">
                <div class="d-flex align-items-center">
                    {{-- <div class="bg-primary bg-opacity-10 p-2 rounded-circle">
                        <i class="bi bi-person-circle text-primary" style="font-size: 1.8rem;"></i>
                    </div> --}}
                    {{-- <div class="ms-3">
                        <h6 class="mb-0 fw-bold">{{ auth()->user()->name ?? 'John Doe' }}</h6>
                        <small class="text-muted">{{ auth()->user()->email ?? 'john@example.com' }}</small>
                    </div> --}}
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-fill d-flex flex-column">
            <!-- Top Bar -->
            <nav class="navbar navbar-light bg-white shadow-sm px-4 py-3">
                <div class="d-flex align-items-center">
                    <button class="btn btn-light btn-sm d-lg-none me-3" id="sidebarToggle">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <span class="navbar-brand mb-0">Welcome back, {{ auth()->user()->name ?? 'User' }}! 👋</span>
                </div>

                <div class="d-flex align-items-center gap-3">
                    <!-- Notifications -->
                    {{-- <div class="position-relative">
                        <i class="bi bi-bell-fill fs-5 text-muted"></i>
                        <span
                            class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </div> --}}

                    <!-- User Menu -->
                    <div class="user-profile">
                        <a href="{{ route('profile.show') }}" class="d-flex align-items-center text-decoration-none">
    <i class="bi bi-person-circle"></i>
    <span class="fw-medium ms-2">{{ auth()->user()->name ?? 'John Doe' }}</span>
    <i class="bi bi-chevron-down small ms-1"></i>
</a>

                    </div>

                    <!-- Logout Form -->
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button class="btn btn-danger logout-btn">
                            <i class="bi bi-box-arrow-right"></i>
                            <span class="d-none d-md-inline">Logout</span>
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Page Content -->
            <div class="container-fluid px-4 py-4 flex-fill">
                @yield('content')
            </div>

            <!-- Footer -->
            {{-- <footer class="bg-white py-3 px-4 border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        &copy; 2024 LeadCRM. All rights reserved.
                    </div>
                    <div class="text-muted small">
                        <i class="bi bi-clock"></i> Last updated: {{ now()->format('F j, Y') }}
                    </div>
                </div>
            </footer> --}}
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sidebar Toggle Script for Mobile -->
    <script>
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('d-none');
        document.querySelector('.sidebar').classList.toggle('d-block');
    });

    // Responsive sidebar handling
    function handleResize() {
        if (window.innerWidth < 992) {
            document.querySelector('.sidebar').classList.add('d-none');
            document.querySelector('.sidebar').classList.remove('d-block');
        } else {
            document.querySelector('.sidebar').classList.remove('d-none');
            document.querySelector('.sidebar').classList.add('d-block');
        }
    }
    
    window.addEventListener('resize', handleResize);
    handleResize();
    </script>

</body>

</html>