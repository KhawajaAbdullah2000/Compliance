@extends('master')

@section('content')

@include('user-nav')

@php
$permissions = json_decode($project_permissions);
$canEdit = in_array('Data Inputter', $permissions);
@endphp

@php
$selected = 'default';

if(isset($framework_approach) && isset($risk_assessment_approach)) {
if($framework_approach->framework_approach_types_id == 1 && $risk_assessment_approach->global_risk_assessment_approach_id == 2) {
$selected = 'qualitative_asset';
} elseif($framework_approach->framework_approach_types_id == 1 && $risk_assessment_approach->global_risk_assessment_approach_id == 1) {
$selected = 'qualitative_event';
} elseif($framework_approach->framework_approach_types_id == 2 && $risk_assessment_approach->global_risk_assessment_approach_id == 2) {
$selected = 'quantitative_asset';
}
// elseif($framework_approach->framework_approach_types_id == 2 && $risk_assessment_approach->global_risk_assessment_approach_id == 1) {
// $selected = 'quantitative_event';
// }
}
@endphp

@php
$framework_labels=[
'qualitative_asset'=>'Qualitative Asset Based',
'qualitative_event'=>'Qualitative Event Based',
'quantitative_asset'=>'Quantitative Asset Based',
'default'=>'Default'
]
@endphp



<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">

            @include('components.topTable')

        </div>
    </div>

    <p class="fs-5 fw-bold">Assess Risk  for:
        <span>
            <table class="table table-bordered table-responsive">
                <tr>
                    <td class="bg-dark text-white">Service</td>
                    <td>{{$asset->s_name}}</td>
                    <td class="bg-dark text-white">Asset Type</td>
                    <td>{{$asset->g_name}}</td>
                    <td class="bg-dark text-white">Asset Subtype</td>
                    <td>{{$asset->name}}</td>
                    <td class="bg-dark text-white">Asset Component</td>
                    <td>{{$asset->c_name}}</td>
                </tr>
            </table>
        </span>
    </p>


    <h3>The administrator has selected the risk assessment methodology : {{$framework_labels[$selected]}}

    </h3>

    <p class="fs-4">You can select a different methodology from the list below:
    </p>


    <form method="POST" action="/update_framework_approach/{{$project->project_type}}/{{auth()->user()->id}}">
        @csrf

        <label>
            <input class="form-check-input" type="radio" name="framework_option" value="default" {{ $selected == 'default' ? 'checked' : '' }} {{ !$canEdit ? 'disabled' : '' }}>
            Default
        </label><br>

        <label>
            <input class="form-check-input" type="radio" name="framework_option" value="qualitative_asset" {{ $selected == 'qualitative_asset' ? 'checked' : '' }} {{ !$canEdit ? 'disabled' : '' }}>
            Qualitative - Asset Based
        </label><br>

        <label>
            <input class="form-check-input" type="radio" name="framework_option" value="quantitative_asset" {{ $selected == 'quantitative_asset' ? 'checked' : '' }} {{ !$canEdit ? 'disabled' : '' }}>
            Quantitative - Asset Based
        </label><br>

        <label>
            <input class="form-check-input" type="radio" name="framework_option" value="qualitative_event" {{ $selected == 'qualitative_event' ? 'checked' : '' }} {{ !$canEdit ? 'disabled' : '' }}>
        Qualitative - Event Based
        </label><br> 

        {{-- <label>
            <input class="form-check-input" type="radio" name="framework_option" value="quantitative_event" {{ $selected == 'quantitative_event' ? 'checked' : '' }} {{ !$canEdit ? 'disabled' : '' }}>
            Quantitative - Event Based
        </label><br> --}}

        <button {{ !$canEdit ? 'disabled' : '' }} type="submit" class="btn btn-success mt-2 btn-sm">Update Changes</button>
    </form>


    <div class="text-end mt-2 mb-2">
        <a href="/proceed_to_risk_assessment/{{$asset->assessment_id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-lg">Proceed</a>
    </div>



    @if($project->risk_scheme!=null)
    <div class="col-md-6">

          <h3>The administrator has selected the CLassification Level : {{$project->risk_scheme}}

</h3>

<p class="fs-4">You can select a different Classification Level from the list below:
</p>

        <form method="POST" action="/save_classification_level_by_enduser/{{auth()->user()->organization->id}}">
            @csrf @method('PUT')
            <select name="risk_scheme" class="form-select">
                @foreach(\App\Support\RiskScheme::all() as $key => $cfg)
                <option value="{{ $key }}" @selected($key==$project->risk_scheme)>
                    {{ $cfg['label'] }}
                </option>
                @endforeach
            </select>

            <input type="hidden" name="selected_projects[]" value="{{ $project->id }}">

            <button class="btn btn-primary mt-2">Save</button>
        </form>
    </div>


    @endif





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

@if(Session::has('error'))
<script>
    swal({
        title: "{{Session::get('error')}}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif




@endsection

@endsection
