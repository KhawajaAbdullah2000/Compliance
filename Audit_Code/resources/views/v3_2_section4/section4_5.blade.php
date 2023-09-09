@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.5 Sampling</h2>

    @if(in_array('Data Inputter',$permissions))

    @if(!isset($data))


    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Sampling</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s4_4_5_insert/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Identify whether sampling was used during the assessment</label>
                    <div class="col-6">
                    <select class="boxstyling bg-primary rounded form-select" name="selection" id="selection">
                    <option value="">Select yes/no</option>
                    <option value="yes" {{old('selection')=='yes'? 'selected':''}}>Yes</option>
                    <option value="no" {{old('selection')=='no'? 'selected':''}}>No</option>
                </select>
            </div>
                    @if($errors->has('selection'))
                    <div class="text-danger">{{ $errors->first('selection') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="if_no">
                    <label for="">Provide the name of the assessor who attests that
                         every system component and all business facilities have been assessed.</label>
        <input type="text" class="form-control" name="if_no" placeholder="name" id="if_no" value="{{old('if_no')}}">
                    @if($errors->has('if_no'))
                    <div class="text-danger">{{ $errors->first('if_no') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="requirement2">
                    <label for="">Provide the name of the assessor who attests that all sample sets used
                        for this assessment are represented in "Sample sets for reporting" table. </label>
                    <div>
                        <textarea name="requirement2" id="" cols="100" rows="10" clas="form-control">{{old('requirement2')}}</textarea>
                    </div>
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2 d-none" id="requirement3">
                    <label for="">Describe the sampling rationale used for selecting sample sizes
                         (for people, processes, technologies, devices, locations/sites, etc)</label>
                    <div>
                        <textarea name="requirement3" id="" cols="100" rows="10" clas="form-control">{{old('requirement3')}}</textarea>
                    </div>
                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2 d-none" id="requirement4">

                    <label for="">If standardized PCI DSS security and operational processes/controls
                        were used for selecting sample sizes, describe how they were validated by the assessor.</label>
                    <div>
                        <textarea name="requirement4" id="" cols="100" rows="10" clas="form-control">{{old('requirement4')}}</textarea>
                    </div>
                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
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
    {{-- if !issset $data --}}



    @endif
    {{-- if datainputter --}}

    @if(isset($data))

    <div class="row">

        <div class="card mb-5">
            <div class="card-body">
            <label>Identify whether sampling was used during the assessment.</label>
             <p><span class="fw-bold">Answer: </span>{{$data->selection}}</p>

             @isset($data->if_no)
             <label>Provide the name of the assessor who attests that every system component
                and all business facilities have been assessed.</label>
             <p><span class="fw-bold">Answer: </span>{{$data->if_no}}</p>
             @endisset

             @isset($data->requirement2)
             <label>Provide the name of the assessor who attests that all sample sets used for this assessment are represented in the "Sample sets for reporting" table</label>
             <p><span class="fw-bold">Answer: </span>{{$data->requirement2}}</p>
             @endisset


             @isset($data->requirement3)
             <label>Describe the sampling rationale used for selecting sample sizes
                (for people, processes, technologies, devices, locations/sites, etc.)</label>
             <p><span class="fw-bold">Answer: </span>{{$data->requirement3}}</p>
             @endisset

             @isset($data->requirement4)
             <label>If standardized PCI DSS security and operational processes/controls were used
                for selecting sample sizes, describe how they were validated by the assessor.</label>
             <p><span class="fw-bold">Answer: </span>{{$data->requirement4}}</p>
             @endisset


           <label for="">last edited by: </label>
             <span class="badge text-bg-success text-black">{{$data->first_name}} {{$data->last_name}}</span>

                <br>

             <label for="">last edited at: </label>
             <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($data->last_edited_at))}}</span>


             @if(in_array('Data Inputter',$permissions))

             <a href="/v3_2_s4_4_5_delete/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}"
                 class="float-end btn btn-danger btn-md mx-2">Delete</a>

             <a href="/v3_2_s4_4_5_edit/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}"
                 class="float-end btn btn-primary btn-md mx-2">Edit</a>

             @endif




            </div>
          </div>




        </div>



    @endif
    {{-- if issset $data --}}



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

var selection=$('#selection');

 selection.change(function(){
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
