@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp

<div class="container">
    <h2 class="text-center">
        Section 2.2 for Project id: {{$project_id}} Project name:{{$project_name}}
        </h2>

        @if(in_array('Data Inputter',$permissions))
        @if($diagrams->count()==0)

        <p>
        Provide a <span class="fw-bold">high-level</span> network diagram (either obtained from the entity or created by assessor) of the
        entity's networking topography, showing the overall architecture of the environment being assessed. This high-level diagram should summarize
         all locations and key systems, and the boundaries between them and should include the following:</p>
         <ul>
            <li>Connections into and out of the network including
                demarcation points between the cardholder data environment (CDE) and other networks/zones</li>
            <li>Critical components within the cardholder data environment,
                 including POS devices, systems, databases, and web servers, as applicable </li>
                <li>
                Other necessary payment components, as applicable
                </li>
         </ul>

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



        @endif
        {{-- if !issset $diagrams --}}



        @endif
        {{-- if data inputter --}}

        @if ($diagrams->count()>0)

       <h2 class="text-center fw-bold">High-level network diagrams</h2>

    @if(in_array('Data Inputter',$permissions))
     <a class="btn btn-success btn-md float-end mt-3 mb-2" href="/v3_2_s2_2_2_add_diagram/{{$project_id}}/{{auth()->user()->id}}"
        role="button">Add another Diagram <i class="fas fa-plus"></i></a>
      </button>



      @endif


       <table class="table table-bordered table-hover table-responsive">
        <thead>
            <tr>
                <th>Diagram</th>
                <th>Uploaded by:</th>
                <th>Uploaded at</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($diagrams as $dia)

            <tr style="vertical-align: middle">
                <td><img src="{{asset('v3_2_s2_2_2/'.$dia->diagram)}}" width="70px" height="50px"></td>
                <td>{{$dia->first_name}} {{$dia->last_name}}</td>
                <td>{{date('F d, Y H:i:A', strtotime($dia->last_edited_at))}}</td>
                @if(in_array('Data Inputter',$permissions))
                <td>
                    <form method="post" action="/v3_2_s2_2_2_delete/{{$dia->assessment_id}}/{{$dia->project_id}}/{{auth()->user()->id}}">
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
        {{-- if issset $diagram --}}


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
