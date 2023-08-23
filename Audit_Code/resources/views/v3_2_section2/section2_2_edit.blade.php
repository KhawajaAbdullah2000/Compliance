@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <h2 class="text-center">
        Section 2.2 for Project id: {{$project_id}} Project name:{{$project_name}}
        </h2>

        <h3 class="text-center mt-3">Insert a high level network diagram</h3>


    <form action="/v3_2_s2_2_2_form/{{$project_id}}/{{auth()->user()->id}}" method="post" enctype="multipart/form-data">
        @csrf
     <div class="row">

         <div class="col-md-6">
             <input type="file" name="diagram" class="form-control">
             @if($errors->has('diagram'))
             <div class="text-danger">{{ $errors->first('diagram') }}</div>
         @endif
         </div>

         <div class="col-md-6">
             <button type="submit" class="btn btn-primary">Upload</button>
         </div>

     </div>
     </form>
</div>


@endsection
