@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
$headers=array('Control num','Title of COntrol','Descriptionof Control')
@endphp

<div class="container">

 <h3 class="text-center fw-bold mb-3">Project id: {{$project_id}} Project name: {{$project_name}} Section2.4 A:7 Physical Controls</h3>

                @foreach ($data[0] as $row)
                            @if(isset($row))
                                <p>
                                    <span class="fw-bold">{{$headers[$loop->index]}}: </span>
                                    {!! nl2br($row) !!}
                                </p>
                            @endif

                @endforeach


                <p> <span class="fw-bold">Control is Applicable: </span>
                    {{$result->applicability}}
                   </p>



    <div class="col-md-12">



        <div class="card-header text-center">
        <h3 class="fw-bold">Edit Applicability</h3>

         </div>
         <div class="card-body">
            <form method="post" action="/submit_edit_app_sec2_4_a7/{{$result->control_num}}/{{$project_id}}/{{auth()->user()->id}}">
                @csrf
                @method('PUT')


                <div class="form-group">
             <label for="">Applicability</label>
                    <select name="applicability" class="form-select">
                    <option value="yes" {{old('applicability',$result->applicability)=='yes'?'selected':''}}>Yes</option>
                    <option value="no" {{old('applicability',$result->applicability)=='no'?'selected':''}}>No</option>
                </select>

                  </div>


                  <div class="text-center mt-3">
                    <button type="submit" class="btn my_bg_color text-white btn-md">Submit</a>
                  </div>


            </form>

        </div>




    </div>



</div>





@endsection
