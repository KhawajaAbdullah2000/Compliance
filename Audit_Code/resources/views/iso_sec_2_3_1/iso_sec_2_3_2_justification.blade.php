@extends('master')

@section('content')

@include('user-nav')

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




<div class="row">

    <div class="col-lg-6">


        <table class="table table-bordered table-warning">
            <thead>
                <tr>
                    <th>Service Name</th>
                    <th>Asset Group Name</th>
                    <th>Asset Name</th>
                    <th>Asset Component Name</th>
                    <th>Asset Component Value</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$assetData->s_name}}</td>
                    <td>@isset($assetData->g_name){{$assetData->g_name}}@endisset</td>
                    <td>@isset($assetData->name){{$assetData->name}}@endisset</td>
                    <td>@isset($assetData->c_name){{$assetData->c_name}}@endisset</td>
                    <td>
                        @if($assetvalue == 10)
                        High
                        @elseif($assetvalue == 5)
                        Medium
                        @elseif($assetvalue == 1)
                        Low
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>

</div>




</div>




<div class="row">

<div class="col-lg-6">

<table style="width: 50%;" class="table table-bordered table-secondary">
    <tbody>
        <tr>
            <td></td>
            <td>Current Risk Assessment</td>
        </tr>
        <tr>
            <td class="fw-bold" >Control is Applicable?</td>
            <td>  {{$treatmentData->applicability}}</td>
        </tr>

        <tr>
            <td class="fw-bold" >Control Compliance</td>
            <td>  {{$treatmentData->control_compliance}}%</td>
        </tr>

        <tr>
            <td class="fw-bold" >Vulnerability</td>
            <td>  {{$treatmentData->vulnerability}}%</td>
        </tr>

        <tr>
            <td class="fw-bold" >Threat</td>
            <td>  {{$treatmentData->threat}}%</td>
        </tr>

        <tr>
            <td class="fw-bold" >Risk Level</td>
            <td>  {{$treatmentData->risk_level}}</td>
        </tr>




    </tbody>
</table>

</div>
</div>



{{-- <p>Asset value: {{$assetvalue}}</p> --}}



<div class="row d-flex">

    <div class="col-md-6">

        <div class="card mt-2">
            <div class="card-header my_bg_color text-white text-center">
                <h3>Justification For Risk Acceptance</h3>
              </div>

            <div class="card-body">
     <form action="/iso_sec_2_3_2_justification_form_submit/{{$asset_id}}/{{$control_num}}/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="control_num" value="{{$control_num}}">

            <label for="">Justification for Risk Acceptance</label>
            <input type="text" name="acceptance_justification" class="form-control"  value="{{old('acceptance_justification',$after_risk_treatment->acceptance_justification)}}">
            @if($errors->has('acceptance_justification'))
            <div class="text-danger">{{ $errors->first('acceptance_justification') }}</div>
        @endif


            <div class="form-group mt-4">
             <label for=""> Acceptance Target Date</label>
                <input type="date" name="acceptance_target_date" value="{{old('acceptance_target_date',$after_risk_treatment->acceptance_target_date)}}">
                    @if($errors->has('acceptance_target_date'))
                    <div class="text-danger">{{ $errors->first('acceptance_target_date') }}</div>
                @endif
            </div>

            <div class="form-group mt-4">
                <label for="">Actual Acceptance Date</label>
                   <input type="date" name="acceptance_actual_date" value="{{old('acceptance_actual_date',$after_risk_treatment->acceptance_actual_date)}}">
                       @if($errors->has('acceptance_actual_date'))
                       <div class="text-danger">{{ $errors->first('acceptance_actual_date') }}</div>
                   @endif
               </div>


               <div class="form-group mt-4">
                <label for=""> Proposed Responsibility for Acceptance</label>
                <select class="boxstyling form-select" name="acceptance_proposed_responsibility">
                    <option value="">Select User</option>
                     @foreach ($users as $user)
     <option value="{{$user->id}}" {{ old('acceptance_proposed_responsibility',$after_risk_treatment->acceptance_proposed_responsibility) == $user->id ? 'selected' : '' }}>
             {{$user->first_name}} {{$user->last_name}}</option>
                           @endforeach
                    </select>
                    @if($errors->has('acceptance_proposed_responsibility'))
                    <div class="text-danger">{{ $errors->first('acceptance_proposed_responsibility') }}</div>
                @endif
              </div>

              <div class="form-group mt-4">
                <label for=""> Accepted By</label>
                <select class="boxstyling form-select" name="accepted_by">
                    <option value="">Select User</option>
                     @foreach ($users as $user)
     <option value="{{$user->id}}" {{ old('accepted_by',$after_risk_treatment->accepted_by) == $user->id ? 'selected' : '' }}>
             {{$user->first_name}} {{$user->last_name}}</option>
                           @endforeach
                    </select>
                    @if($errors->has('accepted_by'))
                    <div class="text-danger">{{ $errors->first('accepted_by') }}</div>
                @endif
              </div>








              <div class="text-center">
                <button type="submit" class="btn my_bg_color text-white btn-md mt-3">Save Changes</button>
              </div>


        </form>

    </div>
</div>


    </div>
</div>





</div>



@endsection

