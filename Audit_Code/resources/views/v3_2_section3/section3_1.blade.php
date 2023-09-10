@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h2 class="text-center">
    Section 3.1 for Project id: {{$project_id}} Project name:{{$project_name}}
    </h2>

    @if(in_array('Data Inputter',$permissions))


    @if(!isset($data))


    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Assessor's validation of defined cardholder data environment and scope accuracy</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s3_3_1_form/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Describe the methods or processes (for example, the specific types of tools, observations,
                        feedback, scans,
                        data flow analysis) used to identify
                        and document all existences of cardholder data (as executed by the assessed entity, assessor or a
                         combination):</label>
                        <textarea name="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1')}}</textarea>
                    @if($errors->has('requirement1'))
                    <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Describe the methods or processes (for example, the specific types of tools, observations, feedback, scans, data flow analysis) used to verify that no cardholder data exists outside of the defined CDE (as executed by the assessed entity, assessor or a combination):</label>
                        <textarea name="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2')}}</textarea>
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Describe how the results of the methods/processes were documented (for example, the results may be a diagram or an inventory of cardholder data locations):</label>
                        <textarea name="requirement3" cols="70" rows="10" class="form-control">{{old('requirement3')}}</textarea>
                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Describe how the results of the methods/processes were evaluated by the assessor to verify that the PCI DSS scope of review is appropriate: </label>
                        <textarea name="requirement4" cols="70" rows="10" class="form-control">{{old('requirement4')}}</textarea>
                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Describe why the methods (for example, tools, observations, feedback, scans, data flow analysis, or any environment design decisions that were made to help limit the scope of the environment) used for scope verification are considered by the assessor to be effective and accurate:</label>
                        <textarea name="requirement5" cols="70" rows="10" class="form-control">{{old('requirement5')}}</textarea>
                    @if($errors->has('requirement5'))
                    <div class="text-danger">{{ $errors->first('requirement5') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Provide the name of the assessor who attests that the defined CDE and scope of the assessment has been verified to be accurate, to the best of the assessor's ability and with all due diligence:</label>
                        <textarea name="requirement6" cols="70" rows="10" class="form-control">{{old('requirement6')}}</textarea>
                    @if($errors->has('requirement6'))
                    <div class="text-danger">{{ $errors->first('requirement6') }}</div>
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

    <div class="row">

        <div class="card mb-5">

            <div class="card-body">

                <label>Describe the methods or processes (for example, the specific types of tools, observations,
                     feedback, scans, data flow analysis) used to identify and document all
                     existences of cardholder data (as executed by the assessed entity, assessor or a combination)</label>
                <p><span class="fw-bold">Answer: </span>{{$data->requirement1}}</p>


                <label>Describe the methods or processes (for example, the specific types of tools, observations,
                    feedback, scans, data flow analysis) used to verify that no cardholder data
                    exists outside of the defined CDE (as executed by the assessed entity, assessor or a combination)</label>
               <p><span class="fw-bold">Answer: </span>{{$data->requirement2}}</p>


               <label>Describe how the results of the methods/processes were documented
                (for example, the results may be a diagram or an inventory of cardholder data locations)</label>
           <p><span class="fw-bold">Answer: </span>{{$data->requirement3}}</p>


           <label>Describe how the results of the methods/processes were evaluated by the assessor
             to verify that the PCI DSS scope of review is appropriate</label>
       <p><span class="fw-bold">Answer: </span>{{$data->requirement4}}</p>

            <label>Describe why the methods (for example, tools, observations, feedback, scans, data flow analysis,
                or any environment design decisions that were made to help limit the scope of the environment) used
                for scope verification are considered by the assessor to be effective and accurate</label>
        <p><span class="fw-bold">Answer: </span>{{$data->requirement5}}</p>


        <label>Provide the name of the assessor who attests that the defined CDE and scope of the assessment has been verified to
             be accurate, to the best of the assessor's ability and with all due diligence</label>
    <p><span class="fw-bold">Answer: </span>{{$data->requirement6}}</p>


    @if(isset($data->other_details))
            <label>Other Details</label>
        <p><span class="fw-bold">Answer: </span>{{$data->other_details}}</p>
    @endif

    <label for="">last edited by: </label>
    <span class="badge text-bg-success text-black">{{$data->first_name}} {{$data->last_name}}</span>

       <br>

    <label for="">last edited at: </label>
    <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($data->last_edited_at))}}</span>


    @if(in_array('Data Inputter',$permissions))

    <a href="/v3_2_s3_3_1_edit/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}"
     class="float-end btn btn-primary btn-md mx-2">Edit</a>

    @endif




            </div>
        </div>
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
