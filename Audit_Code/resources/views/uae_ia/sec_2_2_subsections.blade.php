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
   @include('components.sec2_2_asset_details',[
    'asset'=>$asset
  ])



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

<div class="row h-100 w-75 mb-4">
    <div class="row mt-2" >
        <div class="col-12">

     <a href="/uae_ia_section_2_2/M1.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">M1.1 ENTITY CONTEXT AND LEADERSHIP
    </p></a>
    </div>
    </div>


    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M1.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M1.2 INFORMATION SECURITY POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M1.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M1.3 ORGANIZATION OF INFORMATION SECURITY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M1.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M1.4 SUPPORT

    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M2.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M2.1 INFORMATION SECURITY RISK MANAGEMENT POLICY

    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M2.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M2.2 INFORMATION SECURITY RISK ASSESSMENT

    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M2.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M2.3 INFORMATION SECURITY RISK TREATMENT
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M2.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M2.4 ONGOING INFORMATION SECURITY RISK MANAGEMENT

    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M3.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M3.1 AWARENESS AND TRAINING POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M3.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M3.2 AWARENESS AND TRAINING PLANNING
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M3.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M3.3 SECURITY TRAINING
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M3.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M3.4  SECURITY AWARENESS
    </p></a>
    </div>
    </div>

    
    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M4.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M4.1  HUMAN RESOURCES SECURITY POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M4.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M4.2 PRIOR TO EMPLOYMENT
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M4.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M4.3 DURING EMPLOYMENT
    </p></a>
    </div>
    </div>

    
    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M4.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M4.4 TERMINATION OR CHANGE OF EMPLOYMENT
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M5.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M5.1 COMPLIANCE POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M5.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M5.2 COMPLIANCE WITH INFORMATION SECURITY LEGAL REQUIREMENTS
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M5.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M5.3 COMPLIANCE WITH NON-TECHNICAL REQUIREMENTS
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M5.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M5.4 COMPLIANCE WITH TECHNICAL REQUIREMENTS
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M5.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M5.5 INFORMATION SYSTEMS AUDIT CONSIDERATIONS
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M6.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M6.1 PERFORMANCE EVALUATION POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M6.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M6.2 PERFORMANCE EVALUATION
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/M6.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">M6.3 IMPROVEMENT
    </p></a>
    </div>
    </div>

    
    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T1.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T1.1 ASSET MANAGEMENT POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T1.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T1.2 RESPONSIBILITY FOR ASSETS
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T1.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T1.3 INFORMATION CLASSIFICATION
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T1.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T1.4 MEDIA HANDLING
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T2.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T2.1 PHYSICAL AND ENVIRONMENTAL SECURITY POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T2.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T2.2 SECURE AREAS
    </p></a>
    </div>
    </div>

    
    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T2.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T2.3 EQUIPMENT SECURITY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T3.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T3.1 OPERATIONS MANAGEMENT POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T3.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T3.2 OPERATIONAL PROCEDURES AND RESPONSIBILITIES
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T3.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T3.3 SYSTEM PLANNING AND ACCEPTANCE
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T3.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T3.4 PROTECTION FROM MALWARE
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T3.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T3.5 BACKUP
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T3.6/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T3.6 MONITORING
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T4.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T4.1 COMMUNICATIONS POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T4.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T4.2 INFORMATION TRANSFER
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T4.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T4.3 ELECTRONIC COMMERCE SERVICES
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T4.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T4.4 INFORMATION SHARING PROTECTION
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T4.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T4.5 NETWORK SECURITY MANAGEMENT
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T5.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T5.1 ACCESS CONTROL POLICY
    </p></a>
    </div>
    </div>

    
    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T5.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T5.2 USER ACCESS MANAGEMENT
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T5.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T5.3 USER RESPONSIBILITIES
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T5.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T5.4 NETWORK ACCESS CONTROL
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T5.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T5.5 OPERATING SYSTEM ACCESS CONTROL
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T5.6/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T5.6 APPLICATION AND INFORMATION ACCESS CONTROL
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T5.7/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T5.7 MOBILE DEVICES ACCESS CONTROL
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T6.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T6.1 THIRD-PARTY SECURITY POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T6.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T6.2 THIRD-PARTY SERVICE DELIVERY MANAGEMENT
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T6.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T6.3 CLOUD COMPUTING
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T7.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T7.1 INFORMATION SYSTEMS ACQUISITION, DEVELOPMENT AND MAINTENANCE POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T7.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T7.2 SECURITY REQUIREMENTS OF INFORMATION SYSTEMS
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T7.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T7.3 CORRECT PROCESSING IN APPLICATIONS
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T7.4/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T7.4 CRYPTOGRAPHIC CONTROLS
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T7.5/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T7.5 SECURITY OF SYSTEM FILES
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/7.6/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T7.6 SECURITY IN DEVELOPMENT AND SUPPORT PROCESSES
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T7.7/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T7.7 TECHNICAL VULNERABILITY MANAGEMENT
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T7.8/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T7.8 SUPPLY CHAIN MANAGEMENT
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T8.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T8.1 INFORMATION SECURITY INCIDENT MANAGEMENT POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T8.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T8.2 MANAGEMENT OF INFORMATION SECURITY INCIDENTS AND IMPROVEMENTS
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T8.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T8.3 INFORMATION SECURITY EVENTS AND WEAKNESSES REPORTING
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T9.1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T9.1 INFORMATION SYSTEMS CONTINUITY MANAGEMENT POLICY
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T9.2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T9.2 INFORMATION SECURITY ASPECTS OF INFORMATION CONTINUITY MANAGEMENT
    </p></a>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-12">
     <a href="/uae_ia_section_2_2/T9.3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">T9.3 TESTING, MAINTAINING, AND REASSESSING PLANS
    </p></a>
    </div>
    </div>


    
        {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a> --}}





</div>

 

    
</div>




@endsection
