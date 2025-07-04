
@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="text-end">
        <a href="{{route('one_link_inherent_risk_main',[
        'proj_id'=>$proj_id,
        'user_id'=>auth()->user()->id
        ])}}" class="btn btn-md btn-secondary">Back</a>
    </div>
    <form method="POST" action="/risk-description-catalog">
    @csrf
    <label>Add New Risk Description</label>
    <textarea name="description" class="form-control" required></textarea>
    <button class="btn btn-primary mt-2" type="submit">Add</button>
</form>

<hr>

<ul class="list-group mt-3">
    @foreach($catalogs as $item)
        <li class="list-group-item">{{ $item->description }}</li>
    @endforeach
</ul>

</div>