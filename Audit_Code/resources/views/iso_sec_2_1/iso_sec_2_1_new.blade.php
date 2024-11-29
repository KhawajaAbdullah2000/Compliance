
@extends('master')

@section('content')

@include('user-nav')

@php
$permissions = json_decode($project_permissions);
@endphp

<div class="container">
    <!-- Project Details -->
    <div class="row mt-5 mb-4">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

   

    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Add Service and/or Asset Data</h2>
                </div>
                <div class="card-body p-5">
                    <form action="/new_iso_sec_2_1/{{$project_id}}/{{auth()->user()->id}}" method="post">
                        @csrf

                        <!-- Service Name -->
                        <div class="mb-4">
                            <label for="s_name" class="form-label fw-semibold">Service Name</label>
                            <input type="text" name="s_name" id="s_name" class="form-control rounded-pill" value="{{old('s_name')}}">
                            @if($errors->has('s_name'))
                            <div class="text-danger small mt-2">{{ $errors->first('s_name') }}</div>
                            @endif
                        </div>

                        <!-- Asset Group Name -->
                        <div class="mb-4">
                            <label for="g_name" class="form-label fw-semibold">Asset Group Name</label>
                            <input type="text" name="g_name" id="g_name" class="form-control rounded-pill" value="{{old('g_name')}}">
                            @if($errors->has('g_name'))
                            <div class="text-danger small mt-2">{{ $errors->first('g_name') }}</div>
                            @endif
                        </div>

                        <!-- Asset Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Asset Name</label>
                            <input type="text" name="name" id="name" class="form-control rounded-pill" value="{{old('name')}}">
                            @if($errors->has('name'))
                            <div class="text-danger small mt-2">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

        
                    <div class="mb-4">
                        <label for="c_name" class="form-label fw-semibold">Asset Component Names</label>
                        <div id="component-fields">
                            <div class="input-group mb-3">
                                <input type="text" name="c_name[]" class="form-control rounded-pill" placeholder="Enter Component Name">
                                <button type="button" class="btn btn-success add-component">+</button>
                            </div>
                        </div>
                        @if($errors->has('c_name'))
                        <div class="text-danger small mt-2">{{ $errors->first('c_name') }}</div>
                        @endif
                    
                        <!-- Display validation error for individual c_name entries -->
                        @foreach ($errors->get('c_name.*') as $errorMessages)
                            @foreach ($errorMessages as $errorMessage)
                                <div class="text-danger small mt-2">{{ $errorMessage }}</div>
                            @endforeach
                        @endforeach
                    </div>

                        <!-- Asset Owner Department -->
                        <div class="mb-4">
                            <label for="owner_dept" class="form-label fw-semibold">Asset Owner Department</label>
                            <input type="text" name="owner_dept" id="owner_dept" class="form-control rounded-pill" value="{{old('owner_dept')}}">
                            @if($errors->has('owner_dept'))
                            <div class="text-danger small mt-2">{{ $errors->first('owner_dept') }}</div>
                            @endif
                        </div>

                        <!-- Asset Physical Location -->
                        <div class="mb-4">
                            <label for="physical_loc" class="form-label fw-semibold">Asset Physical Location</label>
                            <input type="text" name="physical_loc" id="physical_loc" class="form-control rounded-pill" value="{{old('physical_loc')}}">
                            @if($errors->has('physical_loc'))
                            <div class="text-danger small mt-2">{{ $errors->first('physical_loc') }}</div>
                            @endif
                        </div>

                        <!-- Asset Logical Location -->
                        <div class="mb-4">
                            <label for="logical_loc" class="form-label fw-semibold">Asset Logical Location</label>
                            <input type="text" name="logical_loc" id="logical_loc" class="form-control rounded-pill" value="{{old('logical_loc')}}">
                            @if($errors->has('logical_loc'))
                            <div class="text-danger small mt-2">{{ $errors->first('logical_loc') }}</div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function () {
        // Add a new component field
        $(document).on('click', '.add-component', function () {
            let newField = `
                <div class="input-group mb-3">
                    <input type="text" name="c_name[]" class="form-control rounded-pill" placeholder="Enter Component Name">
                    <button type="button" class="btn btn-success add-component">+</button>
                    <button type="button" class="btn btn-danger remove-component">-</button>
                </div>`;
            $('#component-fields').append(newField);

            // Ensure the first field only has the '+' button
            $('#component-fields .input-group:first .remove-component').remove();
        });

        // Remove a component field
        $(document).on('click', '.remove-component', function () {
            $(this).closest('.input-group').remove();
        });
    });
</script>


@endsection

@endsection
