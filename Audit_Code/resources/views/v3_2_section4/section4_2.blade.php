@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.2 Description of cardholder data flows</h2>
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a class="nav-link" href="#home" aria-controls="home" role="tab" data-toggle="tab">Cardholder Dataflows</a></li>
        <li role="presentation"><a class="nav-link" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Optional dataflow diagrams</a></li>
    </ul>

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="home">


            @if(in_array('Data Inputter',$permissions))

            @if($data1->count()==0)

            <div class="col-md-12">

                <div class="card-header bg-primary text-center">
                    <h2>Description of cardholder data flows</h2>
                </div>

                <div class="card-body">

                    <form method="post" action="/v3_2_s4_2_2_dataflows/{{$project_id}}/{{auth()->user()->id}}">
                        @csrf
                        <div class="form-group">
                          <label for="dataflows">Cardholder data flows</label>
                          <input type="text" class="form-control" id="dataflows" name='dataflows' value="{{old('dataflows')}}" placeholder="eg capture/authorization etc">
                          @if($errors->has('dataflows'))
                          <div class="text-danger">{{ $errors->first('dataflows') }}</div>
                      @endif
                        </div>

                        <div class="form-group mt-2">
                            <label for="types_of_chd">Types of CHD involved</label>
                            <input type="text" class="form-control" id="types_of_chd" name='types_of_chd' value="{{old('types_of_chd')}}" placeholder="eg full track/PAN etc">
                            @if($errors->has('types_of_chd'))
                            <div class="text-danger">{{ $errors->first('types_of_chd') }}</div>
                        @endif
                          </div>


                          <div class="form-group mt-4" id="description">
                            <label for="">Describe how cardholder data is transmitted and/or processed and for what purpose it
                                is used (for example, which protocols or technologies were used in each transmission)</label>
                        <textarea name="description" id="" cols="100" rows="10" clas="form-control">{{old('description')}}</textarea>
                            @if($errors->has('description'))
                            <div class="text-danger">{{ $errors->first('description') }}</div>
                        @endif
                          </div>

                          <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                          </div>


                    </form>


                </div>


            </div>






            @endif
            {{-- if !isset $data1 --}}

            @endif
            {{-- if Data inputter --}}


            @if($data1->count()>0)

            <h2 class="mt-3 fw-bold text-center">Description of cardholder data flows</h2>
            @if(in_array('Data Inputter',$permissions))
            <a class="btn btn-success btn-md float-end mb-5" href="/v3_2_s4_4_2_insert_dataflow/{{$project_id}}/{{auth()->user()->id}}"
            role="button">Add new cardholder dataflow <i class="fas fa-plus"></i></a>
            @endif

            @foreach ($data1 as $dataflow)

            <p class="lead mt-4">Cardholder data flows</p>
            <p><span class="fw-bold">Answer: </span>{{$dataflow->dataflows}}</p>

            <p class="lead mt-4">Types of CHD</p>
            <p><span class="fw-bold">Answer: </span>{{$dataflow->types_of_chd}}</p>


            <p class="lead mt-4">Describe how cardholder data is transmitted and/or processed and for what purpose it is
                 used (for example, which protocols or technologies were used in each transmission)</p>
            <p><span class="fw-bold">Answer: </span>{{$dataflow->description}}</p>

            @if(in_array('Data Inputter',$permissions))

            <a href="/v3_2_s4_4_2_delete_dataflow/{{$dataflow->assessment_id}}/{{$dataflow->project_id}}/{{auth()->user()->id}}"
                class="float-end btn btn-danger btn-md mx-2">Delete</a>

            <a href="/v3_2_s4_4_2_edit/{{$dataflow->assessment_id}}/{{$dataflow->project_id}}/{{auth()->user()->id}}"
                class="float-end btn btn-primary btn-md mx-2">Edit</a>

            @endif



            @endforeach


            @endif
            {{-- if issset$data1 --}}

        </div>
        {{-- dataflows tab --}}

        <div role="tabpanel" class="tab-pane" id="profile">


    @if(in_array('Data Inputter',$permissions))

            @if($data2->count()==0)

            <h2 class="text-center mt-2 fw-bold">
             Optional Dataflow Diagrams
                </h2>

                <form action="/v3_2_s4_4_2_insert_diagram/{{$project_id}}/{{auth()->user()->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                 <div class="row mt-4">

         <div class="col-md-6">
            <input type="file" name="data_flow_diagram" class="form-control">
            @if($errors->has('data_flow_diagram'))
            <div class="text-danger">{{ $errors->first('data_flow_diagram') }}</div>
        @endif
        </div>

        <div class="col-md-6">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>

                 </div>

                </form>



                @endif
                {{-- iff !issset $data2 --}}

                @endif
                {{-- if datainputter --}}


                @if($data2->count()>0)


    <h2 class="text-center fw-bold">Optional Dataflow diagrams</h2>

    @if(in_array('Data Inputter',$permissions))
     <a class="btn btn-success btn-md float-end mt-3 mb-2" href="/v3_2_s4_4_2_new_diagram/{{$project_id}}/{{auth()->user()->id}}"
        role="button">Add another dataflow Diagram <i class="fas fa-plus"></i></a>
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
            @foreach ($data2 as $dia)

            <tr style="vertical-align: middle">
                <td><img src="{{asset('v3_2_s4_4_2/'.$dia->data_flow_diagram)}}" width="70px" height="50px"></td>
                <td>{{$dia->first_name}} {{$dia->last_name}}</td>
                <td>{{date('F d, Y H:i:A', strtotime($dia->last_edited_at))}}</td>
                @if(in_array('Data Inputter',$permissions))
                <td>
                    <form method="post" action="/v3_2_s4_4_2_dia_del/{{$dia->assessment_id}}/{{$dia->project_id}}/{{auth()->user()->id}}">
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
                {{-- if issset $data2 --}}


        </div>
        {{-- //Diagrams tab--}}



    </div>
    {{-- tab-content div --}}



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
    $(function() {
        $('a[data-toggle="tab"]').on('click', function(e) {
            window.localStorage.setItem('activeTab_4_2', $(e.target).attr('href'));
        });
        var activeTab = window.localStorage.getItem('activeTab_4_2');
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
            window.localStorage.removeItem("activeTab_4_2");
        }
    });

    </script>

@endsection


@endsection
