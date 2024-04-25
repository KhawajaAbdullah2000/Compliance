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




    <div class="row text-center justify-content-center full-img-subsections">
        <div class="row mt-2">
        <div class="col-12">
        <a href="/iso_sec2_4_a5_assets/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white"><p class="fw-bold">Annex A:5-Organizational Controls</p></a>

        </div>
        </div>

        {{-- Section1.2 --}}
        <div class="row">
            <div class="col-12">

                <a href="/iso_sec2_4_a6_assets/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white"><p class="fw-bold">Annex A:6-People Controls</p></a>


            </div>
        </div>


<div class="row">
           <div class="col-12">
            <a href="/iso_sec2_4_a7_assets/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white"><p class="fw-bold">Annex A:7-Physical Controls</p></a>
           </div>
        </div>

<div class="row mb-2">

           <div class="col-12">
            <a href="/iso_sec2_4_a8_assets/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg my_bg_color text-white"><p class="fw-bold">Annex A:8-Technological Controls</p></a>
           </div>
        </div>





    </div>


</div>



@endsection
