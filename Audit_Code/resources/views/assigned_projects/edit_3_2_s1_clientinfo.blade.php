@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center">Edit CLientinfo for project id: {{$clientinfo->project_id}}</h4>
        <form method="post" action="/edit_3_2_s1_clientinfo/{{$clientinfo->project_id}}/{{auth()->user()->id}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Company name:</label>
                <input type="text" class="form-control" id="" name='company_name' value="{{old('company_name',$clientinfo->company_name)}}">
                @if($errors->has('company_name'))
                <div class="text-danger">{{ $errors->first('company_name') }}</div>
            @endif
              </div>

              <div class="form-group">
                  <label for="name">Company Address:</label>
                  <input type="text" class="form-control" id="" name='company_address' value="{{old('company_address',$clientinfo->company_address)}}">
                  @if($errors->has('company_address'))
                  <div class="text-danger">{{ $errors->first('company_address') }}</div>
              @endif
                </div>

                <div class="form-group">
                  <label for="name">Company URL:</label>
                  <input type="text" class="form-control" id="" name='company_url' value="{{old('company_url',$clientinfo->company_url)}}">
                  @if($errors->has('company_url'))
                  <div class="text-danger">{{ $errors->first('company_url') }}</div>
              @endif
                </div>

                <div class="form-group">
                  <label for="name">Company Contact Name:</label>
                  <input type="text" class="form-control" id="" name='company_contact_name' value="{{old('company_contact_name',$clientinfo->company_contact_name)}}">
                  @if($errors->has('company_contact_name'))
                  <div class="text-danger">{{ $errors->first('company_contact_name') }}</div>
              @endif
                </div>

                <div class="form-group">
                  <label for="">Company Contact Number:</label>
                  <input type="text" class="form-control" name="company_number" value="{{old('company_number',$clientinfo->company_contact_number)}}">
                  @if($errors->has('company_number'))
                  <div class="text-danger">{{ $errors->first('company_number') }}</div>
              @endif
                </div>

                <div class="form-group">
                  <label for="name">Company Email:</label>
                  <input type="text" class="form-control" id="" name='company_email' value="{{old('company_email',$clientinfo->company_email)}}">
                  @if($errors->has('company_email'))
                  <div class="text-danger">{{ $errors->first('company_email') }}</div>
              @endif
                </div>

                <div class="text-center mt-2">
                  <button type="submit" class="btn btn-primary btn-md">Edit details</a>
                </div>

              

        </form>
       
    </div>
</div>

        </div>
    </div>

</div>





@endsection