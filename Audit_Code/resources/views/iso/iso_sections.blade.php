@extends('master')

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

     
        

        {{-- <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_2_from_main/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg text-white w-100" style="background-color: blue"><p class="fw-bold" style="text-align:left;">Upload or enter or view evidence against the mandatory requirements</p></a>
        </div>
        </div> --}}

     

        {{-- <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-secondary text-white w-100"><p class="fw-bold" style="text-align:left;">Undertake or view Risk Assessment on the services and/or assets</p></a>
        </div>
        </div> --}}

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
{{-- <script>
    document.getElementById('alertButton').addEventListener('click', function() {
        Swal.fire({

            text: "Do you want to proceed with uploading evidence for non-mandatory requirements also?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user clicked 'Yes', redirect to a specific URL
                window.location.href = "/iso_sec_2_2_subsections/{{$project_id}}/{{auth()->user()->id}}/yes";
            } else {
                // If the user clicked 'No', redirect to another URL
                window.location.href = "/iso_sec_2_2_subsections/{{$project_id}}/{{auth()->user()->id}}/no";
            }
        });
    });
</script> --}}

@endsection

@endsection
