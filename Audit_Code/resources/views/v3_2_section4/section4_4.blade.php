@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.4 Critical hardware and software in use in the cardholder data environment</h2>

    @if(in_array('Data Inputter',$permissions))

    @if($data->count()==0)

    <div class="col-md-12">

        <div class="card-header bg-primary text-center py-3">
            <h2>Types of hardware and critical software in the cardholder environment</h2>

        </div>

        <div class="card-body">

            <p>Identify and list all types of hardware and critical software in the cardholder environment.
                Critical hardware includes network components, servers and other mainframes, devices performing security functions,
                end-user devices (such as laptops and workstations), virtualized devices (if applicable) and any other critical
                hardware - including homegrown components. Critical software includes e-commerce applications,
                 applications accessing CHD for non-payment functions (fraud modeling, credit verification, etc.),
                  software performing security functions or enforcing PCI DSS controls, underlying operating systems that
                  store, process or transmit CHD, system management
                software, virtualization management software, and other critical software - including homegrown software/applications</p>

            <form method="post" action="/v3_2_s4_4_4_insert/{{$project_id}}/{{auth()->user()->id}}">
                @csrf
                <div class="form-group">
                  <label for="requirement1">Type of Device</label>
                  <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1')}}">
                  @if($errors->has('requirement1'))
                  <div class="text-danger">{{ $errors->first('requirement1') }}</div>
              @endif
                </div>

                <div class="form-group mt-2">
                    <label for="requirement2">Vendor</label>
                    <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2')}}">
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-4" id="description">
                    <label for="requirement3">Make/Model</label>
                        <input type="text" class="form-control" id="requirement3" name='requirement3' value="{{old('requirement3')}}">

                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-4" id="description">
                    <label for="requirement4">Name of Software Product</label>
                        <input type="text" class="form-control" id="requirement4" name='requirement4' value="{{old('requirement4')}}">

                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                @endif
                  </div>



                  <div class="form-group mt-4" id="description">
                    <label for="requirement5">Version or release</label>
                        <input type="text" class="form-control" id="requirement5" name='requirement5' value="{{old('requirement5')}}">

                    @if($errors->has('requirement5'))
                    <div class="text-danger">{{ $errors->first('requirement5') }}</div>
                @endif
                  </div>



                  <div class="form-group mt-4" id="description">
                    <label for="requirement6">Role/Functionality</label>
                    <br>
                <textarea name="requirement6" id="" cols="100" rows="10" clas="form-control">{{old('requirement6')}}</textarea>
                    @if($errors->has('requirement6'))
                    <div class="text-danger">{{ $errors->first('requirement6') }}</div>
                @endif
                  </div>

                  <div class="text-center mt-2 mb-2">
                    <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                  </div>


            </form>


        </div>


    </div>




    @endif
    {{-- if !issset $data --}}


    @endif
    {{-- if Data inputter --}}


    @if($data->count()>0)

    <div class="mb-4">

        <div class="row">

            <div class="col-md-12">

    @if(in_array('Data Inputter',$permissions))
    <a class="btn btn-success btn-md float-end mb-3" href="/v3_2_s4_4_4_new/{{$project_id}}/{{auth()->user()->id}}"
    role="button">Add new <i class="fas fa-plus"></i></a>
    @endif
    </div>
    </div>

<div class="row">
    @foreach ($data as $item)

    <div class="card mb-5">
        <div class="card-body">
        <label>Type of Device</label>
         <p><span class="fw-bold">Answer: </span>{{$item->requirement1}}</p>

         <label>Vendor</label>
         <p><span class="fw-bold">Answer: </span>{{$item->requirement2}}</p>

         <label>Make/Model</label>
         <p><span class="fw-bold">Answer: </span>{{$item->requirement3}}</p>

         <label>Name of Software Product</label>
         <p><span class="fw-bold">Answer: </span>{{$item->requirement4}}</p>


         <label>Version or Release </label>
         <p><span class="fw-bold">Answer: </span>{{$item->requirement5}}</p>

         <label>Role/Functionality</label>
         <p><span class="fw-bold">Answer: </span>{{$item->requirement6}}</p>



       <label for="">last edited by: </label>
         <span class="badge text-bg-success text-black">{{$item->first_name}} {{$item->last_name}}</span>

            <br>

         <label for="">last edited at: </label>
         <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($item->last_edited_at))}}</span>


         @if(in_array('Data Inputter',$permissions))

         <a href="/v3_2_s4_4_4_delete/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
             class="float-end btn btn-danger btn-md mx-2">Delete</a>

         <a href="/v3_2_s4_4_4_edit/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
             class="float-end btn btn-primary btn-md mx-2">Edit</a>

         @endif




        </div>
      </div>





    @endforeach

    </div>


    @endif
       {{-- if isset $data --}}






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
