@extends('master')

@section('content')

@include('user-nav')

<div class="container">


    <h1 class="text-center">Edit Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.4 Critical hardware and software in use in the cardholder data environment</h2>

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

            <form method="post" action="/v3_2_s4_4_4_editform/{{$data->assessment_id}}/{{$data->project_id}}/{{auth()->user()->id}}">
                @csrf
                @method('PUT')
                <div class="form-group">
                  <label for="requirement1">Type of Device</label>
                  <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1',$data->requirement1)}}">
                  @if($errors->has('requirement1'))
                  <div class="text-danger">{{ $errors->first('requirement1') }}</div>
              @endif
                </div>

                <div class="form-group mt-2">
                    <label for="requirement2">Vendor</label>
                    <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2',$data->requirement2)}}">
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                @endif
                  </div>


                  <div class="form-group mt-4" id="description">
                    <label for="requirement3">Make/Model</label>
                        <input type="text" class="form-control" id="requirement3" name='requirement3' value="{{old('requirement3',$data->requirement3)}}">

                    @if($errors->has('requirement3'))
                    <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-4" id="description">
                    <label for="requirement4">Name of Software Product</label>
                        <input type="text" class="form-control" id="requirement4" name='requirement4' value="{{old('requirement4',$data->requirement4)}}">

                    @if($errors->has('requirement4'))
                    <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                @endif
                  </div>



                  <div class="form-group mt-4" id="description">
                    <label for="requirement5">Version or release</label>
                        <input type="text" class="form-control" id="requirement5" name='requirement5' value="{{old('requirement5',$data->requirement5)}}">

                    @if($errors->has('requirement5'))
                    <div class="text-danger">{{ $errors->first('requirement5') }}</div>
                @endif
                  </div>



                  <div class="form-group mt-4" id="description">
                    <label for="requirement6">Role/Functionality</label>
                    <br>
                <textarea name="requirement6" id="" cols="100" rows="10" clas="form-control">{{old('requirement6',$data->requirement6)}}</textarea>
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



</div>



@endsection
