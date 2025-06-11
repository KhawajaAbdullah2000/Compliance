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
                 <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if(session('evidenceLevel')!='project')
      @include('components.sec2_2_asset_details',[
    'asset'=>$asset
  ])

@endif

@if(Session('evidenceLevel')=='project')

<a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>

@endif

<a href="/iso_sec_2_2_subsections/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary btn-md float-end mb-4">Go to All Requirements</a>



<h3>Select From below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
    @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
    @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
    @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
    @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif

</h3>

      <h2 class="text-center fw-bold mt-4 mb-4">
   {{$data[0][2]}}
    </h2>


    <table class="table table-bordered table-responsive table-primary">

        <thead style="vertical-align: middle;text-align:center;" class="table-dark">
            <td class="fw-bold" style="width:10%">Control No.</td>
            <td class="fw-bold" style="width:60%">Mandatory Requirement</td>
            <td class="fw-bold" style="width:10%">Actions</td>
            <td class="fw-bold" style="width:20%">Edit</td>
        </thead>

        <tbody>

            @foreach ($data as $d )
            <tr>
                <td style="text-align:center">{{$d[3]}}</td>
                 <td>{!! nl2br($d[4]) !!}</td>
                 <td style="text-align:center">
                <a href="/iso_sec2_2_sub_req_edit/{{$d[3]}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}">
                    <i class="fas fa-edit fa-lg" style="color: #114a1d;"></i>
                </a>
            </td>

            <td>     
                <form action="/add_mandatory_all_sub_req/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="sub_req" value="{{$d[3]}}">
                {{-- <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2">
                   
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </div> --}}
                 @php $selectedStatus = $fetchedData->firstWhere('sub_req', $d[3])->comp_status ?? ''; @endphp

        <select name="comp_status" class="form-select rounded-pill form-select-sm" style="max-width: 180px;">
            <option value="">Select --</option>
            <option value="yes" {{ $selectedStatus == 'yes' ? 'selected' : '' }}>In Place</option>
            <option value="no" {{ $selectedStatus == 'no' ? 'selected' : '' }}>Not in Place</option>
            <option value="not_applicable" {{ $selectedStatus == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
            <option value="not_tested" {{ $selectedStatus == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
            <option value="partial" {{ $selectedStatus == 'partial' ? 'selected' : '' }}>Partial</option>
        </select>
            </form></td>

             </tr>

            @endforeach


        </tbody>

    </table>

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
