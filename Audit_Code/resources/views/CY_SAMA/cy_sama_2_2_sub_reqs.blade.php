@extends('master')

@section('content')

@include('user-nav')


@include('iso_sec_nav')
@php
$permissions=json_decode($project_permissions);
@endphp

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

    <a href="/cy_sama_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md float-end">Go to All Requirements</a>

      <h4 class="text-center fw-bold mt-4 mb-4">
    {{$main_req_num}}  {{$data[0][3]}}
    </h4>

    <table class="table table-bordered table-responsive table-primary">

        <thead style="vertical-align: middle;text-align:center;">
            <td class="fw-bold" style="width:10%">Control No.</td>
            <td class="fw-bold" style="width:80%">Mandatory Requirement</td>
            <td class="fw-bold" style="width:10%">Actions</td>
        </thead>

        <tbody>

            @foreach ($data as $d )
            <tr>
                <td style="text-align:center">{{$d[4]}}</td>
                 <td>{!! nl2br($d[5]) !!}</td>
                 <td style="text-align:center">
                <a href="/cy_sama_sec2_2_sub_req_edit/{{$d[4]}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}">
                    <i class="fas fa-edit fa-lg" style="color: #114a1d;"></i>
                </a>
            </td>

             </tr>

            @endforeach


        </tbody>

    </table>

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
