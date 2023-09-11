@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">


    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.7 Service providers and other third parties with which the entity
        shares cardholder data or that could affect the security of cardholder data </h2>


        @if(in_array('Data Inputter',$permissions))

        @if($data->count()==0)

        <div class="card-header bg-primary text-center py-2">
            <h2>Insert First Service Provider/Third Party</h2>
        </div>


    <div class="card-body">


        <form method="post" action="/v3_2_s4_4_7_insert/{{$project_id}}/{{auth()->user()->id}}">
            @csrf


            <div class="form-group mt-3">
                <label for="requirement1">Company Name</label>
                <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1')}}">
                @if($errors->has('requirement1'))
                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement2">What data is shared</label>
                <br>
                <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2')}}">
                @if($errors->has('requirement2'))
                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
            @endif
              </div>



              <div class="form-group mt-2">
                <label for="requirement3">The purpose for sharing the data </label>
                <input type="text" class="form-control" id="requirement3" name='requirement3' value="{{old('requirement3')}}">
                @if($errors->has('requirement3'))
                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement4">Status of PCI DSS Compliance</label>
                <input type="text" class="form-control" id="requirement4" name='requirement4' value="{{old('requirement4')}}"
                placeholder="Date of AOC and version #">
                @if($errors->has('requirement4'))
                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
            @endif
              </div>



              <div class="text-center mt-2 mb-2">
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
        <a class="btn btn-success btn-md float-end mb-3" href="/v3_2_s4_4_7_new/{{$project_id}}/{{auth()->user()->id}}"
        role="button">Add new <i class="fas fa-plus"></i></a>
        @endif
        </div>
        </div>

    <div class="row">
        @foreach ($data as $item)

        <div class="card mb-5">
            <div class="card-body">
            <label>Company Name</label>
             <p><span class="fw-bold">Answer: </span>{{$item->requirement1}}</p>

             <label>What data is shared</label>
             <p><span class="fw-bold">Answer: </span>{{$item->requirement2}}</p>

             <label>The purpose for sharing the data</label>
             <p><span class="fw-bold">Answer: </span>{{$item->requirement3}}</p>

             <label>Status of PCI DSS Compliance</label>
             <p><span class="fw-bold">Answer: </span>{{$item->requirement4}}</p>



           <label for="">last edited by: </label>
             <span class="badge text-bg-success text-black">{{$item->first_name}} {{$item->last_name}}</span>

                <br>

             <label for="">last edited at: </label>
             <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($item->last_edited_at))}}</span>


             @if(in_array('Data Inputter',$permissions))

             <a href="/v3_2_s4_4_7_delete/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
                 class="float-end btn btn-danger btn-md mx-2">Delete</a>

             <a href="/v3_2_s4_4_7_edit/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
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
