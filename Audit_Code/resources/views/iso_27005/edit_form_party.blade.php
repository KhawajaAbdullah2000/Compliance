@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>




    <div class="d-flex justify-content-center mb-4">
        <div class="col-md-6">
            <div class="card mt-4 shadow-lg border-0 rounded-3">
                <div class="card-body p-4">
                    <h3 class="card-title text-center fw-bold mb-2">Edit Party</h3>
                    <form class="row g-4" method="POST" action="/edit_party_submit/{{$party->id}}/{{$project->project_id}}/{{auth()->user()->id}}">
                        @csrf
                        @method('PUT')

                        <div class="col-md-12">
                            <label for="party_name">Party Name</label>
                            <input type="text" class="form-control" name="party_name" value="{{ old('party_name', $party->party_name) }}" required>

                            @if($errors->has('party_name'))
                            <div class="text-danger mt-2 small">{{ $errors->first('party_name') }}</div>
                            @endif
                        </div>

                        <div class="col-md-12">
                            <label for="">Party Type</label>
                            <select name="party_type" class="form-select">
                                <option value="External" {{ $party->party_type == 'External' ? 'selected' : '' }}>External</option>
                                <option value="Internal" {{ $party->party_type == 'Internal' ? 'selected' : '' }}>Internal</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label for="">Party Category</label>
                            <select name="party_category" class="form-select">
                                <option value="Customer" {{ $party->party_category == 'Customer' ? 'selected' : '' }}>Customer</option>
                                <option value="Partner" {{ $party->party_category == 'Partner' ? 'selected' : '' }}>Partner</option>
                                <option value="Contractor" {{ $party->party_category == 'Contractor' ? 'selected' : '' }}>Contractor</option>
                                <option value="IT Service Provider" {{ $party->party_category == 'IT Service Provider' ? 'selected' : '' }}>IT Service Provider</option>
                                <option value="Business Service Provider" {{ $party->party_category == 'Business Service Provider' ? 'selected' : '' }}>Business Service Provider</option>
                                <option value="End User" {{ $party->party_category == 'End User' ? 'selected' : '' }}>End User</option>
                                <option value="Other" {{ $party->party_category == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>

                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-2 fw-semibold">Update Party</button>
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
        title: "{{Session::get('success')}}"
        , icon: "success"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif



@endsection

@endsection
