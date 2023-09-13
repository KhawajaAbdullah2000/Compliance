@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <h2 class="text-center">
        <h1 class="text-center">Project: {{$project_name}}</h1>
        <h2 class="text-center fw-bold">Section 4.11 Managed service providers</h2>

    </h2>

    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Edit Managed service providers(MSP) review</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s4_4_11_editform/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                @method('PUT')
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
                <input name="requirement2" class="form-control" value="{{old('requirement2',$data->requirement2)}}">
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2 d-none" id="requirement3">
                    <label for="">List the requirements that are the responsibility of the MSP's customers
                         (and have not been included in this assessment).</label>
                <input name="requirement3" class="form-control" value="{{old('requirement3',$data->requirement3)}}">
                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2 d-none" id="requirement4">
                    <label for="">Provide the name of the assessor who attests that the testing of these requirements and/or
                         responsibilities of the MSP is accurately represented in the signed Attestation of Compliance.</label>
                <input name="requirement4" class="form-control" value="{{old('requirement4',$data->requirement4)}}">
                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="requirement5">
                    <label for="">Identify which of the MSP's IP addresses are scanned as part of the MSP's
                        uarterly vulnerability scans.</label>
                <input name="requirement5" class="form-control" value="{{old('requirement5',$data->requirement5)}}">
                    @if($errors->has('requirement5'))
                    <div class="text-danger">{{ $errors->first('requirement5') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2 d-none" id="requirement6">
                    <label for="">Identify which of the MSP's IP addresses are the responsibility of the MSP's customers.</label>
                <input name="requirement6" class="form-control" value="{{old('requirement6',$data->requirement6)}}">
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

</div>




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

@endsection
