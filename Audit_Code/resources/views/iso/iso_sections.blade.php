@extends('master')

@section('content')

@include('user-nav')

<div class="container">




    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td>  {{$project->project_name}}
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

    <div class="row mt-4 w-75">

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white w-100"><p class="fw-bold" style="text-align:left;">Upload or enter or view services and/or assets in the scope of this project</p></a>
        </div>
        </div>

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_2_from_main/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg text-white w-100" style="background-color: blue"><p class="fw-bold" style="text-align:left;">Upload or enter or view evidence against the mandatory requirements</p></a>
        </div>
        </div>

     

        <div class="row mt-2">
            <div class="col-12">
         <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-secondary text-white w-100"><p class="fw-bold" style="text-align:left;">Undertake or view information security risk assessment on the services and/or assets</p></a>
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
