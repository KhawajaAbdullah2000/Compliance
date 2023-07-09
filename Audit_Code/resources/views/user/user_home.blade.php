@extends('master')

@section('content')
    
@include('user-nav')

<div class="mx-5">
    <h2>Welcome {{auth()->user()->first_name}}</h2>

    <br>
<a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>
@endsection

</div>
