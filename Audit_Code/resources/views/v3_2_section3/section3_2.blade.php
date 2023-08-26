@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h2 class="text-center">
    Section 3.2 for Project id: {{$project_id}} Project name:{{$project_name}}
    </h2>

    @if(in_array('Data Inputter',$permissions))


    @if(!isset($data))


    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Cardholder Data Environment (CDE) overview</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s3_3_2_form/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">People - such as technical support, management,
                        administrators, operations teams, cashiers, telephone operators, physical security, etc.:</label>
                        <textarea name="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1')}}</textarea>
                    @if($errors->has('requirement1'))
                    <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Processes - such as payment channels, business functions, etc.: </label>
                        <textarea name="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2')}}</textarea>
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Technologies - such as e-commerce systems, internal network segments, DMZ segments,
                         processor connections, POS systems, encryption mechanisms, etc.:</label>
                        <textarea name="requirement3" cols="70" rows="10" class="form-control">{{old('requirement3')}}</textarea>
                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Locations/sites/stores - such as retail outlets, data centers, corporate office
                        locations, call centers, etc.:</label>
                        <textarea name="requirement4" cols="70" rows="10" class="form-control">{{old('requirement4')}}</textarea>
                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2">
                    <label for="">Other details(if any):</label>
                        <textarea name="other_details" cols="70" rows="10" class="form-control">{{old('other_details')}}</textarea>
                    @if($errors->has('other_details'))
                    <div class="text-danger">{{ $errors->first('other_details') }}</div>
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
    {{-- if !isset $data --}}



    @endif
    {{-- if user is data inputter --}}


    @if(isset($data))
    <div class="container">
        <h2 class="mt-3 fw-bold text-center">Cardholder Data Environment (CDE) overview</h2>


        <p class="lead mt-4">People - such as technical support, management,
            administrators, operations teams, cashiers, telephone operators, physical security, etc.:</p>
        <p><span class="fw-bold">Answer: </span>{{$data->requirement1}}</p>

        <p class="lead mt-4">Processes - such as payment channels, business functions, etc.: </p>
        <p><span class="fw-bold">Answer: </span>{{$data->requirement2}}</p>

        <p class="lead mt-4">Technologies - such as e-commerce systems, internal network segments, DMZ segments, processor connections, POS systems, encryption mechanisms, etc.:</p>
        <p><span class="fw-bold">Answer: </span>{{$data->requirement3}}</p>

        <p class="lead mt-4">Locations/sites/stores - such as retail outlets, data centers, corporate office locations,
            call centers, etc.:</p>
        <p><span class="fw-bold">Answer: </span>{{$data->requirement4}}</p>


        @if(isset($data->other_details))

        <p class="lead mt-4">Other details</p>
        <p><span class="fw-bold">Answer: </span>{{$data->other_details}}</p>
        @endif

        <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$data->first_name}} {{$data->last_name}}</span>
        <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($data->last_edited_at))}}</span>

        @if(in_array('Data Inputter',$permissions))
        <a href="/v3_2_s3_3_2_edit/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}"
            class="float-end btn btn-primary btn-lg mb-2 px-5">Edit</a>

        @endif





    </div>








    @endif
    {{-- if isset $data --}}







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
