@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
@endphp



<div class="container">

<h3 class="text-center">Section 2.3 Edit Asset Id: {{$asset_id}} Control num: {{$control_num}}</h3>

{{-- <p>Asset value: {{$assetvalue}}</p> --}}

<div class="row d-flex justify-content-center">

    <div class="col-md-6">

        <div class="card mt-2">
            <div class="card-header bg-primary text-center">
                <h2>Information Security Risk Assessment And Treatment</h2>
              </div>
            <div class="card-body">

        <form action="/iso_sec_2_3_edit_table_submit/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="asset_id" value="{{$asset_id}}">
            <input type="hidden" name="control_num" value="{{$control_num}}">

            <div class="form-group">
                <label for="">Control Compliance %:</label>
                <input type="number" name="control_compliance" id="control_compliance" class="form-control"
                 value={{old('control_compliance',$data->control_compliance)}}>
                @if($errors->has('control_compliance'))
                <div class="text-danger">{{ $errors->first('control_compliance') }}</div>
            @endif
              </div>

              <div class="form-group mt-3">
                <label for="">Vulnerability %:</label>
                <input type="number" name="vulnerability" id="vulnerability" class="form-control"
                value="{{old('vulnerability',$data->vulnerability)}}" readonly>
              </div>

              <div class="form-group">
                <label for="">Threat %:</label>
                <input type="number" name="threat" id="threat" class="form-control" value="{{old('threat',$data->threat)}}">
                @if($errors->has('threat'))
                <div class="text-danger">{{ $errors->first('threat') }}</div>
            @endif
              </div>

              <div class="form-group mt-3">
                <label for=""> Risk Level</label>
                <input type="number" name="risk_level" id="risk_level" class="form-control"
                value="{{old('risk_level',$data->risk_level)}}" readonly>
              </div>

              <div class="form-group mt-4">
                <label for="">Residual Risk Treatment</label>
         <select name="residual_risk_treatment" class="form-control">
            <option value="">Select</option>
            <option value="retain and accept risk"

        {{old('residual_risk_treatment',$data->residual_risk_treatment)=='retain and accept risk'?'selected':''}}>
                Retain and Accept Risk</option>
            <option value="share risk"
            {{old('residual_risk_treatment',$data->residual_risk_treatment)=='share risk'?'selected':''}}
            >Share Risk</option>
            <option value="avoid risk"
            {{old('residual_risk_treatment',$data->residual_risk_treatment)=='avoid risk'?'selected':''}}
            >Avoid Risk</option>
            <option value="modify risk"
            {{old('residual_risk_treatment',$data->residual_risk_treatment)=='avoid risk'?'selected':''}}
            >Modify Risk</option>
         </select>
         @if($errors->has('residual_risk_treatment'))
         <div class="text-danger">{{ $errors->first('residual_risk_treatment') }}</div>
     @endif
              </div>


              <div class="form-group mt-4">
                <label for=""> Treatment Action</label>
                    <input type="text" name="treatment_action" value="{{old('treatment_action',$data->treatment_action)}}">
                    @if($errors->has('treatment_action'))
                    <div class="text-danger">{{ $errors->first('treatment_action') }}</div>
                @endif
              </div>

              <div class="form-group mt-4">
                <label for=""> Treatment Target Date</label>
                <input type="date" name="treatment_target_date" value="{{old('treatment_target_date',$data->treatment_target_date)}}">
                    @if($errors->has('treatment_target_date'))
                    <div class="text-danger">{{ $errors->first('treatment_target_date') }}</div>
                @endif
              </div>

              <div class="form-group mt-4">
                <label for=""> Responsbility for Treatment</label>
                <select class="boxstyling bg-primary form-select" name="responsibility_for_treatment">
                    <option value="">Select User</option>
                     @foreach ($users as $user)
     <option value="{{$user->id}}" {{ old('responsibility_for_treatment',$data->responsibility_for_treatment) == $user->id ? 'selected' : '' }}>
             {{$user->first_name}} {{$user->last_name}}</option>
                           @endforeach
                    </select>
                    @if($errors->has('responsibility_for_treatment'))
                    <div class="text-danger">{{ $errors->first('responsibility_for_treatment') }}</div>
                @endif
              </div>




              <div class="text-center">
                <button type="submit" class="btn btn-primary btn-md mt-2">Submit Details</button>
              </div>


        </form>

    </div>
</div>


    </div>
</div>





</div>

@section('scripts')

<script>
     $(document).ready(function(){
        //for vulnerabiity
        $("#control_compliance").on("input", function(){
            var controlComplianceValue = $(this).val();

            // Calculate the new value for vulnerability
            var newVulnerabilityValue = 100 - parseFloat(controlComplianceValue);

            // Update the value of the vulnerability input box
            $("#vulnerability").val(newVulnerabilityValue);

        });

//for risk level
$("#threat").on("input", function(){
            var threat = $(this).val();
            var vulnerability=$('#vulnerability').val();

            var asset_value={!!$assetvalue !!};

            var newRiskValue = parseFloat(vulnerability)/100 * parseFloat(threat)/100 * parseFloat(asset_value);;

            // Update the value of the vulnerability input box
            $("#risk_level").val(newRiskValue);

        });


    });

</script>


@endsection



@endsection
