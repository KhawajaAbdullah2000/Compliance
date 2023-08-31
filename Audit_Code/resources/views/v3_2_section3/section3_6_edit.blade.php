@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 3.6 Other business entities that require compliance with the PCI DSS</h2>


<div class="card-header bg-primary text-center">
    <h2>Entity wholly owned by the assessed entity that are required to comply with PCI DSS</h2>
</div>

    <div class="card-body">
        <form method="post" action="/v3_2_s3_3_6_edit_form/{{$data1->assessment_id}}/{{$data1->project_id}}/{{auth()->user()->id}}">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="wholly_owned_entity">Wholly Owned Entity Name</label>
              <input type="text" class="form-control" id="wholly_owned_entity" name='wholly_owned_entity' value="{{old('wholly_owned_entity',$data1->wholly_owned_entity)}}">
              @if($errors->has('wholly_owned_entity'))
              <div class="text-danger">{{ $errors->first('wholly_owned_entity') }}</div>
          @endif
            </div>

            <div class="form-group mt-2">
                <label for="requirement1">Reviewed: As part of this assessment</label>
                <textarea name="requirement1" id="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1',$data1->requirement1)}}</textarea>
                @if($errors->has('requirement1'))
                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement1">Reviewed: Seperately</label>
                <textarea name="requirement2" id="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2',$data1->requirement2)}}</textarea>
                @if($errors->has('requirement2'))
                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
            @endif
              </div>


              <div class="text-center mt-2">
                <button type="submit" class="btn btn-primary btn-md">Edit details</a>
              </div>


        </form>

    </div>

</div>
@endsection
