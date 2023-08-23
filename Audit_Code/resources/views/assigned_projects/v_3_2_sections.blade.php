@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">Project id {{$project_id}} {{$project_name}}Sections</h1>

    <div class="row text-center justify-content-center full-img h-100 w-100 d-inline-block">
        <div class="row mt-2">
            <div class="col-12">

         <a href="/v_3_2_section1_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1- Contact Information and Report Date</a>
        </div>
        </div>
            {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a> --}}
            <div class="row mt-4">
                <div class="col-12">
             <a href="/v_3_2_section2_subsections/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section2- Summary Overview</a>
            </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
             <a href="" class="btn btn-lg btn-warning">Section3- Description of Scope of Work and Approach Taken</a>
            </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
             <a href="" class="btn btn-lg btn-warning">Section4- Details about Reviewed Environment</a>
            </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
             <a href="" class="btn btn-lg btn-warning">Section5- Quarterly Scan Results</a>
            </div>
            </div>

           <div class="row mt-4 mb-2">
                <div class="col-12">
             <a href="" class="btn btn-lg btn-warning">Section6- Findings and Observations</a>
            </div>
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
