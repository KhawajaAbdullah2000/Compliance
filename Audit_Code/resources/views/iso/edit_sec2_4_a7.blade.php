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
        <h3 class="fw-bold">Details</h3>

         </div>
         <div class="card-body">
            <form method="post" action="/submit_edit_sec2_4_a7/{{$result->control_num}}/{{$project_id}}/{{auth()->user()->id}}">
                @csrf
                @method('PUT')



                @if($result->applicability=="no" )
                <div class="form-group mt-2">
                  <label for="network_name" class="fs-5">Justification:</label>
                  <textarea name="justification" cols="70" rows="10" class="form-control">{{old('justification',$result->justification)}}</textarea>
                  @if($errors->has('justification'))
                  <div class="text-danger">{{ $errors->first('justification') }}</div>
              @endif
                </div>
                @endif

                <div class="form-group mt-4 fs-5">
                    <label for="network_name">Reference of Risk Assessment and Treatment:</label>
                    <textarea name="ref_of_risk" cols="70" rows="10" class="form-control">{{old('ref_of_risk',$result->ref_of_risk)}}</textarea>
                    @if($errors->has('ref_of_risk'))
                    <div class="text-danger">{{ $errors->first('ref_of_risk') }}</div>
                @endif
                  </div>



                  <div class="text-center mt-3 mb-2">
                    <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                  </div>


            </form>

        </div>




    </div>



</div>





@endsection
