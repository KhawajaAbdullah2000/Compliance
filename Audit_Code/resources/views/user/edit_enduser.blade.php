@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">




{{-- <div class="row justify-content-center">

    <div class="col-md-6">
    
        <div class="card">
            <div class="card-header bg-primary text-center">
               <h1>Edit User {{$user->first_name}} {{$user->last_name}}</h1>
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
    
                <form method="post" action="/edit_enduser/{{$user->id}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="name">First name:</label>
                      <input type="text" class="form-control" id="name" name='first_name' value="{{old('first_name',$user->first_name)}}">
                    </div>
              
                      <div class="form-group">
                        <label for="lname">Last name:</label>
                        <input type="text" class="form-control" id="" name='last_name' value="{{old('last_name',$user->last_name)}}">
                      </div>
    
              
                    <div class="form-group">
                      <label for="dob">National ID</label>
                      <input type="text" class="form-control" id="" name="national_id" value={{old('national_id',$user->national_id)}}>
                    </div>
                    
              
                      <div class="form-group mt-2">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="" name='email' value="{{old('email',$user->email)}}">
                      </div>
    
                          
                      <div class="form-group mt-2">
                        <label for="telephone">Telephone</label>
                        <input type="text" class="form-control" name='telephone' value="{{old('telephone',$user->telephone)}}">
                      </div>
    
                          
                      <div class="form-group mt-2">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="" name='address' value="{{old('address',$user->address)}}">
                      </div>
    
                      <div class="form-group mt-2">
                        <label for="">City</label>
                        <input type="text" class="form-control" id="" name='city' value="{{old('city',$user->city)}}">
                      </div>
    
                      <div class="form-group mt-2">
                        <label for="">State</label>
                        <input type="text" class="form-control" id="" name='state' value="{{old('state',$user->state)}}">
                      </div>
    
                      <div class="form-group mt-2">
                        <label for="address">Country</label>
                        <input type="text" class="form-control" name='country' value="{{old('country',$user->country)}}">
                      </div>
                      
                      <div class="form-group mt-2">
                        <label for="address">Zip code</label>
                        <input type="text" class="form-control" name='zip_code' value="{{old('zip_code',$user->zip_code)}}">
                      </div>

                      <div class="form-group mt-4">
                        <label for="roles"><h5>Roles</h5></label>
                        <br>
                        @foreach ($permissions as $p)
                        <label class="mt-1">{{ $p->name}}</label>
                        <input type="checkbox" name="roles[]" value="{{$p->name}}"
                           {{ $user->hasPermissionTo($p->name) ? 'checked' : '' }}
                           >
                           
                        @endforeach
          
                      </div> 
    
                      <div class="form-group mt-2">
                      <label for="">Status</label>
                      <select class="boxstyling bg-primary form-select" name="status">
                          <option value="active" {{ old('status',$user->status) == 'active' ? 'selected' : '' }}>Active</option>
                          <option value="inactive" {{ old('status',$user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                      </select>
                    </div>

                    
    
                      <div class="text-center">
    
                      <button type="submit" class="btn btn-primary btn-lg mt-5">Edit end user</button>
                    </div>
    
                    </form>
              
            </div>
    
        </div>
    
    
    </div>
    
    
    
    </div> --}}

    <div class="container mt-5">
      <div class="row justify-content-center">
          <div class="col-md-8">
              <div class="card shadow-lg border-0 rounded-4">
                  <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                      <h2 class="mb-0">Edit User - {{ $user->first_name }} {{ $user->last_name }}</h2>
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
  
                      <form method="post" action="/edit_enduser/{{ $user->id }}">
                          @csrf
                          @method('PUT')
  
                          {{-- Name Fields --}}
                          <div class="row">
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">First Name</label>
                                  <input type="text" class="form-control rounded-3 shadow-sm" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                              </div>
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">Last Name</label>
                                  <input type="text" class="form-control rounded-3 shadow-sm" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                              </div>
                          </div>

                          <div class="mb-3">
                            <label class="form-label fw-bold">Department</label>
                            <select class="form-select rounded-3 shadow-sm" name="department_id">
                                <option value="">Select Department (Optional)</option>
                                @foreach ($departments as $d)
                                    <option value="{{ $d->id }}" {{ old('department_id',$user->department_id) == $d->id ? 'selected' : '' }}>
                                        {{ $d->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
  
                          {{-- National ID --}}
                          <div class="mb-3">
                              <label class="form-label fw-bold">National ID</label>
                              <input type="text" class="form-control rounded-3 shadow-sm" name="national_id" value="{{ old('national_id', $user->national_id) }}">
                          </div>
  
                          {{-- Email & Telephone --}}
                          <div class="row">
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">Email</label>
                                  <input type="email" class="form-control rounded-3 shadow-sm" name="email" value="{{ old('email', $user->email) }}">
                              </div>
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">Telephone</label>
                                  <input type="text" class="form-control rounded-3 shadow-sm" name="telephone" value="{{ old('telephone', $user->telephone) }}">
                              </div>
                          </div>
  
                          {{-- Address Fields --}}
                          <div class="mb-3">
                              <label class="form-label fw-bold">Address</label>
                              <input type="text" class="form-control rounded-3 shadow-sm" name="address" value="{{ old('address', $user->address) }}">
                          </div>
  
                          <div class="row">
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">City</label>
                                  <input type="text" class="form-control rounded-3 shadow-sm" name="city" value="{{ old('city', $user->city) }}">
                              </div>
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">State</label>
                                  <input type="text" class="form-control rounded-3 shadow-sm" name="state" value="{{ old('state', $user->state) }}">
                              </div>
                          </div>
  
                          {{-- Country & Zip Code --}}
                          <div class="row">
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">Country</label>
                                  <input type="text" class="form-control rounded-3 shadow-sm" name="country" value="{{ old('country', $user->country) }}">
                              </div>
                              <div class="col-md-6 mb-3">
                                  <label class="form-label fw-bold">Zip Code</label>
                                  <input type="text" class="form-control rounded-3 shadow-sm" name="zip_code" value="{{ old('zip_code', $user->zip_code) }}">
                              </div>
                          </div>
  
                          {{-- Roles --}}
                          <div class="mb-3">
                              <label class="form-label fw-bold">Roles</label>
                              <br>
                              @foreach ($permissions as $p)
                              @if($p->name == 'Project Creator')
                                  <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $p->name }}"
                                          {{ $user->hasPermissionTo($p->name) ? 'checked' : '' }}>
                                      <label class="form-check-label">{{ $p->name }}</label>
                                  </div>
                                  @endif
                              @endforeach
                          </div>
  
                          {{-- Status --}}
                          <div class="mb-3">
                              <label class="form-label fw-bold">Status</label>
                              <select class="form-select rounded-3 shadow-sm" name="status">
                                  <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                                  <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                              </select>
                          </div>
  
                          {{-- Submit Button --}}
                          <div class="text-center mt-4">
                              <button type="submit" class="btn btn-primary btn-lg px-5 py-2 rounded-3 shadow">
                                  <i class="fas fa-save"></i> Update User
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