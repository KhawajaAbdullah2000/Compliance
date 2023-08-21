@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <h2 class="text-center">
        Edit Section 1.4 for Project id: {{$project_id}} Project name:{{$project_name}}
        </h2>
    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Additional services provided by QSA company</h2>
                  </div>
                <div class="card-body">



            <form action="/v3_2_s1_1_4_services_edit_form/{{$services->assessment_id}}/{{$services->project_id}}/{{auth()->user()->id}}"
                method="post">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="date">Disclose all services offered to the assessed entity by the QSAC,
                        including but not limited to whether the assessed entity uses any security-related devices
                        or security-related applications that have been developed or manufactured by the QSA,
                        or to which the QSA owns the rights or that the QSA has configured or manages:</label>
                        <textarea name="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1',$services->requirement1)}}</textarea>
                    @if($errors->has('requirement1'))
                    <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                @endif
                  </div>

                  <div class="form-group mt-2">
                    <label for="date">Describe efforts made to ensure no conflict of interest resulted
                        from the above mentioned services provided by the QSAC:</label>
                        <textarea name="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2',$services->requirement2)}}</textarea>
                    @if($errors->has('requirement2'))
                    <div class="text-danger">{{ $errors->first('requirement2') }}</div>
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

</div>



@endsection
