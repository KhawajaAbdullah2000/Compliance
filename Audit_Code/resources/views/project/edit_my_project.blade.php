@extends('master')

@section('content')

@include('user-nav')

{{-- <div class="mx-5">
    <h2>Welcome {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h2>

    <br>
<a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>
</div> --}}


<div class="container">

    <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center text-bold mb-3">Edit Project {{$project->project_id}}</h3>

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
                <select class="boxstyling bg-primary form-select" name="project_type">
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
            <select class="boxstyling bg-primary form-select" name="status">
                <option value="Not submitted for approval" {{ old('status') == 'Not submitted for approval' ? 'selected' : '' }}>Not submitted for approval</option>
                <option value="Pending approval" {{ old('status') == 'Pending Approval' ? 'selected' : '' }}>Pending approval</option>
                <option value="Approved" {{ old('status') == 'Approved' ? 'selected' : '' }}>Approved</option>

            </select>
            @if($errors->has('status'))
            <div class="text-danger">{{ $errors->first('status') }}</div>
        @endif
        </div>


            <div class="col-12">
              <button type="submit" class="btn btn-primary">Edit Project</button>
            </div>
          </form>



        </div>
      </div>

</div>




@endsection


