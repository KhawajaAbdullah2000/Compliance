@extends('master')

@section('content')

    @include('user-nav')

    @php
        $permissions = json_decode($project_permissions);
    @endphp

    <div class="container">

        <div class="row mt-5">
            <div class="col-lg-12">
                @include('components.one_link_topTable')
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <!-- Left: Title Box -->
                <div class="p-3 fw-bold rounded shadow"
                    style="background: linear-gradient(135deg, #41da92, #1869e2); transition: 0.3s;">
                    <h5 class="fw-bold mb-0">Risk Response</h5>
                </div>

                <!-- Right: Back Button -->
                <a href="{{ route('one_link_risk_response_main', [
                'proj_id' => $project->project_id,
                'user_id' => auth()->user()->id
            ]) }}" class="btn btn-secondary btn-lg">Back</a>
            </div>
        </div>

        <table class="table table-bordered table-hover text-center align-middle mt-2">
            <thead class="table-dark">
                <tr>
                    <th>Risk Id</th>
                    <th>Date of Risk Identification</th>
                    <th>Date of Risk ReAssessment</th>
                    <th>Department (SBU)</th>
                    <th>Unit</th>
                    <th>Product</th>
                    <th>Cycle</th>
                    <th>Sub-Process</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>R-IPS-{{ $record->risk_id }}</td>
                    <td>{{ $record->risk_identification_date }}</td>
                    <td>{{ $record->risk_reassessment_date }}</td>
                    <td>{{ $record->department_name }}</td>
                    <td>{{ $record->unit_name }}</td>
                    <td>{{ $record->product_name }}</td>
                    <td>{{ $record->cycle_name }}</td>
                    <td>{{ $record->sub_process_name }}</td>
                </tr>
            </tbody>
        </table>

        <div class="card">
            <div class="card-body">

                <form
                    action="/update_risk_response_data/{{ $project->project_id }}/{{ auth()->user()->organization->id }}/{{ auth()->user()->id }}"
                    method="POST">
                    @csrf


                    <input type="hidden" name="risk_id" value="{{ $record->risk_id }}">

                    <div class="mb-3">
                        <label for="risk_response" class="form-label fw-bold">Risk Response</label>
                        <select name="risk_response" id="risk_response" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = ['Yes', 'No'];
                                $selectedValue = old('risk_response', $record->risk_response);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="entity_level_control" class="form-label fw-bold">Entity-Level Control (ELC)</label>
                        <select name="entity_level_control" id="entity_level_control" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = ['Yes', 'No'];
                                $selectedValue = old('entity_level_control', $record->entity_level_control);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="fw-bold" for="catalog_select" class="form-label">Choose from Incident Reference
                            Catalog
                            (optional)</label>

                        <div class="input-group">
                            <div class="input-group-text bg-white">
                                <a href="/incident-reference-catalog/{{ $record->risk_id }}/{{ $project->project_id }}/{{ auth()->user()->id }}"
                                    class="text-warning" title="Edit Catalog">
                                    <i class="fas fa-edit fa-2x"></i>
                                </a>
                            </div>

                            <select id="incident_reference_catalog" class="form-select">
                                <option value="">-- Select Catalog Entry --</option>
                                @foreach ($incident_reference_catalogs as $cat)
                                    <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Editable Textarea -->
                    <div class="mb-3">
                        <label class="fw-bold" for="incident_reference" class="form-label">Incident Reference</label>
                        <textarea name="incident_reference" id="incident_reference" class="form-control" rows="4" required>{{ old('incident_reference', $record->incident_reference) }}</textarea>
                    </div>



                    <div class="mb-3">
                        <label class="fw-bold" for="catalog_select" class="form-label">Choose from External Audit
                            Observation Catalog
                            (optional)</label>

                        <div class="input-group">
                            <div class="input-group-text bg-white">
                                <a href="/external-audit-observation-catalog/{{ $record->risk_id }}/{{ $project->project_id }}/{{ auth()->user()->id }}"
                                    class="text-warning" title="Edit Catalog">
                                    <i class="fas fa-edit fa-2x"></i>
                                </a>
                            </div>

                            <select id="external_audit_observation_catalog" class="form-select">
                                <option value="">-- Select Catalog Entry --</option>
                                @foreach ($external_audit_observation_catalogs as $cat)
                                    <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Editable Textarea -->
                    <div class="mb-3">
                        <label class="fw-bold" for="external_audit_observation" class="form-label">External Audit
                            Observation Reference No</label>
                        <textarea name="external_audit_observation" id="external_audit_observation" class="form-control" rows="4"
                            required>{{ old('external_audit_observation', $record->external_audit_observation) }}</textarea>
                    </div>


                    <div class="mb-3">
                        <label class="fw-bold" for="catalog_select" class="form-label">Choose from Internal Audit
                            Observation Catalog
                            (optional)</label>

                        <div class="input-group">
                            <div class="input-group-text bg-white">
                                <a href="/internal-audit-observation-catalog/{{ $record->risk_id }}/{{ $project->project_id }}/{{ auth()->user()->id }}"
                                    class="text-warning" title="Edit Catalog">
                                    <i class="fas fa-edit fa-2x"></i>
                                </a>
                            </div>

                            <select id="internal_audit_observation_catalog" class="form-select">
                                <option value="">-- Select Catalog Entry --</option>
                                @foreach ($internal_audit_observation_catalogs as $cat)
                                    <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Editable Textarea -->
                    <div class="mb-3">
                        <label class="fw-bold" for="internal_audit_observation" class="form-label">Internal Audit
                            Observation Reference No.</label>
                        <textarea name="internal_audit_observation" id="internal_audit_observation" class="form-control" rows="4"
                            required>{{ old('internal_audit_observation', $record->internal_audit_observation) }}</textarea>
                    </div>



                    <div class="mb-3">
                        <label for="review_date" class="form-label fw-bold">Review Date</label>
                        <input class="form-control" type="date" name="review_date" id=""
                            value="{{ old('review_date', $record->review_date) }}">
                    </div>

                    <div class="mb-3">
                        <label class="fw-bold" for="catalog_select" class="form-label">Choose from Risk Mitigation Plan
                            Catalog
                            (optional)</label>

                        <div class="input-group">
                            <div class="input-group-text bg-white">
                                <a href="/risk-mitigation-plan-catalog/{{ $record->risk_id }}/{{ $project->project_id }}/{{ auth()->user()->id }}"
                                    class="text-warning" title="Edit Catalog">
                                    <i class="fas fa-edit fa-2x"></i>
                                </a>
                            </div>

                            <select id="risk_mitigation_plan_catalog" class="form-select">
                                <option value="">-- Select Catalog Entry --</option>
                                @foreach ($risk_mitigation_plan_catalogs as $cat)
                                    <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Editable Textarea -->
                    <div class="mb-3">
                        <label class="fw-bold" for="risk_mitigation_plan" class="form-label">Risk Mitigation Plan
                            (Actionable Item)</label>
                        <textarea name="risk_mitigation_plan" id="risk_mitigation_plan" class="form-control" rows="4" required>{{ old('risk_mitigation_plan', $record->risk_mitigation_plan) }}</textarea>
                    </div>







                    <div class="mb-3">
                        <label for="risk_mitigation_target_date" class="form-label fw-bold">Risk Mitigation Target
                            Completion Date</label>
                        <input class="form-control" type="date" name="risk_mitigation_target_date" id=""
                            value="{{ old('risk_mitigation_target_date', $record->risk_mitigation_target_date) }}">
                    </div>

                    <div class="mb-3">
                        <label for="implementation_status" class="form-label fw-bold">Implementation Status</label>
                        <select name="implementation_status" id="implementation_status" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = ['Open', 'Closed', 'In-Progress'];
                                $selectedValue = old('implementation_status', $record->implementation_status);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="key_risk" class="form-label fw-bold">Key Risk</label>
                        <select name="key_risk" id="key_risk" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = ['Yes', 'No'];
                                $selectedValue = old('key_risk', $record->key_risk);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="kri_category" class="form-label fw-bold">KRI Category</label>
                        <select name="kri_category" id="kri_category" class="form-select">
                             <option value="" {{ $record->kri_category == '' ? 'selected' : '' }}>-- None (Default) --</option>
        <option value="Fraud Risk" {{ $record->kri_category == 'Fraud Risk' ? 'selected' : '' }}>Fraud Risk</option>
        <option value="Cybersecurity" {{ $record->kri_category == 'Cybersecurity' ? 'selected' : '' }}>Cybersecurity</option>
        <option value="System Downtime" {{ $record->kri_category == 'System Downtime' ? 'selected' : '' }}>System Downtime</option>
        <option value="Regulatory Compliance" {{ $record->kri_category == 'Regulatory Compliance' ? 'selected' : '' }}>Regulatory Compliance</option>
        <option value="Operational Errors" {{ $record->kri_category == 'Operational Errors' ? 'selected' : '' }}>Operational Errors</option>
        <option value="Vendor Risk" {{ $record->kri_category == 'Vendor Risk' ? 'selected' : '' }}>Vendor Risk</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="kri_metric" class="form-label fw-bold">KRI Metric</label>
                        <input value="{{old('kri_metric',$record->kri_metric)}}" type="text" name="kri_metric" id="kri_metric" class="form-control" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="kri_threshold" class="form-label fw-bold">KRI Threshold</label>
                        <input type="text" name="kri_threshold" id="kri_threshold" class="form-control" value="{{old('kri_threshold',$record->kri_threshold)}}" readonly>
                    </div>


                    <div class="text-end">
                        <button class="btn btn-success" type="submit">Submit Risk Record</button>
                    </div>


                </form>

            </div>

        </div>



        {{-- <div class="text-end">
            <a href="/initiate_risk_response_assessment_form/{{ $record->risk_id }}/{{ $project->project_id }}/{{ auth()->user()->id }}"
                class="btn btn-md mb-2 mt-4 fw-bold fw-bold"
                style="background: linear-gradient(135deg, #41da92, #1869e2); transition: 0.3s;">Initiate Risk Response
            </a>
        </div> --}}


    </div> <!-- END .container -->

@section('scripts')
    <script>
        document.getElementById('incident_reference_catalog').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('incident_reference').value = selectedValue;
            }
        });

        document.getElementById('external_audit_observation_catalog').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('external_audit_observation').value = selectedValue;
            }
        });


        document.getElementById('internal_audit_observation_catalog').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('internal_audit_observation').value = selectedValue;
            }
        });

        document.getElementById('risk_mitigation_plan_catalog').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('risk_mitigation_plan').value = selectedValue;
            }
        });
    </script>


    <script>
        const kriOptions = {
            'Fraud Risk': {
                metric: '% of fraudulent transactions',
                threshold: '≤ 0.5%'
            },
            'Cybersecurity': {
                metric: 'No. of security breaches',
                threshold: '≤ 2 per month'
            },
            'System Downtime': {
                metric: '% of service disruption',
                threshold: '≤ 1% uptime impact'
            },
            'Regulatory Compliance': {
                metric: 'No. of compliance breaches',
                threshold: '0'
            },
            'Operational Errors': {
                metric: 'No. of failed settlements/errors',
                threshold: '≤ 3 per month'
            },
            'Vendor Risk': {
                metric: '% of vendor failures affecting ops',
                threshold: '≤ 1%'
            }
        };

        document.getElementById('kri_category').addEventListener('change', function() {
            const selected = this.value;
            const metricInput = document.getElementById('kri_metric');
            const thresholdInput = document.getElementById('kri_threshold');

            if (kriOptions[selected]) {
                metricInput.value = kriOptions[selected].metric;
                thresholdInput.value = kriOptions[selected].threshold;
            } else {
                metricInput.value = '';
                thresholdInput.value = '';
            }
        });
    </script>





    {{-- SweetAlert for success --}}
    @if (Session::has('success'))
        <script>
            swal({
                title: "{{ Session::get('success') }}",
                icon: "success",
                closeOnClickOutside: true,
                timer: 3000,
            });
        </script>
    @endif
@endsection


@endsection
