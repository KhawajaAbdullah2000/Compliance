@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h3 class="card-title text-center fw-bold mb-4">Create New Project</h3>

                    <form class="row g-4" method="POST" action="/create_project/{{auth()->user()->id}}">
                        @csrf
                        <!-- Project Name -->
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Project Name</label>
                            <input type="text" class="form-control rounded-pill" name="project_name" value="{{old('project_name')}}" placeholder="Enter project name">
                            @if($errors->has('project_name'))
                                <div class="text-danger mt-2 small">{{ $errors->first('project_name') }}</div>
                            @endif
                        </div>

                        <!-- Project Type -->
                        <div class="col-md-6">
                            <label for="type" class="form-label fw-semibold">Project Type</label>
                            <select class="form-select rounded-pill" name="project_type">
                                <option value="">Select Project Type</option>
                                @foreach ($types as $t)
                                    <option value="{{$t->id}}" {{ old('project_type') == $t->id ? 'selected' : '' }}>{{$t->type}}</option>
                                @endforeach
                            </select>
                            @if($errors->has('project_type'))
                                <div class="text-danger mt-2 small">{{ $errors->first('project_type') }}</div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-md px-5 rounded-pill">Create Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
