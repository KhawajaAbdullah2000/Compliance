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
    <table  class="table table-bordered table-hover text-center table-secondary align-middle">
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
    
    
    
    <h4>Select one {{$project->type}} Compliance domain from below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
        @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
        @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
        @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
        @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif
    
    </h4>

    <div class="row h-100 w-75">
        <div class="row mt-2" >
            <div class="col-md-8">
         <a href="/isa_section_2_2/5.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">5.2 SM-1: Development process
        </p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5.2">
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
         <a href="/isa_section_2_2/5.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5.3 SM-2: Identification of responsibilities
        </p></a>
        </div>

        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5.3">
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
         <a href="/isa_section_2_2/5.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5.4 SM-3: Identification of applicability</p></a>
        </div>

        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5.4">
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
         <a href="/isa_section_2_2/5.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5.5 SM-4: Security expertis</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5.5">
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
         <a href="/isa_section_2_2/5.6/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5.6 SM-5: Process scoping</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5.6">
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
         <a href="/isa_section_2_2/5.7/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5.7 SM-6: File integrity</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5.7">
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
         <a href="/isa_section_2_2/5.8/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5.8 SM-7: Development environment security</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5.8">
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
         <a href="/isa_section_2_2/5.9/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5.9 SM-8: Controls for private keys</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5.9">
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
         <a href="/isa_section_2_2/5.10/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">5.10 SSM-9: Security requirements for externally provided components</p></a>
        </div>
        <div class="col-md-4">
            <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                @csrf
                <input type="hidden" name="title" value="5.10">
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
                 <a href="/isa_section_2_2/5.11/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">5.11 SM-10: Custom developed components from third-party suppliers</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="5.11">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/5.12/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">5.12 SM-11: Assessing and addressing security-related issues</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="5.12">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/5.13/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">5.13 SM-12: Process verification</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="5.13">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/5.14/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">5.14 SM-13: Continuous improvement</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="5.14">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/6.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">6.2 SR-1: Product security context</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="6.2">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/6.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">6.3 SR-2: Threat model</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="6.3">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/6.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">6.4 SR-3: Product security requirements</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="6.4">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/6.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">6.5 SR-4: Product security requirements content</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="6.5">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/6.6/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">6.6 SR-5: Security requirements review</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="6.6">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/7.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">7.2 SD-1: Secure design principles</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="7.2">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/7.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">7.3 SD-2: Defense in depth design</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="7.3">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/7.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">7.4 SD-3: Security design review</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="7.4">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/7.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">7.5 SD-4: Secure design best practices</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="7.5">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/8.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">8.3 SI-1: Security implementation review</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="8.3">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/8.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">8.4 SI-2: Secure coding standards</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="8.4">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/9.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">9.2 SVV-1: Security requirements testing</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="9.2">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/9.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">9.3 SVV-2: Threat mitigation testing</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="9.3">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/9.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">9.4 SVV-3: Vulnerability testing</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="9.4">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/9.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">9.5 SVV-4: Penetration testing</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="9.5">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/9.6/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">9.6 SVV-5: Independence of testers</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="9.6">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/10.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">10.2 DM-1: Receiving notifications of security-related issues</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="10.2">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/10.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">10.3 DM-2: Reviewing security-related issues</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="10.3">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/10.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">10.4 DM-3: Assessing security-related issues</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="10.4">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/10.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">10.5 DM-4: Addressing security-related issues</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="10.5">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/10.6/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">10.6 DM-5: Disclosing security-related issues</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="10.6">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/10.7/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">10.7 DM-6: Periodic review of security defect management practice</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="10.7">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/11.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">11.2 SUM-1: Security update qualification</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="11.2">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/11.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">11.3 SUM-2: Security update documentation</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="11.3">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/11.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">11.4 SUM-3: Dependent component or operating system security update documentation</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="11.4">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/11.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">11.5 SUM-4: Security update delivery</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="11.5">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/11.6/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">11.6 SUM-5: Timely delivery of security patches</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="11.6">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/12.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">12.2 SG-1: Product defense in depth</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="12.2">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/12.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">12.3 SG-2: Defense in depth measures expected in the environment</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="12.3">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/12.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">12.4 SG-3: Security hardening guidelines</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="12.4">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/12.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">12.5 SG-4: Secure disposal guidelines</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="12.5">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/12.6/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">12.6 SG-5: Secure operation guidelines</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="12.6">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/12.7/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">12.7 SG-6: Account management guidelines</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="12.7">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                         </select>
                         <button type="submit" class="btn btn-sm btn-success">Submit</button>
                     </div>
                 </form>
            </div>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-8">
                 <a href="/isa_section_2_2/12.8/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                     <p class="fw-bold" style="text-align: left;">12.8 SG-7: Documentation review</p>
                 </a>
            </div>
            <div class="col-md-4">
                 <form action="/add_mandatory_all_title/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                     @csrf
                     <input type="hidden" name="title" value="12.8">
                     <div class="d-flex align-items-center">
                         <select name="comp_status" class="form-select rounded-pill me-2">
                             <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                             <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                             <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                             <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                             <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
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
