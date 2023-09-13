@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h2 class="text-center">
        <h1 class="text-center">Project: {{$project_name}}</h1>
        <h2 class="text-center fw-bold">Section 4.11 Managed service providers</h2>

    </h2>

    @if(in_array('Data Inputter',$permissions))


    @if(!isset($data))


    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Managed service providers(MSP) review</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s4_4_11_insert/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf

                <div class="form-group">
                    <label for="">Identify whether the entity being assessed is a managed service provider</label>
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


                  <div class="form-group mt-2 d-none" id="requirement2">
                    <label for="">List the requirements that apply to the MSP and are included in this assessment.</label>
                <input name="requirement2" class="form-control" value="{{old('requirement2')}}">
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2 d-none" id="requirement3">
                    <label for="">List the requirements that are the responsibility of the MSP's customers
                         (and have not been included in this assessment).</label>
                <input name="requirement3" class="form-control" value="{{old('requirement3')}}">
                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2 d-none" id="requirement4">
                    <label for="">Provide the name of the assessor who attests that the testing of these requirements and/or
                         responsibilities of the MSP is accurately represented in the signed Attestation of Compliance.</label>
                <input name="requirement4" class="form-control" value="{{old('requirement4')}}">
                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="requirement5">
                    <label for="">Identify which of the MSP's IP addresses are scanned as part of the MSP's
                        uarterly vulnerability scans.</label>
                <input name="requirement5" class="form-control" value="{{old('requirement5')}}">
                    @if($errors->has('requirement5'))
                    <div class="text-danger">{{ $errors->first('requirement5') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2 d-none" id="requirement6">
                    <label for="">Identify which of the MSP's IP addresses are the responsibility of the MSP's customers.</label>
                <input name="requirement6" class="form-control" value="{{old('requirement6')}}">
                    @if($errors->has('requirement6'))
                    <div class="text-danger">{{ $errors->first('requirement6') }}</div>
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

    <label>Identify whether the entity being assessed is a managed service provider</label>
    <p><span class="fw-bold">Answer: </span>{{$data->requirement1}}</p>

@isset($data->requirement2)
     <label>List the requirements that apply to the MSP and are included in this assessment.</label>
     <p><span class="fw-bold">Answer: </span>{{$data->requirement2}}</p>
     @endisset


    @isset($data->requirement3)
    <label>List the requirements that are the responsibility of the MSP's customers (and have not been included in this assessment).</label>
    <p><span class="fw-bold">Answer: </span>{{$data->requirement3}}</p>
    @endisset


    @isset($data->requirement4)
    <label>Provide the name of the assessor who attests that the testing of these requirements and/or responsibilities of the MSP is accurately represented in the signed Attestation of Compliance.</label>
    <p><span class="fw-bold">Answer: </span>{{$data->requirement4}}</p>
    @endisset


    @isset($data->requirement5)
    <label>Identify which of the MSP's IP addresses are scanned as part of the MSP's quarterly vulnerability scans.</label>
    <p><span class="fw-bold">Answer: </span>{{$data->requirement5}}</p>
    @endisset


    @isset($data->requirement6)
    <label>Identify which of the MSP's IP addresses are the responsibility of the MSP's customers.</label>
    <p><span class="fw-bold">Answer: </span>{{$data->requirement6}}</p>
    @endisset




   <label for="">last edited by: </label>
     <span class="badge text-bg-success text-black">{{$data->first_name}} {{$data->last_name}}</span>

        <br>

     <label for="">last edited at: </label>
     <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($data->last_edited_at))}}</span>


     @if(in_array('Data Inputter',$permissions))

     <a href="/v3_2_s4_4_11_edit/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}"
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



{{-- dependemt form --}}
@section('dependent_form')

var requirement1=$('#requirement1');

 requirement1.change(function(){
    var value=this.value;

    if(value=='no'){
        $('#requirement2').addClass('d-none');
        $('#requirement3').addClass('d-none');
        $('#requirement4').addClass('d-none');
        $('#requirement5').addClass('d-none');
        $('#requirement6').addClass('d-none');
    }

    if(value=='yes'){
        $('#requirement2').removeClass('d-none');
        $('#requirement3').removeClass('d-none');
        $('#requirement4').removeClass('d-none');
        $('#requirement5').removeClass('d-none');
        $('#requirement6').removeClass('d-none');


    }


 });



@endsection
{{-- //dependemt form --}}

 @endsection



@endsection
