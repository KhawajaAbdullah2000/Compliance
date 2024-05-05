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

    <div class="row h-100 w-75">
        <div class="row mt-2" >
            <div class="col-12">

         <a href="/iso_section2_2/{{4}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">PCI-DSS v4.0 Requirement 1: Install and Maintain Network Security Controls</p></a>
        </div>
        </div>


        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{5}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 2: Apply Secure Configurations to All System Components</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{6}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 3: Protect Stored Account Data</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{7}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 4: Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks</p></a>
        </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{8}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 5: Protect All Systems and Networks from Malicious Software</p></a>
        </div>
        </div>


        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{9}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 6: Develop and Maintain Secure Systems and Software</p></a>
        </div>
        </div>


        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 7: Restrict Access to System Components and Cardholder Data by Business Need to Know</p></a>
        </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 8: Identify Users and Authenticate Access to System Components</p></a>
        </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 9: Restrict Physical Access to Cardholder Data</p></a>
        </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 10: Log and Monitor All Access to System Components and Cardholder Data</p></a>
        </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 11: Test Security of Systems and Networks Regularly</p></a>
        </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 12: Support Information Security with Organizational Policies and Programs</p></a>
        </div>
        </div>

        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">Appendix A2: Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections</p></a>
        </div>
        </div>
            {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a> --}}





    </div>

</div>




@endsection
