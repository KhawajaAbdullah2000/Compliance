@extends('master')

@section('content')

@include('user-nav')


@include('iso_sec_nav')
@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">

    <h1 class="text-center">{{$project_name}} </h1>

      <h2 class="text-center fw-bold mt-4 mb-4">
   {{$data[0][2]}}
    </h2>


    <table class="table table-bordered table-responsive table-primary">

        <thead style="vertical-align: middle;text-align:center;">
            <td class="fw-bold" style="width:10%">Req. No</td>
            <td class="fw-bold" style="width:80%">Mandatory Requirement</td>
            <td class="fw-bold" style="width:10%">Actions</td>
        </thead>

        <tbody>

            @foreach ($data as $d )
            <tr>
                <td style="text-align:center">{{$d[3]}}</td>
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
