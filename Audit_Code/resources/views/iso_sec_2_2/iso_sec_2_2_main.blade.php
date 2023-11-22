@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')
@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">


    <h1 class="text-center">Project id {{$project_id}} {{$project_name}} </h1>

      <h2 class="text-center fw-bold mt-4 mb-4">
        {{$title}}- Context Of The Organization
    </h2>


    <table class="table table-bordered table-responsive table-primary">

        <thead>
            <td>Title of Mandatory Requirement</td>
            <td>Actions</td>
        </thead>

        <tbody>
            <tr>
                @php
                $my_main_req_num=explode(' ',$data[0][2]);
                @endphp
                <td>
                <p>{!! nl2br($data[0][2]) !!}</p>
                </td>
                <td><a href="/iso_sec_2_2_req/{{$my_main_req_num[0]}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-warning">View</a></td>

            </tr>

            @for ($i = 1; $i < count($data); $i++)
            <tr style="vertical-align: middle;text-align:initial">

                    @php
                    $my_prev_main_req_num=explode(' ',$data[$i-1][2]);
                     $my_current_main_req_num=explode(' ',$data[$i][2]);
                    @endphp


                    @if ($my_prev_main_req_num==$my_current_main_req_num)
                        @continue

                    @else
                    <td>
                        <p> {!! nl2br($data[$i][2]) !!}</p>
                       </td>

                       <td><a href="/iso_sec_2_2_req/{{$my_current_main_req_num[0]}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-warning">View</a></td>
                    @endif









                              {{-- <p>{!! nl2br($data[$i][2]) !!}</p> --}}

             @endfor
            {{-- @foreach ($data as $d)

            <tr>
                <td>{!! nl2br($d[2]) !!}</td>
                <td style="text-align:center">
                    <a href="/"><i class="fas fa-eye fa-lg" style="color: #114a1d;"></i>
                    </a></td>

            </tr>

            @endforeach --}}

        </tbody>

    </table>

</div>

@endsection
