@extends('layouts.auth')

@section('content')
<h2>Client Dashboard</h2>
<p>Welcome {{ auth()->user()->name }}</p>
@endsection
