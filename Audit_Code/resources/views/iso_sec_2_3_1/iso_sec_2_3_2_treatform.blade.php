@extends('master')

@section('content')

@include('user-nav')

@php
$permissions = json_decode($project_permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td><a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}">{{$project->project_name}}</a></td>
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

    <table class="table table-bordered table-warning" style="width:50%;">
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


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-12">
                    <form action="/iso_sec_2_3_2_treat_form1_submit/{{$asset_id}}/{{$control_num}}/{{$project_id}}/{{auth()->user()->id}}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <div class="form-group mt-4">

                                <div class="d-flex justify-content-end align-items-center">
                                    <label for="residual_risk_treatment" class="fs-5 mr-3">Residual Risk Treatment</label>
                                    <select name="residual_risk_treatment" class="boxstyling2 mr-2" id="residual_risk_treatment">
                                        <option value="modify risk" {{old('residual_risk_treatment',$after_risk_treatment->residual_risk_treatment) == 'modify risk' ? 'selected' : ''}}>Modify Risk</option>
                                        <option value="retain and accept risk" {{old('residual_risk_treatment',$after_risk_treatment->residual_risk_treatment) == 'retain and accept risk' ? 'selected' : ''}}>Retain and Accept Risk</option>
                                        <option value="share risk" {{old('residual_risk_treatment',$after_risk_treatment->residual_risk_treatment) == 'share risk' ? 'selected' : ''}}>Share Risk</option>
                                        <option value="avoid risk" {{old('residual_risk_treatment',$after_risk_treatment->residual_risk_treatment) == 'avoid risk' ? 'selected' : ''}}>Avoid Risk</option>
                                    </select>
                                    <button type="submit" class="btn fs-6 mr-lg-2 my_bg_color fw-bold text-white btn-sm">Save Changes and go to Action Plan</button>

                                    @if($after_risk_treatment->residual_risk_treatment == "retain and accept risk")
                                    <a href="/risk_treatment_justification/{{$asset_id}}/{{$control_num}}/{{$project_id}}/{{auth()->user()->id}}" class="btn my_bg_color text-white fw-bold ml-lg-2">Create Justification</a>
                                    @endif
                                </div>

                                @if($errors->has('residual_risk_treatment'))
                                <div class="text-danger">{{ $errors->first('residual_risk_treatment') }}</div>
                                @endif
                            </div>

                            {{-- <div class="mb-4">
                                <button type="submit" class="btn btn-success btn-sm">Save Changes</button>
                            </div> --}}
                        </div>

                        <input type="hidden" name="control_num" value="{{$control_num}}">
                        <input type="hidden" name="applicability" value="{{$treatmentData->applicability}}">

                        <table class="table table-bordered table-primary">
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>Current Risk Assessment</td>
                                    <td>Set Control Compliance% & Threat% target values to set a target risk level for future</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Control Number</td>
                                    <td>{{$treatmentData->control_num}}</td>
                                    <td>{{$after_risk_treatment->control_num}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Control is Applicable?</td>
                                    <td>{{$treatmentData->applicability}}</td>
                                    <td>{{$after_risk_treatment->applicability}}</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Control Compliance</td>
                                    <td>{{$treatmentData->control_compliance}}%</td>
                                    <td>
                                        <input type="number" name="control_compliance" oninput="validateInput(this)" class="form-control make-readonly" min=0 max=100 data-control-id="{{$after_risk_treatment->control_num}}" value="{{old('control_compliance',$after_risk_treatment->control_compliance)}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Vulnerability</td>
                                    <td>{{$treatmentData->vulnerability}}%</td>
                                    <td>
                                        <input type="number" name="vulnerability" class="form-control" data-control-id="{{$after_risk_treatment->control_num}}" readonly value="{{old('vulnerability',$after_risk_treatment->vulnerability)}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Threat</td>
                                    <td>{{$treatmentData->threat}}%</td>
                                    <td>
                                        <input type="number" name="threat" class="form-control make-readonly" min=0 max=100 data-control-id="{{$after_risk_treatment->control_num}}" value="{{old('threat',$after_risk_treatment->threat)}}">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Risk Level</td>
                                    <td>{{$treatmentData->risk_level}}</td>
                                    <td>
                                        <input type="number" name="risk_level" class="form-control" data-control-id="{{$after_risk_treatment->control_num}}" value="{{old('risk_level',$after_risk_treatment->risk_level)}}" readonly>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Asset Component Value</td>
                                    <td>
                                        @if($treatmentData->asset_value == 10)
                                        High
                                        @endif
                                        @if($treatmentData->asset_value == 5)
                                        Medium
                                        @endif
                                        @if($treatmentData->asset_value == 1)
                                        Low
                                        @endif
                                    </td>
                                    <td>
                                        @if($after_risk_treatment->asset_value == 10)
                                        High
                                        @endif
                                        @if($after_risk_treatment->asset_value == 5)
                                        Medium
                                        @endif
                                        @if($after_risk_treatment->asset_value == 1)
                                        Low
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>

        {{-- <div class="col-lg-6 mt-4">
            @if($after_risk_treatment->residual_risk_treatment == "retain and accept risk")
            <a href="/risk_treatment_justification/{{$asset_id}}/{{$control_num}}/{{$project_id}}/{{auth()->user()->id}}" class="btn my_bg_color text-white fw-bold">Create Justification</a>
            @endif
        </div> --}}
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function(){
        var assetValue = {{ $assetvalue }};
        var vulnerabilityValue = parseFloat($('input[name="vulnerability"]').val()) || null;
        var threatValue = parseFloat($('input[name="threat"]').val()) || null;

        function updateRiskLevel() {
            if (!isNaN(assetValue) && !isNaN(vulnerabilityValue) && !isNaN(threatValue)) {
                var riskLevel = (vulnerabilityValue / 100) * (threatValue / 100) * assetValue;
                $('input[name="risk_level"]').val(riskLevel.toFixed(4));
            } else {
                $('input[name="risk_level"]').val('');
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

        updateRiskLevel();

        $('#residual_risk_treatment').on('change', function() {
            var selectedValue = $(this).val();
            if (selectedValue === 'retain and accept risk') {
                $('.make-readonly').prop('readonly', true);
            } else {
                $('.make-readonly').prop('readonly', false);
            }
        });

        if ($('#residual_risk_treatment').val() === 'retain and accept risk') {
            $('.make-readonly').prop('readonly', true);
        }
    });

    function validateInput(inputElement) {
        if (inputElement.value.indexOf(".") !== -1) {
            alert("Decimal values are not allowed.");
            inputElement.value = Math.floor(inputElement.value);
        }
    }

    @if(Session::has('success'))
    swal({
        title: "{{Session::get('success')}}",
        icon: "success",
        closeOnClickOutside: true,
        timer: 3000,
    });
    @endif
</script>
@endsection

@endsection
