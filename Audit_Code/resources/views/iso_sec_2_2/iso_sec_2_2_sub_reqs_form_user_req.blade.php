@extends('master')

@section('content')

@include('user-nav')
@include('iso_sec_nav')

@php
$permissions = json_decode($project_permissions);
@endphp

<div class="container">

    <div class="row mt-5">
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

    @if(session('evidenceLevel')!='project')
    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark ">
            <tr>
                <th>Service</th>
                    <th>Asset Group</th>
                    <th>Asset</th>
                    <th>Asset Component</th>
                    <th>Asset Owner Dept</th>
                    <th>Asset Physical Location</th>
                    <th>Asset Logical Location</th>
                
            </tr>
        </thead>
        <tbody>
          
            <tr>
                <td>{{ $asset->s_name }}</td>
                <td>{{ $asset->g_name }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->c_name }}</td>
                <td>{{ $asset->owner_dept }}</td>
                <td>{{ $asset->physical_loc }}</td>
                <td>{{ $asset->logical_loc }}</td>
               
            </tr>
           
        </tbody>
    </table>
@endif

@if(Session('evidenceLevel')=='project')

<a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>

@endif



<h3>Select From below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
    @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
    @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
    @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
    @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif

</h3>

   

    <!-- Compliance Form -->
    <div class="card shadow-lg mb-5">
        <div class="card-header bg-primary text-white text-center">
            <h3>
               Edit Compliance Details
            </h3>
        </div>
        <div class="card-body">
            @if(in_array('Data Inputter', $permissions))
                @isset($result)
                <!-- Edit Form -->
                <form action="/iso_sec_2_2_edit_form/{{$sub_req}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Compliance Status -->
                    <div class="mb-4">
                        <label for="comp_status" class="form-label fw-bold">Compliance Status</label>
                        <select name="comp_status" class="form-select">
                            <option value="yes" {{ old('comp_status', $result->comp_status) == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('comp_status', $result->comp_status) == 'no' ? 'selected' : '' }}>No</option>
                            <option value="partial" {{ old('comp_status', $result->comp_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                        </select>
                        @if($errors->has('comp_status'))
                        <div class="text-danger small">{{ $errors->first('comp_status') }}</div>
                        @endif
                    </div>

                    <!-- Comments -->
                    <div class="mb-4">
                        <label for="comments" class="form-label fw-bold">Comments (Optional)</label>
                        <textarea name="comments" id="comments" rows="4" class="form-control">{{ old('comments', $result->comments) }}</textarea>
                        @if($errors->has('comments'))
                        <div class="text-danger small">{{ $errors->first('comments') }}</div>
                        @endif
                    </div>

                    <!-- Attachment -->
                    <div class="mb-4">
                        <label for="attachment" class="form-label fw-bold">Attachment (Optional)</label>
                        <input type="file" name="attachment" class="form-control">
                        @if(isset($result->attachment))
                        <p class="mt-3">Current Attachment: 
                            <a href="{{ asset('iso_sec_2_2/'.$result->attachment) }}" download>{{ $result->attachment }}</a>
                        </p>
                        @endif
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success btn-lg px-5">Save Changes</button>
                    </div>
                </form>
                @else
                <!-- New Form -->
                <form action="/iso_sec_2_2_form/{{$sub_req}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Compliance Status -->
                    <div class="mb-4">
                        <label for="comp_status" class="form-label fw-bold">Compliance Status</label>
                        <select name="comp_status" class="form-select">
                            <option value="">Select --</option>
                            <option value="yes" {{ old('comp_status') == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('comp_status') == 'no' ? 'selected' : '' }}>No</option>
                            <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                        </select>
                        @if($errors->has('comp_status'))
                        <div class="text-danger small">{{ $errors->first('comp_status') }}</div>
                        @endif
                    </div>

                    <!-- Comments -->
                    <div class="mb-4">
                        <label for="comments" class="form-label fw-bold">Comments (Optional)</label>
                        <textarea name="comments" id="comments" rows="4" class="form-control"></textarea>
                        @if($errors->has('comments'))
                        <div class="text-danger small">{{ $errors->first('comments') }}</div>
                        @endif
                    </div>

                    <!-- Attachment -->
                    <div class="mb-4">
                        <label for="attachment" class="form-label fw-bold">Attachment (Optional)</label>
                        <input type="file" name="attachment" class="form-control">
                    </div>

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">Submit</button>
                    </div>
                </form>
                @endisset
            @else
            <!-- Display Only -->
            <div class="card">
                <div class="card-body">
                    <p><span class="fw-bold">Compliance Status:</span> {{ $result->comp_status }}</p>
                    <p><span class="fw-bold">Comments:</span> {{ $result->comments ?? 'No comments' }}</p>
                    <p><span class="fw-bold">Attachment:</span>
                        @isset($result->attachment)
                        <a href="{{ asset('iso_sec_2_2/'.$result->attachment) }}" download>{{ $result->attachment }}</a>
                        @else
                        No attachment
                        @endisset
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@section('scripts')
@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}",
        icon: "success",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>
@endif
@endsection

@endsection
