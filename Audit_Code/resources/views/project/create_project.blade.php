@extends('master')

@section('content')

@include('user-nav')


<div class="container">

    <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center fw-bold mb-3">Create new Project</h3>

          <form class="row g-3" method="POST" action="/create_project/{{auth()->user()->id}}">
            @csrf
            <div class="col-md-6">
              <label for="name" class="form-label">Project Name</label>
              <input type="text" class="form-control" name="project_name" value="{{old('project_name')}}">
            </div>
            @if($errors->has('project_name'))
            <div class="text-danger">{{ $errors->first('project_name') }}</div>
        @endif

            <div class="col-md-6">
                <label for="type" class="form-label">Type</label>
                <select class="boxstyling bg-info form-select" name="project_type">
                    <option value="">Select Project type</option>
                    @foreach ($types as $t)

                    <option value="{{$t->id}}" {{ old('project_type') == $t->id? 'selected' : '' }}>{{$t->type}}</option>

                    @endforeach


                </select>
            </div>
         @if($errors->has('project_type'))
            <div class="text-danger">{{ $errors->first('project_type') }}</div>
        @endif




            <div class="col-12 text-center mt-5">
              <button type="submit" class="btn btn-primary">Create Project</button>
            </div>
          </form>



        </div>
      </div>

</div>




@endsection


