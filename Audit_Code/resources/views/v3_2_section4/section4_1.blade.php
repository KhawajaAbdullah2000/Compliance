@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp

<div class="container">
    <h2 class="text-center">
    Section 4.1 for Project id: {{$project_id}} Project name:{{$project_name}}
    </h2>

    @if(in_array('Data Inputter',$permissions))

    @if($data->count()==0)

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


    @endif
    {{-- if !issset $data --}}



    @endif
    {{-- if data inputter --}}


    @if($data->count()>0)

    <h2 class="text-center fw-bold">High-level network diagrams</h2>

    @if(in_array('Data Inputter',$permissions))
     <a class="btn btn-success btn-md float-end mt-3 mb-2" href="/v3_2_s4_4_1_new/{{$project_id}}/{{auth()->user()->id}}"
        role="button">Add another Diagram <i class="fas fa-plus"></i></a>
      </button>



      @endif


       <table class="table table-bordered table-hover table-responsive">
        <thead>
            <tr>
                <th>Network Diagram</th>
                <th>Uploaded by:</th>
                <th>Uploaded at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dia)

            <tr style="vertical-align: middle">
                <td><img src="{{asset('v3_2_s4_4_1/'.$dia->network_diagrams)}}" width="70px" height="50px"></td>
                <td>{{$dia->first_name}} {{$dia->last_name}}</td>
                <td>{{date('F d, Y H:i:A', strtotime($dia->last_edited_at))}}</td>
                @if(in_array('Data Inputter',$permissions))
                <td>
                    <form method="post" action="/v3_2_s4_4_1_del/{{$dia->assessment_id}}/{{$dia->project_id}}/{{auth()->user()->id}}">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-md">Delete</button>
                    </form>
                </td>
                @else
                <td>Not allowed</td>
                @endif
            </tr>
            @endforeach
        </tbody>
       </table>

    @endif
    {{-- if issset $data --}}

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


@endsection


@endsection
