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


{{-- <div class="row justify-content-center mt-4">

<div class="col-md-6">

    <div class="card">
        <div class="card-header text-center">
           <h3>Add user in {{$org->name}}</h3>
        </div>

        <div class="card-body">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

            <form method="post" action="/add_new_user">
                @csrf
                <div class="form-group">
                  <label for="name">First name: *</label>
                  <input type="text" class="form-control" id="name" name='first_name' value="{{old('first_name')}}">
                </div>
          
                  <div class="form-group">
                    <label for="lname">Last name: *</label>
                    <input type="text" class="form-control" id="" name='last_name' value="{{old('last_name')}}">
                  </div>
                  <div class="form-group mt-3 mb-2">
                    <label for="department_id">Department</label>
                    <select class="form-select rounded border shadow-sm" name="department_id" id="department_id">
                        <option value="">Select Department (Optional)</option>
                        @foreach ($departments as $d)
                            <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>
                                {{ $d->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                

                  <input type="hidden" name="org_id" value="{{$org->id}}">
          
                <div class="form-group mt-2">
                  <label for="dob">National ID</label>
                  <input type="text" class="form-control" id="" name="national_id" value={{old('national_id')}}>
                </div>
                
          
                  <div class="form-group mt-2">
                    <label for="email">Email *</label>
                    <input type="text" class="form-control" id="" name='email' value="{{old('email')}}">
                  </div>

                      
                  <div class="form-group mt-2">
                    <label for="telephone">Telephone</label>
                    <input type="text" class="form-control" name='telephone' value="{{old('telephone')}}">
                  </div>

                      
                  <div class="form-group mt-2">
                    <label for="address">Address</label>
                    <input type="text" class="form-control" id="" name='address' value="{{old('address')}}">
                  </div>

                  <div class="form-group mt-2">
                    <label for="">City</label>
                    <input type="text" class="form-control" id="" name='city' value="{{old('city')}}">
                  </div>

                  <div class="form-group mt-2">
                    <label for="">State</label>
                    <input type="text" class="form-control" id="" name='state' value="{{old('state')}}">
                  </div>

                  <div class="form-group mt-2">
                    <label for="address">Country</label>
                    <input type="text" class="form-control" name='country' value="{{old('country')}}">
                  </div>
                  
                  <div class="form-group mt-2">
                    <label for="address">Zip code</label>
                    <input type="text" class="form-control" name='zip_code' value="{{old('zip_code')}}">
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Password *</label>
                    <input type="password" class="form-control" name='password' value="{{old('password')}}">
                  </div>

                  <input type="hidden" name="2FA" value="N">


                  <div class="form-group mt-4">
                    <label for="gender">Privilege *</label>
                    <select class="rounded form-select" name="privilege_id">
                        <option value="">Select Privilege of user</option>
                        @foreach ($privilege as $p)
                        <option value="{{$p->id}}" {{ old('privilege_id') == $p->id ? 'selected' : '' }}>{{$p->privilege_name}}</option>
                        @endforeach
                    </select>
                  </div> 

                  <label for="" class="form-label">Status *</label>
                  <select class="form-select" name="status">
                      <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                      <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>

                  <div class="text-center">

                  <button type="submit" class="btn btn-primary btn-lg mt-5">Add user</button>
                </div>

                </form>
          
        </div>

    </div>


</div>



</div> --}}

<div class="row justify-content-center mt-4">
  <div class="col-md-8">
      <div class="card shadow-lg border-0 rounded-4">
          <div class="card-header bg-primary text-white text-center py-4 rounded-top">
              <h2 class="mb-0 fw-bold">Add User in {{ $org->name }}</h2>
          </div>

          <div class="card-body p-4">
              {{-- Display Errors --}}
              @if ($errors->any())
                  <div class="alert alert-danger rounded-3 p-3">
                      <ul class="mb-0">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif

              <form method="post" action="/add_new_user">
                  @csrf
                  
                  {{-- First Name --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">First Name *</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name='first_name' value="{{ old('first_name') }}">
                  </div>

                  {{-- Last Name --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Last Name *</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name='last_name' value="{{ old('last_name') }}">
                  </div>

                  {{-- Department --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Department</label>
                      <select class="form-select rounded-3 shadow-sm" name="department_id">
                          <option value="">Select Department (Optional)</option>
                          @foreach ($departments as $d)
                              <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>
                                  {{ $d->name }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  <input type="hidden" name="org_id" value="{{ $org->id }}">

                  {{-- National ID --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">National ID</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name="national_id" value="{{ old('national_id') }}">
                  </div>

                  {{-- Email --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Email *</label>
                      <input type="email" class="form-control rounded-3 shadow-sm" name='email' value="{{ old('email') }}">
                  </div>

                  {{-- Telephone --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Telephone</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name='telephone' value="{{ old('telephone') }}">
                  </div>

                  {{-- Address --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Address</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name='address' value="{{ old('address') }}">
                  </div>

                  {{-- City & State --}}
                  <div class="row">
                      <div class="col-md-6 mb-3">
                          <label class="form-label fw-bold">City</label>
                          <input type="text" class="form-control rounded-3 shadow-sm" name='city' value="{{ old('city') }}">
                      </div>
                      <div class="col-md-6 mb-3">
                          <label class="form-label fw-bold">State</label>
                          <input type="text" class="form-control rounded-3 shadow-sm" name='state' value="{{ old('state') }}">
                      </div>
                  </div>

                  {{-- Country & Zip Code --}}
                  <div class="row">
                      <div class="col-md-6 mb-3">
                          <label class="form-label fw-bold">Country</label>
                          <input type="text" class="form-control rounded-3 shadow-sm" name='country' value="{{ old('country') }}">
                      </div>

                      <div class="col-md-6 mb-3">
                          <label class="form-label fw-bold">Zip Code</label>
                          <input type="text" class="form-control rounded-3 shadow-sm" name='zip_code' value="{{ old('zip_code') }}">
                      </div>
                  </div>

                  {{-- Password --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Password *</label>
                      <input type="password" class="form-control rounded-3 shadow-sm" name='password' value="{{ old('password') }}">
                  </div>

                  <input type="hidden" name="2FA" value="N">

                  {{-- Privilege --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Privilege *</label>
                      <select class="form-select rounded-3 shadow-sm" name="privilege_id">
                          <option value="">Select Privilege of user</option>
                          @foreach ($privilege as $p)
                              <option value="{{ $p->id }}" {{ old('privilege_id') == $p->id ? 'selected' : '' }}>
                                  {{ $p->privilege_name }}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  {{-- Status --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Status *</label>
                      <select class="form-select rounded-3 shadow-sm" name="status">
                          <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                          <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                      </select>
                  </div>

                  {{-- Submit Button --}}
                  <div class="text-center mt-4">
                      <button type="submit" class="btn btn-primary btn-lg px-5 py-2 rounded-3 shadow">
                          <i class="fas fa-user-plus"></i> Add User
                      </button>
                  </div>

              </form>
          </div>
      </div>
  </div>
</div>


</div>
</div>



@endsection