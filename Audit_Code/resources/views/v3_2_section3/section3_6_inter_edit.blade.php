@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 3.6 Other business entities that require compliance with the PCI DSS</h2>


<div class="card-header bg-primary text-center">
    <h2>International entities owned by the assessed entity that are required to comply with PCI DSS:</h2>
</div>

    <div class="card-body">
        <form method="post" action="/v3_2_s3_3_6_inter_editform/{{$data2->assessment_id}}/{{$data2->project_id}}/{{auth()->user()->id}}">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="entity_name">International Entity Name</label>
              <input type="text" class="form-control" id="entity_name" name='entity_name' value="{{old('entity_name',$data2->entity_name)}}">
              @if($errors->has('entity_name'))
              <div class="text-danger">{{ $errors->first('entity_name') }}</div>
          @endif
            </div>

            <div class="form-group mt-2">
                <label for="entity_country">Country</label>
                <textarea name="entity_country" id="country" cols="70" rows="10" class="form-control">{{old('entity_country',$data2->entity_country)}}</textarea>
                @if($errors->has('entity_country'))
                <div class="text-danger">{{ $errors->first('entity_country') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement1">Facilities in this country reviewed: As part of this assessment</label>
                <textarea name="requirement1" id="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1',$data2->requirement1)}}</textarea>
                @if($errors->has('requirement1'))
                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
            @endif
              </div>


              <div class="form-group mt-2">
                <label for="requirement2">Facilities in this country reviewed: Seperately</label>
                <textarea name="requirement2" id="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2',$data2->requirement2)}}</textarea>
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
