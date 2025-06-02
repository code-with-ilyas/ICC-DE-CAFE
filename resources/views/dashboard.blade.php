@extends('layouts.auth')

@section('content')
<div class="main-container">
    <div class="logo-side">
        <img src="{{ asset('assets/imgs/GreenBurger.png') }}" alt="ICC DE CAFE Logo">
    </div>
</div>


<style>
    body {
        margin: 0;
        padding: 0;
        overflow: hidden; /* Disable scroll */
    }

    .main-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: calc(100vh - 60px); /* Footer height accounted */
        padding: 20px;
        text-align: center;
       
    }

    .logo-side img {
        max-height: 60vh;
        width: auto;
        object-fit: contain;
    }

    
</style>
@endsection
