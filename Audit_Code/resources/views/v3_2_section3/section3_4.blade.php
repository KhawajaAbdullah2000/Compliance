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
                @if($data1->count()==0)


                <div class="card-header bg-primary text-center">
                    <h2>Describe a network that store, process and/or transmit CHD:</h2>
                 </div>
                 <div class="card-body">
                    <form method="post" action="/v3_2_s1_clientinfo/{{$project_id}}/{{auth()->user()->id}}">
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

                          <div class="text-center mt-2">
                            <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                          </div>


                    </form>

                </div>




                @endif
                {{-- if data1-count==0 --}}


            </div>

            @endif
            {{-- //if Data inputter --}}


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
