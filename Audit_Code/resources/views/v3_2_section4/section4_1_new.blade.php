@extends('master')

@section('content')

@include('user-nav')


<div class="container">

    <h2 class="text-center">
        Section 4.1 for Project id: {{$project_id}} Project name:{{$project_name}}
        </h2>

        <form action="/v3_2_s4_4_1_insert/{{$project_id}}/{{auth()->user()->id}}" method="post" enctype="multipart/form-data">
            @csrf
         <div class="row">

            <p>
                Provide one or more detailed diagrams to illustrate each communication/connection
                 point between in scope networks/environments/facilities. Diagrams should include the following:
                 <ul>
                    <li>
                        All boundaries of the cardholder data environment
                    </li>
                    <li>Any network segmentation points which are used to reduce scope of the assessment </li>

                    <li>Boundaries between trusted and untrusted networks</li>

                    <li>Wireless and wired networks</li>

                    <li>All other connection points applicable to the assessment  </li>


                 </ul>
            </p>

             <div class="col-md-6">
                 <input type="file" name="network_diagrams" class="form-control">
                 @if($errors->has('network_diagrams'))
                 <div class="text-danger">{{ $errors->first('network_diagrams') }}</div>
             @endif
             </div>

             <div class="col-md-6">
                 <button type="submit" class="btn btn-primary">Upload</button>
             </div>

         </div>
         </form>


</div>


@endsection
