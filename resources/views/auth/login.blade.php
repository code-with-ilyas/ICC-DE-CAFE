<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with FoodHut landing page.">
    <meta name="author" content="Devcrud">
    <title>ICC DE CAFE</title>

    <!-- Font Icons -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/animate/animate.css">

    <!-- Bootstrap + FoodHut main styles -->
    <link rel="stylesheet" href="assets/css/foodhut.css">

    <style>
        /* Remove Scrolling */
        html, body {
            overflow: hidden;
            height: 100%;
        }

        /* Style Fixes */
        h4, .form-label, .form-check-label {
            color: #333 !important; /* Light black color */
        }

        /* Adjust Logo Size */
        .brand-img {
            width: 150px; /* Change size as needed */
            height: auto;
        }

        /* Center Content */
        .full-page-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        /* Adjust Navbar */
        .custom-navbar {
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <div class="container d-flex justify-content-between align-items-center p-3">
            <!-- Cafe Name -->
            <a class="navbar-brand text-white" href="{{ route('home') }}">
                <h4 class="brand-txt text-white">ICC DE CAFE</h4>
            </a>

            <!-- Navigation Links Moved to Right -->
            <div class="ms-auto">
                <a class="nav-link d-inline-block text-white me-3 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                <a class="nav-link d-inline-block text-white me-3 {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                <a class="nav-link d-inline-block text-white {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
            </div>
        </div>
    </nav>

    <!-- Logo & Login Form Container -->
    <div class="full-page-container">
        <!-- Logo -->
        <a class="navbar-brand text-center" href="#">
            <img src="{{ asset('assets/imgs/GreenBurger.png') }}" class="brand-img" alt="ICC DE CAFE">
            <span class="brand-txt d-block text-center">ICC DE CAFE</span>
        </a>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="p-4 bg-white rounded shadow" style="max-width: 400px; width: 100%;">
            @csrf
            <h4 class="text-center text-black mb-3">LOGIN</h4>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required autofocus autocomplete="username" value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <div class="text-danger mt-1">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required autocomplete="current-password">
                @if ($errors->has('password'))
                    <div class="text-danger mt-1">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                <label class="form-check-label text-black" for="remember_me">Remember me</label>
            </div>
            <div class="text-end mb-3">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900">Forgot your password?</a>
                @endif
            </div>
            <button type="submit" class="btn btn-secondary w-100">Login</button>
        </form>
    </div>
</body>
</html>
