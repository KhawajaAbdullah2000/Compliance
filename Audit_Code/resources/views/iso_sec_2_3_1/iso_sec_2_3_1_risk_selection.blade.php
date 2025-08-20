@extends('master')

@section('content')

@include('user-nav')




<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">

            @include('components.topTable')

        </div>
    </div>
    <h3 class="fw-bold mt-2">Risk Assessment for</h3>

    <div class="col-md-8 mt-4">
        <table class="table table-bordered table-responsive">
            <tr>
                <td class="bg-secondary text-white">Service</td>
                <td>{{$asset->s_name}}</td>
                <td class="bg-secondary text-white">Asset Type</td>
                <td>{{$asset->g_name}}</td>
                <td class="bg-secondary text-white">Asset Subtype</td>
                <td>{{$asset->name}}</td>
                <td class="bg-secondary text-white">Asset Component</td>
                <td>{{$asset->c_name}}</td>
            </tr>
        </table>
    </div>

    <h3 class="fw-bold mt-2">Adverse Consequence to the Service</h3>
    <div class="col-md-8">
        <table class="table mt-2 table-bordered table-responsive">
            <tr>
                <td class="bg-secondary text-white">Data Confidentiality</td>
                <td> @if($asset->risk_confidentiality == 10)
                    <span class="text-danger">High</span>
                    @elseif($asset->risk_confidentiality == 5)
                    <span class="text-warning">Medium</span>
                    @elseif($asset->risk_confidentiality == 1)
                    <span class="text-success">Low</span>
                    @endif</td>
                <td class="bg-secondary text-white">Data Integrity</td>
                <td> @if($asset->risk_integrity == 10)
                    <span class="text-danger">High</span>
                    @elseif($asset->risk_integrity == 5)
                    <span class="text-warning">Medium</span>
                    @elseif($asset->risk_integrity == 1)
                    <span class="text-success">Low</span>
                    @endif</td>
                <td class="bg-secondary text-white">Data Availability</td>
                <td> @if($asset->risk_availability == 10)
                    <span class="text-danger">High</span>
                    @elseif($asset->risk_availability == 5)
                    <span class="text-warning">Medium</span>
                    @elseif($asset->risk_availability == 1)
                    <span class="text-success">Low</span>
                    @endif</td>


            </tr>
        </table>

    </div>




    <form id="riskForm" method="post" action="/iso_sec2_3_1_risk_selection/{{$asset->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label class="form-label" data-bs-toggle="tooltip" title="Severity of adverse impact to the business if data is leaked in an unauthorized manner beyond tolerable limit">
                Select Adverse Consequence Level: Data Confidentiality
            </label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="risk_confidentiality" id="risk_confidentiality_high" value="10" {{ old('risk_confidentiality', $asset->risk_confidentiality) == 10 ? 'checked' : '' }}>
                    <label class="form-check-label" for="risk_confidentiality_high">High (10)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="risk_confidentiality" id="risk_confidentiality_medium" value="5" {{ old('risk_confidentiality', $asset->risk_confidentiality) == 5 ? 'checked' : '' }}>
                    <label class="form-check-label" for="risk_confidentiality_medium">Medium (5)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="risk_confidentiality" id="risk_confidentiality_low" value="1" {{ old('risk_confidentiality', $asset->risk_confidentiality) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="risk_confidentiality_low">Low (1)</label>
                </div>
            </div>
        </div>

        <div class="form-group mt-4">
            <label class="form-label" data-bs-toggle="tooltip" title="Severity of adverse impact to the business if data is modified in an unauthorized manner beyond tolerable limits">
                Select Adverse Consequence Level: Data Integrity
            </label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="risk_integrity" id="risk_integrity_high" value="10" {{ old('risk_integrity', $asset->risk_integrity) == 10 ? 'checked' : '' }}>
                    <label class="form-check-label" for="risk_integrity_high">High (10)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="risk_integrity" id="risk_integrity_medium" value="5" {{ old('risk_integrity', $asset->risk_integrity) == 5 ? 'checked' : '' }}>
                    <label class="form-check-label" for="risk_integrity_medium">Medium (5)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="risk_integrity" id="risk_integrity_low" value="1" {{ old('risk_integrity', $asset->risk_integrity) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="risk_integrity_low">Low (1)</label>
                </div>
            </div>
        </div>

        <div class="form-group mt-4">
            <label class="form-label" data-bs-toggle="tooltip" title="Severity of adverse impact to the business if information is inaccessible to authorized parties beyond the tolerable time limit">
                Select Adverse Consequence Level: Data Availability
            </label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="risk_availability" id="risk_availability_high" value="10" {{ old('risk_availability', $asset->risk_availability) == 10 ? 'checked' : '' }}>
                    <label class="form-check-label" for="risk_availability_high">High (10)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="risk_availability" id="risk_availability_medium" value="5" {{ old('risk_availability', $asset->risk_availability) == 5 ? 'checked' : '' }}>
                    <label class="form-check-label" for="risk_availability_medium">Medium (5)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="risk_availability" id="risk_availability_low" value="1" {{ old('risk_availability', $asset->risk_availability) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="risk_availability_low">Low (1)</label>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <button type="submit" class="btn btn-success text-white fw-bold mt-4">Save and continue Risk Assessment for the selected component</button>
            </div>

        </div>
    </form>




</div>

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

</script>

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


<script>
    document.getElementById('riskForm').addEventListener('submit', function(e) {
        console.log("hello");
        e.preventDefault(); // Prevent default form submission

        swal({
            title: "Are you sure?"
            , text: "The values set will apply to all asset components in this service and will over-ride any different values set previously."
            , icon: "warning"
            , buttons: {
                cancel: "Cancel"
                , confirm: {
                    text: "Proceed"
                    , value: true
                    , visible: true
                    , className: "btn btn-danger"
                    , closeModal: true
                }
            }
            , dangerMode: true
        , }).then((willSubmit) => {
            if (willSubmit) {
                this.submit(); // Proceed with form submission
            }
        });
    });

</script>


@endsection

@endsection
