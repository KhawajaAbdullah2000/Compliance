
@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')


@php
$permissions = json_decode($project_permissions);
@endphp
<div class="container">

        <div class="row mt-5">
        <div class="col-lg-12">
         
            @include('components.one_link_topTable')
            
        </div>

    <h3 class="fw-bold">Project: {{$project->project_name}}</h3>

  <div class="container my-5">
    <div class="row justify-content-center mb-4">
        <div class="col-6 col-md-6">
            <a href="/one_link_inherent_risk_main/{{$project->project_id}}/{{auth()->user()->id}}" class="text-decoration-none">
                <div class="p-4 text-white text-center rounded shadow"
                     style="background: linear-gradient(135deg, #FF512F, #DD2476); transition: 0.3s;">
                    <h4 class="fw-bold mb-0">Risk Identification and Classification</h4>
                </div>
            </a>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-6 col-md-6">
            <a href="" class="text-decoration-none">
                <div class="p-4 text-white text-center rounded shadow"
                     style="background: linear-gradient(135deg, #FF512F, #F09819); transition: 0.3s;">
                    <h4 class="fw-bold mb-0">Residual Risk Assessment</h4>
                </div>
            </a>
        </div>
    </div>
</div>



</div>









        @section('scripts')


        @endsection


@endsection