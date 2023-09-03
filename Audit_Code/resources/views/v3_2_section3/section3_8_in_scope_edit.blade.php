@extends('master')

@section('content')

@include('user-nav')




<div class="container">

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 3.8 Wireless Details</h2>


    <div class="col-md-12">

        <div class="card-header bg-primary text-center">
            <h2>For a wireless technology in scope, identify the following:</h2>
        </div>

            <div class="card-body">
                <form method="post" action="/v3_2_s3_3_8_inscope_edit/{{$data1->assessment_id}}/{{$data1->project_id}}/{{auth()->user()->id}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="wireless_technology">Identified wireless technology</label>
                      <input type="text" class="form-control" id="wireless_technology" name='wireless_technology' value="{{old('wireless_technology',$data1->wireless_technology)}}">
                      @if($errors->has('wireless_technology'))
                      <div class="text-danger">{{ $errors->first('wireless_technology') }}</div>
                  @endif
                    </div>

                    <div class="form-group mt-2">
                        <label for="requirement1">Whether the technology is used to store, process or transmit CHD</label>
                        <div class="col-6">
                            <select class="boxstyling bg-primary rounded form-select fw-bold" name="requirement1" id="requirement1">
                            <option value="">Select yes/no</option>
                            <option value="yes" {{old('requirement1',$data1->requirement1)=='yes'? 'selected':''}}>Yes</option>
                            <option value="no" {{old('requirement1',$data1->requirement1)=='no'? 'selected':''}}>No</option>
                        </select>

                        @if($errors->has('requirement1'))
                        <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                    @endif
                      </div>
                    </div>



                    <div class="form-group mt-2">
                        <label for="requirement2">Whether the technology is connected to or part of the CDE</label>
                        <div class="col-6">
                            <select class="boxstyling bg-primary rounded form-select fw-bold" name="requirement2" id="requirement2">
                            <option value="">Select yes/no</option>
                            <option value="yes" {{old('requirement2',$data1->requirement2)=='yes'? 'selected':''}}>Yes</option>
                            <option value="no" {{old('requirement2',$data1->requirement2)=='no'? 'selected':''}}>No</option>
                        </select>
                        @if($errors->has('requirement2'))
                        <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                    @endif
                      </div>
                    </div>


                    <div class="form-group mt-2">
                        <label for="requirement3">Whether the technology could impact the security of the CDE</label>
                        <div class="col-6">
                            <select class="boxstyling bg-primary rounded form-select fw-bold" name="requirement3" id="requirement3">
                            <option value="">Select yes/no</option>
                            <option value="yes" {{old('requirement3',$data1->requirement3)=='yes'? 'selected':''}}>Yes</option>
                            <option value="no" {{old('requirement3',$data1->requirement3)=='no'? 'selected':''}}>No</option>
                        </select>
                        @if($errors->has('requirement3'))
                        <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                    @endif
                      </div>
                    </div>



                      <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                      </div>


                </form>

            </div>
         </div>




</div>


@endsection
