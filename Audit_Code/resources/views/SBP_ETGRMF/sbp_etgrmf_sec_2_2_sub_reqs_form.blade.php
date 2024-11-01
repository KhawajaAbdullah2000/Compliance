@extends('master')

@section('content')

@include('user-nav')


@include('iso_sec_nav')
@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


    <h2 class="text-center fw-bold mt-4 mb-4">
    Req No. {{$filteredData[0][4]}}
         </h2>

        <p>{{$filteredData[0][5]}} </p>

        @if(in_array('Data Inputter',$permissions))

        @isset($result)

        <div class="row justify-content-center">

            <div class="col-md-6">

                <div class="card mt-2">
                    <div class="card-header my_bg_color text-white text-center">
                        <h2>View or Edit Status</h2>
                      </div>
                    <div class="card-body">

                <form action="/sbp_etgrmf_sec_2_2_edit_form/{{$sub_req}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for=""> Compliance Status</label>
                        <select class=" form-select" name="comp_status">


             <option value="yes" {{ old('comp_status',$result->comp_status) == 'yes' ? 'selected' : '' }}>Yes</option>
             <option value="no" {{ old('comp_status',$result->comp_status) == 'no' ? 'selected' : '' }}>No</option>
             <option value="partial" {{ old('comp_status',$result->comp_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                            </select>
                            @if($errors->has('comp_status'))
                            <div class="text-danger">{{ $errors->first('comp_status') }}</div>
                        @endif
                      </div>


                      <div class="form-group mt-4">
                        <label for="">Comments (Optional):</label>
                            <textarea name="comments" cols="70" rows="10" class="form-control">{{old('comments',$result->comments)}}</textarea>
                        @if($errors->has('comments'))
                        <div class="text-danger">{{ $errors->first('comments') }}</div>
                    @endif
                      </div>

                      <div class="form-group mt-4">
                        <label for="" class="mb-2">Attachment (Optional)</label>
                        <label class="btn btn-secondary">
                 <input type="file" name="attachment">
                        </label>


                      </div>

                      @isset($result->attachment)
                      <p>  Current Attachment:</p>
                      <a href="{{asset('sbp_etgrmf_sec_2_2/'.$result->attachment)}}" download>
                        {{$result->attachment}}
                      </a>

                      @endisset



                      <div class="text-center">
                        <button type="submit" class="btn my_bg_color text-white btn-md mt-2">Save</button>
                      </div>


                </form>

            </div>
        </div>


            </div>
        </div>


        @else


<div class="row">

    <div class="col-md-12">

        <div class="card mt-2">
            <div class="card-header my_bg_color text-white text-center">
                <h2>Mandatory Requirement</h2>
              </div>
            <div class="card-body">

        <form action="/sbp_etgrmf_sec_2_2_form/{{$sub_req}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for=""> Compliance Status</label>
                <select class="boxstyling form-select" name="comp_status">
                    <option value="">Select --</option>

     <option value="yes" {{ old('comp_status') == 'yes' ? 'selected' : '' }}>Yes</option>
     <option value="no" {{ old('comp_status') == 'no' ? 'selected' : '' }}>No</option>
     <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                    </select>
                    @if($errors->has('comp_status'))
                    <div class="text-danger">{{ $errors->first('comp_status') }}</div>
                @endif
              </div>


              <div class="form-group mt-4">
                <label for="">Comments (Optional):</label>
                    <textarea name="comments" cols="70" rows="10" class="form-control"></textarea>
                @if($errors->has('comments'))
                <div class="text-danger">{{ $errors->first('comments') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="" class="mb-2">Attachment (Optional)</label>

                <label class="btn btn-secondary">
         <input type="file" name="attachment">
                </label>


              </div>




              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-md mt-2">Submit Details</button>
              </div>


        </form>

    </div>
</div>


    </div>
</div>

        @endisset

@else

@isset($result)

<div class="row">

    <div class="card mb-5">

        <div class="card-body">

            <label>Compliance Status: </label>
            <p><span class="fw-bold">Answer: </span>{{$result->comp_status}}</p>


           <label>Comments: </label>
           @isset($result->comments)
       <p><span class="fw-bold">Answer: </span>{{$result->comments}}</p>
       @else
       <p></p>
       @endisset

       <label>Attachment:</label>
       @isset($result->attachment)
       <img src="{{asset('iso_sec_2_2/'.$result->attachment)}}" alt="Document attached" height="100" width="100">

       @else
       <p></p>
       @endisset

<br>
<br>
<label for="">last edited by: </label>
<span class="badge text-bg-success text-black">{{$result->first_name}} {{$result->last_name}}</span>

   <br>

<label for="">last edited at: </label>
<span class="badge text-bg-warning">{{date('F d, Y H:i:A', strtotime($result->last_edited_at))}}</span>





        </div>
    </div>
</div>


@endisset
        @endif
        {{-- if Datainputter --}}
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

@endsection


@endsection
