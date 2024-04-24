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

    <div class="col-md-6">

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
                <label for="">Vulnerability %</label>
                <input type="number" name="vulnerability" class="form-control" data-control-id="{{$assetData->control_num}}" readonly value="{{old('vulnerability',$assetData->vulnerability)}}">
            </div>

            <div class="form-group mt-4">
                <label for="">Threat %</label>
                <input type="number" name="threat" class="form-control" min=0 max=100 data-control-id="{{$assetData->control_num}}" value="{{old('threat',$assetData->threat)}}">
            </div>

            <div class="form-group mt-4">
                <label for="">Risk Level</label>
                <input type="number" name="risk_level" class="form-control" data-control-id="{{$assetData->control_num}}" value="{{old('risk_level',$assetData->risk_level)}}" readonly>
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
