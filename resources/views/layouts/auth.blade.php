<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ICC DE CAFE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!-- Favicon -->
    <link href="{{ asset('admin_assets/img/favicon.ico') }}" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="{{ asset('admin_assets/lib/font-awesome/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin_assets/lib/bootstrap-icons/font/bootstrap-icons.css') }}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('admin_assets/css/style.css') }}" rel="stylesheet">

    <!-- Dark Theme Styles -->
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
            color: #4db8ff !important;
        }
    </style>
</head>

<body class="dark-theme">
    <div class="container-xxl d-flex p-0">
        <!-- Sidebar Start -->
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar navbar-light">
                <a href="{{ route('dashboard') }}" class="navbar-brand mx-4 mb-4">
                    <img class="rounded-circle" src="{{ asset('admin_assets/img/GreenBurger.png') }}" alt="Logo" style="width: 120px; height: 120px;">
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="{{ asset('admin_assets/img/ilyas.jpg') }}" alt="Profile" style="width: 40px; height: 40px;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <!-- <h6 class="mb-0">MUHAMMAD ILYAS</h6> -->
                        <span class="text-white">MUHAMMAD ILYAS</span>
                    </div>
                </div>
                <ul class="nav flex-column">

                    <a href="{{ route('categories.index') }}" class="nav-link d-flex align-items-center">
                        <i class="bi bi-list-task me-2"></i> Categories</a>


                    <a href="{{ route('products.index') }}" class="nav-link d-flex align-items-center">
                        <i class="bi bi-box-seam me-2"></i> Products</a>


                    <a href="{{ route('orders.index') }}" class="nav-link d-flex align-items-center">
                        <i class="bi bi-receipt me-2"></i> Orders </a>



                    <a href="{{ route('reports.index') }}" class="nav-link d-flex align-items-center">
                        <i class="bi bi-receipt me-2"></i> Reports </a>

                    <a href="{{ route('ingredients.index') }}" class="nav-link d-flex align-items-center">
                        <i class="bi bi-receipt me-2"></i>Ingredients</a>

                    <a href="{{ route('purchase-stocks.index') }}" class="nav-link d-flex align-items-center">
                        <i class="bi bi-receipt me-2"></i>Purchase Stocks</a>




                    <!-- Logout Link -->
                    <div class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link text-primary fw-bold" style="padding: 8px 16px; transition: all 0.3s ease;"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> LogOut
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </ul>
            </nav>
        </div>
        <!-- Sidebar End -->

        <!-- Main Content Start -->
        <div class="content p-4 w-100">
            <div class="container-fluid">
                @yield('content')
            </div>

            <!-- Footer Start -->
            <footer class="text-center py-3 mt-5">
                <small>&copy; 𝓲𝓬𝓬 <span class="text-danger">𝓓𝓮</span> 𝓬𝓪𝓯𝓮 | Developed by <span class="text-danger">MUHAMMAD ILYAS</span></small>
            </footer>
            <!-- Footer End -->
        </div>
        <!-- Main Content End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('admin_assets/js/main.js') }}"></script>

    {{-- This is the added line to allow page-specific scripts --}}
    @yield('scripts')

</body>

</html>