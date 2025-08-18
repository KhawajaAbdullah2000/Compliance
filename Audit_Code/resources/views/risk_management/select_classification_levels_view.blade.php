@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
        <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
        <h3 class="fw-bold">Set up Risk Management methodology by project type</h3>

        <div class="row">
            <div class="col-md-4 me-md-4">
                <h5 class="fw-bold mb-3 mt-4">Project Types Selected</h5>

                <ul class="list-group shadow-sm rounded">
                    @forelse ($projects as $proj)
                    <li class="list-group-item d-flex align-items-center bg-light">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        {{$proj->type}}
                    </li>
                    @empty
                    <li class="list-group-item text-muted">No project types selected.</li>
                    @endforelse
                </ul>
            </div>

            <p class="fs-4 mt-4">Select Classification Level</p>
            <form method="POST" action="/save_classification_level/{{auth()->user()->organization->id}}">
                @csrf @method('PUT')
                <select name="risk_scheme" class="form-select">
                    @foreach(\App\Support\RiskScheme::all() as $key => $cfg)
                    <option value="{{ $key }}" >
                        {{ $cfg['label'] }}
                    </option>
                    @endforeach
                </select>

                  @foreach ($projects as $proj)
                <input type="hidden" name="selected_projects[]" value="{{ $proj->id }}">
            @endforeach
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
