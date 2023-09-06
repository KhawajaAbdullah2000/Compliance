@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <h2 class="text-center mt-2 fw-bold">
        Optional Dataflow Diagrams
           </h2>

           <form action="/v3_2_s4_4_2_insert_diagram/{{$project_id}}/{{auth()->user()->id}}" method="post" enctype="multipart/form-data">
            @csrf
         <div class="row mt-4">

 <div class="col-md-6">
    <input type="file" name="data_flow_diagram" class="form-control">
    @if($errors->has('data_flow_diagram'))
    <div class="text-danger">{{ $errors->first('data_flow_diagram') }}</div>
@endif
</div>

<div class="col-md-6">
    <button type="submit" class="btn btn-primary">Upload</button>
</div>

         </div>

        </form>



</div>


@endsection
