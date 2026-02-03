<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with FoodHut landing page.">
    <meta name="author" content="Devcrud">
    <title>𝓲𝓬𝓬 𝓓𝓮 𝓬𝓪𝓯𝓮</title>


    <link rel="icon" type="image/png" href="{{ asset('assets/imgs/GreenBurger.png') }}">

   
    <!-- font icons -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">

    <link rel="stylesheet" href="assets/vendors/animate/animate.css">

    <!-- Bootstrap + FoodHut main styles -->
     
	<link rel="stylesheet" href="assets/css/foodhut.css">

    
</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">
    
    <!-- Navbar -->
    <nav class="custom-navbar navbar navbar-expand-lg navbar-dark fixed-top" data-spy="affix" data-offset-top="10">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#home">𝓗𝓸𝓶𝓮</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="#about">About</a> -->
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#gallary">𝓖𝓪𝓵𝓵𝓮𝓻𝔂</a>
                </li>
                <li class="nav-item">
                    <!-- <a class="nav-link" href="#book-table">Book-Table</a> -->
                </li>
            </ul>

            <a class="navbar-brand m-auto" href="#">
            <img src="{{ asset('assets/imgs/GreenBurger.png') }}" class="brand-img" alt="ICC DE CAFE" style="width: 150px; height: auto;">
            <span class="brand-txt" style="color: white;">𝓲𝓬𝓬 <span style="color: red;">𝓓𝓮</span> 𝓬𝓪𝓯𝓮</span>
            </a>



            <ul class="navbar-nav">

                 <li class="nav-item">
                    <a class="nav-link" href="#testmonial">𝓡𝓮𝓿𝓲𝓮𝔀𝓼</a>
                  </li>

                  <li class="nav-item">
                     <a class="nav-link" href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">𝓛𝓸𝓰𝓲𝓷</a>
                  </li>

                 
                
            </ul>
        </div>
    </nav>
    <!-- header -->
    <header id="home" class="header">
        <div class="overlay text-white text-center">
        <h1 class="display-2 font-weight-bold my-3" style="font-style: italic;">𝓲𝓬𝓬  <span style="color: red;">𝓓𝓮 </span> 𝓬𝓪𝓯𝓮</h1>
       
            <h2 class="display-4 mb-5">𝒜𝓁𝓌𝒶𝓎𝓈 𝒻𝓇𝑒𝓈𝒽 & 𝒟𝑒𝓁𝒾𝑔𝒽𝓉𝒻𝓊𝓁</h2>
            <a class="btn btn-lg btn-primary" href="#gallary">𝓥𝓲𝓮𝔀 𝓞𝓾𝓻 𝓖𝓪𝓵𝓵𝓮𝓻𝔂</a>
        </div>
    </header>



    @yield('content')

    

     <!-- page footer  -->
     <div class="container-fluid bg-dark text-light has-height-md middle-items border-top text-center wow fadeIn">
        <div class="row">
            <div class="col-sm-4">
                <!-- <h3>EMAIL US</h3>
                <P class="text-muted">info@website.com</P> -->
            </div>
            <div class="col-sm-4">
                <h3>𝓒𝓐𝓛𝓛 𝓤𝓢</h3>
                <P class="text-muted">(0943) 480-406</P>
                <P class="text-muted">03250206666</P>
            </div>
            <div class="col-sm-4">
                <!-- <h3>FIND US</h3>
                <P class="text-muted">12345 Fake ST NoWhere AB Country</P> -->
            </div>
        </div>
    </div>
    <div class="bg-dark text-light text-center border-top wow fadeIn">
        <p class="mb-0 py-3 text-muted small">&copy; Made In <script>document.write(new Date().getFullYear())</script> & Design By <i class="ti-heart text-danger"></i><a href="http://devcrud.com">Muhammad Ilyas</a></p>
    </div>
    <!-- end of page footer -->

	<!-- core  -->
    <script src="assets/vendors/jquery/jquery-3.4.1.js"></script>
    <script src="assets/vendors/bootstrap/bootstrap.bundle.js"></script>

    <!-- bootstrap affix -->
    <script src="assets/vendors/bootstrap/bootstrap.affix.js"></script>

    <!-- wow.js -->
    <script src="assets/vendors/wow/wow.js"></script>
    
    <!-- google maps -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCtme10pzgKSPeJVJrG1O3tjR6lk98o4w8&callback=initMap"></script>

    <!-- FoodHut js -->
    <script src="assets/js/foodhut.js"></script>

</body>
</html>