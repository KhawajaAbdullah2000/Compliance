@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>

    <h3 class="fw-bold mt-2">Risk Assessment for {{ auth()->user()->organization->name }}</h3>
    <span class="fw-bold">Services: </span>{{ $services->pluck('s_name')->implode(', ') }}

    <div class="row">
        <h4 class="mt-4 fw-bold">Edit Strategic Scenario</h4>

        <div class="d-flex justify-content-center mb-4">
            <div class="col-md-6">
                <div class="card mt-4 shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center fw-bold mb-2">Edit Scenario</h3>

                        <form class="row g-4" method="POST" 
                              action="/submit_edit_scenario/{{$scenario->id}}/{{$project->project_id}}/{{auth()->user()->id}}">
                            @csrf
                            @method('PUT') {{-- For RESTful update --}}

                            {{-- Title --}}
                            <div class="col-md-12">
                                <label for="title">Scenario Title</label>
                                <input type="text" class="form-control" 
                                       name="title" 
                                       value="{{ old('title', $scenario->title) }}" required>
                                @if($errors->has('title'))
                                    <div class="text-danger mt-2 small">{{ $errors->first('title') }}</div>
                                @endif
                            </div>

                            {{-- Risk Type --}}
                            <div class="col-md-12">
                                <label for="">Risk Type</label>
                                <select name="risk_type" class="form-select">
                                    <option value="risk_confidentiality" {{ $scenario->risk_type == 'risk_confidentiality' ? 'selected' : '' }}>Data Confidentiality</option>
                                    <option value="risk_integrity" {{ $scenario->risk_type == 'risk_integrity' ? 'selected' : '' }}>Data Integrity</option>
                                    <option value="risk_availability" {{ $scenario->risk_type == 'risk_availability' ? 'selected' : '' }}>Data Availability</option>
                                    <option value="all" {{ $scenario->risk_type == 'all' ? 'selected' : '' }}>All</option>
                                </select>
                            </div>

                            {{-- Party Type --}}
                            <div class="col-md-12">
                                <label for="">Party Name</label>
                                <select name="party_type" class="form-select">
                                    @foreach ($party as $p)
                                        <option value="{{ $p->id }}" {{ $scenario->party_type == $p->id ? 'selected' : '' }}>
                                            {{ $p->party_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Description --}}
                            <div class="col-md-12">
                                <label for="">Scenario Description</label>
                                <textarea class="form-control" name="scenario">{{ old('scenario', $scenario->scenario) }}</textarea>
                            </div>

                            {{-- Submit --}}
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-2 fw-semibold">
                                    Update Scenario
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
@if(Session::has('success'))
<script>
    swal({
        title: "{{Session::get('success')}}",
        icon: "success",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>
@endif
@endsection

@endsection
