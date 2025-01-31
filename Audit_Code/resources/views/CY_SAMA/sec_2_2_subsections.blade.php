@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

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

    @if(Session('evidenceLevel')!='project')
    <table  class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark ">
            <tr>
                <th>Service</th>
                    <th>Asset Group</th>
                    <th>Asset</th>
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

    <div class="row h-100 w-75">
        <div class="row mt-2" >
            <div class="col-md-8">
         <a href="/cy_sama_section_2_2/{{3.1}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">3.1 Cyber Security Leadership and Governance</p></a>
        </div>

        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="3.1">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2">
                   
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </div>
            </form>
        </div>
        </div>


        <div class="row mt-2">
            <div class="col-md-8">
         <a href="/cy_sama_section_2_2/{{3.2}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">3.2 Cyber Security Risk Management and Compliance</p></a>
        </div>

        
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="3.2">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2">
                   
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </div>
            </form>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-8">
         <a href="/cy_sama_section_2_2/{{3.3}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">3.3 Cyber Security Operations and Technology</p></a>
        </div>

        
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="3.3">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2">
                   
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </div>
            </form>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-8">
         <a href="/cy_sama_section_2_2/{{3.4}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">3.4 Third Party Cyber Security</p></a>
        </div>

        
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="3.4">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2">
                   
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success">Submit</button>
                </div>
            </form>
        </div>
        </div>







    </div>

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
