@extends('master')

@section('content')

@include('user-nav')


@php
$permissions = json_decode($project_permissions);

// User is editable if they have "Data Inputter"
$isEditable = in_array('Data Inputter', $permissions) && $assetData->approved != 1;

// User is read-only ONLY IF they do NOT have "Data Inputter"
$isReadOnly = !$isEditable && (in_array('Data Viewer', $permissions) || in_array('Data Approver', $permissions));

$isApprover=in_array('Data Approver', $permissions);
@endphp



<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
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

    <div class="row d-flex justify-content-between align-items-start">

    <div class="col-md-6 mt-4">
        <table class="table table-bordered table-responsive">
            <tr>
                <td class="bg-secondary text-white">Service</td>
                <td>{{$riskData->s_name}}</td>
                <td class="bg-secondary text-white">Asset Group</td>
                <td>{{$riskData->g_name}}</td>
                <td class="bg-secondary text-white">Asset Subgroup</td>
                <td>{{$riskData->name}}</td>
                <td class="bg-secondary text-white">Asset Component</td>
                <td>{{$riskData->c_name}}</td>
            </tr>
        </table>
        </div>

        <div class="col-md-6 mt-4 text-end">
           <a href="/iso_sec_2_3_1/{{$assetData->asset_id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-md btn-warning">Go back to RIsk Assessment</a>
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

            <h3 class="">Severity of Adverse Impacts</h3>

            <p><span class="fw-bold">Risk Confidentiality:</span>
            @if($riskData->risk_confidentiality==10)
            High
            @endif
            
            @if($riskData->risk_confidentiality==5)
            Medium
            @endif
            
            @if($riskData->risk_confidentiality==1)
            Low
            @endif
            </p>
            
            
            <p><span class="fw-bold">Risk Integrity:</span>
            
                @if($riskData->risk_integrity==10)
            High
            @endif
            
            @if($riskData->risk_integrity==5)
            Medium
            @endif
            
            @if($riskData->risk_integrity==1)
            Low
            @endif
            
            </p>
            
            <p><span class="fw-bold">Risk Availability:</span>
            
                @if($riskData->risk_availability==10)
            High
            @endif
            
            @if($riskData->risk_availability==5)
            Medium
            @endif
            
            @if($riskData->risk_availability==1)
            Low
            @endif
            
            </p>

    <div class="form-group">
        <label for="" class="fw-bold">Applicability: </label>

        @if($assetData->applicability=='yes')
        Only to this asset component
        @endif

        @if($assetData->applicability=='yes_to_all')
        To all asset components in this project
        @endif

        @if($assetData->applicability=='no')
        Not to this asset component
        @endif
</td>



            </div>



            <div class="form-group mt-4">
                <label for="" class="fw-bold">Description of Vulnerability</label>
                <br>
                <input {{ $isEditable ? '' : 'disabled' }} class="form-check-input" type="radio" name="desc_vulnerability" value="Description of control is fully met"
                    {{ old('desc_vulnerability', $assetData->desc_vulnerability) == 'Description of control is fully met' ? 'checked' : '' }}>
                <label for="">Description of control is fully met</label><br>

                <input {{ $isEditable ? '' : 'disabled' }} class="form-check-input" type="radio" name="desc_vulnerability" value="Description of control is partially met or not met"
                    {{ old('desc_vulnerability', $assetData->desc_vulnerability) == 'Description of control is partially met or not met' ? 'checked' : '' }}>
                <label for="">Description of control is partially met or not met</label><br>

                <input {{ $isEditable ? '' : 'disabled' }} class="form-check-input" type="radio" name="desc_vulnerability" value="Other"
                    {{ old('desc_vulnerability', $assetData->desc_vulnerability) == 'Other' ? 'checked' : '' }}>
                <label for="">Other</label><br>

                <input {{ $isEditable ? '' : 'disabled' }} type="text" name="desc_vulnerability_other" class="form-control"
                    value="{{ old('desc_vulnerability_other', $assetData->desc_vulnerability_other) }}">
            </div>




            <div class=" mt-4">
                <label for="" class="fw-bold">Description of Threat</label>
                <br>
                <input {{ $isEditable ? '' : 'disabled' }} class="form-check-input" type="radio" name="desc_threat" value="Asset component is directly publicly exposed"
                {{ old('desc_threat', $assetData->desc_threat) == 'Asset component is directly publicly exposed' ? 'checked' : '' }}>
                <label for="">Asset component is directly publicly exposed</label>

                <br>



                <input {{ $isEditable ? '' : 'disabled' }} class="form-check-input" type="radio" name="desc_threat" value="Asset component is NOT directly publicly exposed"
                    {{ old('desc_threat', $assetData->desc_threat) == 'Asset component is NOT directly publicly exposed' ? 'checked' : '' }}>
                <label for="">Asset component is NOT directly publicly exposed</label>

                <br>



                <input {{ $isEditable ? '' : 'disabled' }} class="form-check-input" type="radio" name="desc_threat" value="Other"
                    {{ old('desc_threat', $assetData->desc_threat) == 'Other' ? 'checked' : '' }}>
                <label for="">Other</label>

                <input {{ $isEditable ? '' : 'disabled' }} type="text" name="desc_threat_other" class="form-control"
                    value="{{ old('desc_threat_other', $assetData->desc_threat_other) }}">
            </div>



            {{-- <div class="form-group mt-4">
                <label for="risk" class="fw-bold">Types of Risk</label>
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

                <input type="checkbox" name="desc_risk[]" value="Information or Service Denial"
                    {{ is_array($selectedRisks) && in_array('Information or Service Denial', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Denial of Data Availability</label><br>

                <input type="checkbox" name="desc_risk[]" value="Other"
                    {{ is_array($selectedRisks) && in_array('Other', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Other</label><br>

                <input type="text" name="desc_risk_other" class="form-control"
                    value="{{ old('desc_risk_other', $assetData->desc_risk_other) }}">
            </div> --}}

            <div class="form-group mt-4">
                <label for="risk" class="fw-bold">Types of Risk</label>
                <br>
                @php
                    $descRisk = old('desc_risk', $assetData->desc_risk);
                    $defaultRisks = ['Breach of data confidentiality', 'Breach of data integrity', 'Information or Service Denial'];

                    if (in_array($assetData->control_num, [8.6, 8.13, 8.14])) {
                        $defaultRisks = ['Information or Service Denial'];
                    }
                    else if (in_array($assetData->control_num, [6.6,8.11,8,12])){
                        $defaultRisks = ['Breach of data confidentiality'];
                    }
                    
                    else {
                        $defaultRisks = ['Breach of data confidentiality', 'Breach of data integrity', 'Information or Service Denial'];
                    }
                    $selectedRisks = is_string($descRisk) ? json_decode($descRisk, true) : $descRisk;
            
                    // If no risks are selected, set the default values
                    if (empty($selectedRisks)) {
                        $selectedRisks = $defaultRisks;
                    }
                @endphp
            
                <input {{ $isEditable ? '' : 'disabled' }} type="checkbox" name="desc_risk[]" value="Breach of data confidentiality"
                    {{ is_array($selectedRisks) && in_array('Breach of data confidentiality', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Breach of data confidentiality</label><br>
            
                <input {{ $isEditable ? '' : 'disabled' }} type="checkbox" name="desc_risk[]" value="Breach of data integrity"
                    {{ is_array($selectedRisks) && in_array('Breach of data integrity', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Breach of data integrity</label><br>
            
                <input {{ $isEditable ? '' : 'disabled' }} type="checkbox" name="desc_risk[]" value="Information or Service Denial"
                    {{ is_array($selectedRisks) && in_array('Information or Service Denial', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Denial of Data Availability</label><br>
            
                <input {{ $isEditable ? '' : 'disabled' }} type="checkbox" name="desc_risk[]" value="Other"
                    {{ is_array($selectedRisks) && in_array('Other', $selectedRisks) ? 'checked' : '' }}>
                <label for="">Other</label><br>
            
                <input {{ $isEditable ? '' : 'disabled' }} type="text" name="desc_risk_other" class="form-control"
                    value="{{ old('desc_risk_other', $assetData->desc_risk_other) }}">
            </div>
            

            <small class="text-danger fw-bold d-block mt-2">
                <i class="fas fa-exclamation-triangle"></i> 
                You must press save changes button before leaving this page
            </small>

            @if ($isEditable)
              <div class="text-center mt-3 fw-bold">
                <button type="submit" class="btn my_bg_color btn-md mt-2 text-white">Save Changes </button>
              </div>
              @endif


        </form>

    </div>
</div>


    </div>
</div>

@if($isApprover && isset($assetData))
<div class="container d-flex justify-content-center">
    <div class="card shadow-lg border-0 mt-5 mb-5" style="max-width: 1000px; width: 100%;">
        <div class="card-header text-white text-center" style="background-color: rgb(121, 173, 44)">
            <h3 class="text-center">Approve</h3>
        </div>

        <div class="card-body">
            
        <p class="fw-bold">Current Status:
            @if(isset($assetData) && ($assetData->approved == 0 || is_null($assetData->approved)))
         Not worked on by approver
         @endif
         @if(isset($assetData) && ($assetData->approved == 1 ) )
        Approved
        @endif

        @if(isset($assetData) && ($assetData->approved == 2 ) )
        Not Approved
        @endif
            
        </p>
            <form action="/approve_sec_2_3_1/{{$assetData->control_num}}/{{$project->project_id}}/{{auth()->user()->id}}/{{$assetData->asset_id}}" method="post" id="approvalForm">
                @csrf


                <div class="row">
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-success px-5 rounded-pill w-80 h-100" name="action" value="1">
                            Apply Approve only this control and save changes
                        </button>
                    </div>
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-success px-5 rounded-pill w-80 h-100" name="action" value="2">
                            Apply to Approve all controls in this domain and save changes
                        </button>
                    </div>
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-success px-5 rounded-pill w-80 h-100" name="action" value="3">
                            Apply to Approve all controls in all domains and save changes
                        </button>
                    </div>
                </div>

                
                <div class="mb-4 mt-4">
                    <label for="approver_comments" class="form-label"> <span class=" fw-semibold">Approver Comments</span> (Comments are mandatory if not approved)</label>
                    <textarea name="approver_comments" id="approver_comments" rows="4" class="form-control rounded">{{ old('approver_comments', $assetData->approver_comments ?? '') }}</textarea>
                    <div class="text-danger small mt-2 d-none" id="commentError">Approver comments are required when rejecting.</div>
                    @error('approver_comments')
                    <div class="text-danger small mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-danger px-5 rounded-pill w-80 h-100 reject-button" name="action" value="4">
                           Do not Approve only this control and save changes
                        </button>
                    </div>
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-danger px-5 rounded-pill w-80 h-100 reject-button" name="action" value="5">
                           Do not Approve all controls in this domain and save changes
                        </button>
                    </div>
                    <div class="col-md-4 d-flex">
                        <button type="submit" class="btn btn-danger px-5 rounded-pill w-80 h-100 reject-button" name="action" value="6">
                            Do not Approve all controls in all domains and save changes
                        </button>
                    </div>
                </div>


            </form>
        </div>

    </div>
</div>

@endif


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


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.getElementById("approvalForm");
        const approverComments = document.getElementById("approver_comments");
        const rejectButtons = document.querySelectorAll(".reject-button");
        const commentError = document.getElementById("commentError");

        rejectButtons.forEach(button => {
            button.addEventListener("click", function (event) {
                if (approverComments.value.trim() === "") {
                    event.preventDefault(); // Prevent form submission
                    commentError.classList.remove("d-none"); // Show error message
                } else {
                    commentError.classList.add("d-none"); // Hide error message if valid
                }
            });
        });
    });
</script>


@endsection


@endsection
