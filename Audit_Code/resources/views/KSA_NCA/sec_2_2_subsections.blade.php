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
    
    
    
    <h4>Select one {{$project->type}} mandatory compliance domain from below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
        @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
        @if(Session('evidenceLevel')=='group') All Assets in the Asset Type: {{$asset->g_name}} @endif
        @if(Session('evidenceLevel')=='name') All Assets in the Asset Subtype: {{$asset->name}} @endif
        @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif
    
    </h4>


    @if($project->project_type==7)
    {{-- KSA --}}
    <div class="row h-100 w-100 mb-2">
        <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{1}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">1. Cybersecurity Governance</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="1">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>


        <div class="row mt-2 align-items-center">
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{2}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">2. Cybersecurity Defense</p></a>
        </div>

        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post" class="d-flex align-items-center">
                @csrf
                <input type="hidden" name="title" value="2">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                     <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>

                </div>
            </form>
        </div>
        </div>

 <div class="row mt-3 align-items-center">
    <div class="col-md-8">
        <a href="/ksa_nca_section_2_2/3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
            3. Cybersecurity Resilience
        </a>
    </div>

    <div class="col-md-4">
        <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="POST" class="d-flex align-items-center">
            @csrf
            <input type="hidden" name="title" value="3">

            <select name="comp_status" class="form-select form-select-sm rounded-pill me-2" style="max-width: 150px;">
                <option value="">Select --</option>
                <option value="yes" {{ old('comp_status') == 'yes' ? 'selected' : '' }}>In Place</option>
                <option value="no" {{ old('comp_status') == 'no' ? 'selected' : '' }}>Not in Place</option>
                <option value="not_applicable" {{ old('comp_status') == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                <option value="not_tested" {{ old('comp_status') == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
            </select>

            <button type="submit" class="btn btn-success btn-sm me-2 px-3">Submit</button>
            <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
        </form>
    </div>
</div>


        <div class="row mt-2 align-items-center">
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{4}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">4. Third-Party and Cloud Computing Cybersecurity</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="4">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                      <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

        <div class="row mt-2 align-items-center">
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{5}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5. Industrial Control Systems Cybersecurity</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                      <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>





@elseif($project->project_type==18)
{{-- COSO --}}


<div class="row h-100 w-100 mb-2">

     <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{1}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Control Environment</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="1">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

     <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{2}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Risk Assessment</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="2">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

     <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{3}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Control Activities</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="3">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

    


      <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{4}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Information and communication</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="4">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>



        <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{5}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Monitoring</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

    </div>


    
@elseif($project->project_type==19)
{{-- SOc2 - type 2 --}}

<div class="row h-100 w-100 mb-2">

     <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{1}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Asset Management</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="1">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

         <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{2}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Availability</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="2">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

         <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{3}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Change Management</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="3">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

         <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{4}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Communications</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="4">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

         <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{5}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Confidentiality</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>


         <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{6}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Data Classification</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="6">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

        <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{7}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Fraud Management</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="7">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

        <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{8}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Human Resource aspects of Trust Services</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="8">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

           <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{9}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Information Assets Security Management Policy </p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="9">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

         <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Information Security Events Monitoring</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="10">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

          <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{11}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Information Security Incident Management
</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="11">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>
        

        <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{12}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Information Security Monitoring</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="12">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

          <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{13}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">IT Operational Anomalies Reporting</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="13">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

             <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{14}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Logical and Physical Access Controls</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="14">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>
        

        
             <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{15}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Monitoring of Controls</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="15">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

         <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{16}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Organization & Management</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="16">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

           <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{17}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Risk Management </p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="17">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>

        <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{18}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Vendor and Business Partner Risk Management </p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="18">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>
        

         <div class="row mt-2 align-items-center" >
            <div class="col-md-8">
         <a href="/ksa_nca_section_2_2/{{19}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Vulnerability Management</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="19">
                <div class="d-flex align-items-center">
                    <select name="comp_status" class="form-select rounded-pill me-2" style="max-width: 150px;">
                     <option value="">Select --</option>
                        <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                        <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                        <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                        <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                        <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    <button type="submit" class="btn btn-sm btn-success me-2 px-3">Submit</button>
                    <a href="#" class="btn btn-primary btn-sm px-3" style="min-width: 80px;">AI Input</a>
                </div>
            </form>
        </div>
        </div>
        
        
        

        
        
        

        
        
        

        

        

        
        
        

        
        

   
   
   
   
   
   
    </div>

    
@endif

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
