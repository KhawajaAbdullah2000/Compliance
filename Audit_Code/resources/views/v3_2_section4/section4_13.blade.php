@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.13 Disclosure summary for "Not Tested" responses</h2>

    @if(in_array('Data Inputter',$permissions))

    @if(!isset($data1))

    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>summary for "Not Tested" responses</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s4_4_13_insert/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf

                <div class="form-group">
                    <label for="">Identify whether there were any responses indicated as "Not Tested" </label>
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
                    <label for="">Requirement/testing procedure with this result</label>
                <input name="requirement2" class="form-control" value="{{old('requirement2')}}">
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2 d-none" id="requirement3">
                    <label for="">Summary of the issue (for example, not deemed in scope for the assessment, etc.)</label>
                    <br>
                    <textarea name="requirement3" cols="70" rows="10">{{old('requirement3')}}</textarea>
                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
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
    {{-- if !issset $data1 --}}


    @endif
    {{-- if datainputter --}}

            @if (isset($data1))

            @if($data1->requirement1=="yes")

            @if($data2->count()>0)

            <div class="row">

        <div class="col-md-12">

        @if(in_array('Data Inputter',$permissions))
        <a class="btn btn-success btn-md float-end mb-3" href="/v3_2_s4_4_13_new/{{$project_id}}/{{auth()->user()->id}}"
        role="button">Add new <i class="fas fa-plus"></i></a>
        @endif
        </div>
        </div>

        <div class="row">
            @foreach ($data2 as $item)

            <div class="card mb-5">
                <div class="card-body">

                <label>Identify whether there were any responses indicated as “Not Tested” </label>
                <p><span class="fw-bold">Answer: </span>{{$data1->requirement1}}</p>


                 <label>Requirement/testing procedures with this result</label>
                 <p><span class="fw-bold">Answer: </span>{{$item->requirement2}}</p>

                 <label>Summary of the issue</label>
                 <p><span class="fw-bold">Answer: </span>{{$item->requirement3}}</p>



               <label for="">last edited by: </label>
                 <span class="badge text-bg-success text-black">{{$item->first_name}} {{$item->last_name}}</span>

                    <br>

                 <label for="">last edited at: </label>
                 <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($item->last_edited_at))}}</span>


                 @if(in_array('Data Inputter',$permissions))

                 <a href="/v3_2_s4_4_13_delete/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
                     class="float-end btn btn-danger btn-md mx-2">Delete</a>

                 <a href="/v3_2_s4_4_13_edit/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
                     class="float-end btn btn-primary btn-md mx-2">Edit</a>

                 @endif




                </div>
              </div>





            @endforeach

            </div>






            @endif
            {{-- if issset $data2 --}}

            @if($data2->count()==0)

            <label for="">Identify whether there were any responses indicated as "Not Tested" (yes/no)</label>
            <p><span class="fw-bold">Answer: </span>{{$data1->requirement1}}</p>

            <label for="">last edited by: </label>
            <span class="badge text-bg-success text-black">{{$data1->first_name}} {{$data1->last_name}}</span>

               <br>

            <label for="">last edited at: </label>
            <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($data1->last_edited_at))}}</span>

            @if(in_array('Data Inputter',$permissions))

            <a href="/v3_2_s4_4_13_edit_yes_no/{{$data1->project_id}}/{{auth()->user()->id}}"
                class="float-end btn btn-primary btn-md mx-2">Edit</a>

            @endif

            <div class="row mt-5">

                <div class="col-md-12">

                    <div class="card mt-2">
                        <div class="card-header bg-primary text-center">
                            <h2>summary for "Not Tested" responses</h2>
                          </div>
                        <div class="card-body">


                    <form action="/v3_2_s4_4_13_insert_new/{{$project_id}}/{{auth()->user()->id}}" method="post">
                        @csrf

                          <div class="form-group mt-2">
                            <label for="">Requirement/testing procedure with this result</label>
                        <input name="requirement2" class="form-control" value="{{old('requirement2')}}">
                            @if($errors->has('requirement2'))
                            <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                        @endif
                          </div>


                          <div class="form-group mt-2">
                            <label for="">Summary of the issue (legal obligation, etc.)</label>
                            <br>
                            <textarea name="requirement3" cols="70" rows="10">{{old('requirement3')}}</textarea>
                            @if($errors->has('requirement3'))
                            <div class="text-danger">{{ $errors->first('requirement3') }}</div>
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
            {{-- !if !isssrt $data2 --}}




            @endif
            {{-- if $data1->requiremn1==yes --}}


            @if($data1->requirement1=="no")
            <label for="">Identify whether there were any responses indicated as "Not Tested" (yes/no)</label>
            <p><span class="fw-bold">Answer: </span>{{$data1->requirement1}}</p>

            <label for="">last edited by: </label>
            <span class="badge text-bg-success text-black">{{$data1->first_name}} {{$data1->last_name}}</span>

               <br>

            <label for="">last edited at: </label>
            <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($data1->last_edited_at))}}</span>

            @if(in_array('Data Inputter',$permissions))

            <a href="/v3_2_s4_4_13_edit_yes_no/{{$data1->project_id}}/{{auth()->user()->id}}"
                class="float-end btn btn-primary btn-md mx-2">Edit</a>

            @endif



            @endif
            {{-- $data1->requirement1=="no" --}}





            @endif
            {{-- if issset $data1 --}}

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
    }

    if(value=='yes'){
        $('#requirement2').removeClass('d-none');
        $('#requirement3').removeClass('d-none');

    }


 });



@endsection
{{-- //dependemt form --}}

 @endsection



@endsection
