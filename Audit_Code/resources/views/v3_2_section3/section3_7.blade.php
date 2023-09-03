@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h2 class="text-center">
    Section 3.7 for Project id: {{$project_id}} Project name:{{$project_name}}
    </h2>

    @if(in_array('Data Inputter',$permissions))


    @if(!isset($data))


    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Wireless Summary</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s3_3_7_insert/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Indicate whether there  are wireless networks or technologies in use (in or out of scope) </label>
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

                  <div class="form-group mt-2 d-none" id="if_no">
                    <label for="">describe how the assessor verified that there are no wireless networks
                        or technologies in use.</label>
                <textarea name="if_no" id="" cols="100" rows="10" clas="form-control">{{old('if_no')}}</textarea>
                    @if($errors->has('if_no'))
                    <div class="text-danger">{{ $errors->first('if_no') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="requirement2">
                    <label for="">Wireless LANs</label>
                    <select class="boxstyling bg-primary rounded form-select" name="requirement2" id="">
                        <option value="">Select yes/no</option>
                        <option value="yes" {{old('requirement2')=='yes'? 'selected':''}}>Yes</option>
                        <option value="no" {{old('requirement2')=='no'? 'selected':''}}>No</option>
                    </select>
                  </div>

                  <div class="form-group mt-2 d-none" id="requirement3">
                    <label for="">Wireless payment applications (for example, POS terminals)</label>
                    <select class="boxstyling bg-primary rounded form-select" name="requirement3" id="">
                        <option value="">Select yes/no</option>
                        <option value="yes" {{old('requirement3')=='yes'? 'selected':''}}>Yes</option>
                        <option value="no" {{old('requirement3')=='no'? 'selected':''}}>No</option>
                    </select>
                  </div>

                  <div class="form-group mt-2 d-none" id="requirement4">
                    <label for="">All other wireless devices/technologies</label>
                    <select class="boxstyling bg-primary rounded form-select" name="requirement4" id="">
                        <option value="">Select yes/no</option>
                        <option value="yes" {{old('requirement4')=='yes'? 'selected':''}}>Yes</option>
                        <option value="no" {{old('requirement4')=='no'? 'selected':''}}>No</option>
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



    @endif
    {{-- if !isset $data --}}



    @endif
    {{-- if user is data inputter --}}

    @if(isset($data))

     <div class="container">
        <h2 class="mt-3 fw-bold text-center">Wireless Summary</h2>


        <p class="lead mt-4">Indicate whether there  are wireless networks or technologies in use (in or out of scope), (yes/no)</p>
        <p><span class="fw-bold">Answer: </span>{{$data->requirement1}}</p>


        @isset($data->if_no)
        <p class="lead mt-4">Describe how the assessor verified that there are no wireless networks or technologies in use.</p>
        <p><span class="fw-bold">Answer: </span>{{$data->if_no}}</p>
        @endisset

        @isset($data->requirement2)
        <p class="lead mt-4">Indicate whether wireless is in scope (i.e. part of the CDE, connected to or could
            impact the security of the cardholder data environment), (yes/no):</p>

            <p class="lead ">Wireless LANs:</p>

        <p><span class="fw-bold">Answer: </span>{{$data->requirement2}}</p>
        @endisset


        @isset($data->requirement3)
        <p class="lead mt-4">Wireless payment applications (for example, POS terminals)</p>
        <p><span class="fw-bold">Answer: </span>{{$data->requirement3}}</p>
        @endisset

        @isset($data->requirement4)
        <p class="lead mt-4">All other wireless devices/technologies</p>
        <p><span class="fw-bold">Answer: </span>{{$data->requirement4}}</p>
        @endisset




        <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$data->first_name}} {{$data->last_name}}</span>
        <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($data->last_edited_at))}}</span>

        @if(in_array('Data Inputter',$permissions))
        <a href="/v3_2_s3_3_7_edit/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}"
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



@endsection
