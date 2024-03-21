@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">


    <h3 class="text-center fw-bold mb-3">Project name: {{$project_name}} Scope of Assets and Services</h3>



@if($data->count()==0)

<h1>Add assets first in section2.1</h1>


@endif
{{-- if !issset $data --}}


@if($data->count()>0)

    <h3 class="text-center">Sec2.4 A6: Organizational Controls</h3>

    <table class="table table-responsive table-primary table-striped mt-4">
        <thead class="thead-dark">
          <tr style="vertical-align: middle">
            <th >Asset Group Name</th>
            <th>Asset Name</th>
            <th>Asset Component Name</th>
            <th>Asset Owner Dept</th>
            <th>Asset Physical Location</th>
            <th>Asset Logical Location</th>
            <th>Service Name for which this is an underlying asset </th>
<th>Organizational Controls</th>

            <th>Actions</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
@foreach ($data as $d)
            <tr>
                <td class="fw-bold">{{substr($d->g_name,0,15)}} @if(strlen($d->g_name)>15)... @endif </td>
                <td>{{substr($d->name,0,20)}} @if(strlen($d->name)>20)... @endif </td>
                <td>{{substr($d->c_name,0,10)}}@if(strlen($d->c_name)>10)... @endif </td>
                <td>{{substr($d->owner_dept,0,10)}}@if(strlen($d->owner_dept)>10)... @endif </td>
                <td>{{substr($d->physical_loc,0,10)}}@if(strlen($d->physical_loc)>10).. @endif </td>
                <td>{{substr($d->logical_loc,0,10)}}@if(strlen($d->logical_loc)>10)... @endif </td>
                <td>{{substr($d->s_name,0,16)}}@if(strlen($d->s_name)>16)... @endif </td>


                <td>
 <a href="/iso_sec2_4_a6/{{$d->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white"><p class="fw-bold">
People Controls</p></a>

                </td>


            <td>
            @if(in_array('Data Inputter',$permissions))

             <a href="/iso_sec_2_1_edit/{{$d->assessment_id}}/{{$d->project_id}}/{{auth()->user()->id}}">
                <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
            </a>

            <a href="/iso_sec_2_1_delete/{{$d->assessment_id}}/{{$d->project_id}}/{{auth()->user()->id}}">
                <i class="fas fa-trash-alt fa-lg" style="color: #e60000;"></i>
            </a>
        @else
        <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>

        @endif
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
