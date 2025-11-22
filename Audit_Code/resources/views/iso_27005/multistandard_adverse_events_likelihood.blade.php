@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>


    <div class="row">
        

        <div class="col-md-12 text-end">
             <a href="/proceed_to_risk_assessment/{{$asset->assessment_id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-secondary btn-md"><i class="bi bi-arrow-right-circle me-1"></i> Back</a>
      
        </div>
    </div>


    @include('components.asset-summary_component', ['asset' => $asset])


    <div class="col-12">
        @include('components.consequence_of_loss', ['asset' => $asset,'project'=>$project])
    </div>


       {{-- Likelihood of Adverse Events selection --}}
    <div class="card mt-4">
        <div class="card-header">
            <h5 class="mb-0">Estimate Likelihood of Adverse Events that could cause compromise of:</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('multistandard.likelihood.store') }}" method="POST">
                @csrf

                {{-- keep project & asset identifiers --}}
                <input type="hidden" name="project_id" value="{{ $project->project_id }}">
                <input type="hidden" name="asset_id" value="{{ $asset->assessment_id }}">

                @php
                    $selectedId = $proj_adverse_events_likelihood_selected->likelihood_adverse_event_selected ?? null;
                @endphp

                @foreach($global_adverse_events_likelihood as $event)
                    <div class="form-check mb-2">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="likelihood_adverse_event_selected"
                            id="likelihood_{{ $event->id }}"
                            value="{{ $event->id }}"
                            {{ $selectedId == $event->id ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="likelihood_{{ $event->id }}">
                            {{ $event->event_name }}
                        </label>
                    </div>
                @endforeach

                @error('likelihood_adverse_event_selected')
                    <div class="text-danger small">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn btn-primary mt-3">
                    Save Likelihood
                </button>
            </form>
        </div>
    </div>


<div class="text-end mt-2">
    <a href="/multistandard_risk_levels/{{$project->project_id}}/{{$asset->assessment_id}}" class="btn btn-md btn-primary">Next</a>
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
