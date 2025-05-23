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
    <table  class="table table-bordered table-hover table-secondary text-center align-middle">
        <thead class="table-dark ">
            <tr>
                <th>Service</th>
                    <th>Asset Type</th>
                    <th>Asset Subtype</th>
                    <th>Asset Component</th>
                    <th>Asset Owner Dept</th>
                    <th>Asset Physical Location</th>
                    <th>Asset Logical Location</th>
                
            </tr>
        </thead>
        <tbody>
           
            <tr>
                <td>{{ $asset->s_name }}</td>
                <td>{{ $asset->g_name }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->c_name }}</td>
                <td>{{ $asset->owner_dept }}</td>
                <td>{{ $asset->physical_loc }}</td>
                <td>{{ $asset->logical_loc }}</td>
               
            </tr>
      
        </tbody>
    </table>
    
    
    @endif
    
    @if(Session('evidenceLevel')=='project')
    
    <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>
    
    @endif
    
    
    
    <h3>Select From below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
        @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
        @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
        @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
        @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif
    
    </h3>

    <a href="/ksa_nca_sec_2_2_subsections/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary btn-md float-end">Go to All Requirements</a>

      <h4 class="text-center fw-bold mt-4 mb-4">
    {{$main_req_num}}  {{$data[0][3]}}
    </h4>

    <table class="table table-bordered table-responsive table-primary">

        <thead style="vertical-align: middle;text-align:center;" class="table-dark">
            <td class="fw-bold" style="width:5%">Control No.</td>
            <td class="fw-bold" style="width:30%">Mandatory Requirement</td>
             <td class="fw-bold" style="width:10%">Tools</td>
            <td class="fw-bold" style="width:10%">Guidelines</td>
            <td class="fw-bold" style="width:10%">Deliverables</td>
            <td class="fw-bold" style="width:5%">Actions</td>
            <td class="fw-bold" style="width:30%">Edit</td>
        </thead>

        <tbody>

            @foreach ($data as $d )
            <tr>
                <td style="text-align:center">{{$d[4]}}</td>
                 <td>{!! nl2br($d[5]) !!}</td>
                 <td class="text-center">
    <button style="background-color: pink" class="btn btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 px-3 py-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-gear-wide" viewBox="0 0 16 16">
  <path d="M8.932.727c-.243-.97-1.62-.97-1.864 0l-.071.286a.96.96 0 0 1-1.622.434l-.205-.211c-.695-.719-1.888-.03-1.613.931l.08.284a.96.96 0 0 1-1.186 1.187l-.284-.081c-.96-.275-1.65.918-.931 1.613l.211.205a.96.96 0 0 1-.434 1.622l-.286.071c-.97.243-.97 1.62 0 1.864l.286.071a.96.96 0 0 1 .434 1.622l-.211.205c-.719.695-.03 1.888.931 1.613l.284-.08a.96.96 0 0 1 1.187 1.187l-.081.283c-.275.96.918 1.65 1.613.931l.205-.211a.96.96 0 0 1 1.622.434l.071.286c.243.97 1.62.97 1.864 0l.071-.286a.96.96 0 0 1 1.622-.434l.205.211c.695.719 1.888.03 1.613-.931l-.08-.284a.96.96 0 0 1 1.187-1.187l.283.081c.96.275 1.65-.918.931-1.613l-.211-.205a.96.96 0 0 1 .434-1.622l.286-.071c.97-.243.97-1.62 0-1.864l-.286-.071a.96.96 0 0 1-.434-1.622l.211-.205c.719-.695.03-1.888-.931-1.613l-.284.08a.96.96 0 0 1-1.187-1.186l.081-.284c.275-.96-.918-1.65-1.613-.931l-.205.211a.96.96 0 0 1-1.622-.434zM8 12.997a4.998 4.998 0 1 1 0-9.995 4.998 4.998 0 0 1 0 9.996z"/>
</svg>
        <span>Tools</span>
    </button>
</td>
                 <td class="text-center">
    <button style="background-color: rgb(117, 236, 117)" class="btn btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 px-3 py-2">
     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-rulers" viewBox="0 0 16 16">
  <path d="M1 0a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5v-1H2v-1h4v-1H4v-1h2v-1H2v-1h4V9H4V8h2V7H2V6h4V2h1v4h1V4h1v2h1V2h1v4h1V4h1v2h1V2h1v4h1V1a1 1 0 0 0-1-1z"/>
</svg>
        <span>Guidelines</span>
    </button>
</td>

              <td class="text-center">
    <button style="background-color: rgb(243, 243, 67)" class="btn btn-sm fw-bold d-flex align-items-center justify-content-center gap-2 px-3 py-2">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-truck" viewBox="0 0 16 16">
  <path d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5zm1.294 7.456A2 2 0 0 1 4.732 11h5.536a2 2 0 0 1 .732-.732V3.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5v7a.5.5 0 0 0 .294.456M12 10a2 2 0 0 1 1.732 1h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12zm-9 1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2"/>
</svg>
        <span>Deliverables</span>
    </button>
</td>


       
                 <td style="text-align:center">
                <a href="/ksa_nca_sec2_2_sub_req_edit/{{$d[4]}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}">
                    <i class="fas fa-edit fa-lg" style="color: #114a1d;"></i>
                </a>
            </td>

     

    <td>
    <form action="/add_mandatory_all_sub_req/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST" class="d-flex align-items-center gap-2">
        @csrf
        <input type="hidden" name="sub_req" value="{{$d[4]}}">

        @php $selectedStatus = $fetchedData->firstWhere('sub_req', $d[4])->comp_status ?? ''; @endphp

        <select name="comp_status" class="form-select rounded-pill form-select-sm" style="max-width: 180px;">
            <option value="">Select --</option>
            <option value="yes" {{ $selectedStatus == 'yes' ? 'selected' : '' }}>In Place</option>
            <option value="no" {{ $selectedStatus == 'no' ? 'selected' : '' }}>Not in Place</option>
            <option value="not_applicable" {{ $selectedStatus == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
            <option value="not_tested" {{ $selectedStatus == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
            <option value="partial" {{ $selectedStatus == 'partial' ? 'selected' : '' }}>Partial</option>
        </select>

        <button type="submit" class="btn btn-success btn-sm px-3">Submit</button>
        <a href="/ksa_nca_sec2_2_sub_req_edit/{{$d[4]}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}"
           class="btn btn-primary btn-sm px-3 text-nowrap">AI Input</a>
    </form>
</td>


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
