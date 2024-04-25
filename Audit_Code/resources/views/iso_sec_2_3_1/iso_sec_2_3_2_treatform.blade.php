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


<table style="width: 50%;" class="table table-bordered">
    <tbody>
        <tr>
            <td class="fw-bold" >Service Name:</td>
            <td>  {{$assetData->s_name}}</td>
        </tr>

        @isset($assetData->g_name)
        <tr>
        <td class="fw-bold">Asset Group Name:</td>
        <td>  {{$assetData->g_name}}</td>
         </tr>
        @endisset



        <tr>
        @isset($assetData->name)
        <td class="fw-bold">Asset Name:</td>
        <td>  {{$assetData->name}}</td>
        </tr>
        @endisset


        @isset($assetData->c_name)
        <tr>
        <td class="fw-bold">Asset Component Name:</td>
        <td>  {{$assetData->c_name}}</td>
         </tr>
        @endisset

        <tr>
            <td class="fw-bold">Asset Value:</td>
            <td>
                @if($assetvalue==10)
                High
                @elseif($assetvalue==5)
                Medium
                @elseif($assetvalue==1)
                Low
                @endif
            </td>

        </tr>



    </tbody>
</table>

</div>

</div>

<h4 class="mt-4 mb-4 fw-bold">Current Information Security Risk Assessment</h4>

<div class="row">

<div class="col-lg-6">

<table style="width: 50%;" class="table table-bordered table-primary">
    <tbody>
        <tr>
            <td class="fw-bold" >Control Number</td>
            <td>  {{$treatmentData->control_num}}</td>
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

        <tr>
            <td class="fw-bold" >Asset Value</td>
            <td>
@if($treatmentData->asset_value==10)
High
@endif

@if($treatmentData->asset_value==5)
Medium
@endif

@if($treatmentData->asset_value==1)
Low
@endif


            </td>
        </tr>


    </tbody>
</table>


<h4 class="fw-bold">Target Information Security Risk After Proposed Risk Treatment</h4>
<table style="width: 50%;" class="table table-bordered table-secondary">
    <tbody>
        <tr>
            <td class="fw-bold" >Control Number</td>
            <td>  {{$after_risk_treatment->control_num}}</td>
        </tr>
        <tr>
            <td class="fw-bold" >Control is Applicable?</td>
            <td>  {{$after_risk_treatment->applicability}}</td>
        </tr>

        <tr>
            <td class="fw-bold" >Control Compliance</td>
            <td>  {{$after_risk_treatment->control_compliance}}%</td>
        </tr>

        <tr>
            <td class="fw-bold" >Vulnerability</td>
            <td>  {{$after_risk_treatment->vulnerability}}%</td>
        </tr>

        <tr>
            <td class="fw-bold" >Threat</td>
            <td>  {{$after_risk_treatment->threat}}%</td>
        </tr>

        <tr>
            <td class="fw-bold" >Risk Level</td>
            <td>  {{$after_risk_treatment->risk_level}}</td>
        </tr>

        <tr>
            <td class="fw-bold" >Asset Value</td>
            <td>
@if($after_risk_treatment->asset_value==10)
High
@endif

@if($after_risk_treatment->asset_value==5)
Medium
@endif

@if($after_risk_treatment->asset_value==1)
Low
@endif



            </td>
        </tr>




    </tbody>
</table>


</div>
</div>



{{-- <p>Asset value: {{$assetvalue}}</p> --}}


<div class="row">




    <div class="col-md-6">

        <div class="card mt-2">

        {{-- @if ($errors->any())
        <div >
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

            <div class="card-header my_bg_color text-white text-center">
                <h3>View or Edit</h3>
              </div>

            <div class="card-body">
        {{-- <form action="/iso_sec_2_3_2_treat_form_submit/{{$asset_id}}/{{$control_num}}/{{$project_id}}/{{auth()->user()->id}}" method="post"> --}}
     <form action="/iso_sec_2_3_2_treat_form1_submit/{{$asset_id}}/{{$control_num}}/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="control_num" value="{{$control_num}}">


              <div class="form-group mt-4">
                <label for="">Residual Risk Treatment</label>
         <select name="residual_risk_treatment" class="form-control" id="residual_risk_treatment">
            <option value="">Select</option>
            <option value="retain and accept risk" {{old('residual_risk_treatment',$after_risk_treatment->residual_risk_treatment)=='retain and accept risk'?'selected':''}}>Retain and Accept Risk</option>
            <option value="share risk" {{old('residual_risk_treatment',$after_risk_treatment->residual_risk_treatment)=='share risk'?'selected':''}}>
                Share Risk</option>
            <option value="avoid risk" {{old('residual_risk_treatment',$after_risk_treatment->residual_risk_treatment)=='avoid risk'?'selected':''}}>Avoid Risk</option>
            <option value="modify risk"  {{old('residual_risk_treatment',$after_risk_treatment->residual_risk_treatment)=='modify risk'?'selected':''}}>Modify Risk</option>
         </select>
         @if($errors->has('residual_risk_treatment'))
         <div class="text-danger">{{ $errors->first('residual_risk_treatment') }}</div>
     @endif
              </div>

{{--
        <div class="form-group mt-4" id="additional-fields" style="{{ $after_risk_treatment->residual_risk_treatment === 'modify risk'|| $after_risk_treatment->residual_risk_treatment==="avoid risk" || $after_risk_treatment->residual_risk_treatment==="share risk" ? 'display: block;' : 'display: none;' }}"> --}}
            <div class="form-group mt-4" id="additional-fields" style="{{ in_array($after_risk_treatment->residual_risk_treatment, ['modify risk', 'avoid risk', 'share risk']) ? 'display: block;' : 'display: none;' }}">

             <label for="">Applicability</label>
             <select name="applicability" class="form-select">
                <option value='yes' {{ old('applicability',$after_risk_treatment->applicability) == "yes"? 'selected' : '' }}>Yes</option>
                <option value='no' {{ old('applicability',$after_risk_treatment->applicability) == "no"? 'selected' : '' }}>No</option>
            </select>

            <label for="">Control Compliance</label>
            <input type="number" name="control_compliance" oninput="validateInput(this)" class="form-control" min=0 max=100 data-control-id="{{$after_risk_treatment->control_num}}" value="{{old('control_compliance',$after_risk_treatment->control_compliance)}}">

            <label for="">Vulnerability</label>
            <input type="number" name="vulnerability" class="form-control" data-control-id="{{$after_risk_treatment->control_num}}" readonly value="{{old('vulnerability',$after_risk_treatment->vulnerability)}}">

            <label for="">Threat</label>
            <input type="number" name="threat" class="form-control" min=0 max=100 data-control-id="{{$after_risk_treatment->control_num}}" value="{{old('threat',$after_risk_treatment->threat)}}">

            <label for="">Risk Level</label>
            <input type="number" name="risk_level" class="form-control" data-control-id="{{$after_risk_treatment->control_num}}" value="{{old('risk_level',$after_risk_treatment->risk_level)}}" readonly>


              </div>

              <div class="form-group mt-4" id="additional-fields2"
              style="{{$after_risk_treatment->residual_risk_treatment=="retain and accept risk" ? 'display: block;' : 'display: none;' }}">

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






            </div>




{{--

              <div class="form-group mt-4">
                <label for=""> Treatment Action</label>
                <textarea name="treatment_action" cols="70" rows="10" class="form-control">{{old('treatment_action',$treatmentData->treatment_action)}}</textarea>

                    @if($errors->has('treatment_action'))
                    <div class="text-danger">{{ $errors->first('treatment_action') }}</div>
                @endif
              </div> --}}
{{--
              <div class="form-group mt-4">
                <label for=""> Treatment Target Date</label>
                <input type="date" name="treatment_target_date" value="{{old('treatment_target_date',$treatmentData->treatment_target_date)}}">
                    @if($errors->has('treatment_target_date'))
                    <div class="text-danger">{{ $errors->first('treatment_target_date') }}</div>
                @endif
              </div> --}}

              {{-- <div class="form-group mt-4">
                <label for=""> Treatment Completion Date</label>
                <input type="date" name="treatment_comp_date" value="{{old('treatment_comp_date',




              {{-- <div class="form-group mt-4">
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
              </div> --}}



              <div class="text-center">
                <button type="submit" class="btn my_bg_color text-white btn-md mt-3">Save Changes</button>
              </div>


        </form>

    </div>
</div>


    </div>
    <div class="col-md-6">
        @if($after_risk_treatment->applicability=="yes")
<a href="/risk_treatment_edit_action_plan_form/{{$asset_id}}/{{$control_num}}/{{$project_id}}/{{auth()->user()->id}}" class="btn my_bg_color text-white fw-bold">Create or edit Action plan</a>
@endif

      </div>
</div>





</div>

@section('scripts')

<script>
    $(document).ready(function() {
        $('#residual_risk_treatment').change(function() {
            if ($(this).val() == 'modify risk' ||$(this).val() == 'avoid risk' ||$(this).val() == 'share risk' ) {
                $('#additional-fields').show();
            } else {
                $('#additional-fields').hide();
            }
        });

        // Set the correct display state based on the dropdown's initial value
        if ($('#residual_risk_treatment').val() == 'modify risk' ||$('#residual_risk_treatment').val() == 'avoid risk' ||$('#residual_risk_treatment').val()== 'share risk' ) {
            $('#additional-fields').show();
        } else {
            $('#additional-fields').hide();
        }
        $('#residual_risk_treatment').change(function() {
            if ($(this).val() == 'retain and accept risk' ) {
                $('#additional-fields2').show();
            } else {
                $('#additional-fields2').hide();
            }
        });

        // Set the correct display state based on the dropdown's initial value
        if ($('#residual_risk_treatment').val() == 'retain and accept risk'  ) {
            $('#additional-fields2').show();
        } else {
            $('#additional-fields2').hide();
        }
    });



</script>

<script>
    $(document).ready(function(){
        // Initialize values from the form's current state
        var assetValue = {{ $assetvalue }};

        var vulnerabilityValue = parseFloat($('input[name="vulnerability"]').val()) || null;
        var threatValue = parseFloat($('input[name="threat"]').val()) || null;

        // Update function to calculate the risk level
        function updateRiskLevel() {

            if (!isNaN(assetValue) && !isNaN(vulnerabilityValue) && !isNaN(threatValue)) {
                var riskLevel = (vulnerabilityValue / 100) * (threatValue / 100) * assetValue;
                $('input[name="risk_level"]').val(riskLevel.toFixed(4));
            } else {
                $('input[name="risk_level"]').val('');  // Clear the field if any values are not ready
            }
        }



        $('input[name="control_compliance"]').on("input", function () {
            vulnerabilityValue = 100 - parseFloat($(this).val());
            $('input[name="vulnerability"]').val(vulnerabilityValue);
            updateRiskLevel();
        });

        $('input[name="threat"]').on("input", function () {
            threatValue = parseFloat($(this).val());
            updateRiskLevel();
        });

        // Initial call to set everything up with current values
        updateRiskLevel();
    });
</script>

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
     function validateInput(inputElement) {

       if (inputElement.value.indexOf(".") !== -1) {
         alert("Decimal values are not allowed.");
         inputElement.value = Math.floor(inputElement.value);
       }
     }
   </script>

@endsection



@endsection

