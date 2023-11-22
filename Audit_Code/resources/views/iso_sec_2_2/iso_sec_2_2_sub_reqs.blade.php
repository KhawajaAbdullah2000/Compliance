@extends('master')

@section('content')

@include('user-nav')
@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">

    <h1 class="text-center">Project id {{$project_id}} {{$project_name}} </h1>

      <h2 class="text-center fw-bold mt-4 mb-4">
   {{$data[0][2]}}
    </h2>


    <table class="table table-bordered table-responsive table-primary">

        <thead style="vertical-align: middle;text-align:center;">
            <td class="fw-bold">Req. No</td>
            <td class="fw-bold">Mandatory Requirement</td>
            <td class="fw-bold">Actions</td>
        </thead>

        <tbody>

            @foreach ($data as $d )
            <tr>
                <td>{{$d[3]}}</td>
                 <td>{!! nl2br($d[4]) !!}</td>
                 <td style="text-align:center">
                <a href="/iso_sec2_2_sub_req_edit/{{$d[3]}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}">
                    <i class="fas fa-eye fa-lg" style="color: #114a1d;"></i>
                </a>
            </td>

             </tr>

            @endforeach


        </tbody>

    </table>

</div>

@endsection
