@extends('master')

@section('content')

@include('user-nav')


<div class="container">

    <div class="col-md-12">

        <div class="card-header bg-primary text-center">
            <h2>Description of cardholder data flows</h2>
        </div>

        <div class="card-body">

            <form method="post" action="/v3_2_s4_2_2_edit_dataflows/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="dataflows">Cardholder data flows</label>
                  <input type="text" class="form-control" id="dataflows" name='dataflows' value="{{old('dataflows',$data->dataflows)}}" placeholder="eg capture/authorization etc">
                  @if($errors->has('dataflows'))
                  <div class="text-danger">{{ $errors->first('dataflows') }}</div>
              @endif
                </div>

                <div class="form-group mt-2">
                    <label for="types_of_chd">Types of CHD involved</label>
                    <input type="text" class="form-control" id="types_of_chd" name='types_of_chd' value="{{old('types_of_chd',$data->types_of_chd)}}" placeholder="eg full track/PAN etc">
                    @if($errors->has('types_of_chd'))
                    <div class="text-danger">{{ $errors->first('types_of_chd') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-4" id="description">
                    <label for="">Describe how cardholder data is transmitted and/or processed and for what purpose it
                        is used (for example, which protocols or technologies were used in each transmission)</label>
                <textarea name="description" id="" cols="100" rows="10" clas="form-control">{{old('description',$data->description)}}</textarea>
                    @if($errors->has('description'))
                    <div class="text-danger">{{ $errors->first('description') }}</div>
                @endif
                  </div>

                  <div class="text-center mt-2">
                    <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                  </div>


            </form>


        </div>


    </div>



</div>


@endsection
