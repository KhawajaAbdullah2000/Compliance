@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
$headers=array('Control num','Title of Control','Descriptionof Control')
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


    <table class="table table-responsive table-secondary table-striped mt-4">
        <thead class="thead-dark">
          <tr style="vertical-align: middle">
            <th>Service Name</th>
            <th >Asset Group Name</th>
            <th>Asset Name</th>
            <th>Asset Component Name</th>
            <th>Asset Owner Dept</th>
            <th>Asset Physical Location</th>
            <th>Asset Logical Location</th>

          </tr>

          <tr>
            <td>{{$assetData->s_name}}</td>
            <td>{{$assetData->g_name}}</td>
            <td>{{$assetData->name}}</td>
            <td>{{$assetData->c_name}}</td>
            <td>{{$assetData->owner_dept}}</td>
            <td>{{$assetData->physical_loc}}</td>
            <td>{{$assetData->logical_loc}}</td>
          </tr>

          </table>


                @foreach ($data[0] as $row)
                            @if(isset($row))
                                <p>
                                    <span class="fw-bold">{{$headers[$loop->index]}}: </span>
                                    {!! nl2br($row) !!}
                                </p>
                            @endif

                @endforeach








    <div class="col-md-12">



        <div class="card-header text-center">


         </div>
         <div class="card-body">
            <form method="post" action="/submit_edit_sec2_4_a5/{{$result->control_num}}/{{$asset_id}}/{{$project_id}}/{{auth()->user()->id}}">
                @csrf
                @method('PUT')


                @if($result->applicability=="no" )
                <div class="form-group mt-2">
                  <label for="network_name" class="fs-5">* Justification for Excluding this control for this asset component:</label>
                  <textarea name="justification" cols="70" rows="10" class="form-control">@if(isset($control_data)){{old('justification',$control_data->justification)}}@endif</textarea>
                  @if($errors->has('justification'))
                  <div class="text-danger">{{ $errors->first('justification') }}</div>
              @endif
                </div>
                @endif

                <div class="form-group mt-4 fs-5">
                    <label for="network_name">Notes:</label>
                    <textarea name="ref_of_risk" cols="70" rows="10" class="form-control">@if(isset($control_data)){{old('ref_of_risk',$control_data->ref_of_risk)}}@endif</textarea>
                    @if($errors->has('ref_of_risk'))
                    <div class="text-danger">{{ $errors->first('ref_of_risk') }}</div>
                @endif
                  </div>



                  <div class="text-center mt-3">
                    <button type="submit" class="btn my_bg_color text-white btn-md">Submit</a>
                  </div>


            </form>

        </div>




    </div>



</div>





@endsection
