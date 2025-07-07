
@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="text-end mt-4">
        <a href="{{route('initiate_risk_response_assessment_form',[
        'risk_id'=>$risk_record_id,
        'proj_id'=>$proj_id,
        'user_id'=>auth()->user()->id
        ])}}" class="btn btn-md btn-secondary">Back</a>
    </div>
    <form method="POST" action="/internal-audit-observation-catalog">
    @csrf
    <label>Add New Record for Internal Audit Observation Catalog</label>
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