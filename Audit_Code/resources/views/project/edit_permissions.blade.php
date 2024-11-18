
 @extends('master')

@section('content')

@include('user-nav')
@php
$perm=json_decode($user->project_permissions);
@endphp

<div class="container py-5">
    <!-- Page Header -->
    <h2 class="text-center fw-bold mb-5">Assign End User Permissions</h2>

    <!-- Project and User Details -->
    <div class="row mb-5">
        <!-- Project Details -->
        <div class="col-lg-6">
            <div class="bg-light p-4 rounded shadow-sm">
                <h5 class="fw-bold">Project Details</h5>
                <p><span class="fw-semibold">Project Name: </span>{{ $project->project_name }}</p>
                <p><span class="fw-semibold">Project Type: </span>{{ $project->type }}</p>
                <p><span class="fw-semibold">Project Status: </span>{{ $project->status }}</p>
            </div>
        </div>

        <!-- User Details -->
        <div class="col-lg-6">
            <div class="bg-light p-4 rounded shadow-sm">
                <h5 class="fw-bold">Your Details</h5>
                <p><span class="fw-semibold">Your Email: </span>{{ auth()->user()->email }}</p>
                <p><span class="fw-semibold">Organization Name: </span>{{ auth()->user()->organization->name }}</p>
                <p><span class="fw-semibold">Sub-Organization: </span>{{ auth()->user()->organization->sub_org }}</p>
            </div>
        </div>
    </div>

    <!-- User Information -->
    {{-- <div class="row mb-5">
        <div class="col-lg-6 mx-auto">
            <div class="bg-light p-4 rounded shadow-sm">
                <h5 class="fw-bold">User Details</h5>
                <p><span class="fw-semibold">User Name: </span>{{ $userDetails->first_name }} {{ $userDetails->last_name }}</p>
                <p><span class="fw-semibold">User ID: </span>{{ $userDetails->email }}</p>
            </div>
        </div>
    </div> --}}

    <!-- Permissions Form -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h3 class="card-title text-center fw-bold mb-4">Project Permissions</h3>

                    <form action="/edit_permissions/{{ $user->project_code }}/{{ $user->assigned_enduser }}" method="post">
                        @csrf
                        @method('PUT')

                        <p><span class="fw-semibold">User Name: </span>{{ $userDetails->first_name }} {{ $userDetails->last_name }}</p>
                        <p><span class="fw-semibold">User ID: </span>{{ $userDetails->email }}</p>

                        <!-- Permissions Checkboxes -->
                        <div class="mb-4">
                            <label for="permissions" class="form-label fw-semibold">Assign Permissions:</label>
                            <div class="form-check">
                                @foreach ($permissions as $p)
                                    @if ($p->name != 'Project Creator')
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="project_permissions[]" value="{{ $p->name }}" 
                                               {{ in_array($p->name, $perm) ? 'checked' : '' }}>
                                        <label class="form-check-label">
                                            {{ $p->name }}
                                        </label>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            @if($errors->has('project_permissions'))
                            <div class="text-danger small mt-2">{{ $errors->first('project_permissions', 'Choose at least 1 permission') }}</div>
                            @endif
                        </div>

                        <!-- Save Changes Button -->
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

@if(Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}",
        icon: "error",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>
@endif

@endsection

@endsection
