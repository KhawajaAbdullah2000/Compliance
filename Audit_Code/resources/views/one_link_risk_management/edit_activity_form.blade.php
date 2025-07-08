@extends('master')

@section('content')

@include('user-nav')

@php $permissions = json_decode($project_permissions); @endphp

<div class="container min-vh-100 d-flex justify-content-center align-items-center mt-4">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header fw-bold text-center">Edit Activity</div>
            <div class="card-body">
                <form action="{{ route('update_activity_form', [$project->project_id, auth()->user()->id, $activity->id]) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="activity_name" class="form-label">Activity Name</label>
                        <input type="text" name="activity_name" id="activity_name" class="form-control" value="{{ old('activity_name', $activity->activity_name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="activity_type" class="form-label fw-bold">Activity Type</label>
                        <select name="activity_type" class="form-select">
                             <option value="">--</option>
                            @foreach(['Assessment', 'Training', 'Review', 'Other', 'Monitoring'] as $val)
                                <option value="{{ $val }}" {{ $activity->activity_type == $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="responsible_team" class="form-label fw-bold">Responsible Team</label>
                        <select name="responsible_team" class="form-select">
                             <option value="">--</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" {{ $activity->responsible_team == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="frequency" class="form-label fw-bold">Frequency</label>
                        <select name="frequency" class="form-select">
                            <option value="">--</option>
                            @foreach(['Quarterly', 'Monthly', 'Annually'] as $val)
                                <option value="{{ $val }}" {{ $activity->frequency == $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="scheduled_date" class="form-label fw-bold">Scheduled Date</label>
                        <input type="date" name="scheduled_date" class="form-control" value="{{ $activity->scheduled_date }}">
                    </div>

                    <div class="mb-3">
                        <label for="completion_status" class="form-label fw-bold">Completion Status</label>
                        <select name="completion_status" class="form-select">
                             <option value="">--</option>
                            @foreach(['Pending', 'In Progress', 'Completed'] as $val)
                                <option value="{{ $val }}" {{ $activity->completion_status == $val ? 'selected' : '' }}>{{ $val }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="comments" class="form-label fw-bold">Comments/Updates</label>
                        <textarea name="comments" class="form-control" rows="3">{{ $activity->comments }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Update Activity</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
