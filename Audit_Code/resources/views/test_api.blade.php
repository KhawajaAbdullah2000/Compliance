@extends('master')

@section('content')

<div class="container">

    <h1 class='text-center mt-4'>Testing API</h1>
<div class="mx-auto">
    <p1>ID: {{$data['data']['id']}}</p1>
    <br>
    <p1>Symbol: {{$data['data']['symbol']}}</p1>
    <br>
    <p1>Price (USD): {{$data['data']['priceUsd']}}</p1>

</div>




</div>


@endsection