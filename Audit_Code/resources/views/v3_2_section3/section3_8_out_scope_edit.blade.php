@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <div class="col-md-12">


        <div class="card-header bg-primary text-center">
            <h2>Wireless technology not in scope, For this assessment</h2>
        </div>

            <div class="card-body">
                <form method="post" action="/v3_2_s3_3_8_outscope_edit/{{$data2->assessment_id}}/{{$data2->project_id}}/{{auth()->user()->id}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="wireless_out_scope">Identified wireless technology(not in scope)</label>
                      <input type="text" class="form-control" id="wireless_out_scope" name='wireless_out_scope' value="{{old('wireless_out_scope',$data2->wireless_out_scope)}}">
                      @if($errors->has('wireless_out_scope'))
                      <div class="text-danger">{{ $errors->first('wireless_out_scope') }}</div>
                  @endif
                    </div>


                    <div class="form-group mt-2" id="description">
                        <label for="">Describe how the wireless technology was validated by the assessor
                            to be not in scope</label>
                    <textarea name="description" id="" cols="100" rows="10" clas="form-control">{{old('description',$data2->description)}}</textarea>
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
