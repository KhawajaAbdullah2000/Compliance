@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">

            @php
            $perm=json_decode($user->project_permissions);
            @endphp

<div class="row mt-5">
    <div class="col-lg-6 d-flex flex-column align-items-start">
        <p><span class="fw-bold">Project Name: </span>{{$project->project_name}}</p>
        <p><span class="fw-bold">Project Type: </span>{{$project->type}}</p>
        <p><span class="fw-bold">Project Status: </span>{{$project->status}}</p>

    </div>

    <div class="col-lg-6 d-flex flex-column align-items-start">
        <p>Your Email: {{auth()->user()->email}}</p>
        <p>Organization Name: {{auth()->user()->organization->name}}</p>
        <p>Sub-Organization: {{auth()->user()->organization->sub_org}}</p>

    </div>
 </div>

 <p> <span class="fw-bold">User Name: </span>{{$userDetails->first_name}} {{$userDetails->last_name}}</p>
 <p> <span class="fw-bold">User ID: </span>{{$userDetails->email}}</p>


    <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center text-bold mb-3">Assign End User Permissions</h3>

          <form action="/edit_permissions/{{$user->project_code}}/{{$user->assigned_enduser}}" method="post">
            @csrf
            @method('PUT')

              <div class="form-group mt-4">
                <label for=""><h3>Project Permissions</h3></label>
                @foreach ($permissions as $p)
                <br>
                   {{ $p->name}} <input type="checkbox" name="project_permissions[]" value="{{$p->name}}"
                   {{in_array($p->name,$perm) ? 'checked':''}}
                   >
                @endforeach
                @if($errors->has('project_permissions'))
                <div class="text-danger">{{ $errors->first('project_permissions','Choose atleast 1 permission ') }}</div>
            @endif


              </div>


              <div class="text-center">
                <button class="btn btn-primary btn-md">Save Changes</button>
              </div>


          </form>


        </div>
      </div>
    </div>
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
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif


@endsection


@endsection


