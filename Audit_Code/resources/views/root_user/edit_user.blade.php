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

            <form method="post" action="/users/edit/{{$user->id}}">
                @csrf
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
                    <label for="gender">Privilege</label>
                    <select class="boxstyling bg-primary rounded form-select" name="privilege_id">
                        <option value="">Select Privilege of user</option>
                        @foreach ($privileges as $p)
                        <option value="{{$p->id}}" {{ old('privilege_id',$user->privilege_id) == $p->id ? 'selected' : '' }}>{{$p->privilege_name}}</option>
                        @endforeach
                    </select>
                  </div> 

                  <label for="" class="form-label">Status</label>
                  <select class="boxstyling bg-primary form-select" name="status">
                      <option value="active" {{ old('status',$user->status) == 'active' ? 'selected' : '' }}>Active</option>
                      <option value="inactive" {{ old('status',$user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                  </select>

                  <div class="text-center">

                  <button type="submit" class="btn btn-primary btn-lg mt-5">Edit User</button>
                </div>

                </form>
          
        </div>

    </div>


</div>



</div>


</div>
</div>



@endsection