@extends('master')

@section('content')
    
@include('user-nav')


<div class="container">


    <div class="row justify-content-center">

        <div class="col-md-6">
        
            <div class="card">
                <div class="card-header bg-primary text-center">
                  @if($org->type=='guest')
                    <h2 class="users">Add new End user in {{$org->name}} {{$org->sub_org}}</h2>
                    @else
                    <h2 class="users">Add new End user</h2>
                  @endif
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
                        @if($org->type=='host')
                        <div class="form-group">
                      <label for="" class="form-label">Organization</label>
                         <select class="boxstyling bg-primary form-select" name="org_id" id="organization_name">
                         <option value="">Select organization</option>
                          @foreach ($allorgs as $allorg)
                                <option value="{{$allorg->org_id}}" {{ old('org_id') == $allorg->org_id ? 'selected' : '' }}>{{$allorg->name}} {{$allorg->sub_org}}</option>
                                @endforeach
                         </select>
                        </div>

                        {{-- <div class="form-group">
                          <label for="" class="form-label">Sub Organization</label>
                             <select class="boxstyling bg-primary form-select" name="organizations_sub_org" id="sub_org">
                                                                
                             </select>
                            </div> --}}
                         @endif

                        <div class="form-group mt-2">
                          <label for="name">First name:</label>
                          <input type="text" class="form-control" id="name" name='first_name' value="{{old('first_name')}}">
                        </div>
                  
                          <div class="form-group">
                            <label for="lname">Last name:</label>
                            <input type="text" class="form-control" id="" name='last_name' value="{{old('last_name')}}">
                          </div>
        
                          @if($org->type=='guest')
                          <input type="hidden" name="organization_name" value="{{$org->name}}">
                          <input type="hidden" name="organizations_sub_org" value="{{$org->sub_org}}">
                          @endif
                  
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



@section('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  $(document).ready(function () {

   
      $('#organization_name').on('change', function () {
          var idCountry = $(this).val();
          $("#sub_org").html('');
          $.ajax({
            url: "{{url('/fetch_suborg')}}",
              type: "post",
              data: {
                  org_name: idCountry,
                  _token: '{{csrf_token()}}'
              },
              dataType: 'json',
              success: function (result) {
                  $('#sub_org').html('<option value="">-- Select Sub Organization --</option>');
                  $.each(result.sub_org, function (key, value) {
                      $("#sub_org").append('<option value="' + value.sub_org
                         + '">' + value.sub_org+ '</option>');
                  });
              }
          });
      });

     
  });
</script> --}}

@endsection





@endsection


