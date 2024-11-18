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
                <div class="card-header bg-warning text-white text-center">
                    <h3 class="mb-0">Edit Service and/or Asset Data</h3>
                    <small class="text-danger fw-bold d-block mt-2">
                        <i class="fas fa-exclamation-triangle"></i> Editing this will override the previous values.
                    </small>
                </div>
                <div class="card-body p-5">
                    <form action="/iso_sec_2_1_submit_edit/{{ $data->assessment_id }}/{{ $data->project_id }}/{{ auth()->user()->id }}" method="post">
                        @csrf
                        @method('PUT')

                        <!-- Service Name -->
                        <div class="mb-4">
                            <label for="s_name" class="form-label fw-semibold">Service Name</label>
                            <input type="text" name="s_name" id="s_name" class="form-control rounded-pill" value="{{ old('s_name', $data->s_name) }}">
                            @if($errors->has('s_name'))
                            <div class="text-danger small mt-2">{{ $errors->first('s_name') }}</div>
                            @endif
                        </div>

                        <!-- Asset Group Name -->
                        <div class="mb-4">
                            <label for="g_name" class="form-label fw-semibold">Asset Group Name</label>
                            <input type="text" name="g_name" id="g_name" class="form-control rounded-pill" value="{{ old('g_name', $data->g_name) }}">
                            @if($errors->has('g_name'))
                            <div class="text-danger small mt-2">{{ $errors->first('g_name') }}</div>
                            @endif
                        </div>

                        <!-- Asset Name -->
                        <div class="mb-4">
                            <label for="name" class="form-label fw-semibold">Asset Name</label>
                            <input type="text" name="name" id="name" class="form-control rounded-pill" value="{{ old('name', $data->name) }}">
                            @if($errors->has('name'))
                            <div class="text-danger small mt-2">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <!-- Asset Component Name -->
                        <div class="mb-4">
                            <label for="c_name" class="form-label fw-semibold">Asset Component Name</label>
                            <input type="text" name="c_name" id="c_name" class="form-control rounded-pill" value="{{ old('c_name', $data->c_name) }}">
                            @if($errors->has('c_name'))
                            <div class="text-danger small mt-2">{{ $errors->first('c_name') }}</div>
                            @endif
                        </div>

                        <!-- Asset Owner Department -->
                        <div class="mb-4">
                            <label for="owner_dept" class="form-label fw-semibold">Asset Owner Department</label>
                            <input type="text" name="owner_dept" id="owner_dept" class="form-control rounded-pill" value="{{ old('owner_dept', $data->owner_dept) }}">
                            @if($errors->has('owner_dept'))
                            <div class="text-danger small mt-2">{{ $errors->first('owner_dept') }}</div>
                            @endif
                        </div>

                        <!-- Asset Physical Location -->
                        <div class="mb-4">
                            <label for="physical_loc" class="form-label fw-semibold">Asset Physical Location</label>
                            <input type="text" name="physical_loc" id="physical_loc" class="form-control rounded-pill" value="{{ old('physical_loc', $data->physical_loc) }}">
                            @if($errors->has('physical_loc'))
                            <div class="text-danger small mt-2">{{ $errors->first('physical_loc') }}</div>
                            @endif
                        </div>

                        <!-- Asset Logical Location -->
                        <div class="mb-4">
                            <label for="logical_loc" class="form-label fw-semibold">Asset Logical Location</label>
                            <input type="text" name="logical_loc" id="logical_loc" class="form-control rounded-pill" value="{{ old('logical_loc', $data->logical_loc) }}">
                            @if($errors->has('logical_loc'))
                            <div class="text-danger small mt-2">{{ $errors->first('logical_loc') }}</div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

