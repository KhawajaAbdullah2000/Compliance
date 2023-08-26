@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h2 class="text-center">
    Section 3.3 for Project id: {{$project_id}} Project name:{{$project_name}}
    </h2>

    @if(in_array('Data Inputter',$permissions))


    @if(!isset($data))


    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Network Segmentation</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s3_3_3_insert/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Identify whether the assessed entity has used network segmentation to reduce the scope of the assessment</label>
                    <div class="col-6">
                    <select class="boxstyling bg-primary rounded form-select" name="requirement1" id="requirement1">
                    <option value="">Select yes/no</option>
                    <option value="yes" {{old('requirement1')=='yes'? 'selected':''}}>Yes</option>
                    <option value="no" {{old('requirement1')=='no'? 'selected':''}}>No</option>
                </select>
            </div>
                    @if($errors->has('requirement1'))
                    <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="segmentation_not_used">
                    <label for="">Provide the name of the assessor who attests that the whole
                        network has been included in the scope of the assessment.</label>

                            <input type="text" class="form-control" name="segmentation_not_used" placeholder="name" id="segmentation_not_used">

                    @if($errors->has('segmentation_not_used'))
                    <div class="text-danger">{{ $errors->first('segmentation_not_used') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="segmentation_used">
                    <label for="">Briefly describe how the segmentation is implemented:</label>
                    <div>
                        <textarea name="segmentation_used" id="" cols="100" rows="10" clas="form-control"></textarea>
                    </div>
                    @if($errors->has('segmentation_used'))
                    <div class="text-danger">{{ $errors->first('segmentation_used') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="segmentation_used_req1">
                    <label for="">Identify the technologies used and any supporting processes</label>
                    <div>
                        <textarea name="segmentation_used_req1" id="" cols="100" rows="10" clas="form-control"></textarea>
                    </div>
                    @if($errors->has('segmentation_used_req1'))
                    <div class="text-danger">{{ $errors->first('segmentation_used_req1') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2 d-none" id="segmentation_used_req2">

                    <label for="">Describe the methods used to validate the effectiveness of the segmentation
                        (for example, observed configurations of implemented technologies,
                        tools used, network traffic analysis, etc.).</label>
                    <div>
                        <textarea name="segmentation_used_req2" id="" cols="100" rows="10" clas="form-control"></textarea>
                    </div>
                    @if($errors->has('segmentation_used_req2'))
                    <div class="text-danger">{{ $errors->first('segmentation_used_req2') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="segmentation_used_req3">

                    <label for="">Describe how it was verified that the segmentation is functioning as intended</label>
                    <div>
                        <textarea name="segmentation_used_req3" id="" cols="100" rows="10" clas="form-control"></textarea>
                    </div>
                    @if($errors->has('segmentation_used_req3'))
                    <div class="text-danger">{{ $errors->first('segmentation_used_req3') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="segmentation_used_req4">

                    <label for="">Identify the security controls that are in place to ensure the integrity of the segmentation mechanisms
                        (e.g., access controls, change management, logging, monitoring, etc.).</label>
                    <div>
                        <textarea name="segmentation_used_req4" id="" cols="100" rows="10" clas="form-control"></textarea>
                    </div>
                    @if($errors->has('segmentation_used_req4'))
                    <div class="text-danger">{{ $errors->first('segmentation_used_req4') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="segmentation_used_req5">

                    <label for="">Describe how it was verified that the identified security controls are in place</label>
                    <div>
                        <textarea name="segmentation_used_req5" id="" cols="100" rows="10" clas="form-control"></textarea>
                    </div>
                    @if($errors->has('segmentation_used_req5'))
                    <div class="text-danger">{{ $errors->first('segmentation_used_req5') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">

                    <label for="">Provide the name of the assessor who attests that the segmentation was verified to
                        be adequate to reduce the scope of the assessment AND that the
                        technologies/processes used to implement segmentation were included in the PCI DSS assessment. </label>
                    <div>
                        <textarea name="requirement6" id="" cols="100" rows="10" clas="form-control"></textarea>
                    </div>
                    @if($errors->has('requirement6'))
                    <div class="text-danger">{{ $errors->first('requirement6') }}</div>
                @endif
                  </div>








                  {{-- <div class="form-group mt-2">
                    <label for="">Other details(if any):</label>
                        <textarea name="other_details" cols="70" rows="10" class="form-control">{{old('other_details')}}</textarea>
                    @if($errors->has('other_details'))
                    <div class="text-danger">{{ $errors->first('other_details') }}</div>
                @endif
                  </div> --}}

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

{{--
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





    </div> --}}

    @if(isset($data))
<h2>Record added</h2>
    @endif







    {{-- @endif --}}
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


{{-- dependemt form --}}
@section('dependent_form')

var requirement1=$('#requirement1');

 requirement1.change(function(){
    var value=this.value;

    if(value=='no'){
        $('#segmentation_not_used').removeClass('d-none');
        $('#segmentation_used').addClass('d-none');
        $('#segmentation_used_req1').addClass('d-none');
        $('#segmentation_used_req2').addClass('d-none');
        $('#segmentation_used_req3').addClass('d-none');
        $('#segmentation_used_req4').addClass('d-none');
        $('#segmentation_used_req5').addClass('d-none');
    }
    if(value=='yes'){
        $('#segmentation_not_used').addClass('d-none');
        $('#segmentation_used').removeClass('d-none');
        $('#segmentation_used_req1').removeClass('d-none');
        $('#segmentation_used_req2').removeClass('d-none');
        $('#segmentation_used_req3').removeClass('d-none');
        $('#segmentation_used_req4').removeClass('d-none');
        $('#segmentation_used_req5').removeClass('d-none');
    }


 });



@endsection
{{-- //dependemt form --}}

 @endsection



@endsection
