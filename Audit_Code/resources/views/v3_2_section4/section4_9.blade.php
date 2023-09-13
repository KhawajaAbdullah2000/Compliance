@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">


    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.9 Documentation Reviewed</h2>


        @if(in_array('Data Inputter',$permissions))

        @if($data->count()==0)

        <div class="card-header bg-primary text-center py-2">
            <h2>Insert First reviewed document details</h2>
        </div>


    <div class="card-body">


        <form method="post" action="/v3_2_s4_4_9_insert/{{$project_id}}/{{auth()->user()->id}}">
            @csrf


            <div class="form-group mt-3">
                <label for="requirement1">Reference Number  (optional)</label>
                <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1')}}">
                @if($errors->has('requirement1'))
                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement2">Document Name (including version, if applicable)</label>
                <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2')}}">
                @if($errors->has('requirement2'))
                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
            @endif
              </div>


              <div class="form-group mt-2">
                <label for="requirement3">Brief description of document purpose</label>
                <br>
                <textarea name="requirement3" id="" cols="100" rows="10" clas="form-control">{{old('requirement3')}}</textarea>
                @if($errors->has('requirement3'))
                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
            @endif
              </div>

              <div class="form-group mt-2 col-6">
                <label for="requirement4">Document date (latest version date)</label>
                <input type="date" name="requirement4" id="requirement4" class="form-control" value="{{old('requirement4')}}">

                @if($errors->has('requirement4'))
                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
            @endif
              </div>



              <div class="text-center mt-4 mb-2">
                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
              </div>


        </form>

    </div>


        @endif
        {{-- if !issset $data --}}


        @endif
        {{-- if datainputter --}}

        @if($data->count()>0)


            <div class="row">

                <div class="col-md-12">

        @if(in_array('Data Inputter',$permissions))
        <a class="btn btn-success btn-md float-end mb-3" href="/v3_2_s4_4_9_new/{{$project_id}}/{{auth()->user()->id}}"
        role="button">Add new <i class="fas fa-plus"></i></a>
        @endif
        </div>
        </div>

    <div class="row">
        @foreach ($data as $item)

        <div class="card mb-5">
            <div class="card-body">
            <label>Reference Number (optional)</label>
            @isset($item->requirement1)
            <p><span class="fw-bold">Answer: </span>{{$item->requirement1}}</p>
            @else
            <p><span class="fw-bold">Answer: </span>--</p>
            @endisset

             <label>Document Name</label>
             <p><span class="fw-bold">Answer: </span>{{$item->requirement2}}</p>

             <label>Brief description of document purpose</label>
             <p><span class="fw-bold">Answer: </span>{{$item->requirement3}}</p>

             <label>Document date (latest version date)</label>
             <p><span class="fw-bold">Answer: </span>{{date('F d, Y', strtotime($item->requirement4))}}</p>



           <label for="">last edited by: </label>
             <span class="badge text-bg-success text-black">{{$item->first_name}} {{$item->last_name}}</span>

                <br>

             <label for="">last edited at: </label>
             <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($item->last_edited_at))}}</span>


             @if(in_array('Data Inputter',$permissions))

             <a href="/v3_2_s4_4_9_delete/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
                 class="float-end btn btn-danger btn-md mx-2">Delete</a>

             <a href="/v3_2_s4_4_9_edit/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
                 class="float-end btn btn-primary btn-md mx-2">Edit</a>

             @endif




            </div>
          </div>





        @endforeach

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

@endsection

@endsection
