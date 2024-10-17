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


      <h2 class="text-center fw-bold mt-4 mb-4">
        @if($title==1)
      1: INFORMATION TECHNOLOGY GOVERNANCE IN FI(s)

        @elseif ($title==2)
        2: INFORMATION SECURITY
        @elseif ($title==3)
        3: IT SERVICES DELIVERY & OPERATIONS MANAGEMENT

        @elseif ($title==4)
        4: ACQUISITION & IMPLEMENTATION OF IT SYSTEMS

        @elseif ($title==5)
        5: BUSINESS CONTINUITY AND DISASTER RECOVERY

        @elseif ($title==6)
        6: IT AUDIT
        @endif
      </h2>



    <table class="table table-bordered table-responsive table-primary">

        <thead>
            <td>Title of Mandatory Requirement</td>
            <td>Actions</td>
        </thead>

        <tbody>
            <tr>

                <td>
                <p>{!! nl2br($data[0][2]) !!} {!! nl2br($data[0][3]) !!}</p>

                </td>
                <td><a href="/sbp_etgrmf_sec_2_2_req/{{($data[0][2]) }}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white">View</a></td>

            </tr>

            @for ($i = 1; $i < count($data); $i++)
            <tr style="vertical-align: middle;text-align:initial">

                    @php
                    $my_prev_main_req_num=$data[$i-1][2];
                     $my_current_main_req_num=$data[$i][2];
                    @endphp


                    @if ($my_prev_main_req_num==$my_current_main_req_num)
                        @continue

                    @else
                    <td>
                        <p> {!! nl2br($data[$i][2]) !!} {!! nl2br($data[$i][3]) !!}</p>

                       </td>

                       <td><a href="/sbp_etgrmf_sec_2_2_req/{{$my_current_main_req_num}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white">View</a></td>
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