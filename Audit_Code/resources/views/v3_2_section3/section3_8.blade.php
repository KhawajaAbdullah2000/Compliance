@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 3.8 Wireless Details</h2>

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a class="nav-link" href="#home" aria-controls="home" role="tab" data-toggle="tab">Wireless technology in scope</a></li>
        <li role="presentation"><a class="nav-link" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Wireless technology not in scope for this assessment</a></li>
    </ul>

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="home">

            @if(in_array('Data Inputter',$permissions))

            @if($data1->count()==0)


            <div class="col-md-12">


                <div class="card-header bg-primary text-center">
                    <h2>For a wireless technology in scope, identify the following:</h2>
                </div>

                    <div class="card-body">
                        <form method="post" action="/v3_2_s3_3_8_inscope/{{$project_id}}/{{auth()->user()->id}}">
                            @csrf
                            <div class="form-group">
                              <label for="wireless_technology">Identified wireless technology</label>
                              <input type="text" class="form-control" id="wireless_technology" name='wireless_technology' value="{{old('wireless_technology')}}">
                              @if($errors->has('wireless_technology'))
                              <div class="text-danger">{{ $errors->first('wireless_technology') }}</div>
                          @endif
                            </div>

                            <div class="form-group mt-2">
                                <label for="requirement1">Whether the technology is used to store, process or transmit CHD</label>
                                <div class="col-6">
                                    <select class="boxstyling bg-primary rounded form-select fw-bold" name="requirement1" id="requirement1">
                                    <option value="">Select yes/no</option>
                                    <option value="yes" {{old('requirement1')=='yes'? 'selected':''}}>Yes</option>
                                    <option value="no" {{old('requirement1')=='no'? 'selected':''}}>No</option>
                                </select>

                                @if($errors->has('requirement1'))
                                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                            @endif
                              </div>
                            </div>



                            <div class="form-group mt-2">
                                <label for="requirement2">Whether the technology is connected to or part of the CDE</label>
                                <div class="col-6">
                                    <select class="boxstyling bg-primary rounded form-select fw-bold" name="requirement2" id="requirement2">
                                    <option value="">Select yes/no</option>
                                    <option value="yes" {{old('requirement2')=='yes'? 'selected':''}}>Yes</option>
                                    <option value="no" {{old('requirement2')=='no'? 'selected':''}}>No</option>
                                </select>
                                @if($errors->has('requirement2'))
                                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                            @endif
                              </div>
                            </div>


                            <div class="form-group mt-2">
                                <label for="requirement3">Whether the technology could impact the security of the CDE</label>
                                <div class="col-6">
                                    <select class="boxstyling bg-primary rounded form-select fw-bold" name="requirement3" id="requirement3">
                                    <option value="">Select yes/no</option>
                                    <option value="yes" {{old('requirement3')=='yes'? 'selected':''}}>Yes</option>
                                    <option value="no" {{old('requirement3')=='no'? 'selected':''}}>No</option>
                                </select>
                                @if($errors->has('requirement3'))
                                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                            @endif
                              </div>
                            </div>



                              <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                              </div>


                        </form>

                    </div>
                 </div>



            @endif
            {{-- if !data1 --}}


            @endif
            {{-- if data inputter --}}


            @if($data1->count()>0)
            <h2 class="mt-3 fw-bold text-center">Wireless Details (In scope)</h2>

            @if(in_array('Data Inputter',$permissions))
            <a class="btn btn-success btn-md float-end mb-5" href="/v3_2_s3_3_8_inscope_new/{{$project_id}}/{{auth()->user()->id}}"
            role="button">Add new wireless technology in scope <i class="fas fa-plus"></i></a>
            @endif


        @foreach ($data1 as $wireless)

        <div class="container">


            <p class="lead">Identfied Wireless Technology</p>
            <p><span class="fw-bold">Answer: </span>{{$wireless->wireless_technology}}</p>


            <p class="lead mt-4">Whether the technology is used to store, process or transmit CHD</p>
            <p><span class="fw-bold">Answer: </span>{{$wireless->requirement1}}</p>

            <p class="lead mt-4">Whether the technology is connected to or part of the CDE</p>
            <p><span class="fw-bold">Answer: </span>{{$wireless->requirement2}}</p>

            <p class="lead mt-4">Whether the technology could impact the security of the CDE</p>
            <p><span class="fw-bold">Answer: </span>{{$wireless->requirement3}}</p>

            <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$wireless->first_name}} {{$wireless->last_name}}</span>
            <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($wireless->last_edited_at))}}</span>

            @if(in_array('Data Inputter',$permissions))

            <a href="/v3_2_s3_3_8_wireless_delete/{{$wireless->assessment_id}}/{{$wireless->project_id}}/{{auth()->user()->id}}"
                class="float-end btn btn-danger btn-lg mb-2 px-5">Delete</a>

            <a href="/v3_2_s3_3_8_wireless_edit/{{$wireless->assessment_id}}/{{$wireless->project_id}}/{{auth()->user()->id}}"
                class="float-end btn btn-primary btn-lg mb-2 px-5 mx-2">Edit</a>

            @endif


        </div>

        @endforeach


            @endif
            {{-- if isset $data1 --}}


        </div>
        {{-- in scope tab--}}


        <div role="tabpanel" class="tab-pane" id="profile">


            @if(in_array('Data Inputter',$permissions))

            @if($data2->count()==0)


            <div class="col-md-12">


                <div class="card-header bg-primary text-center">
                    <h2>Wireless technology not in scope, For this assessment</h2>
                </div>

                    <div class="card-body">
                        <form method="post" action="/v3_2_s3_3_8_outscope/{{$project_id}}/{{auth()->user()->id}}">
                            @csrf
                            <div class="form-group">
                              <label for="wireless_out_scope">Identified wireless technology(not in scope)</label>
                              <input type="text" class="form-control" id="wireless_out_scope" name='wireless_out_scope' value="{{old('wireless_out_scope')}}">
                              @if($errors->has('wireless_out_scope'))
                              <div class="text-danger">{{ $errors->first('wireless_out_scope') }}</div>
                          @endif
                            </div>


                            <div class="form-group mt-2" id="description">
                                <label for="">Describe how the wireless technology was validated by the assessor
                                    to be not in scope</label>
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
            {{-- if !data1 --}}


            @endif
            {{-- if data inputter --}}


            @if($data2->count()>0)
            <h2 class="mt-3 fw-bold text-center">Wireless Details (In scope)</h2>

            @if(in_array('Data Inputter',$permissions))
            <a class="btn btn-success btn-md float-end mb-5" href="/v3_2_s3_3_8_out_scope_new/{{$project_id}}/{{auth()->user()->id}}"
            role="button">Add new wireless technology not in scope <i class="fas fa-plus"></i></a>
            @endif

        <div class="container">

        @foreach ($data2 as $out)

            <p class="lead mt-4">Identfied Wireless Technology(not in scope)</p>
            <p><span class="fw-bold">Answer: </span>{{$out->wireless_out_scope}}</p>


            <p class="lead mt-4">Whether the technology is used to store, process or transmit CHD</p>
            <p><span class="fw-bold">Answer: </span>{{$out->description}}</p>


            <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$out->first_name}} {{$out->last_name}}</span>
            <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($out->last_edited_at))}}</span>

            @if(in_array('Data Inputter',$permissions))

            <a href="/v3_2_s3_3_8_wireless_out_delete/{{$out->assessment_id}}/{{$wireless->project_id}}/{{auth()->user()->id}}"
                class="float-end btn btn-danger btn-lg mb-2 px-5 my-2">Delete</a>

            <a href="/v3_2_s3_3_8_wireless_out_edit/{{$out->assessment_id}}/{{$wireless->project_id}}/{{auth()->user()->id}}"
                class="float-end btn btn-primary btn-lg mb-2 px-5 mx-2 my-2">Edit</a>

            @endif


        </div>

        @endforeach


            @endif
            {{-- if isset $data2 --}}



        </div>
        {{-- out of scope --}}



    </div>
    {{-- tab-content --}}


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
            window.localStorage.setItem('activeTab_3_8', $(e.target).attr('href'));
        });
        var activeTab = window.localStorage.getItem('activeTab_3_8');
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
            window.localStorage.removeItem("activeTab_3_8");
        }
    });

    </script>

@endsection

@endsection
