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


@if($data->count()==0)

<h1>Please Add an Asset first</h1>


@endif
{{-- if !issset $data --}}


@if($data->count()>0)

    <h3 class="text-center">SOA for Annex A7: Physical Controls</h3>

    <table class="table table-responsive table-primary table-striped mt-4">
        <thead class="thead-dark">
          <tr style="vertical-align: middle">
            <th>Service Name</th>
            <th >Asset Group Name</th>
            <th>Asset Name</th>
            <th>Asset Component Name</th>
            <th>Asset Owner Dept</th>
            <th>Asset Physical Location</th>
            <th>Asset Logical Location</th>

<th>Organizational Controls</th>

            <th>Details</th>
          </tr>
        </thead>
        <tbody>
@foreach ($data as $d)
            <tr>
                <td>{{substr($d->s_name,0,16)}}@if(strlen($d->s_name)>16)... @endif </td>
                <td>{{substr($d->g_name,0,15)}} @if(strlen($d->g_name)>15)... @endif </td>
                <td>{{substr($d->name,0,20)}} @if(strlen($d->name)>20)... @endif </td>
                <td>{{substr($d->c_name,0,10)}}@if(strlen($d->c_name)>10)... @endif </td>
                <td>{{substr($d->owner_dept,0,10)}}@if(strlen($d->owner_dept)>10)... @endif </td>
                <td>{{substr($d->physical_loc,0,10)}}@if(strlen($d->physical_loc)>10).. @endif </td>
                <td>{{substr($d->logical_loc,0,10)}}@if(strlen($d->logical_loc)>10)... @endif </td>



                <td>
 <a href="/iso_sec2_4_a7/{{$d->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white"><p class="fw-bold">
Physical Controls</p></a>

                </td>




                <td>
                <a href="/iso_sec_2_1_details/{{$d->assessment_id}}/{{$d->project_id}}/{{auth()->user()->id}}">
                    <i class="fas fa-eye fa-lg" style="color: #00d123;"></i>
                </a>
            </td>






            </tr>
     @endforeach


        </tbody>

      </table>
      @endif
      {{-- if issset $data --}}


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
