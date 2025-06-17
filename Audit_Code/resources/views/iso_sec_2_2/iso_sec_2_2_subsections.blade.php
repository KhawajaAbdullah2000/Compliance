@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

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

@if(Session('evidenceLevel')!='project')
   @include('components.sec2_2_asset_details',[
    'asset'=>$asset
  ])


@endif

@if(Session('evidenceLevel')=='project')

<a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>

@endif

<div class="text-end">
    <form action="/upload_file_for_compliance_api_proj/{{$project->project_id}}/{{auth()->user()->id}}" method="POST" enctype="multipart/form-data" class="d-inline-block">
        @csrf
        <div class="input-group input-group-sm mb-2">
         
            <input type="file" name="data_record_attachments" id="data_record_attachments" class="form-control">
        </div>
        <button type="submit" class="btn btn-sm btn-primary">Upload</button>
    </form>
</div>


<h4>Select one {{$project->type}} mandatory compliance domain from below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
    @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
    @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
    @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
    @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif

</h4>


 
    
    <div class="row h-100 w-75">
        <div class="row mt-2" >
            <div class="col-md-8">

         <a href="/iso_section2_2/{{4}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;"> Clause 4- Context Of The Organization</p></a>
        </div>

        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="4">
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
         <a href="/iso_section2_2/{{5}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;"> Clause 5- Leadership</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5">
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
         <a href="/iso_section2_2/{{6}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;"> Clause 6- Planning</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="6">
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
         <a href="/iso_section2_2/{{7}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;"> Clause 7- Support</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="7">
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

        <div class="row mt-2 mb-2">
            <div class="col-md-8">
         <a href="/iso_section2_2/{{8}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;"> Clause 8- Operation</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="8">
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


        <div class="row mt-2 mb-2">
            <div class="col-md-8">
         <a href="/iso_section2_2/{{9}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;"> Clause 9- Performance Evaluation</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="9">
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


        <div class="row mt-2 mb-2">
            <div class="col-md-8">
         <a href="/iso_section2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;"> Clause 10- Improvement</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="10">
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


        {{-- ISO Non Mandatory Requirements --}}
        {{-- <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{11}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;"> Annex A</p></a>
        </div>
        </div> --}}






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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif

@endsection




@endsection
