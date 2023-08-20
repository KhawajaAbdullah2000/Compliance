@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h2 class="text-center">
    Section 1.2 for Project id: {{$project_id}} Project name:{{$project_name}}
    </h2>

    @if(in_array('Data Inputter',$permissions))

    @if(!isset($timeframe))

    <div class="row justify-content-center">

    <div class="col-md-6">

    <form action="/v3_2_s1_2_date/{{$project_id}}/{{auth()->user()->id}}" method="post">
        @csrf
        <div class="form-group">
          <label for="date">Date of report:</label>
          <input type="date" class="form-control" id="" name='date_of_report' value="{{old('date_of_report')}}">
          @if($errors->has('date_of_report'))
          <div class="text-danger">{{ $errors->first('date_of_report') }}</div>
      @endif
        </div>

        <div class="form-group mt-3">
            <label for="">Start Date:</label>
            <input type="date" class="form-control"  name='start_date' value="{{old('start_date')}}">
            @if($errors->has('start_date'))
            <div class="text-danger">{{ $errors->first('start_date') }}</div>
        @endif
          </div>

          <div class="form-group mt-3">
            <label for="">End Date:</label>
            <input type="date" class="form-control" name='end_date' value="{{old('end_date')}}">
            @if($errors->has('end_date'))
            <div class="text-danger">{{ $errors->first('end_date') }}</div>
        @endif
          </div>


          <div class="form-group mt-3">
            <label for="">Time spend Onsite</label>
            <input type="text" class="form-control" name='time_onsite' value="{{old('time_onsite')}}">
            @if($errors->has('time_onsite'))
            <div class="text-danger">{{ $errors->first('time_onsite') }}</div>
        @endif
          </div>

          <div class="form-group mt-3">
            <label for="">Time spend Remote</label>
            <input type="text" class="form-control" name='time_remote' value="{{old('time_remote')}}">
            @if($errors->has('time_remote'))
            <div class="text-danger">{{ $errors->first('time_remote') }}</div>
        @endif
          </div>

          <div class="form-group mt-3">
            <label for="">Time spend on validation of remediation activities</label>
            <input type="text" class="form-control" name='time_remediation' value="{{old('time_remediation')}}">
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


    @endif
    {{-- if !isset timeframe for fdata inputter --}}



    @endif
    {{-- Data inputter or not endif --}}

    @if(isset($timeframe))

    <h2 class="mt-3 text-center">Date and timeframe of Assessment</h2>

    @if(in_array('Data Inputter',$permissions))
    <a class="btn btn-success btn-md float-end mb-3" href="/v3_2_s1_1_2_onsite/{{$project_id}}/{{auth()->user()->id}}"
        role="button">Add Date spent onsite <i class="fas fa-plus"></i></a>
        @endif
    <table class="table table-responsive table-hover table-bordered">
        <thead>
            <tr>
                <th>Date of report</th>
                <th>Start date</th>
                <th>End date</th>
                <th>Time spent Onsite</th>
                <th>Time spent remote</th>
                <th>Time spent remediation</th>
                <th>Last edited by</th>
                <th>Last edited at</th>

                <th>Actions</th>

            </tr>
        </thead>
        <tbody>

          <tr>
          <td>{{$timeframe->date_of_report}}</td>
          <td>{{$timeframe->start_date}}</td>
          <td>{{$timeframe->end_date}}</td>
          <td>{{$timeframe->time_onsite}}</td>
          <td>{{$timeframe->time_remote}}</td>
          <td>{{$timeframe->time_remediation}}</td>
          <td>{{$timeframe->first_name}} {{$timeframe->last_name}}</td>
          <td>{{date('F d, Y', strtotime($timeframe->last_edited_at))}}</td>




          @if(in_array('Data Inputter',$permissions))
            <td><a href="/v3_2_s1_1_2_edit_timeframe/{{$project_id}}/{{auth()->user()->id}}" class='btn btn-warning btn-sm'>Edit details</a></td>
            @else
            <td>Not allowed</td>
          @endif


          </tr>

        </tbody>

    </table>

    @if($date_onsite->count()>0)

    <h2 class="mt-5 text-center">Dates Spent onsite at the entity</h2>
    <table class="table table-responsive table-hover table-bordered mt-4">
        <thead>
            <tr>
                <th>Date Spend Onsite</th>
                <th>Last edited by</th>
                <th>Last edited at</th>
                <th>Actions</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($date_onsite as $onsite)

          <tr>
            <td>{{date('F d, Y', strtotime($onsite->date_spent_onsite))}}</td>

          <td>{{$onsite->first_name}} {{$onsite->last_name}}</td>
          <td>{{date('F d, Y', strtotime($onsite->last_edited_at))}}</td>



          @if(in_array('Data Inputter',$permissions))
            <td><a href="/v3_2_s1_edit_date_onsite/{{$onsite->assessment_id}}/{{$onsite->project_id}}/{{auth()->user()->id}}"
            class='btn btn-warning btn-sm'>Edit Date</a>
        <a href="/v3_2_s1_1_2_deleteonsite/{{$onsite->assessment_id}}/{{$onsite->project_id}}/{{auth()->user()->id}}"
            class='btn btn-danger btn-sm'>Delete</a>

            </td>
            @else
            <td>Not allowed</td>
          @endif
          </tr>
          @endforeach

        </tbody>

    </table>


    @endif
    {{-- if we have dates on site --}}



    @endif
    {{-- if isset timeframe --}}







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

<script>

let table = new DataTable('#myTable',
    {
    language: {
       searchPlaceholder: "search"
    },
      "ordering": false

     }
     );

</script>

 @endsection



@endsection
