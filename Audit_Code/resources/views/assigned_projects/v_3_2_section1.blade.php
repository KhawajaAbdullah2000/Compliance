@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    @php
    $permissions=json_decode($project_permissions)
    @endphp

    <h1 class="text-center">Project: {{$project_name}}</h1>
    <h2 class="text-center fw-bold">Section1</h2>


    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a class="nav-link" href="#home" aria-controls="home" role="tab" data-toggle="tab">Client info</a></li>
        <li role="presentation"><a class="nav-link" href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Assessor Company</a></li>
        <li role="presentation"><a class="nav-link" href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Assessors</a></li>
        <li role="presentation"><a class="nav-link" href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Associate QSAs</a></li>
        <li role="presentation"><a class="nav-link" href="#qa" aria-controls="qa" role="tab" data-toggle="tab">Assessor Quality Assurance (QA) </a></li>

    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">
          @if(in_array('Data Inputter',$permissions))
          <div class="col-md-12">

            @if(!isset($clientinfo))

            <div class="card">
              <div class="card-header bg-primary text-center">
                <h1>Add client info</h1>
             </div>

             <div class="card-body">
              <form method="post" action="/v3_2_s1_clientinfo/{{$project_id}}/{{auth()->user()->id}}">
                  @csrf
                  <div class="form-group">
                    <label for="name">Company name:</label>
                    <input type="text" class="form-control" id="" name='company_name' value="{{old('company_name')}}">
                    @if($errors->has('company_name'))
                    <div class="text-danger">{{ $errors->first('company_name') }}</div>
                @endif
                  </div>

                  <div class="form-group">
                      <label for="name">Company Address:</label>
                      <input type="text" class="form-control" id="" name='company_address' value="{{old('company_address')}}">
                      @if($errors->has('company_address'))
                      <div class="text-danger">{{ $errors->first('company_address') }}</div>
                  @endif
                    </div>

                    <div class="form-group">
                      <label for="name">Company URL:</label>
                      <input type="text" class="form-control" id="" name='company_url' value="{{old('company_url')}}">
                      @if($errors->has('company_url'))
                      <div class="text-danger">{{ $errors->first('company_url') }}</div>
                  @endif
                    </div>

                    <div class="form-group">
                      <label for="name">Company Contact Name:</label>
                      <input type="text" class="form-control" id="" name='company_contact_name' value="{{old('company_contact_name')}}">
                      @if($errors->has('company_contact_name'))
                      <div class="text-danger">{{ $errors->first('company_contact_name') }}</div>
                  @endif
                    </div>

                    <div class="form-group">
                      <label for="">Company Contact Number:</label>
                      <input type="text" class="form-control" name="company_number" value="{{old('company_number')}}">
                      @if($errors->has('company_number'))
                      <div class="text-danger">{{ $errors->first('company_number') }}</div>
                  @endif
                    </div>

                    <div class="form-group">
                      <label for="name">Company Email:</label>
                      <input type="text" class="form-control" id="" name='company_email' value="{{old('company_email')}}">
                      @if($errors->has('company_email'))
                      <div class="text-danger">{{ $errors->first('company_email') }}</div>
                  @endif
                    </div>

                    <div class="text-center mt-2">
                      <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                    </div>


              </form>

          </div>

            </div>

            @endif
            {{-- for !isset clientinfo --}}

          </div>



          @endif
          {{-- for data inputter --}}

          @if(isset($clientinfo))
          <h1 class="text-center mt-2">Client Info</h1>
          <table class="table table-responsive table-hover mt-4">
            <thead>
                <tr>
                    <th>Project_id</th>
                    <th>Company name</th>
                    <th>Company Address</th>
                    <th>Company URL</th>
                    <th>Company Contact name</th>
                    <th>Company Contact number</th>
                    <th>Company Email</th>
                    <th>Last edited by</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>

              <tr>
              <td>{{$clientinfo->project_id}}</td>
              <td>{{$clientinfo->company_name}}</td>
              <td>{{$clientinfo->company_address}}</td>
              <td>{{$clientinfo->company_url}}</td>
              <td>{{$clientinfo->company_contact_name}}</td>
              <td>{{$clientinfo->company_contact_number}}</td>
              <td>{{$clientinfo->company_email}}</td>
              <td>{{$clientinfo->first_name}} {{$clientinfo->last_name}}</td>
              @if(in_array('Data Inputter',$permissions))
                <td><a href="/edit_3_2_s1_clientinfo/{{$project_id}}/{{auth()->user()->id}}" class='btn btn-warning btn-sm'>Edit details</a></td>
                @else
                <td>Not allowed</td>
              @endif


              </tr>

            </tbody>

        </table>

          @endif
          {{-- if isset clientinfo --}}



        </div>

        <div role="tabpanel" class="tab-pane" id="profile">

          @if(in_array('Data Inputter',$permissions))
          <div class="col-md-12">

            @if(!isset($assessorCompany))

            <div class="card">
              <div class="card-header bg-primary text-center">
                <h1>Add Assessor Company info</h1>
             </div>

             <div class="card-body">
              <form method="post" action="/v3_2_s1_assessorcompany/{{$project_id}}/{{auth()->user()->id}}">
                  @csrf
                  <div class="form-group">
                    <label for="name">Company name:</label>
                    <input type="text" class="form-control" id="" name='comp_name' value="{{old('comp_name')}}">
                    @if($errors->has('comp_name'))
                    <div class="text-danger">{{ $errors->first('comp_name') }}</div>
                @endif
                  </div>

                  <div class="form-group">
                      <label for="name">Company Address:</label>
                      <input type="text" class="form-control" id="" name='comp_address' value="{{old('comp_address')}}">
                      @if($errors->has('comp_address'))
                      <div class="text-danger">{{ $errors->first('comp_address') }}</div>
                  @endif
                    </div>

                    <div class="form-group">
                      <label for="name">Company URL:</label>
                      <input type="text" class="form-control" id="" name='comp_website' value="{{old('comp_website')}}">
                      @if($errors->has('comp_website'))
                      <div class="text-danger">{{ $errors->first('comp_website') }}</div>
                  @endif
                    </div>


                    <div class="text-center mt-2">
                      <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                    </div>


              </form>

          </div>

            </div>

            @endif
            {{-- for !isset assessor company --}}

          </div>



          @endif
          {{-- for data inputter --}}

          @if(isset($assessorCompany))
          <h1 class="text-center mt-2">Assessor Company</h1>
          <table class="table table-responsive table-hover mt-4">
            <thead>
                <tr>
                    <th>Project_id</th>
                    <th>Company name</th>
                    <th>Company Address</th>
                    <th>Company Website</th>
                    <th>Last edited by</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <tbody>

              <tr>
              <td>{{$assessorCompany->project_id}}</td>
              <td>{{$assessorCompany->comp_name}}</td>
              <td>{{$assessorCompany->comp_address}}</td>
              <td>{{$assessorCompany->comp_website}}</td>
              <td>{{$assessorCompany->first_name}} {{$assessorCompany->last_name}}</td>
              @if(in_array('Data Inputter',$permissions))
                <td><a href="/edit_v_3_2_s1_assessorcomp/{{$project_id}}/{{auth()->user()->id}}" class='btn btn-warning btn-sm'>Edit details</a></td>
                @else
                <td>Not allowed</td>
              @endif


              </tr>

            </tbody>

        </table>

          @endif
          {{-- if isset clientinfo --}}



        </div>


{{--
        Assessors --}}
        <div role="tabpanel" class="tab-pane" id="messages">


            @if(in_array('Data Inputter',$permissions))
            <div class="col-md-12">

              @if($assessors->count()==0)

              <div class="card">
                <div class="card-header bg-primary text-center">
                  <h1>Add First Assessor details</h1>
               </div>

               <div class="card-body">
                <form method="post" action="/v_3_2_s1_assessors/{{$project_id}}/{{auth()->user()->id}}">
                    @csrf
                    <div class="form-group">
                      <label for="name">Assessor name:</label>
                      <input type="text" class="form-control" id="" name='assessor_name' value="{{old('assessor_name')}}">
                      @if($errors->has('assessor_name'))
                      <div class="text-danger">{{ $errors->first('assessor_name') }}</div>
                  @endif
                    </div>

                    <div class="form-group">
                        <label for="name">Assessor PCI Credentials:</label>
                        <input type="text" class="form-control" id="" name='assessor_pci_cred' value="{{old('assessor_pci_cred')}}">
                        @if($errors->has('assessor_pci_cred'))
                        <div class="text-danger">{{ $errors->first('assessor_pci_cred') }}</div>
                    @endif
                      </div>

                      <div class="form-group">
                        <label for="name">Assessor Phone:</label>
                        <input type="text" class="form-control" id="" name='assessor_phone' value="{{old('assessor_phone')}}">
                        @if($errors->has('assessor_phone'))
                        <div class="text-danger">{{ $errors->first('assessor_phone') }}</div>
                    @endif
                      </div>

                      <div class="form-group">
                        <label for="name">Assessor Email:</label>
                        <input type="text" class="form-control" id="" name='assessor_email' value="{{old('assessor_email')}}">
                        @if($errors->has('assessor_email'))
                        <div class="text-danger">{{ $errors->first('assessor_email') }}</div>
                    @endif
                      </div>


                      <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                      </div>


                </form>

            </div>

              </div>

              @endif
              {{-- for !isset assessor --}}

            </div>



            @endif
            {{-- for data inputter --}}

            @if($assessors->count()>0)
            <h1 class="text-center mt-2">Assessors</h1>
            @if(in_array('Data Inputter',$permissions))
            <a class="btn btn-success btn-md float-end mt-3" href="/v3_2_s1_add_new_assessor/{{$project_id}}/{{auth()->user()->id}}"
            role="button">Add new Assessor <i class="fas fa-plus"></i></a>
            @endif
            <table class="table table-responsive table-hover mt-4">
              <thead>
                  <tr>

                      <th>Assessor Name</th>
                      <th>Assessor PCI Credentials</th>
                      <th>Assessor Phone</th>
                      <th>Assessor Email</th>
                      <th>Last edited by</th>
                      <th>Actions</th>

                  </tr>
              </thead>
              <tbody>
  @foreach ($assessors as $ass)

                <tr>
                <td>{{$ass->assessor_name}}</td>
                <td>{{$ass->assessor_pci_cred}}</td>
                <td>{{$ass->assessor_phone}}</td>
                <td>{{$ass->assessor_email}}</td>
                <td>{{$ass->first_name}} {{$ass->last_name}}</td>

                @if(in_array('Data Inputter',$permissions))
                  <td><a href="/edit_v3_2_s1_assesssor/{{$ass->assessment_id}}/{{auth()->user()->id}}/{{$project_id}}"
                    class='btn btn-warning btn-sm'>Edit details</a>

                 <a href="/v3_2_s1_delete_assessor/{{$ass->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}"
                    class="btn btn-danger btn-md">Delete</a>
                </td>
                  @else
                  <td>Not allowed</td>
                @endif

                </tr>

  @endforeach

              </tbody>

          </table>

            @endif
            {{-- if isset assessor --}}



        </div>





{{-- Associate QSAS --}}
        <div role="tabpanel" class="tab-pane" id="settings">

            @if(in_array('Data Inputter',$permissions))
            <div class="col-md-12">

              @if($associate_qsas->count()==0)

              <div class="card">
                <div class="card-header bg-primary text-center">
                  <h1>Add First Associate Qsas details</h1>
               </div>

               <div class="card-body">
                <form method="post" action="/v3_2_s1_associate_qsa/{{$project_id}}/{{auth()->user()->id}}">
                    @csrf
                    <div class="form-group">
                      <label for="name">Associate QSA name:</label>
                      <input type="text" class="form-control" id="" name='qsa_name' value="{{old('qsa_name')}}">
                      @if($errors->has('qsa_name'))
                      <div class="text-danger">{{ $errors->first('qsa_name') }}</div>
                  @endif
                    </div>

                      <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                      </div>


                </form>

            </div>

              </div>

              @endif
              {{-- for !isset associate qsa --}}

            </div>



            @endif
            {{-- for data inputter --}}

            @if($associate_qsas->count()>0)
            <h1 class="text-center mt-2">Associate QSAs</h1>
            @if(in_array('Data Inputter',$permissions))
            <a class="btn btn-success btn-md float-end mt-3" href="/v3_2_s1_newassociate_qsa/{{$project_id}}/{{auth()->user()->id}}"
            role="button">Add new Associate QSA<i class="fas fa-plus"></i></a>
            @endif
            <table class="table table-responsive table-hover mt-4">
              <thead>
                  <tr>

                      <th>Assessor QSA name</th>
                      <th>Last edited by</th>
                      <th>Actions</th>

                  </tr>
              </thead>
              <tbody>
  @foreach ($associate_qsas as $ass_qsa)

                <tr>
                <td>{{$ass_qsa->qsa_name}}</td>
                <td>{{$ass_qsa->first_name}} {{$ass_qsa->last_name}}</td>

                @if(in_array('Data Inputter',$permissions))
                  <td><a href="/v3_2_s1_associateqsa_edit/{{$ass_qsa->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}"
                    class='btn btn-warning btn-sm'>Edit details</a>

                 <a href="/v3_2_s1_delete_associate_qsa/{{$ass_qsa->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}"
                    class="btn btn-danger btn-md">Delete</a>
                </td>
                  @else
                  <td>Not allowed</td>
                @endif

                </tr>

  @endforeach

              </tbody>

          </table>

            @endif
            {{-- if isset assessor --}}


        </div>


        {{-- QAS --}}
        <div role="tabpanel" class="tab-pane" id="qa">


            @if(in_array('Data Inputter',$permissions))
            <div class="col-md-12">

              @if($qas->count()==0)

              <div class="card">
                <div class="card-header bg-primary text-center">
                  <h2 class="fw-bold">Add First Assessor Quality Assurance (QA) details</h2>
               </div>

               <div class="card-body">
                <form method="post" action="/v3_2_s1_qa_insert/{{$project_id}}/{{auth()->user()->id}}">
                    @csrf
                    <div class="form-group">
                      <label for="name"> QA name:</label>
                      <input type="text" class="form-control" id="" name='reviewer_name' value="{{old('reviewer_name')}}">
                      @if($errors->has('reviewer_name'))
                      <div class="text-danger">{{ $errors->first('reviewer_name') }}</div>
                  @endif
                    </div>

                    <div class="form-group">
                        <label for="name">QA Email:</label>
                        <input type="text" class="form-control" id="" name='reviewer_email' value="{{old('reviewer_email')}}">
                        @if($errors->has('reviewer_email'))
                        <div class="text-danger">{{ $errors->first('reviewer_email') }}</div>
                    @endif
                      </div>

                      <div class="form-group">
                        <label for="name">QA Phone:</label>
                        <input type="text" class="form-control" id="" name='reviewer_phone' value="{{old('reviewer_phone')}}">
                        @if($errors->has('reviewer_phone'))
                        <div class="text-danger">{{ $errors->first('reviewer_phone') }}</div>
                    @endif
                      </div>

                      <div class="text-center mt-2">
                        <button type="submit" class="btn btn-primary btn-md">Submit details</a>
                      </div>


                </form>

            </div>

              </div>

              @endif
              {{-- for !isset QA --}}

            </div>



            @endif
            {{-- for data inputter --}}

            @if($qas->count()>0)
            <h1 class="text-center mt-2">Assessor Quality Assurance (QA)</h1>
            @if(in_array('Data Inputter',$permissions))
            <a class="btn btn-success btn-md float-end mt-3" href="/v3_2_s1_add_new_qa/{{$project_id}}/{{auth()->user()->id}}"
            role="button">Add new QA<i class="fas fa-plus"></i></a>
            @endif
            <table class="table table-responsive table-hover mt-4">
              <thead>
                  <tr>

                      <th> QA name</th>
                      <th> QA email</th>
                      <th> QA phone</th>
                      <th>Last edited by</th>
                      <th>Actions</th>

                  </tr>
              </thead>
              <tbody>
  @foreach ($qas as $qa)

                <tr>
                <td>{{$qa->reviewer_name}}</td>
                <td>{{$qa->reviewer_email}}</td>
                <td>{{$qa->reviewer_phone}}</td>
                <td>{{$qa->first_name}} {{$qa->last_name}}</td>

                @if(in_array('Data Inputter',$permissions))
                  <td><a href="/v3_2_edit_qa/{{$qa->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}"
                    class='btn btn-warning btn-sm'>Edit details</a>

                 <a href="/v3_2_s1_delete_qa/{{$qa->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}"
                    class="btn btn-danger btn-sm">Delete</a>
                </td>
                  @else
                  <td>Not allowed</td>
                @endif

                </tr>

  @endforeach

              </tbody>

          </table>

            @endif
            {{-- if isset assessor --}}







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
        window.localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = window.localStorage.getItem('activeTab');
    if (activeTab) {
        $('#myTab a[href="' + activeTab + '"]').tab('show');
        window.localStorage.removeItem("activeTab");
    }
});

let table = new DataTable('#myTable',
    {
    language: {
       searchPlaceholder: "search"
    },
      "ordering": false

     }
     );

</script>

 @endsection


@endsection
