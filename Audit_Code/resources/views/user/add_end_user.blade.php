@extends('master')

@section('content')
    
@include('user-nav')

<div class="mx-5">
    <h2>Welcome {{auth()->user()->first_name}}</h2>

    <br>
<a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>
</div>

<div class="container">


    <div class="row justify-content-center">

        <div class="col-md-6">
        
            <div class="card">
                <div class="card-header bg-primary text-center">
                    <h2 class="users">Add new End user in {{$org->name}} {{$org->sub_org}}</h2>
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
        
                    <form method="post" action="/add_new_end_user">
                        @csrf
                        <div class="form-group">
                          <label for="name">First name:</label>
                          <input type="text" class="form-control" id="name" name='first_name' value="{{old('first_name')}}">
                        </div>
                  
                          <div class="form-group">
                            <label for="lname">Last name:</label>
                            <input type="text" class="form-control" id="" name='last_name' value="{{old('last_name')}}">
                          </div>
        
                          <input type="hidden" name="organization_name" value="{{$org->name}}">
                          <input type="hidden" name="organizations_sub_org" value="{{$org->sub_org}}">
                  
                        <div class="form-group">
                          <label for="dob">National ID</label>
                          <input type="text" class="form-control" id="" name="national_id" value={{old('national_id')}}>
                        </div>
                        
                  
                          <div class="form-group mt-2">
                            <label for="email">Email</label>
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


                          <div class="form-group mt-4">
                            <label for="roles"><h3>Roles</h3></label>
                            <br>
                            @foreach ($permissions as $p)
                               {{ $p->name}} <input type="checkbox" name="roles[]" value="{{$p->name}}">
                            @endforeach
              
                          </div> 
        
        
                          <div class="form-group mt-2">
                            <label for="">Password</label>
                            <input type="password" class="form-control" name='password' value="{{old('password')}}">
                          </div>

                          <input type="hidden" name="privilege_id" value=5>

        
                          <input type="hidden" name="2FA" value="N">
        
        
        
                          <label for="" class="form-label">Status</label>
                          <select class="boxstyling bg-primary form-select" name="status">
                              <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                              <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                          </select>
        
                          <div class="text-center">
        
                          <button type="submit" class="btn btn-primary btn-lg mt-5">Add end user</button>
                        </div>
        
                        </form>
                  
                </div>
        
            </div>
        
        
        </div>
        
        
        
        </div>
        












</div>









@endsection


