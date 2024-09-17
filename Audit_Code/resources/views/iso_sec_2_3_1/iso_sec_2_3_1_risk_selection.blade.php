@extends('master')

@section('content')

@include('user-nav')




<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h2 class="text-center fw-bold mt-4">Information Security Risk Assessment</h2>

    <p><span class="fw-bold">Service: </span>{{$asset->s_name}}</p>

    <form method="post" action="/iso_sec2_3_1_risk_selection/{{$asset->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}">
        @method('PUT')
        @csrf
   <div class="form-group">
    <label class="form-label" data-bs-toggle="tooltip" title="Severity of adverse impact to the business if data is leaked in an unauthorized manner beyond tolerable limit">
        Select Impact Level due to Loss of Data Confidentiality
    </label>
    <select class="form-select" name="risk_confidentiality">
        <option value="10" {{ old('risk_confidentiality', $asset->risk_confidentiality) == 10 ? 'selected' : '' }}>High</option>
        <option value="5" {{ old('risk_confidentiality', $asset->risk_confidentiality) == 5 ? 'selected' : '' }}>Medium</option>
        <option value="1" {{ old('risk_confidentiality', $asset->risk_confidentiality) == 1 ? 'selected' : '' }}>Low</option>
    </select>
   </div>

   <div class="form-group mt-4">
    <label class="form-label" data-bs-toggle="tooltip" title="“Severity of adverse impact to the business if data is modified in an unauthorized manner beyond tolerable limits">
        Select Impact Level due to Loss of Data Integrity
    </label>
        <select class="form-select" name="risk_integrity">
            <option value="10" {{ old('risk_integrity', $asset->risk_integrity) == 10 ? 'selected' : '' }}>High</option>
        <option value="5" {{ old('risk_integrity', $asset->risk_integrity) == 5 ? 'selected' : '' }}>Medium</option>
        <option value="1" {{ old('risk_integrity', $asset->risk_integrity) == 1 ? 'selected' : '' }}>Low</option>

        </select>
   </div>



   <div class="form-group mt-4">
    <label class="form-label" data-bs-toggle="tooltip" title="“Severity of adverse impact to the business if information is inaccessible to authorized parties beyond the tolerable time limit">
        Select Impact Level due to Loss of Data Availability
    </label>
    <select class="form-select" name="risk_availability">
        <option value="10" {{ old('risk_availability', $asset->risk_availability) == 10 ? 'selected' : '' }}>High</option>
    <option value="5" {{ old('risk_availability', $asset->risk_availability) == 5 ? 'selected' : '' }}>Medium</option>
    <option value="1" {{ old('risk_availability', $asset->risk_availability) == 1 ? 'selected' : '' }}>Low</option>

    </select>
   </div>

   <div class="row">
    <div class="col-md-6">
        <button type="submit" class="btn btn-success text-white fw-bold mt-4">Save and continue Risk Assessment for the selected component</button>
    </div>
    <div class="col-md-6 mt-4">
        <p><span class="fw-bold">Asset Group Name: </span>{{$asset->g_name}}</p>
        <p><span class="fw-bold">Asset Name: </span>{{$asset->name}}</p>
        <p><span class="fw-bold">Asset Component Name: </span>{{$asset->c_name}}</p>

    </div>
   </div>


</form>

</div>

@section('scripts')
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

@endsection

@endsection
