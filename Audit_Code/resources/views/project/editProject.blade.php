@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h2 class="text-center">Edit {{$project->project_name}}</h2>

    <div class="row text-center mt-5">

    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
              <h3 class="card-title text-center text-bold mb-3">Edit Project</h3>

              <form class="row g-3" method="POST" action="/edit_project_submit/{{$project->project_id}}">
                @csrf
                @method('PUT')
                <div class="col-md-6">
                  <label for="name" class="form-label">Project Name</label>
                  <input type="text" class="form-control" name="project_name" value="{{old('project_name',$project->project_name)}}">
                </div>
                @if($errors->has('project_name'))
                <div class="text-danger">{{ $errors->first('project_name') }}</div>
            @endif

                <div class="col-md-6">
                    <label for="type" class="form-label">Type</label>
                    <select class="boxstyling  form-select" name="project_type">
                        <option value="">Select Project type</option>
                        @foreach ($types as $t)

                        <option value="{{$t->id}}" {{ old('project_type',$project->project_type) == $t->id? 'selected' : '' }}>{{$t->type}}</option>

                        @endforeach

                    </select>
                </div>
             @if($errors->has('project_type'))
                <div class="text-danger">{{ $errors->first('project_type') }}</div>
            @endif


             <div class="col-md-6">
                <label for="" class="form-label">Project Status</label>
                <select class="boxstyling form-select" name="status">
                    <option value="Not submitted for approval" {{ old('status',$project->status) == 'Not submitted for approval' ? 'selected' : '' }}>Not submitted for approval</option>
                    <option value="Pending Approval" {{ old('status',$project->status) == 'Pending Approval' ? 'selected' : '' }}>Pending approval</option>
                    <option value="Approved" {{ old('status',$project->status) == 'Approved' ? 'selected' : '' }}>Approved</option>

                </select>
                @if($errors->has('status'))
                <div class="text-danger">{{ $errors->first('status') }}</div>
            @endif
            </div>


                <div class="col-12">
                  <button type="submit" class="btn btn-success">Save changes</button>
                </div>
              </form>



            </div>
          </div>
    </div>

    <div class="col-lg-6">

        <p>Your Email: {{auth()->user()->email}}</p>
        <p>Organization Name: {{auth()->user()->organization->name}}</p>
        <p>Sub-Organization: {{auth()->user()->organization->sub_org}}</p>


    </div>
    </div>

    <div class="text-center mt-4">
        <a href="/assigned_endusers/{{$project->project_id}}" class="btn btn-success">Create or edit End Users</a>
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
