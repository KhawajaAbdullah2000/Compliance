@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    @php
    $permissions=json_decode($project_permissions)
    @endphp

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 3.4 Network Segment details</h2>

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a class="nav-link" href="#home" aria-controls="home" role="tab" data-toggle="tab">Type1</a></li>
        <li role="presentation"><a class="nav-link" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Type 2</a></li>
        <li role="presentation"><a class="nav-link" href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Type 3</a></li>


    </ul>

    <div class="tab-content">

        {{-- type1 --}}
        <div role="tabpanel" class="tab-pane active" id="home">


            @if(in_array('Data Inputter',$permissions))

            <div class="col-md-12">
                @if($dataone->count()==0)


                <div class="card-header bg-primary text-center">
                    <h2>Describe a network that store, process and/or transmit CHD:</h2>
                 </div>
                 <div class="card-body">
                    <form method="post" action="/v3_2_s3_3_4_insert/{{$project_id}}/{{auth()->user()->id}}">
                        @csrf
                        <div class="form-group">
                          <label for="network_name">Network name:</label>
                          <input type="text" class="form-control" id="network_name" name='network_name' value="{{old('network_name')}}">
                          @if($errors->has('network_name'))
                          <div class="text-danger">{{ $errors->first('network_name') }}</div>
                      @endif
                        </div>

                        <div class="form-group">
                            <label for="purpose_of_network">Purpose of network:</label>
                            <textarea name="purpose_of_network" id="purpose_of_network" cols="70" rows="10" class="form-control">{{old('purpose_of_network')}}</textarea>
                            @if($errors->has('purpose_of_network'))
                            <div class="text-danger">{{ $errors->first('purpose_of_network') }}</div>
                        @endif
                          </div>

                          <input type="hidden" name="network_type" value="1">

                          <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                          </div>


                    </form>

                </div>




                @endif
                {{-- if dataone-count==0 --}}


            </div>

            @endif
            {{-- //if Data inputter --}}

            @if ($dataone->count()>0)

            <div class="card-header bg-primary text-center">
                <h2>Networks that store, process and/or transmit CHD</h2>
             </div>

            <a class="btn btn-success btn-md float-end mb-5" href="/v3_2_s3_3_4_new/1/{{$project_id}}/{{auth()->user()->id}}"
            role="button">Add new Network <i class="fas fa-plus"></i></a>

            @foreach ($dataone as $data1)

             <p class="lead mt-4">Network Name</p>
           <p><span class="fw-bold">Answer: </span>{{$data1->network_name}}</p>

           <p class="lead mt-4">Purpose of Network</p>
           <p><span class="fw-bold">Answer: </span>{{$data1->purpose_of_network}}</p>

           <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$data1->first_name}} {{$data1->last_name}}</span>
        <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($data1->last_edited_at))}}</span>

        @if(in_array('Data Inputter',$permissions))

        <a href="/v3_2_s3_3_4_delete/{{$data1->assessment_id}}/{{$data1->project_id}}/{{auth()->user()->id}}" class="btn btn-danger btn-lg float-end mx-2"> Delete </a>
        <a href="/v3_2_s3_3_4_edit/{{$data1->assessment_id}}/{{$data1->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-lg float-end"> Edit </a>
        @endif
        @endforeach




            @endif
            {{-- if isset $dataone --}}


        </div>


        <div role="tabpanel" class="tab-pane" id="profile">


            @if(in_array('Data Inputter',$permissions))

            <div class="col-md-12">
                @if($datatwo->count()==0)


                <div class="card-header bg-primary text-center">
                    <h2>Describe all networks that do not store, process and/or transmit CHD, but are still
                        in scope (e.g., connected to the CDE or provide management functions to the CDE)</h2>
                 </div>
                 <div class="card-body">
                    <form method="post" action="/v3_2_s3_3_4_insert/{{$project_id}}/{{auth()->user()->id}}">
                        @csrf
                        <div class="form-group">
                          <label for="network_name">Network name:</label>
                          <input type="text" class="form-control" id="network_name" name='network_name' value="{{old('network_name')}}">
                          @if($errors->has('network_name'))
                          <div class="text-danger">{{ $errors->first('network_name') }}</div>
                      @endif
                        </div>

                        <div class="form-group">
                            <label for="purpose_of_network">Purpose of network:</label>
                            <textarea name="purpose_of_network" id="purpose_of_network" cols="70" rows="10" class="form-control">{{old('purpose_of_network')}}</textarea>
                            @if($errors->has('purpose_of_network'))
                            <div class="text-danger">{{ $errors->first('purpose_of_network') }}</div>
                        @endif
                          </div>

                          <input type="hidden" name="network_type" value="2">

                          <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                          </div>


                    </form>

                </div>




                @endif
                {{-- if datatwo->count==0 --}}


            </div>

            @endif
            {{-- //if Data inputter --}}

            @if ($datatwo->count()>0)

            <div class="card-header bg-primary text-center">
                <h2>Networks that do not store, process and/or transmit CHD, but are still
                     in scope (e.g., connected to the CDE or provide management functions to the CDE)</h2>
             </div>


            <a class="btn btn-success btn-md float-end mb-5" href="/v3_2_s3_3_4_new/2/{{$project_id}}/{{auth()->user()->id}}"
            role="button">Add new Network <i class="fas fa-plus"></i></a>

            @foreach ($datatwo as $data2)

             <p class="lead mt-4">Network Name</p>
           <p><span class="fw-bold">Answer: </span>{{$data2->network_name}}</p>

           <p class="lead mt-4">Purpose of Network</p>
           <p><span class="fw-bold">Answer: </span>{{$data2->purpose_of_network}}</p>

           <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$data2->first_name}} {{$data2->last_name}}</span>
        <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($data2->last_edited_at))}}</span>

        @if(in_array('Data Inputter',$permissions))
        <a href="/v3_2_s3_3_4_delete/{{$data2->assessment_id}}/{{$data2->project_id}}/{{auth()->user()->id}}" class="btn btn-danger btn-lg float-end mx-2"> Delete </a>

        <a href="/v3_2_s3_3_4_edit/{{$data2->assessment_id}}/{{$data2->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-lg float-end"> Edit </a>
        @endif
        @endforeach




            @endif
            {{-- if isset $dataone --}}



        </div>

        <div role="tabpanel" class="tab-pane" id="messages">


            @if(in_array('Data Inputter',$permissions))

            <div class="col-md-12">
                @if($datathree->count()==0)


                <div class="card-header bg-primary text-center">
                    <h2>Describe any networks confirmed to be out of scope</h2>
                 </div>
                 <div class="card-body">
                    <form method="post" action="/v3_2_s3_3_4_insert/{{$project_id}}/{{auth()->user()->id}}">
                        @csrf
                        <div class="form-group">
                          <label for="network_name">Network name:</label>
                          <input type="text" class="form-control" id="network_name" name='network_name' value="{{old('network_name')}}">
                          @if($errors->has('network_name'))
                          <div class="text-danger">{{ $errors->first('network_name') }}</div>
                      @endif
                        </div>

                        <div class="form-group">
                            <label for="purpose_of_network">Purpose of network:</label>
                            <textarea name="purpose_of_network" id="purpose_of_network" cols="70" rows="10" class="form-control">{{old('purpose_of_network')}}</textarea>
                            @if($errors->has('purpose_of_network'))
                            <div class="text-danger">{{ $errors->first('purpose_of_network') }}</div>
                        @endif
                          </div>

                          <input type="hidden" name="network_type" value="3">

                          <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                          </div>


                    </form>

                </div>




                @endif
                {{-- if datathree->count==0 --}}


            </div>

            @endif
            {{-- //if Data inputter --}}

            @if ($datathree->count()>0)

            <div class="card-header bg-primary text-center">
                <h2>Networks confirmed to be out of scope:</h2>
             </div>


            <a class="btn btn-success btn-md float-end mb-5" href="/v3_2_s3_3_4_new/3/{{$project_id}}/{{auth()->user()->id}}"
            role="button">Add new Network<i class="fas fa-plus"></i></a>

            @foreach ($datathree as $data3)

             <p class="lead mt-4">Network Name</p>
           <p><span class="fw-bold">Answer: </span>{{$data3->network_name}}</p>

           <p class="lead mt-4">Purpose of Network</p>
           <p><span class="fw-bold">Answer: </span>{{$data3->purpose_of_network}}</p>

           <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$data3->first_name}} {{$data3->last_name}}</span>
        <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($data3->last_edited_at))}}</span>

        @if(in_array('Data Inputter',$permissions))

        <a href="/v3_2_s3_3_4_delete/{{$data3->assessment_id}}/{{$data3->project_id}}/{{auth()->user()->id}}" class="btn btn-danger btn-lg float-end mx-2"> Delete </a>

        <a href="/v3_2_s3_3_4_edit/{{$data3->assessment_id}}/{{$data3->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-lg float-end"> Edit </a>
        @endif
        @endforeach




            @endif
            {{-- if isset $data3 --}}


        </div>


    </div>


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
        window.localStorage.setItem('activeTab_3_4', $(e.target).attr('href'));
    });
    var activeTab = window.localStorage.getItem('activeTab_3_4');
    if (activeTab) {
        $('#myTab a[href="' + activeTab + '"]').tab('show');
        window.localStorage.removeItem("activeTab_3_4");
    }
});

// let table = new DataTable('#myTable',
//     {
//     language: {
//        searchPlaceholder: "search"
//     },
//       "ordering": false

//      }
//      );

</script>

 @endsection


@endsection
