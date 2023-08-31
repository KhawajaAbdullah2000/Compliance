@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 3.6 Other business entities that require compliance with the PCI DSS</h2>

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a class="nav-link" href="#home" aria-controls="home" role="tab" data-toggle="tab">Wholly owned Entities</a></li>
        <li role="presentation"><a class="nav-link" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Entity countries</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">

            @if(in_array('Data Inputter',$permissions))
            @if($data1->count()==0)
            <div class="col-md-12">

                <div class="card-header bg-primary text-center">
                    <h2>Entity wholly owned by the assessed entity that are required to comply with PCI DSS</h2>
                </div>

                    <div class="card-body">
                        <form method="post" action="/v3_2_s3_3_6_insert/{{$project_id}}/{{auth()->user()->id}}">
                            @csrf
                            <div class="form-group">
                              <label for="wholly_owned_entity">Wholly Owned Entity Name</label>
                              <input type="text" class="form-control" id="wholly_owned_entity" name='wholly_owned_entity' value="{{old('wholly_owned_entity')}}">
                              @if($errors->has('wholly_owned_entity'))
                              <div class="text-danger">{{ $errors->first('wholly_owned_entity') }}</div>
                          @endif
                            </div>

                            <div class="form-group mt-2">
                                <label for="requirement1">Reviewed: As part of this assessment</label>
                                <textarea name="requirement1" id="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1')}}</textarea>
                                @if($errors->has('requirement1'))
                                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                            @endif
                              </div>

                              <div class="form-group mt-2">
                                <label for="requirement1">Reviewed: Seperately</label>
                                <textarea name="requirement2" id="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2')}}</textarea>
                                @if($errors->has('requirement2'))
                                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                            @endif
                              </div>


                              <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                              </div>


                        </form>

                    </div>
                 </div>

                @endif
                {{-- if !isset wholly owned entities --}}


            @endif
            {{-- if data inputter --}}

            @if ($data1->count()>0)
            <div class="card-header bg-primary text-center">
                <h2>Entities wholly owned by the assessed entity that are required to comply with PCI DSS</h2>
             </div>

             @if(in_array('Data Inputter',$permissions))
             <a class="btn btn-success btn-md float-end mb-5" href="/v3_2_s3_3_6_add_new/{{$project_id}}/{{auth()->user()->id}}"
             role="button">Add new wholly owned entity <i class="fas fa-plus"></i></a>
             @endif

             @foreach ($data1 as $wholly)

             <p class="lead mt-4">Wholly owned Entity Name</p>
           <p><span class="fw-bold">Answer: </span>{{$wholly->wholly_owned_entity}}</p>

           <p class="lead mt-4">Reviewed: As part of this assessment</p>
           <p><span class="fw-bold">Answer: </span>{{$wholly->requirement1}}</p>

           <p class="lead mt-4">Reviewed: Seperately</p>
           <p><span class="fw-bold">Answer: </span>{{$wholly->requirement2}}</p>

           <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$wholly->first_name}} {{$wholly->last_name}}</span>
        <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($wholly->last_edited_at))}}</span>

        @if(in_array('Data Inputter',$permissions))

        <a href="/v3_2_s3_3_6_delete_wholly/{{$wholly->assessment_id}}/{{$wholly->project_id}}/{{auth()->user()->id}}" class="btn btn-danger btn-lg float-end mx-2"> Delete </a>
        <a href="/v3_2_s3_3_6_edit_wholly/{{$wholly->assessment_id}}/{{$wholly->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-lg float-end"> Edit </a>
        @endif
        @endforeach



            @endif
            {{-- if isset $data1 --}}

            </div>
            {{-- whollyowned entity tab --}}


            {{-- Inernational entity --}}
            <div role="tabpanel" class="tab-pane" id="profile">
                @if(in_array('Data Inputter',$permissions))
                @if($data2->count()==0)
                <div class="col-md-12">


                <div class="card-header bg-primary text-center">
                    <h2>Add an International entity owned by the assessed entity that are required to comply with PCI DSS</h2>
                </div>

                    <div class="card-body">
                        <form method="post" action="/v3_2_s3_3_6_international/{{$project_id}}/{{auth()->user()->id}}">
                            @csrf
                            <div class="form-group">
                              <label for="entity_name">International Entity Name</label>
                              <input type="text" class="form-control" id="entity_name" name='entity_name' value="{{old('entity_name')}}">
                              @if($errors->has('entity_name'))
                              <div class="text-danger">{{ $errors->first('entity_name') }}</div>
                          @endif
                            </div>

                            <div class="form-group mt-2">
                                <label for="entity_country">Country</label>
                                <textarea name="entity_country" id="entity_country" cols="70" rows="10" class="form-control">{{old('entity_country')}}</textarea>
                                @if($errors->has('entity_country'))
                                <div class="text-danger">{{ $errors->first('entity_country') }}</div>
                            @endif
                              </div>

                              <div class="form-group mt-2">
                                <label for="requirement1">Facilities in this country reviewed: As part of this assessment</label>
                                <textarea name="requirement1" id="requirement1" cols="70" rows="10" class="form-control">{{old('requirement1')}}</textarea>
                                @if($errors->has('requirement1'))
                                <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                            @endif
                              </div>


                              <div class="form-group mt-2">
                                <label for="requirement2">Facilities in this country reviewed: Seperately</label>
                                <textarea name="requirement2" id="requirement2" cols="70" rows="10" class="form-control">{{old('requirement2')}}</textarea>
                                @if($errors->has('requirement2'))
                                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                            @endif
                              </div>


                              <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                              </div>


                        </form>

                    </div>


                </div>





                @endif
                {{-- if!isset $data2 --}}
                @endif
                {{-- if datainputter --}}


                @if($data2->count()>0)

                <div class="card-header bg-primary text-center">
                    <h2>International entities owned by the assessed entity that are required to comply with PCI DSS</h2>
                 </div>

                 @if(in_array('Data Inputter',$permissions))
                 <a class="btn btn-success btn-md float-end mb-5" href="/v3_2_s3_3_6_inter_new/{{$project_id}}/{{auth()->user()->id}}"
                 role="button">Add new International entity <i class="fas fa-plus"></i></a>
                 @endif

                 @foreach ($data2 as $inter)

                 <p class="lead mt-4">Internatial Entity Name</p>
               <p><span class="fw-bold">Answer: </span>{{$inter->entity_name}}</p>

               <p class="lead mt-4">Country</p>
               <p><span class="fw-bold">Answer: </span>{{$inter->entity_country}}</p>

               <p class="lead mt-4">Facilities in this country Reviewed: As part of this assessment</p>
               <p><span class="fw-bold">Answer: </span>{{$inter->requirement1}}</p>

               <p class="lead mt-4">Facilities in this country Reviewed: Seperately</p>
               <p><span class="fw-bold">Answer: </span>{{$inter->requirement2}}</p>

               <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$inter->first_name}} {{$inter->last_name}}</span>
            <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($inter->last_edited_at))}}</span>

            @if(in_array('Data Inputter',$permissions))

            <a href="/v3_2_s3_3_6_delete_inter/{{$inter->assessment_id}}/{{$inter->project_id}}/{{auth()->user()->id}}" class="btn btn-danger btn-lg float-end mx-2"> Delete </a>
            <a href="/v3_2_s3_3_6_edit_inter/{{$inter->assessment_id}}/{{$inter->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-lg float-end"> Edit </a>
            @endif
            @endforeach


            @endif

                {{-- if issset $data2 --}}


            </div>
            {{-- //Internation entity --}}



        </div>
        {{-- tabcontent --}}



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

<script>
    $(function() {
        $('a[data-toggle="tab"]').on('click', function(e) {
            window.localStorage.setItem('activeTab_3_6', $(e.target).attr('href'));
        });
        var activeTab = window.localStorage.getItem('activeTab_3_6');
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
            window.localStorage.removeItem("activeTab_3_6");
        }
    });

    </script>



 @endsection


@endsection
