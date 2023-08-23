@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <h2 class="mt-3 fw-bold text-center"> For project id: {{$project_id}} Project name: {{$project_name}}</h2>


    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Description of the entity's payment card business</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s2_2_1_edit_form/{{$entity->assessment_id}}/{{$entity->project_id}}/{{auth()->user()->id}}"
                method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="">Describe the nature of the entity's business
                        (what kind of work they do, etc):</label>
                        <textarea name="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1',$entity->requirement1)}}</textarea>
                    @if($errors->has('requirement1'))
                    <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Describe how the entity stores, processes, and/or transmits cardholder data:</label>
                        <textarea name="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2',$entity->requirement2)}}</textarea>
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Describe why the entity stores, processes, and/or transmits cardholder data:</label>
                        <textarea name="requirement3" cols="70" rows="10" class="form-control">{{old('requirement3',$entity->requirement3)}}</textarea>
                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Identify the types of payment channels the entity serves, such as
                        card-present and card-not-present (for example, mail order/telephone order (MOTO), e-commerce):</label>
                        <textarea name="requirement4" cols="70" rows="10" class="form-control">{{old('requirement4',$entity->requirement4)}}</textarea>
                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2">
                    <label for="">Other details(if any):</label>
                        <textarea name="other_details" cols="70" rows="10" class="form-control">{{old('other_details',$entity->other_details)}}</textarea>
                    @if($errors->has('other_details'))
                    <div class="text-danger">{{ $errors->first('other_details') }}</div>
                @endif
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-md mt-2">Edit Details</button>
                  </div>


            </form>

        </div>
    </div>


        </div>
    </div>




</div>


@endsection
