@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 3.4 Network Segment details</h2>



    <div class="col-md-12">



        <div class="card-header bg-primary text-center">
            @if($data->network_type==1)
            <h2>Describe a network that store, process and/or transmit CHD</h2>
            @elseif($data->network_type==2)
            <h2>Describe all networks that do not store, process and/or transmit CHD, but are still in scope
                (e.g., connected to the CDE or provide management functions to the CDE)</h2>
            @else
            <h2>Describe any networks confirmed to be out of scope</h2>
            @endif


         </div>
         <div class="card-body">
            <form method="post" action="/v3_2_s3_3_4_edit_form/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="network_name">Network name:</label>
                  <input type="text" class="form-control" id="network_name" name='network_name' value="{{old('network_name',$data->network_name)}}">
                  @if($errors->has('network_name'))
                  <div class="text-danger">{{ $errors->first('network_name') }}</div>
              @endif
                </div>

                <div class="form-group">
                    <label for="purpose_of_network">Purpose of network:</label>
                    <textarea name="purpose_of_network" id="purpose_of_network" cols="70" rows="10" class="form-control">{{old('purpose_of_network',$data->purpose_of_network)}}</textarea>
                    @if($errors->has('purpose_of_network'))
                    <div class="text-danger">{{ $errors->first('purpose_of_network') }}</div>
                @endif
                  </div>

                  <div class="text-center mt-2">
                    <button type="submit" class="btn btn-primary btn-md">Edit details</a>
                  </div>


            </form>

        </div>




    </div>



</div>

@endsection
