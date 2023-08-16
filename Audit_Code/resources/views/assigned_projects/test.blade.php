@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">
    @php
    $permissions=json_decode($project_permissions) 
    @endphp   

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section1</h2>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Client Info</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Assessor Company</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">

        <div class="tab-pane fade show active " id="home" role="tabpanel" aria-labelledby="home-tab">

          @if(in_array('Data Inputter',$permissions))

          <div class="col-md-12">

          @if(!isset($clientinfo))
          
          <div class="card">
              <div class="card-header bg-primary text-center">
                 <h1>Add client info</h1>
              </div>
      
              <div class="card-body">
                  <form method="post" action="/v3_2_s1_clientinfo/{{$project_id}}/{{auth()->user()->id}}">
                      @csrf
                      <div class="form-group">
                        <label for="name">Company name:</label>
                        <input type="text" class="form-control" id="" name='company_name' value="{{old('company_name')}}">
                        @if($errors->has('company_name'))
                        <div class="text-danger">{{ $errors->first('company_name') }}</div>
                    @endif
                      </div>

                      <div class="form-group">
                          <label for="name">Company Address:</label>
                          <input type="text" class="form-control" id="" name='company_address' value="{{old('company_address')}}">
                          @if($errors->has('company_address'))
                          <div class="text-danger">{{ $errors->first('company_address') }}</div>
                      @endif
                        </div>

                        <div class="form-group">
                          <label for="name">Company URL:</label>
                          <input type="text" class="form-control" id="" name='company_url' value="{{old('company_url')}}">
                          @if($errors->has('company_url'))
                          <div class="text-danger">{{ $errors->first('company_url') }}</div>
                      @endif
                        </div>

                        <div class="form-group">
                          <label for="name">Company Contact Name:</label>
                          <input type="text" class="form-control" id="" name='company_contact_name' value="{{old('company_contact_name')}}">
                          @if($errors->has('company_contact_name'))
                          <div class="text-danger">{{ $errors->first('company_contact_name') }}</div>
                      @endif
                        </div>

                        <div class="form-group">
                          <label for="">Company Contact Number:</label>
                          <input type="text" class="form-control" name="company_number" value="{{old('company_number')}}">
                          @if($errors->has('company_number'))
                          <div class="text-danger">{{ $errors->first('company_number') }}</div>
                      @endif
                        </div>

                        <div class="form-group">
                          <label for="name">Company Email:</label>
                          <input type="text" class="form-control" id="" name='company_email' value="{{old('company_email')}}">
                          @if($errors->has('company_email'))
                          <div class="text-danger">{{ $errors->first('company_email') }}</div>
                      @endif
                        </div>

                        <div class="text-center mt-2">
                          <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                        </div>

                      
                  </form>
    
                  @endif {{--!isset clientinfo --}}

              </div>
              </div>

              @else
              <h1>No Data uploaded yet by Data inputter</h1>
              @endif 
              {{-- data inputer permission --}}
              @if(isset($clientinfo))

              <table class="table table-responsive table-hover mt-4">
                  <thead>
                      <tr>
                          <th>Project_id</th>
                          <th>Company name</th>
                          <th>Company Address</th>
                          <th>Company URL</th>
                          <th>Company Contact name</th>
                          <th>Company Contact number</th>
                          <th>Company Email</th>
                          <th>Last edited by</th>
                          <th>Actions</th>

                      </tr>
                  </thead>
                  <tbody>

                    <tr>
                    <td>{{$clientinfo->project_id}}</td>
                    <td>{{$clientinfo->company_name}}</td>
                    <td>{{$clientinfo->company_address}}</td>
                    <td>{{$clientinfo->company_url}}</td>
                    <td>{{$clientinfo->company_contact_name}}</td>
                    <td>{{$clientinfo->company_contact_number}}</td>
                    <td>{{$clientinfo->company_email}}</td>
                    <td>{{$clientinfo->first_name}} {{$clientinfo->last_name}}</td>
                    @if(in_array('Data Inputter',$permissions))
                      <td><a href="/edit_3_2_s1_clientinfo/{{$project_id}}/{{auth()->user()->id}}" class='btn btn-warning btn-sm'>Edit details</a></td>
                      @else
                      <td>Not allowed</td>
                    @endif

                      
                    </tr>
                   
                  </tbody>
              
              </table>
                  
              @endif {{-- if isset clientinfo --}}
          </div>
            


</div>

        
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
<h2>Hello</h2>
        </div>






        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>

      </div>

</div>

 @section('scripts')

@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script> 
@endif

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script> 
@endif

<script>

let table = new DataTable('#myTable',
    {
    language: {
       searchPlaceholder: "search"
    },
      "ordering": false

     } 
     );

</script> 

 @endsection 


@endsection