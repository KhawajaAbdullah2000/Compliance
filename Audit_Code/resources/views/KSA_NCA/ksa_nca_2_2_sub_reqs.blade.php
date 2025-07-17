@extends('master')

@section('content')

@include('user-nav')


@include('iso_sec_nav')
@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
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


    @if(Session('evidenceLevel')!='project')
    @include('components.sec2_2_asset_details',[
    'asset'=>$asset
    ])


    @endif

    @if(Session('evidenceLevel')=='project')

    <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>

    @endif



    {{-- <h3>Select From below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
        @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
    @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
    @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
    @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif

    </h3> --}}

    <a href="/ksa_nca_sec_2_2_subsections/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary btn-md float-end">Go to All Control Domains</a>

    <p class="fw-bold mt-4 mb-4 fs-6">
        {{$main_req_num}} {{$data[0][3]}}
    </p>

    <form action="/add_mandatory_all_sub_req_all_controls/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST">
        @csrf

        <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-success btn-md px-5">Save All</button>
        </div>

        <table class="table table-bordered table-responsive table-primary">
            <thead style="vertical-align: middle; text-align: center;" class="table-dark">
                <tr>
                    <td class="fw-bold" style="width:5%">Control No.</td>
                    <td class="fw-bold" @if($project->project_type==7) style="width:30%;" @elseif($project->project_type==18) style="width:60%;" @else style="width:50%;" @endif>Requirement</td>

                    @if($project->project_type==7)
                    <td class="fw-bold" style="width:10%">Tools</td>
                    <td class="fw-bold" style="width:10%">Guidelines</td>
                    <td class="fw-bold" style="width:10%">Deliverables</td>
                    @endif

                    <td class="fw-bold">Applicability</td>
                    <td class="fw-bold">Compliance Status</td>
                </tr>
            </thead>

            <tbody>
               @foreach ($data as $index => $d)
@php
    $subReq = $d[4];
    $status = $fetchedData->firstWhere('sub_req', $subReq)->comp_status ?? '';
    $applicability = $fetchedData->firstWhere('sub_req', $subReq)->applicability ?? '';
    $justification = $fetchedData->firstWhere('sub_req', $subReq)->justification ?? '';
@endphp

<tr>
    <td style="text-align:center">{{$subReq}}</td>
    <td class="fw-bold">
        <a href="/ksa_nca_sec2_2_sub_req_edit/{{$subReq}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" style="text-decoration: underline;color:inherit;">
            {!! nl2br($d[5]) !!}
        </a>
    </td>

    @if($project->project_type==7)
    <td class="text-center">
        <button style="background-color: pink" class="btn btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 px-3 py-2">
            <i class="bi bi-gear-wide"></i> <span>Tools</span>
        </button>
    </td>
    <td class="text-center">
        <button style="background-color: rgb(117, 236, 117)" class="btn btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 px-3 py-2">
            <i class="bi bi-rulers"></i> <span>Guidelines</span>
        </button>
    </td>
    <td class="text-center">
        <button style="background-color: rgb(243, 243, 67)" class="btn btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 px-3 py-2">
            <i class="bi bi-truck"></i> <span>Deliverables</span>
        </button>
    </td>
    @endif

    <td>
        <input type="hidden" name="sub_reqs[]" value="{{$subReq}}">

        <select name="applicabilities[]" class="form-select form-select-sm rounded-pill applicability-select" data-index="{{$index}}" style="max-width:150px; min-width:150px;">
            <option value="">Select --</option>
            <option value="yes" {{ $applicability == 'yes' ? 'selected' : '' }}>Yes</option>
            <option value="no" {{ $applicability == 'no' ? 'selected' : '' }}>No</option>
        </select>

        <!-- Justification field -->
        <textarea name="justifications[]" 
                  class="form-control form-control-sm mt-2 justification-textarea justification-{{$index}}" 
                  placeholder="Enter justification"
                  style="display: {{ $applicability == 'no' ? 'block' : 'none' }};">{{$justification}}</textarea>
    </td>

    <td>
        <div class="d-flex align-items-center gap-2">
            <select name="comp_statuses[]" class="form-select rounded-pill form-select-sm" style="max-width: 180px;">
                <option value="">Select --</option>
                <option value="yes" {{ $status == 'yes' ? 'selected' : '' }}>In Place</option>
                <option value="no" {{ $status == 'no' ? 'selected' : '' }}>Not in Place</option>
                <option value="not_applicable" {{ $status == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                <option value="not_tested" {{ $status == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                <option value="partial" {{ $status == 'partial' ? 'selected' : '' }}>Partial</option>
            </select>

            <a href="/ksa_nca_sec2_2_sub_req_edit/{{$subReq}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary btn-sm px-3 text-nowrap">AI Input</a>
        </div>
    </td>
</tr>
@endforeach

            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-3">
            <button class="btn btn-success btn-md px-5">Save All</button>
        </div>
    </form>



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

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.applicability-select').forEach(function (select) {
        select.addEventListener('change', function () {
            var index = this.getAttribute('data-index');
            var justification = document.querySelector('.justification-' + index);
            if (this.value === 'no') {
                justification.style.display = 'block';
            } else {
                justification.style.display = 'none';
                justification.value = '';
            }
        });
    });
});
</script>

@endsection

@endsection
