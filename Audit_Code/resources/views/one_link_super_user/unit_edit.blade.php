@extends('master')

@section('content')
@include('user-nav')

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Unit</h4>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('units.update', $unit->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Organization</label>
                    <input type="text" class="form-control" value="{{ $unit->department->organization->name }}" readonly>
                </div>

                <div class="mb-3">
                    <label>Department</label>
                    <input type="text" class="form-control" value="{{ $unit->department->name }}" readonly>
                </div>

                <div class="mb-3">
                    <label>Unit Name</label>
                    <input type="text" name="unit_name" value="{{ old('unit_name', $unit->name) }}" class="form-control" required>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Update Unit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
