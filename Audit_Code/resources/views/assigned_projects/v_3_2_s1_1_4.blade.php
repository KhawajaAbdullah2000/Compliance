@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h2 class="text-center">
    Section 1.4 for Project id: {{$project_id}} Project name:{{$project_name}}
    </h2>

    @if(in_array('Data Inputter',$permissions))


    @if(!isset($services))


    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Additional services provided by QSA company</h2>
                  </div>
                <div class="card-body">



            <form action="/v3_2_s1_1_4_services/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="date">Disclose all services offered to the assessed entity by the QSAC,
                        including but not limited to whether the assessed entity uses any security-related devices
                        or security-related applications that have been developed or manufactured by the QSA,
                        or to which the QSA owns the rights or that the QSA has configured or manages:</label>
                        <textarea name="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1')}}</textarea>
                    @if($errors->has('requirement1'))
                    <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="date">Describe efforts made to ensure no conflict of interest resulted
                        from the above mentioned services provided by the QSAC:</label>
                        <textarea name="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2')}}</textarea>
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-md mt-2">Submit Details</button>
                  </div>


            </form>

        </div>
    </div>


        </div>
    </div>



    @endif
    {{-- if !isset $services --}}



    @endif
    {{-- if user is data inputter --}}


    @if(isset($services))


    <div class="row">
        <div class="col-md-6 border border-primary">
            <p>Disclose all services offered to the assessed entity by the QSAC,
                including but not limited to whether the assessed entity uses any security-related devices
                or security-related applications that have been developed or manufactured by the QSA,
                or to which the QSA owns the rights or that the QSA has configured or manages</p>
        </div>

        <div class="col-md-6 border border-success bg-warning">

      <p>{{$services->requirement1}}</p>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6 border border-primary">
            <p>Describe efforts made to ensure no conflict of interest resulted
                from the above mentioned services provided by the QSAC</p>
        </div>

        <div class="col-md-6 border border-success bg-warning">
      <p>{{$services->requirement2}}</p>
        </div>
    </div>


    <div class="row mt-4">
        <div class="col-md-6 border border-primary">
            <p>Last edited by: {{$services->first_name}} {{$services->last_name}}</p>
            <p>Last edited at: {{date('F d, Y H:i A', strtotime($services->last_edited_at))}}</p>
        </div>

        @if(in_array('Data Inputter',$permissions))
        <div class="col-md-6">
      <p><a href="/v3_2_s1_1_4_edit/{{$services->assessment_id}}/{{$services->project_id}}/{{auth()->user()->id}}"
        class="btn btn-primary btn-md px-5">Edit</a></p>
        </div>
        @endif
{{--
        if data inputter for editing --}}
    </div>





    @endif
    {{-- if isset $services --}}







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

</script>

 @endsection



@endsection
