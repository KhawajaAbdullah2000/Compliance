@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">


<form action="/v3_2_s1_1_2_edit_timeframe_form/{{$timeframe->project_id}}/{{auth()->user()->id}}" method="post">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="date">Date of report:</label>
      <input type="date" class="form-control" id="" name='date_of_report' value="{{old('date_of_report',$timeframe->date_of_report)}}">
      @if($errors->has('date_of_report'))
      <div class="text-danger">{{ $errors->first('date_of_report') }}</div>
  @endif
    </div>

    <div class="form-group mt-3">
        <label for="">Start Date:</label>
        <input type="date" class="form-control"  name='start_date' value="{{old('start_date',$timeframe->start_date)}}">
        @if($errors->has('start_date'))
        <div class="text-danger">{{ $errors->first('start_date') }}</div>
    @endif
      </div>

      <div class="form-group mt-3">
        <label for="">End Date:</label>
        <input type="date" class="form-control" name='end_date' value="{{old('end_date',$timeframe->end_date)}}">
        @if($errors->has('end_date'))
        <div class="text-danger">{{ $errors->first('end_date') }}</div>
    @endif
      </div>


      <div class="form-group mt-3">
        <label for="">Time spend Onsite</label>
        <input type="text" class="form-control" name='time_onsite' value="{{old('time_onsite',$timeframe->time_onsite)}}">
        @if($errors->has('time_onsite'))
        <div class="text-danger">{{ $errors->first('time_onsite') }}</div>
    @endif
      </div>

      <div class="form-group mt-3">
        <label for="">Time spend Remote</label>
        <input type="text" class="form-control" name='time_remote' value="{{old('time_remote',$timeframe->time_remote)}}">
        @if($errors->has('time_remote'))
        <div class="text-danger">{{ $errors->first('time_remote') }}</div>
    @endif
      </div>

      <div class="form-group mt-3">
        <label for="">Time spend on validation of remediation activities</label>
        <input type="text" class="form-control" name='time_remediation' value="{{old('time_remediation',$timeframe->time_remediation)}}">
        @if($errors->has('time_remediation'))
        <div class="text-danger">{{ $errors->first('time_remediation') }}</div>
    @endif
      </div>

      <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary btn-md">Submit details</button>
      </div>








</form>

        </div>
    </div>

</div>
@endsection
