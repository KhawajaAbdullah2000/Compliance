@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('root_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
    
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
        <a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>

      </div>
    </nav>
    <div class="container">

      {{-- <h1 class="text-center">Register New organization</h1> --}}

      <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center text-bold mb-3">Add new Organization</h3>

          <form class="row g-3" method="POST" action="/add_new_org">
            @csrf
            <div class="col-md-6">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
            </div>
            @if($errors->has('name'))
            <div class="text-danger">{{ $errors->first('name') }}</div>
        @endif

            <div class="col-md-6">
              <label for="sub_org" class="form-label">Sub Organization</label>
              <input type="text" class="form-control" name="sub_org" placeholder="department" value="{{old('sub_org')}}">
            </div>
            @if($errors->has('sub_org'))
            <div class="text-danger">{{ $errors->first('sub_org') }}</div>
        @endif
      



            <div class="col-md-6">
                <label for="type" class="form-label">Type</label>
                <select class="boxstyling bg-primary form-select" name="type">
                    <option value="">Select type</option>
                    <option value="guest" {{ old('type') == 'guest' ? 'selected' : '' }}>Guest</option>
                    <option value="host" {{ old('type') == 'host' ? 'selected' : '' }}>Host</option>
                </select>
            </div>
         @if($errors->has('type'))
            <div class="text-danger">{{ $errors->first('type') }}</div>
        @endif


            <div class="col-md-6">
              <label for="country" class="form-label">Country</label>
              <input type="text" class="form-control" placeholder="Country" name="country" value="{{old('country')}}">
            </div>
            @if($errors->has('country'))
            <div class="text-danger">{{ $errors->first('country') }}</div>
        @endif


            <div class="col-md-6">
              <label for="city" class="form-label">City</label>
              <input type="text" class="form-control" name="city" value="{{old('city')}}">
            </div>
            @if($errors->has('city'))
            <div class="text-danger">{{ $errors->first('city') }}</div>
        @endif


            <div class="col-md-4">
              <label for="inputState" class="form-label">State</label>
        <input type="text" name="state" class="form-control" value="{{old('state')}}">
            </div>
            @if($errors->has('state'))
            <div class="text-danger">{{ $errors->first('state') }}</div>
        @endif

            <div class="col-md-2">
              <label for="inputZip" class="form-label">Zip</label>
              <input type="text" class="form-control" name="zip_code" value="{{old('zip_code')}}">
            </div>
            @if($errors->has('zip_code'))
            <div class="text-danger">{{ $errors->first('zip_code') }}</div>
        @endif

        <div class="col-12">
            <label for="" class="form-label">Addess</label>
            <input type="text" class="form-control" name="address" value="{{old('address')}}">
        </div>
        @if($errors->has('address'))
        <div class="text-danger">{{ $errors->first('address') }}</div>
    @endif
        <input type="hidden" name="record_created_by" value="{{auth()->user()->email}}">
        
        <div class="col-md-6">
            <label for="" class="form-label">Status</label>
            <select class="boxstyling bg-primary form-select" name="status">
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @if($errors->has('status'))
            <div class="text-danger">{{ $errors->first('status') }}</div>
        @endif
        </div>



            <div class="col-12">
              <button type="submit" class="btn btn-primary">Register</button>
            </div>
          </form>



        </div>
      </div>
            
           
          

    </div>
    


</div>
</div>



@endsection