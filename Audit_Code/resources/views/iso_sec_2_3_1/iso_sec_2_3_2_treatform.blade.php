@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
@endphp



<div class="container">
    @if ($errors->any())
    <div >
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<h3 class="text-center">Section 2.3.2 Asset Id: {{$asset_id}} Control num: {{$control_num}} Risk Treatment</h3>

<p>Asset value: {{$assetvalue}}</p>

<div class="row d-flex justify-content-center">

    <div class="col-md-6">


        <div class="card mt-2">
            <div class="card-header bg-primary text-center">
                <h2>Information Security Risk Assessment And Treatment</h2>
              </div>
            <div class="card-body">

        <form action="/iso_sec_2_3_2_treat_form_submit/{{$asset_id}}/{{$control_num}}/{{$asset}}/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="asset_id" value="{{$asset_id}}">
            <input type="hidden" name="control_num" value="{{$control_num}}">



              <div class="form-group mt-4">
                <label for="">Residual Risk Treatment</label>
         <select name="residual_risk_treatment" class="form-control">
            <option value="">Select</option>
            <option value="retain and accept risk">Retain and Accept Risk</option>
            <option value="share risk">Share Risk</option>
            <option value="avoid risk">Avoid Risk</option>
            <option value="modify risk">Modify Risk</option>
         </select>
         @if($errors->has('residual_risk_treatment'))
         <div class="text-danger">{{ $errors->first('residual_risk_treatment') }}</div>
     @endif
              </div>


              <div class="form-group mt-4">
                <label for=""> Treatment Action</label>
                    <input type="text" name="treatment_action" value="{{old('treatment_action',$treatmentData->treatment_action)}}">
                    @if($errors->has('treatment_action'))
                    <div class="text-danger">{{ $errors->first('treatment_action') }}</div>
                @endif
              </div>

              <div class="form-group mt-4">
                <label for=""> Treatment Target Date</label>
                <input type="date" name="treatment_target_date" value="{{old('treatment_target_date',$treatmentData->treatment_target_date)}}">
                    @if($errors->has('treatment_target_date'))
                    <div class="text-danger">{{ $errors->first('treatment_target_date') }}</div>
                @endif
              </div>

              <div class="form-group mt-4">
                <label for=""> Responsbility for Treatment</label>
                <select class="boxstyling bg-primary form-select" name="responsibility_for_treatment">
                    <option value="">Select User</option>
                     @foreach ($users as $user)
     <option value="{{$user->id}}" {{ old('responsibility_for_treatment') == $user->id ? 'selected' : '' }}>
             {{$user->first_name}} {{$user->last_name}}</option>
                           @endforeach
                    </select>
                    @if($errors->has('responsibility_for_treatment'))
                    <div class="text-danger">{{ $errors->first('responsibility_for_treatment') }}</div>
                @endif
              </div>




              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-md mt-2">Submit Details</button>
              </div>


        </form>

    </div>
</div>


    </div>
</div>





</div>

@section('scripts')



@endsection



@endsection

