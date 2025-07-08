@extends('master')

@section('content')

@include('user-nav')


<div class="container mt-5">

     <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <!-- Left: Title Box -->
                <div class="p-3 fw-bold rounded shadow"
                        style="background: linear-gradient(135deg, #35323296, #848680); transition: 0.3s;">
                    <h5 class="fw-bold mb-0">Risk Register</h5>
                </div>

                    <!-- Right: Back Button -->
            <a href="{{ route('one_link_risk_register', [
                'proj_id' => $project->project_id,
                'user_id' => auth()->user()->id
            ]) }}" class="btn btn-secondary btn-lg">Back</a>
            </div>
        </div>
    <h3 class="mb-4 text-center fw-bold">Risk Record Details</h3>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white fw-semibold">General Information</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><strong>Risk ID:</strong> R-IPS-{{ $risk->risk_id }}</div>
            <div class="col-md-6"><strong>Created By:</strong> {{ $risk->created_by_name }}</div>
            <div class="col-md-6"><strong>Risk Description:</strong> {{ $risk->risk_description }}</div>
            <div class="col-md-6"><strong>ERM Classification:</strong> {{ $risk->erm_risk_classification }}</div>
            <div class="col-md-6"><strong>Residual Risk Rating:</strong> {{ $risk->residual_risk_rating }}</div>
            <div class="col-md-6"><strong>Likelihood:</strong> {{ $risk->likelihood }}</div>
            <div class="col-md-6"><strong>Overall Impact:</strong> {{ $risk->overall_impact }}</div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-secondary text-white fw-semibold">Entity & Ownership</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><strong>Department:</strong> {{ $risk->department_name }}</div>
            <div class="col-md-6"><strong>Unit:</strong> {{ $risk->unit_name }}</div>
            <div class="col-md-6"><strong>Product:</strong> {{ $risk->product_name }}</div>
            <div class="col-md-6"><strong>Cycle:</strong> {{ $risk->cycle_name }}</div>
            <div class="col-md-6"><strong>Sub Process:</strong> {{ $risk->sub_process_name }}</div>
            <div class="col-md-6"><strong>Risk Owner:</strong> {{ $risk->risk_owner_name }}</div>
            <div class="col-md-6"><strong>Control Owner:</strong> {{ $risk->control_owner_name }}</div>
            <div class="col-md-6"><strong>Technology Support:</strong> {{ $risk->technology_support_name }}</div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-info text-dark fw-semibold">Control Details</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><strong>Control Objective:</strong> {{ $risk->control_objective }}</div>
            <div class="col-md-6"><strong>Control Description:</strong> {{ $risk->control_description }}</div>
            <div class="col-md-6"><strong>Control Type:</strong> {{ $risk->control_type }}</div>
            <div class="col-md-6"><strong>Document Reference:</strong> {{ $risk->document_reference }}</div>
            <div class="col-md-6"><strong>Sub Process Reference:</strong> {{ $risk->sub_process_reference }}</div>
            <div class="col-md-6"><strong>Application:</strong> {{ $risk->application }}</div>
            <div class="col-md-6"><strong>COSO Component:</strong> {{ $risk->coso_component }}</div>
            <div class="col-md-6"><strong>Nature of Control:</strong> {{ $risk->nature_of_control }}</div>
            <div class="col-md-6"><strong>Control Mechanism:</strong> {{ $risk->control_mechanism }}</div>
            <div class="col-md-6"><strong>Recurrence:</strong> {{ $risk->recurrence_of_control }}</div>
            <div class="col-md-6"><strong>Frequency:</strong> {{ $risk->frequency_application }}</div>
            <div class="col-md-6"><strong>Key Control:</strong> {{ $risk->key_control }}</div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-warning text-dark fw-semibold">Audit & Risk Response</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><strong>External Audit:</strong> {{ $risk->external_audit_observation }}</div>
            <div class="col-md-6"><strong>Internal Audit:</strong> {{ $risk->internal_audit_observation }}</div>
            <div class="col-md-6"><strong>Incident Reference:</strong> {{ $risk->incident_reference }}</div>
            <div class="col-md-6"><strong>Risk Response:</strong> {{ $risk->risk_response }}</div>
            <div class="col-md-6"><strong>Entity-Level Control:</strong> {{ $risk->entity_level_control }}</div>
            <div class="col-md-6"><strong>Key Risk:</strong> {{ $risk->key_risk }}</div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white fw-semibold">Mitigation & Status</div>
        <div class="card-body row g-3">
            <div class="col-md-6"><strong>Mitigation Plan:</strong> {{ $risk->risk_mitigation_plan }}</div>
            <div class="col-md-6"><strong>Target Date:</strong> {{ $risk->risk_mitigation_target_date }}</div>
            <div class="col-md-6"><strong>Review Date:</strong> {{ $risk->review_date }}</div>
            <div class="col-md-6"><strong>Status:</strong> {{ $risk->implementation_status }}</div>
            <div class="col-md-12"><strong>Comments:</strong> {{ $risk->comments }}</div>
        </div>
    </div>

    @if($risk->kri_category)
    <div class="card shadow mb-5">
        <div class="card-header bg-dark text-white fw-semibold">Key Risk Indicators (KRI)</div>
        <div class="card-body row g-3">
            <div class="col-md-4"><strong>KRI Category:</strong> {{ $risk->kri_category }}</div>
            <div class="col-md-4"><strong>KRI Metric:</strong> {{ $risk->kri_metric }}</div>
            <div class="col-md-4"><strong>KRI Threshold:</strong> {{ $risk->kri_threshold }}</div>
        </div>
    </div>
    @endif

</div>



@endsection