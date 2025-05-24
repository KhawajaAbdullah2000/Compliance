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
    <table  class="table table-bordered table-hover text-center table-secondary align-middle">
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
    

@if($project->project_type==7)
      <h2 class="fw-bold mt-4 mb-2">
        @if($title==1)
        1: CyberSecurity Governance

        @elseif ($title==2)
        2: Cybersecurity Defense
        @elseif ($title==3)
        3: Cybersecurity Resilience

        @elseif ($title==4)
        4: Third-Party and Cloud Computing Cybersecurity

        @elseif ($title==5)
        5: Industrial Control Systems Cybersecurity

        @endif
      </h2>
      @endif

      @if($project->project_type==18)
      <h2 class="fw-bold mt-4 mb-2">
        @if($title==5)
        5: Monitoring
        @endif
      @endif

        
    <h4>Select one {{$project->type}}  subdomain from below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
        @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
        @if(Session('evidenceLevel')=='group') All Asset Types in the group: {{$asset->g_name}} @endif
        @if(Session('evidenceLevel')=='name') All Asset Subtypes in: {{$asset->name}} @endif
        @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif
    
    </h4>
    
    <table class="table table-bordered table-responsive table-primary">

        <thead class="fw-bold table-dark">
            <td>Subdomain</td>
            <td>Actions</td>
            <td>Edit</td>
        </thead>

        <tbody>
            <tr>

                <td>
                <p>{!! nl2br($data[0][2]) !!} {!! nl2br($data[0][3]) !!}</p>

                </td>
                <td><a href="/ksa_nca_sec_2_2_req/{{($data[0][2]) }}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-sm my_bg_color text-white">Select</a></td>
                <td>
    <form action="/add_mandatory_all_domain/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST" class="d-flex align-items-center gap-2">
        @csrf
        <input type="hidden" name="domain" value="{{$data[0][2]}}">

        <select name="comp_status" class="form-select form-select-sm rounded-pill" style="max-width: 160px;">
              <option value="">Select --</option>
            <option value="yes" {{ old('comp_status') == 'yes' ? 'selected' : '' }}>In Place</option>
            <option value="no" {{ old('comp_status') == 'no' ? 'selected' : '' }}>Not in Place</option>
            <option value="not_applicable" {{ old('comp_status') == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
            <option value="not_tested" {{ old('comp_status') == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
            <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
        </select>
<button type="submit" class="btn btn-success btn-sm w-100" style="max-width: 100px;">Submit</button>
<a href="#" class="btn btn-primary btn-sm w-100" style="max-width: 100px;">AI Input</a>


    </form>
</td>

            </tr>

            @for ($i = 1; $i < count($data); $i++)
            <tr style="vertical-align: middle;text-align:initial">

                    @php
                    $my_prev_main_req_num=$data[$i-1][2];
                     $my_current_main_req_num=$data[$i][2];
                    @endphp


                    @if ($my_prev_main_req_num==$my_current_main_req_num)
                        @continue

                    @else
                    <td>
                        <p> {!! nl2br($data[$i][2]) !!} {!! nl2br($data[$i][3]) !!}</p>

                       </td>

                       <td><a href="/ksa_nca_sec_2_2_req/{{$my_current_main_req_num}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-sm my_bg_color text-white">Select</a></td>
                       <td>
                        <form action="/add_mandatory_all_domain/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post" class="d-flex align-items-center gap-2">
                            @csrf
                            <input type="hidden" name="domain" value="{{$data[$i][2]}}">
                        
                                <select name="comp_status" class="form-select rounded-pill" style="max-width: 160px;">
                                 <option value="">Select --</option>
                                    <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                                    <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                                    <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                                    <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                                    <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                                </select>
                                
   <button type="submit" class="btn btn-success btn-sm w-100" style="max-width: 100px;">Submit</button>
<a href="#" class="btn btn-primary btn-sm w-100" style="max-width: 100px;">AI Input</a>

                           
                        </form>
                    </td>
                       @endif
                              

             @endfor
    
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
