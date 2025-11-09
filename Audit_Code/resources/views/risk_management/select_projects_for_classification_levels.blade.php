@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
        <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>

        <div class="row">
        

            <p class="fs-4 mt-4">Select Classification Level</p>
            <form method="POST" action="/save_classification_level/{{$organization->id}}">
                @csrf @method('PUT')
                <select name="risk_scheme" class="form-select">
                    @foreach(\App\Support\RiskScheme::all() as $key => $cfg)
                    <option value="{{ $key }}" {{ $organization->risk_scheme === $key ? 'selected' : '' }} >
                        {{ $cfg['label'] }}
                    </option>
                    @endforeach
                </select>

                      
                <button class="btn btn-primary mt-2">Save</button>
            </form>



        </div>






    </div>
</section>

@section('scripts')
@if(Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}"
        , icon: "success"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>

@endif


@endsection

@endsection
