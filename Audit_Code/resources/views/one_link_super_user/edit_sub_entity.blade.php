@extends('master')

@section('content')
@include('user-nav')

<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="mb-4">Edit Sub-Entity</h4>

            <form method="POST" action="{{ route('sub_entity.update', $subEntity->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Sub-Entity Name</label>
                    <input type="text" name="name" value="{{ old('name', $subEntity->name) }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Sub-Entity Type</label>
                    <input type="text" class="form-control" value="{{ $subEntity->sub_entity_type }}" readonly>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
