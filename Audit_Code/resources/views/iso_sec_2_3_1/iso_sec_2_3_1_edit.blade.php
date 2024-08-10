@extends('master')

@section('content')

@include('user-nav')




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


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<div class="row justify-content-center">

    <div class="col-md-12">

        <div class="card mt-2">
            <div class="card-header my_bg_color text-white text-center">
                <h2>Edit Risk Assessment for Control: {{$assetData->control_num}}</h2>
              </div>
            <div class="card-body">

        <form action="/edit_risk_assessment/{{$project->project_id}}/{{auth()->user()->id}}/{{$assetData->asset_id}}/{{$assetData->control_num}}" method="post">
            @csrf
            @method('PUT')

            <div class="fw-bold mb-3">
                <label for="">Asset Value:
                    @if ($assetData->asset_value==10)
                    High
                    @endif

                    @if ($assetData->asset_value==5)
                    Medium
                    @endif

                    @if ($assetData->asset_value==1)
                    Low
                    @endif
                </label>

            </div>

            <div class="form-group">
                <label for="">Applicability</label>
                <select name="applicability" class="form-select">
                    <option value=""> Select--  </option>

                    <option value='yes' {{ old('applicability',$assetData->applicability) == "yes"? 'selected' : '' }}>Yes</option>

                    <option value='no' {{ old('applicability',$assetData->applicability) == "no"? 'selected' : '' }}>No</option>
                </select>


            </div>

            <div class="form-group mt-4">
                <label for="">Control Compliance %</label>
                <input type="number" name="control_compliance" oninput="validateInput(this)" class="form-control" min=0 max=100 data-control-id="{{$assetData->control_num}}" value="{{old('control_compliance',$assetData->control_compliance)}}">
            </div>

            <div class="form-group mt-4">
                <label for="">Description of Vulnerability</label>
                <br>
                <input class="form-check-input" type="radio" name="desc_vulnerability" value="Description of control is fully met"
                    {{ old('desc_vulnerability', $assetData->desc_vulnerability) == 'Description of control is fully met' ? 'checked' : '' }}>
                <label for="">Description of control is fully met</label><br>

                <input class="form-check-input" type="radio" name="desc_vulnerability" value="Description of control is partially met or not met"
                    {{ old('desc_vulnerability', $assetData->desc_vulnerability) == 'Description of control is partially met or not met' ? 'checked' : '' }}>
                <label for="">Description of control is partially met or not met</label><br>

                <input class="form-check-input" type="radio" name="desc_vulnerability" value="Other"
                    {{ old('desc_vulnerability', $assetData->desc_vulnerability) == 'Other' ? 'checked' : '' }}>
                <label for="">Other</label><br>

                <input type="text" name="desc_vulnerability_other" class="form-control"
                    value="{{ old('desc_vulnerability_other', $assetData->desc_vulnerability_other) }}">
            </div>

            <div class="form-group mt-4">
                <label for="">Vulnerability %</label>

                <input type="number" name="vulnerability" class="form-control" data-control-id="{{$assetData->control_num}}" readonly value="{{old('vulnerability',$assetData->vulnerability)}}">
            </div>


            <div class=" mt-4">
                <label for="">Description of Threat</label>
                <br>
                <input class="form-check-input" type="radio" name="desc_threat" value="Asset component is directly publicly exposed"
                {{ old('desc_threat', $assetData->desc_threat) == 'Asset component is directly publicly exposed' ? 'checked' : '' }}>
                <label for="">Asset component is directly publicly exposed</label>

                <br>



                <input class="form-check-input" type="radio" name="desc_threat" value="Asset component is NOT directly publicly exposed"
                    {{ old('desc_threat', $assetData->desc_threat) == 'Asset component is NOT directly publicly exposed ' ? 'checked' : '' }}>
                <label for="">Asset component is NOT directly publicly exposed</label>

                <br>



                <input class="form-check-input" type="radio" name="desc_threat" value="Other"
                    {{ old('desc_threat', $assetData->desc_threat) == 'Other' ? 'checked' : '' }}>
                <label for="">Other</label>

                <input type="text" name="desc_threat_other" class="form-control"
                    value="{{ old('desc_threat_other', $assetData->desc_threat_other) }}">
            </div>






            <div class="form-group mt-4">
                <label for="">Threat %</label>
                <input type="number" name="threat" class="form-control" min=0 max=100 data-control-id="{{$assetData->control_num}}" value="{{old('threat',$assetData->threat)}}">
            </div>

            <div class="form-group mt-4">
                <label for="">Risk Level</label>
                <input type="number" name="risk_level" class="form-control" data-control-id="{{$assetData->control_num}}" value="{{old('risk_level',$assetData->risk_level)}}" readonly>
            </div>


            <div class="form-group mt-4">
                <label for="">Types of Risk</label>
                <br>
                @php
                $descRisk = old('desc_risk', $assetData->desc_risk);
                $selectedRisks = is_string($descRisk) ? json_decode($descRisk, true) : $descRisk;
            @endphp

                <input type="checkbox" name="desc_risk[]" value="Breach of data confidentiality"
                    {{ is_array($selectedRisks) && in_array('Breach of data confidentiality', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Breach of data confidentiality</label><br>

                <input type="checkbox" name="desc_risk[]" value="Breach of data integrity"
                    {{ is_array($selectedRisks) && in_array('Breach of data integrity', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Breach of data integrity</label><br>

                <input type="checkbox" name="desc_risk[]" value="Denial of IT service or denial of data access to an authorized entity"
                    {{ is_array($selectedRisks) && in_array('Denial of IT service or denial of data access to an authorized entity', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Denial of IT service or denial of data access to an authorized entity</label><br>

                <input type="checkbox" name="desc_risk[]" value="Other"
                    {{ is_array($selectedRisks) && in_array('Other', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Other</label><br>

                <input type="text" name="desc_risk_other" class="form-control"
                    value="{{ old('desc_risk_other', $assetData->desc_risk_other) }}">
            </div>



              <div class="text-center mt-3 fw-bold">
                <button type="submit" class="btn my_bg_color btn-md mt-2 text-white">Save Changes </button>
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
        // Initialize values from the form's current state
        var assetValue = {{$assetData->asset_value}};
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

        // Event handlers
        $('#assetSelect').change(function(){
            assetValue = parseFloat($(this).val());
            updateRiskLevel();
        });

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
