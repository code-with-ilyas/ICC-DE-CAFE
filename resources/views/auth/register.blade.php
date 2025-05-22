<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with FoodHut landing page.">
    <meta name="author" content="Devcrud">
    <title>ICC DE CAFE | Free Bootstrap 4.3.x template</title>

    <!-- Font Icons -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/animate/animate.css">

    <!-- Bootstrap + FoodHut main styles -->
    <link rel="stylesheet" href="assets/css/foodhut.css">

    <style>
        /* Remove Scroll */
        html, body {
            overflow: hidden;
            height: 100%;
            margin: 0;
        }

        /* Style Fixes */
        h4, .form-label, .form-check-label {
            color: #333 !important; /* Light black color */
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

        /* Adjust Logo */
        .brand-img {
            width: 150px; /* Adjust size as needed */
            height: auto;
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

            <!-- Navigation Links -->
            <div>
                <a class="nav-link d-inline-block text-white me-3 {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                <a class="nav-link d-inline-block text-white me-3 {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                <a class="nav-link d-inline-block text-white {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
            </div>
        </div>
    </nav>

    <!-- Logo & Registration Form Container -->
    <div class="full-page-container">
        <!-- Logo -->
        <a class="navbar-brand text-center mb-3" href="#">
            <img src="{{ asset('assets/imgs/GreenBurger.png') }}" class="brand-img" alt="ICC DE CAFE">
            <span class="brand-txt d-block text-center">ICC DE CAFE</span>
        </a>

        <!-- Registration Form -->
        <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
            <h4 class="text-center text-dark">REGISTER</h4>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input name="name" type="text" id="name" value="{{ old('name') }}" class="form-control" required>
                    @error('name')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" id="email" value="{{ old('email') }}" class="form-control" required>
                    @error('email')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input name="password" type="password" id="password" class="form-control" required>
                    @error('password')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input name="password_confirmation" type="password" id="password_confirmation" class="form-control" required>
                    @error('password_confirmation')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Already Registered -->
                <div class="mb-3 text-center">
                    <a href="{{ route('login') }}" class="text-primary">Already registered?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-secondary w-100">Register</button>
            </form>
        </div>
    </div>
</body>
</html>
