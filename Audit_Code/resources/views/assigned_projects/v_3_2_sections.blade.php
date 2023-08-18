@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">Project id {{$project_id}} {{$project_name}}Sections</h1>

    <div class="row text-center justify-content-center">
        <div class="col">
         <a href="/v_3_2_section1_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1- Contact Information and Report Date</a>

        </div>
            {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a> --}}
           <div class="col-6">
            <a href="" class="btn btn-lg btn-warning">Section2</a>
           </div>

           <div class="col-6 mt-3">
            <a href="" class="btn btn-lg btn-warning">Section3</a>
           </div>

           <div class="col-6 mt-3">
            <a href="" class="btn btn-lg btn-warning">Section4</a>
           </div>




    </div>


</div>

{{-- @section('scripts')

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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif

<script>

let table = new DataTable('#myTable',
    {
    language: {
       searchPlaceholder: "search"
    },
      "ordering": false

     }
     );

</script> --}}

{{-- @endsection --}}


@endsection
