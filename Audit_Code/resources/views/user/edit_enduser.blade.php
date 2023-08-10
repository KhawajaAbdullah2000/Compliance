@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">




<div class="row justify-content-center">

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
    
    
    
    </div>
</div>

    @endsection