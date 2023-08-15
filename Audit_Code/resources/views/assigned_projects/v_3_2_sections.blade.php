@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">

    <h1 class="text-center">Project id {{$project_id}} {{$project_name}}Sections</h1>

    <div class="row text-center justify-content-center">
        <div class="col-md-6 mt-4">
            <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a>
            <a href="" class="btn btn-lg btn-warning">Section2</a>
            <a href="" class="btn btn-lg btn-warning">Section3</a>
            <a href="" class="btn btn-lg btn-warning">Section4</a>
            <a href="" class="btn btn-lg btn-warning">Section5</a>
            <a href="" class="btn btn-lg btn-warning mt-3">Section6</a>
            <a href="" class="btn btn-lg btn-warning mt-3">Section7</a>
            <a href="" class="btn btn-lg btn-warning mt-3">Section8</a>
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