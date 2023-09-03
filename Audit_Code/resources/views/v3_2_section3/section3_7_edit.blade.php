@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h2 class="text-center">
        Section 3.7 for Project id: {{$project_id}} Project name:{{$project_name}}
        </h2>

        <div class="row">

            <div class="col-md-12">

                <div class="card mt-2">
                    <div class="card-header bg-primary text-center">
                        <h2>Wireless Summary</h2>
                      </div>
                    <div class="card-body">


                <form action="/v3_2_s3_3_7_editform/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}" method="post">
                    @csrf

                    @method('PUT')
                    <div class="form-group">
                        <label for="">Indicate whether there  are wireless networks or technologies in use (in or out of scope) </label>
                        <div class="col-6">
                        <select class="boxstyling bg-primary rounded form-select" name="requirement1" id="requirement1">
                        <option value="">Select yes/no</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                    </select>
                </div>
                        @if($errors->has('requirement1'))
                        <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                    @endif
                      </div>

                      <div class="form-group mt-2 d-none" id="if_no">
                        <label for="">describe how the assessor verified that there are no wireless networks
                            or technologies in use.</label>
                    <textarea name="if_no" id="" cols="100" rows="10" clas="form-control">{{old('if_no',$data->if_no)}}</textarea>
                        @if($errors->has('if_no'))
                        <div class="text-danger">{{ $errors->first('if_no') }}</div>
                    @endif
                      </div>

                      <div class="form-group mt-2 d-none" id="requirement2">
                        <label for="">Wireless LANs</label>
                        <select class="boxstyling bg-primary rounded form-select" name="requirement2" id="">
                            <option value="">Select yes/no</option>
                            <option value="yes" {{old('requirement2',$data->requirement2)=='yes'? 'selected':''}}>Yes</option>
                            <option value="no" {{old('requirement2',$data->requirement2)=='no'? 'selected':''}}>No</option>
                        </select>
                      </div>

                      <div class="form-group mt-2 d-none" id="requirement3">
                        <label for="">Wireless payment applications (for example, POS terminals)</label>
                        <select class="boxstyling bg-primary rounded form-select" name="requirement3" id="">
                            <option value="">Select yes/no</option>
                            <option value="yes" {{old('requirement3',$data->requirement3)=='yes'? 'selected':''}}>Yes</option>
                            <option value="no" {{old('requirement3',$data->requirement3)=='no'? 'selected':''}}>No</option>
                        </select>
                      </div>

                      <div class="form-group mt-2 d-none" id="requirement4">
                        <label for="">All other wireless devices/technologies</label>
                        <select class="boxstyling bg-primary rounded form-select" name="requirement4" id="">
                            <option value="">Select yes/no</option>
                            <option value="yes" {{old('requirement4',$data->requirement4)=='yes'? 'selected':''}}>Yes</option>
                            <option value="no" {{old('requirement4',$data->requirement4)=='no'? 'selected':''}}>No</option>
                        </select>
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

{{-- dependemt form --}}
@section('dependent_form')

var requirement1=$('#requirement1');

 requirement1.change(function(){
    var value=this.value;

    if(value=='no'){
        $('#if_no').removeClass('d-none');
        $('#requirement2').addClass('d-none');
        $('#requirement3').addClass('d-none');
        $('#requirement4').addClass('d-none');
    }

    if(value=='yes'){
        $('#if_no').addClass('d-none');
        $('#requirement2').removeClass('d-none');
        $('#requirement3').removeClass('d-none');
        $('#requirement4').removeClass('d-none');


    }


 });



@endsection
{{-- //dependemt form --}}





@endsection
