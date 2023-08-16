@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center">Edit CLientinfo for project id: {{$assessor_company->project_id}}</h4>
        <form method="post" action="/edit_v3_2_assessorcompany_form/{{$assessor_company->project_id}}/{{auth()->user()->id}}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Company name:</label>
                <input type="text" class="form-control" id="" name='comp_name' value="{{old('comp_name',$assessor_company->comp_name)}}">
                @if($errors->has('comp_name'))
                <div class="text-danger">{{ $errors->first('comp_name') }}</div>
            @endif
              </div>

              <div class="form-group">
                  <label for="name">Company Address:</label>
                  <input type="text" class="form-control" id="" name='comp_address' value="{{old('comp_address',$assessor_company->comp_address)}}">
                  @if($errors->has('comp_address'))
                  <div class="text-danger">{{ $errors->first('comp_address') }}</div>
              @endif
                </div>

                <div class="form-group">
                  <label for="name">Company URL:</label>
                  <input type="text" class="form-control" id="" name='comp_website' value="{{old('company_url',$assessor_company->comp_website)}}">
                  @if($errors->has('comp_website'))
                  <div class="text-danger">{{ $errors->first('comp_website') }}</div>
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