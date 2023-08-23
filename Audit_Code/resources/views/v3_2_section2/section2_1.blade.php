@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="">
    <h2 class="text-center">
    Section 2.1 for Project id: {{$project_id}} Project name:{{$project_name}}
    </h2>

    @if(in_array('Data Inputter',$permissions))


    @if(!isset($entity))


    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Description of the entity's payment card business</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s2_2_1_insert/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Describe the nature of the entity's business
                        (what kind of work they do, etc):</label>
                        <textarea name="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1')}}</textarea>
                    @if($errors->has('requirement1'))
                    <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Describe how the entity stores, processes, and/or transmits cardholder data:</label>
                        <textarea name="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2')}}</textarea>
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Describe why the entity stores, processes, and/or transmits cardholder data:</label>
                        <textarea name="requirement3" cols="70" rows="10" class="form-control">{{old('requirement3')}}</textarea>
                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="">Identify the types of payment channels the entity serves, such as
                        card-present and card-not-present (for example, mail order/telephone order (MOTO), e-commerce):</label>
                        <textarea name="requirement4" cols="70" rows="10" class="form-control">{{old('requirement4')}}</textarea>
                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-2">
                    <label for="">Other details(if any):</label>
                        <textarea name="other_details" cols="70" rows="10" class="form-control">{{old('other_details')}}</textarea>
                    @if($errors->has('other_details'))
                    <div class="text-danger">{{ $errors->first('other_details') }}</div>
                @endif
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-md mt-2">Submit Details</button>
                  </div>


            </form>

        </div>
    </div>


        </div>
    </div>



    @endif
    {{-- if !isset $entity --}}



    @endif
    {{-- if user is data inputter --}}


    @if(isset($entity))
    <div class="container">
        <h2 class="mt-3 fw-bold text-center">Description of the entity's payment card business</h2>


        <p class="lead mt-4">Describe the nature of the entity's business (what kind of work they do, etc.) </p>
        <p><span class="fw-bold">Answer: </span>{{$entity->requirement1}}</p>

        <p class="lead mt-4">Describe how the entity stores, processes, and/or transmits cardholder data.</p>
        <p><span class="fw-bold">Answer: </span>{{$entity->requirement2}}</p>

        <p class="lead mt-4">Describe why the entity stores, processes, and/or transmits cardholder data.</p>
        <p><span class="fw-bold">Answer: </span>{{$entity->requirement3}}</p>

        <p class="lead mt-4">Identify the types of payment channels the entity serves, such as card-present and card-not-present
            (for example, mail order/telephone order (MOTO), e-commerce</p>
        <p><span class="fw-bold">Answer: </span>{{$entity->requirement4}}</p>

        @if(isset($entity->other_details))

        <p class="lead mt-4">Other details</p>
        <p><span class="fw-bold">Answer: </span>{{$entity->other_details}}</p>
        @endif

        <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$entity->first_name}} {{$entity->last_name}}</span>
        <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($entity->last_edited_at))}}</span>

        @if(in_array('Data Inputter',$permissions))
        <a href="/v3_2_s2_2_1_edit/{{$entity->assessment_id}}/{{$entity->project_id}}/{{auth()->user()->id}}"
            class="float-end btn btn-primary btn-lg mb-2 px-5">Edit</a>

        @endif





    </div>








    @endif
    {{-- if isset $entity --}}







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
