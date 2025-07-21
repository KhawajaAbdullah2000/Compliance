{{-- @extends('master')

@section('content')

@include('user-nav')

<div class="container">



    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>

    <div class="row mt-4 w-75">

        <div class="row mt-2">
    
            <div class="col-12">
                <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" 
                   class="btn btn-lg my_bg_color text-white w-100 text-start py-3">
                       <ul class="mb-0 ps-4">
                        <li>Enter, upload or view services and assets</li>
                        <li>Conduct compliance checks</li>
                        <li>Assess and treat information security risks</li>
                        </ul>
                
                </a>
            </div>
        </div>

     
        
        <div class="row mt-2">
            <div class="col-12">
         <a href="/risk_treatment/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-secondary text-white w-100"><p class="fw-bold" style="text-align:left;">Undertake or view information security risk treatment on the Services and/or assets</p></a>
        </div>
        </div>



        <div class="row mt-2 mb-2">
            <div class="col-12">
         <a href="/iso_section2_4_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg text-white w-100" style="background-color: rgb(244, 113, 134)"><p class="fw-bold" style="text-align:left;">Create or edit or view statement of applicability</p></a>
        </div>
        </div>



    </div>

</div>


@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


@endsection

@endsection --}}


@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>

    <div class="row justify-content-center mt-4">

        <div class="col-lg-8 col-md-10">

            <!-- Services & Assets Management -->
            <div class="card shadow mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-cubes fa-2x me-3 text-primary"></i>
                    <div>
                        <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}/services_register" class="stretched-link text-decoration-none text-dark fw-bold">
                     Edit services & assets register
                        </a>
                        
                    </div>
                </div>
            </div>

            <!-- Compliance Check (New Button) -->
            <div class="card shadow-sm ms-4 mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-shield-alt fa-lg me-3 text-success"></i>
                    <div>
                      <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}/assess_compliance" class="stretched-link text-decoration-none text-dark fw-bold">
                         Assess compliance against controls
                        </a>
                       
                    </div>
                </div>
            </div>

            <!-- Risk Treatment -->
            <div class="card shadow-sm ms-4 mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-exclamation-triangle fa-lg me-3 text-warning"></i>
                 <div>
    <a href="" class="stretched-link text-decoration-none text-dark fw-bold">
       Treat Risk
    </a> 
    <ul class="mb-0 small text-muted ps-3 mt-1">
        
        <li>Modify</li>
        <li>Transfer</li>
        <li>Avoid</li>
        <li>Accept</li>
    </ul>
</div>

                </div>
            </div>

            <!-- Asset Risk Controls -->
            <div class="card shadow-sm ms-5 mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-tools fa-lg me-3 text-secondary"></i>
                    <div>
                         <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}/risk_assessment" class="stretched-link text-decoration-none text-dark fw-bold">
                            Assess Risk against Controls
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- FontAwesome -->

@endsection

@endsection
