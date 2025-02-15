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



<div class="row justify-content-center mt-4">
  <div class="col-md-8">
      <div class="card shadow-lg border-0 rounded-4">
          <div class="card-header bg-primary text-white text-center py-4 rounded-top">
              <h2 class="mb-0 fw-bold">Edit User - {{ $user->first_name }} {{ $user->last_name }}</h2>
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

              <form method="post" action="/users/edit/{{$user->id}}">
                  @csrf
                  
                  {{-- First Name --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">First Name *</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name='first_name' value="{{ old('first_name', $user->first_name) }}">
                  </div>

                  {{-- Last Name --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Last Name *</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name='last_name' value="{{ old('last_name', $user->last_name) }}">
                  </div>

                  {{-- Sub-Organization --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Sub-Organization</label>
                      <select class="form-select rounded-3 shadow-sm" name="department_id">
                          <option value="">Select Sub-Organization (Optional)</option>
                          @foreach ($departments as $d)
                              <option value="{{$d->id}}" {{ old('department_id', $user->department_id) == $d->id ? 'selected' : '' }}>
                                  {{$d->name}}
                              </option>
                          @endforeach
                      </select>
                  </div>

                  {{-- National ID --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">National ID</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name="national_id" value="{{ old('national_id', $user->national_id) }}">
                  </div>

                  {{-- Email --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Email *</label>
                      <input type="email" class="form-control rounded-3 shadow-sm" name='email' value="{{ old('email', $user->email) }}">
                  </div>

                  {{-- Telephone --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Telephone</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name='telephone' value="{{ old('telephone', $user->telephone) }}">
                  </div>

                  {{-- Address --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Address</label>
                      <input type="text" class="form-control rounded-3 shadow-sm" name='address' value="{{ old('address', $user->address) }}">
                  </div>

                  {{-- City --}}
                  <div class="row">
                      <div class="col-md-6 mb-3">
                          <label class="form-label fw-bold">City</label>
                          <input type="text" class="form-control rounded-3 shadow-sm" name='city' value="{{ old('city', $user->city) }}">
                      </div>

                      <div class="col-md-6 mb-3">
                          <label class="form-label fw-bold">State</label>
                          <input type="text" class="form-control rounded-3 shadow-sm" name='state' value="{{ old('state', $user->state) }}">
                      </div>
                  </div>

                  {{-- Country & Zip Code --}}
                  <div class="row">
                      <div class="col-md-6 mb-3">
                          <label class="form-label fw-bold">Country</label>
                          <input type="text" class="form-control rounded-3 shadow-sm" name='country' value="{{ old('country', $user->country) }}">
                      </div>

                      <div class="col-md-6 mb-3">
                          <label class="form-label fw-bold">Zip Code</label>
                          <input type="text" class="form-control rounded-3 shadow-sm" name='zip_code' value="{{ old('zip_code', $user->zip_code) }}">
                      </div>
                  </div>

                  {{-- Privilege --}}
                  <div class="mb-3">
                      <label class="form-label fw-bold">Privilege</label>
                      <select class="form-select rounded-3 shadow-sm" name="privilege_id">
                          <option value="">Select Privilege of user</option>
                          @foreach ($privileges as $p)
                              <option value="{{$p->id}}" {{ old('privilege_id', $user->privilege_id) == $p->id ? 'selected' : '' }}>
                                  {{$p->privilege_name}}
                              </option>
                          @endforeach
                      </select>
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