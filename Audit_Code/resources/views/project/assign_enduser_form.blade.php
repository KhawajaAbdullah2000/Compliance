
 @extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Header -->
    <h2 class="text-center fw-bold mb-4">Assign End User to {{ $project->project_name }}</h2>

    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h3 class="card-title text-center fw-bold mb-4">Assign End User</h3>

                    <form action="/assign_enduser_to_project/{{ $project_id }}" method="post">
                        @csrf

                        <!-- End User Dropdown -->
                        <div class="mb-4">
                            <label for="assigned_enduser" class="form-label fw-semibold">Select End User</label>
                            <select class="form-select rounded-pill" name="assigned_enduser">
                                <option value="">Select User</option>
                                @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('assigned_enduser') == $user->id ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </option>
                                @endforeach
                            </select>
                            @if($errors->has('assigned_enduser'))
                            <div class="text-danger small mt-2">{{ $errors->first('assigned_enduser') }}</div>
                            @endif
                        </div>

                        <!-- Project Permissions -->
                        <div class="mb-4">
                            <label for="project_permissions" class="form-label fw-semibold">Project Permissions</label>
                            <div class="form-check">
                                @foreach ($permissions as $p)
                                @if ($p->name != 'Project Creator')
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="project_permissions[]" value="{{ $p->name }}">
                                    <label class="form-check-label">
                                        {{ $p->name }}
                                    </label>

                                </div>
                                @endif
                                @endforeach
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill">Assign User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
