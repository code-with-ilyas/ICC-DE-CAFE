<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>𝓲𝓬𝓬 𝓓𝓮 𝓬𝓪𝓯𝓮</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/imgs/GreenBurger.png') }}">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('admin_assets/img/favicon.ico') }}" rel="icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('admin_assets/lib/font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/lib/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/css/style.css') }}" rel="stylesheet">
    <style>
        .dark-theme {
            background-color: #1e1e1e !important;
            color: #e0e0e0 !important;
        }

        .dark-theme .sidebar {
            background-color: #2a2a2a !important;
        }

        .dark-theme .nav-link {
            color: #e0e0e0 !important;
        }

        .dark-theme .nav-link:hover {
            background-color: #333 !important;
        }

        .dark-theme footer {
            background-color: #2a2a2a !important;
            color: #ccc !important;
        }

        .dark-theme .card,
        .dark-theme .content {
            background-color: #2c2c2c !important;
            color: #ddd !important;
        }

        .dark-theme .navbar-brand img {
            border: 2px solid #444;
        }

        .dark-theme .nav-link.text-primary {
            color: rgb(222, 236, 26) !important;
        }

        .glowing-blue {
            box-shadow: 0 0 15px rgba(0, 188, 212, 0.7), 0 0 30px rgba(0, 188, 212, 0.5);
            border: 2px solid rgba(0, 188, 212, 0.7);
            transition: box-shadow 0.3s ease;
        }

        .glowing-blue:hover {
            box-shadow: 0 0 25px rgb(164, 233, 53), 0 0 40px rgba(100, 255, 10, 0.9);
        }

        /* NEW: Active link styling */
        .dark-theme .nav-link.active {
            background-color: #333 !important;
            border-left: 4px solid rgba(102, 112, 11, 0.7) !important;
            color: rgb(144, 153, 17) !important;
        }
    </style>
</head>

<body class="dark-theme">
    <div class="container-xxl d-flex p-0">
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar navbar-light">
                <a href="{{ route('dashboard') }}" class="navbar-brand mx-4 mb-4">
                    <img class="rounded-circle" src="{{ asset('admin_assets/img/GreenBurger.png') }}" alt="Logo" style="width: 120px; height: 120px; border: 4px solid rgba(0, 188, 212, 0.7); box-shadow: 0 0 12px rgba(0, 188, 212, 0.7); padding: 2px;">
                </a>
                <ul class="nav flex-column">
                    @if(auth()->user()->role === 'admin')
                    <li><a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center"><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</a></li>
                    <li><a href="{{ route('categories.index') }}" class="nav-link d-flex align-items-center"><i class="bi bi-list-task me-2"></i>Categories</a></li>
                    <li><a href="{{ route('products.index') }}" class="nav-link d-flex align-items-center"><i class="bi bi-box-seam me-2"></i>Products</a></li>
                    <li><a href="{{ route('orders.index') }}" class="nav-link d-flex align-items-center"><i class="bi bi-receipt me-2"></i>Orders</a></li>
                    <li><a href="{{ route('reports.index') }}" class="nav-link d-flex align-items-center"><i class="bi bi-graph-up-arrow me-2"></i>Reports</a></li>
                    <li><a href="{{ route('purchase_stocks.index') }}" class="nav-link d-flex align-items-center"><i class="bi bi-box-arrow-in-down me-2"></i>Purchase Stocks</a></li>
                    <li><a href="{{ route('purchase.reports.index') }}" class="nav-link d-flex align-items-center"><i class="bi bi-bar-chart-line me-2"></i>Purchase Reports</a></li>
                    <li><a href="{{ route('expenses.index') }}" class="nav-link d-flex align-items-center"><i class="bi bi-cash-coin me-2"></i>Expenses</a></li>

                    @endif
                    @if(auth()->user()->role === 'client')
                    <li><a href="{{ route('dashboard') }}" class="nav-link d-flex align-items-center"><i class="bi bi-speedometer2 me-2"></i>Client Dashboard</a></li>
                    <li><a href="{{ route('orders.index') }}" class="nav-link d-flex align-items-center"><i class="bi bi-receipt me-2"></i>Orders</a></li>
                    <li><a href="{{ route('reports.index') }}" class="nav-link d-flex align-items-center"><i class="bi bi-graph-up-arrow me-2"></i>Reports</a></li>
                    @endif
                    <li class="nav-item mt-2">
                        <a href="{{ route('logout') }}" class="nav-link text-primary fw-bold" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> 𝓛𝓞𝓖𝓞𝓤𝓣
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="content p-4 w-100">
            <div class="container-fluid">
                @yield('content')
            </div>
            <footer class="text-center py-3 mt-5">
                <small>&copy; 𝓲𝓬𝓬 <span class="text-danger">𝓓𝓮</span> 𝓬𝓪𝓯𝓮 | Developed by <span class="text-danger">MUHAMMAD ILYAS</span></small>
            </footer>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin_assets/js/main.js') }}"></script>
    @yield('scripts')

    <!-- NEW: Active Link Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');

            navLinks.forEach(link => {
                const linkPath = new URL(link.href).pathname;
                if (linkPath === currentPath) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>

</html>