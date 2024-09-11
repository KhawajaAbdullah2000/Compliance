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
            <td>Target Risk Level</td>
        </tr>

        <tr>
            <td class="fw-bold" >Control is Applicable?</td>
            <td>  {{$risk_assessment->applicability}}</td>
            <td>  {{$treatmentData->applicability}}</td>
        </tr>

        <tr>
            <td class="fw-bold" >Control Compliance</td>
            <td>  {{$risk_assessment->control_compliance}}%</td>
            <td>  {{$treatmentData->control_compliance}}%</td>
        </tr>

        <tr>
            <td class="fw-bold" >Vulnerability</td>
            <td>  {{$risk_assessment->vulnerability}}%</td>
            <td>  {{$treatmentData->vulnerability}}%</td>
        </tr>

        <tr>
            <td class="fw-bold" >Threat</td>
            <td>  {{$risk_assessment->threat}}%</td>
            <td>  {{$treatmentData->threat}}%</td>
        </tr>

        <tr>
            <td class="fw-bold" >Risk Level</td>
            <td>  {{$risk_assessment->risk_level}}</td>
            <td>  {{$treatmentData->risk_level}}</td>
        </tr>
        <tr>
            <td class="fw-bold" >Residual Risk Treatment</td>
            <td> - </td>
            <td>  {{$treatmentData->residual_risk_treatment}}</td>

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
                <h3>Treatment Action Plan</h3>
              </div>

            <div class="card-body">
     <form action="/iso_sec_2_3_2_treat_form_submit/{{$asset_id}}/{{$control_num}}/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="control_num" value="{{$control_num}}">


              <div class="form-group mt-4">
                <label for=""> Treatment Action</label>
                <textarea name="treatment_action" cols="70" rows="10" class="form-control">{{old('treatment_action',$treatmentData->treatment_action)}}</textarea>

                    @if($errors->has('treatment_action'))
                    <div class="text-danger">{{ $errors->first('treatment_action') }}</div>
                @endif
              </div>


              <div class="form-group mt-4">
                <label for=""> Treatment Target Date</label>
                <input type="date" name="treatment_target_date" value="{{old('treatment_target_date',$treatmentData->treatment_target_date)}}">
                    @if($errors->has('treatment_target_date'))
                    <div class="text-danger">{{ $errors->first('treatment_target_date') }}</div>
                @endif
              </div>

               <div class="form-group mt-4">
                <label for=""> Treatment Completion Date</label>
                <input type="date" name="treatment_comp_date" value="{{old('treatment_comp_date',$treatmentData->treatment_comp_date)}}">
                    @if($errors->has('treatment_comp_date'))
                    <div class="text-danger">{{ $errors->first('treatment_comp_date') }}</div>
                @endif
              </div>

              <div class="form-group mt-4">
                <label for=""> Actual Acceptane date</label>
                <input type="date" name="acceptance_actual_date" value="{{old('acceptance_actual_date',$treatmentData->acceptance_actual_date)}}">
                    @if($errors->has('acceptance_actual_date'))
                    <div class="text-danger">{{ $errors->first('acceptance_actual_date') }}</div>
                @endif
              </div>




               <div class="form-group mt-4">
                <label for=""> Responsbility for Treatment</label>
                <select class="boxstyling form-select" name="responsibility_for_treatment">
                    <option value="">Select User</option>
                     @foreach ($users as $user)
     <option value="{{$user->id}}" {{ old('responsibility_for_treatment',$treatmentData->responsibility_for_treatment) == $user->id ? 'selected' : '' }}>
             {{$user->first_name}} {{$user->last_name}}</option>
                           @endforeach
                    </select>
                    @if($errors->has('responsibility_for_treatment'))
                    <div class="text-danger">{{ $errors->first('responsibility_for_treatment') }}</div>
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

