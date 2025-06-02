<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Login Page - ICC DE CAFE" />
<title>𝓲𝓬𝓬 𝓓𝓮 𝓬𝓪𝓯𝓮 𝓵𝓸𝓰𝓲𝓷 𝓯𝓸𝓻𝓶</title>



    <link rel="icon" type="image/png" href="{{ asset('assets/imgs/GreenBurger.png') }}">


    <!-- Font Icons & CSS -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css" />
    <link rel="stylesheet" href="assets/vendors/animate/animate.css" />
    <link rel="stylesheet" href="assets/css/foodhut.css" />

    <style>
        :root {
            --bg-color: rgba(99, 79, 14, 0.8);
            --input-text: yellow;
            --placeholder-text: lightyellow;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background-color: var(--bg-color);
        }

        .main-container {
            display: flex;
            height: 100vh;
            align-items: center;
            justify-content: center;
            gap: 40px;
            padding: 20px;
        }

        .logo-side img {
            height: 90vh;
            max-width: 100%;
            object-fit: contain;
        }

        .form-side {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .nav-links-left {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .nav-links-left a {
            color: yellow;
            font-weight: bold;
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 5px;
            background-color: var(--bg-color);
            transition: 0.3s ease;
            white-space: nowrap;
            box-shadow: 0 0 8px rgba(13, 233, 79, 0.6);
        }

        .nav-links-left a.active,
        .nav-links-left a:hover {
            background-color: #a1f7a1;
            /* bright green light */
            color: #333;
            box-shadow: 0 0 12px #a1f7a1;
        }

        .login-form-container {
            background-color: var(--bg-color);
            padding: 2rem;
            border-radius: 10px;
            width: 400px;
            box-shadow: 0 4px 10px rgba(13, 233, 79, 0.89);
        }

        .login-form-container h4,
        .login-form-container label,
        .login-form-container .form-check-label,
        .login-form-container a,
        .login-form-container .text-danger {
            color: yellow;
            font-weight: bold;
        }

        .login-form-container input {
            color: var(--input-text);
            background-color: transparent !important;
            border: 1px solid #ccc;
            box-shadow: 0 0 8px rgba(13, 233, 79, 0.89);
            transition: box-shadow 0.3s ease;
        }

        /* Remove gray background on focus */
        .login-form-container input:focus {
            outline: none;
            background-color: transparent !important;
            box-shadow: 0 0 12px rgba(13, 233, 79, 1);
        }

        /* Autofill fix for Chrome */
        input:-webkit-autofill {
            box-shadow: 0 0 0px 1000px transparent inset !important;
            -webkit-box-shadow: 0 0 0px 1000px transparent inset !important;
            -webkit-text-fill-color: yellow !important;
            font-weight: bold !important;
            background-color: transparent !important;
        }


        .login-form-container input::placeholder {
            color: var(--placeholder-text);
        }

        .btn-login {
            background-color: #a1f7a1;
            /* bright green light */
            color: #333;
            font-weight: bold;
            border: none;
            box-shadow: 0 0 8px #a1f7a1;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-login:hover {
            background-color: #7de17d;
            color: #000;
            box-shadow: 0 0 12px #7de17d;
        }

        @media (max-width: 992px) {
            .main-container {
                flex-direction: column;
                height: auto;
            }

            .logo-side img {
                height: 600vh;
                width: auto;
                max-width: none;
                object-fit: contain;
            }
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="logo-side">
            <img src="{{ asset('assets/imgs/GreenBurger.png') }}" alt="ICC DE CAFE Logo">
        </div>

        <div class="form-side">
            <div class="nav-links-left">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            </div>

            <form method="POST" action="{{ route('login') }}" class="login-form-container">
                @csrf
                <h4 class="text-center mb-3">LOGIN FORM</h4>

                <div class="mb-3 text-start">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required autofocus
                        value="{{ old('email') }}" placeholder="Enter your email" />
                    @error('email')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 text-start">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required
                        placeholder="Enter your password" />
                    @error('password')
                    <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check text-start">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember" />
                    <label for="remember_me" class="form-check-label">Remember me</label>
                </div>

                <div class="text-end mb-3">
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                    @endif
                </div>

                <button type="submit" class="btn btn-login w-100">LOGIN</button>
            </form>
        </div>
    </div>
</body>

</html>