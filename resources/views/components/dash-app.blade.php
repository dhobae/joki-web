<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Custom Admin Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .sidebar {
            background: linear-gradient(180deg, #4e73df 10%, #224abe 100%);
            min-height: 100vh;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 16px;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .card {
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border: none;
        }

        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
        }

        .border-left-primary {
            border-left: 0.25rem solid #4e73df !important;
        }

        .border-left-success {
            border-left: 0.25rem solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 0.25rem solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 0.25rem solid #f6c23e !important;
        }

        .text-gray-300 {
            color: #dddfeb !important;
        }

        .text-gray-800 {
            color: #5a5c69 !important;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-left: -250px;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 1000;
                transition: margin-left 0.3s ease;
            }

            .sidebar.show {
                margin-left: 0;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>

    @yield('styles')
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="sidebar d-none d-md-block">
            <div class="p-3">
                <a class="navbar-brand text-white" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt mr-2"></i>
                    Admin Panel
                </a>
            </div>

            <div class="px-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                            href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home"></i>
                            Dashboard
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}"
                            href="{{ route('admin.bookings.index') ?? '#' }}">
                            <i class="fas fa-calendar-alt"></i>
                            Kelola Booking
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}"
                            href="{{ route('admin.rooms.index') ?? '#' }}">
                            <i class="fas fa-door-open"></i>
                            Kelola Ruangan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                            href="{{ route('admin.users.index') ?? '#' }}">
                            <i class="fas fa-users"></i>
                            Kelola User
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                            href="{{ route('admin.reports.bookings') ?? '#' }}">
                            <i class="fas fa-chart-bar"></i>
                            Laporan
                        </a>
                    </li> --}}

                    <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="main-content flex-grow-1">
            <!-- Top Navigation for Mobile -->
            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm d-md-none mb-4">
                <button class="navbar-toggler" type="button" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>

                <div class="ml-auto">
                    <div class="dropdown">
                        <button class="btn btn-link dropdown-toggle" type="button" id="userDropdown"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                            {{ Auth::user()->name }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Toggle sidebar on mobile
            $('#sidebarToggle').on('click', function() {
                $('.sidebar').toggleClass('show');
            });

            // Close sidebar when clicking outside on mobile
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.sidebar, #sidebarToggle').length) {
                    $('.sidebar').removeClass('show');
                }
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>

    @yield('scripts')
</body>

</html>
