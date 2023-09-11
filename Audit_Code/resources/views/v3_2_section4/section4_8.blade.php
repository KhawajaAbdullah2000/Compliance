@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section 4.8 Third-party payment applications/solutions</h2>

    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a class="nav-link" href="#home" aria-controls="home" role="tab" data-toggle="tab">Third Party</a></li>
        <li role="presentation"><a class="nav-link" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Assessor Info</a></li>
    </ul>


    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="home">

            @if(in_array('Data Inputter',$permissions))

            @if($data->count()==0)

            <div class="col-md-12">

                <div class="card-header bg-primary text-center">
                    <h2>Add new Third Party</h2>
                </div>

                    <div class="card-body">
                        <form method="post" action="/v3_2_s4_4_8_insert_party/{{$project_id}}/{{auth()->user()->id}}">
                            @csrf
                            <div class="form-group">
                              <label for="requirement1">Name of Third-Party Payment Application/Solution</label>
                              <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1')}}">
                              @if($errors->has('requirement1'))
                              <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                          @endif
                            </div>

                            <div class="form-group mt-2">
                                <label for="requirement2">Version of Product</label>
                                <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2')}}">

                                @if($errors->has('requirement2'))
                                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                            @endif
                              </div>

                              <div class="form-group mt-2">
                                <label for="requirement3">PA-DSS validated?</label>
                                <select class="boxstyling bg-primary rounded form-select" name="requirement3">
                                    <option value="">Select yes/no</option>
                                    <option value="yes" {{old('requirement3')=='yes'? 'selected':''}}>Yes</option>
                                    <option value="no" {{old('requirement3')=='no'? 'selected':''}}>No</option>
                                </select>

                                @if($errors->has('requirement3'))
                                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                            @endif
                              </div>



                              <div class="form-group mt-2">
                                <label for="requirement4">P2PE validated?</label>
                                <select class="boxstyling bg-primary rounded form-select" name="requirement4">
                                    <option value="">Select yes/no</option>
                                    <option value="yes" {{old('requirement4')=='yes'? 'selected':''}}>Yes</option>
                                    <option value="no" {{old('requirement4')=='no'? 'selected':''}}>No</option>
                                </select>

                                @if($errors->has('requirement4'))
                                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                            @endif
                              </div>


                              <div class="form-group mt-2">
                                <label for="requirement5">PCI SSC listing reference number</label>
                                <input type="text" class="form-control" id="requirement5" name='requirement5' value="{{old('requirement5')}}">

                                @if($errors->has('requirement5'))
                                <div class="text-danger">{{ $errors->first('requirement5') }}</div>
                            @endif
                              </div>


                              <div class="form-group mt-2 col-6">
                                <label for="requirement6">Expiry date of listing, if applicable</label>
                                <input type="date" class="form-control" name='requirement6' value="{{old('requirement6')}}">
                                @if($errors->has('requirement6'))
                                <div class="text-danger">{{ $errors->first('requirement6') }}</div>
                            @endif
                              </div>



                              <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                              </div>


                        </form>

                    </div>
                 </div>



            @endif
            {{-- if !issset $data --}}


            @endif
            {{-- if datainputter --}}

            @if($data->count()>0)

            <div class="row">

                <div class="col-md-12">

        @if(in_array('Data Inputter',$permissions))
        <a class="btn btn-success btn-md float-end mb-3 mt-2" href="/v3_2_s4_4_8_new_party/{{$project_id}}/{{auth()->user()->id}}"
        role="button">Add new Third Party <i class="fas fa-plus"></i></a>
        @endif
        </div>
        </div>

        <div class="row">
            @foreach ($data as $item)

            <div class="card mb-5">
                <div class="card-body">
                <label>Name of Third-Party Payment Application/Solution</label>
                 <p><span class="fw-bold">Answer: </span>{{$item->requirement1}}</p>

                 <label>Version of Product</label>
                 <p><span class="fw-bold">Answer: </span>{{$item->requirement2}}</p>

                 <label>PA-DSS validated? </label>
                 <p><span class="fw-bold">Answer: </span>{{$item->requirement3}}</p>

                 <label>P2PE validated?</label>
                 <p><span class="fw-bold">Answer: </span>{{$item->requirement4}}</p>

                 <label>PCI SSC listing reference number</label>
                 <p><span class="fw-bold">Answer: </span>{{$item->requirement5}}</p>

                 @isset($item->requirement6)
                 <label>Expiry date of listing</label>
                 <p><span class="fw-bold">Answer: </span>{{date('F d, Y', strtotime($item->requirement6))}}</p>
                 @endisset

               <label for="">last edited by: </label>
                 <span class="badge text-bg-success text-black">{{$item->first_name}} {{$item->last_name}}</span>

                    <br>

                 <label for="">last edited at: </label>
                 <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($item->last_edited_at))}}</span>


                 @if(in_array('Data Inputter',$permissions))

                 <a href="/v3_2_s4_4_8_party_delete/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
                     class="float-end btn btn-danger btn-md mx-2">Delete</a>

                 <a href="/v3_2_s4_4_8_party_edit/{{$item->assessment_id}}/{{$item->project_id}}/{{auth()->user()->id}}"
                     class="float-end btn btn-primary btn-md mx-2">Edit</a>

                 @endif




                </div>
              </div>





            @endforeach

            </div>





            @endif
            {{-- if isset $third party --}}

        </div>
        {{-- THird party tab --}}



        <div role="tabpanel" class="tab-pane" id="profile">

            @if(in_array('Data Inputter',$permissions))

            @if($data2->count()==0)

            <div class="col-md-12">


                <div class="card-header bg-primary text-center">
                    <h2>Assessor Info</h2>
                </div>

                    <div class="card-body">
                        <form method="post" action="/v3_2_s4_4_8_asses/{{$project_id}}/{{auth()->user()->id}}">
                            @csrf
                            <div class="form-group mt-2">
                              <label for="requirement1">Provide the name of the assessor who attests that all PA-DSS
                                validated payment applications were reviewed to verify they have been implemented in a PCI DSS compliant
                                manner according to the payment application vendor's PA-DSS Implementation Guide</label>
                              <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1')}}">
                              @if($errors->has('requirement1'))
                              <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                          @endif
                            </div>

                            <div class="form-group mt-2">
                                <label for="requirement2">Provide the name of the assessor who attests that all PCI
                                    SSC-validated P2PE applications and solutions were reviewed to verify they have been
                                    implemented in a PCI DSS compliant manner according to the P2PE application
                                    vendor's P2PE Application Implementation Guide and the P2PE solution vendor's
                                    P2PE Instruction Manual (PIM).</label>
                                <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2')}}">
                                @if($errors->has('requirement2'))
                                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
                            @endif
                              </div>

                              <div class="form-group mt-2">
                                <label for="requirement3">For any of the above Third-Party Payment Applications and/or
                                     solutions that are not listed on the PCI SSC website,
                                    identify any being considered for scope reduction/exclusion/etc. </label>
                                <input type="text" class="form-control" id="requirement3" name='requirement3' value="{{old('requirement3')}}">
                                @if($errors->has('requirement3'))
                                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
                            @endif
                              </div>

                              <div class="form-group mt-2">
                                <label for="requirement4">Any additional comments or findings the assessor would like to include,
                                    as applicable:</label>
                                <input type="text" class="form-control" id="requirement4" name='requirement4' value="{{old('requirement4')}}">
                                @if($errors->has('requirement4'))
                                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
                            @endif
                              </div>




                              <div class="text-center mt-2">
                                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                              </div>


                        </form>

                    </div>


                </div>

            @endif
            {{-- if !isset $assessor --}}



            @endif
            {{-- if datainputer --}}

            @if($data2->count()>0)

            <div class="row">
                @foreach ($data2 as $item2)

                <div class="card mb-5">
                    <div class="card-body">
                    <label>Name of the assessor who attests that all PA-DSS validated payment applications were reviewed to verify they have been implemented in a PCI DSS compliant manner according to the payment application vendor's PA-DSS Implementation Guide</label>
                     <p><span class="fw-bold">Answer: </span>{{$item2->requirement1}}</p>

                     <label>Name of the assessor who attests that all PCI SSC-validated P2PE applications and solutions were reviewed to verify they have been implemented in a PCI DSS compliant manner according to the P2PE application vendor's P2PE Application Implementation Guide and the P2PE solution vendor's P2PE Instruction Manual (PIM).</label>
                     <p><span class="fw-bold">Answer: </span>{{$item2->requirement2}}</p>

                     <label>For any of the above Third-Party Payment Applications and/or solutions that are not listed on the PCI SSC website, identify any being considered for scope reduction/exclusion/etc. </label>
                     <p><span class="fw-bold">Answer: </span>{{$item2->requirement3}}</p>

                     @isset($item2->requirement4)
                     <label>Any additional comments or findings the assessor would like to include, as applicable:</label>
                     <p><span class="fw-bold">Answer: </span>{{$item2->requirement4}}</p>

                     @endisset


                   <label for="">last edited by: </label>
                     <span class="badge text-bg-success text-black">{{$item2->first_name}} {{$item2->last_name}}</span>

                        <br>

                     <label for="">last edited at: </label>
                     <span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($item2->last_edited_at))}}</span>


                     @if(in_array('Data Inputter',$permissions))

                     <a href="/v3_2_s4_4_8_asses_delete/{{$item2->assessment_id}}/{{$item2->project_id}}/{{auth()->user()->id}}"
                         class="float-end btn btn-danger btn-md mx-2">Delete</a>

                     <a href="/v3_2_s4_4_8_asses_edit/{{$item2->assessment_id}}/{{$item2->project_id}}/{{auth()->user()->id}}"
                         class="float-end btn btn-primary btn-md mx-2">Edit</a>

                     @endif




                    </div>
                  </div>





                @endforeach

                </div>




            @endif


        </div>
        {{-- for assessor tab --}}

    </div>
    {{-- tab content --}}



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
            window.localStorage.setItem('activeTab_4_8', $(e.target).attr('href'));
        });
        var activeTab = window.localStorage.getItem('activeTab_4_8');
        if (activeTab) {
            $('#myTab a[href="' + activeTab + '"]').tab('show');
            window.localStorage.removeItem("activeTab_4_8");
        }
    });

    </script>



 @endsection



@endsection
