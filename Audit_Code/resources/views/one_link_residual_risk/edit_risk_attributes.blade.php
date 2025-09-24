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
                    style="background: linear-gradient(135deg, #70e292, #F09819); transition: 0.3s;">
                    <h5 class="fw-bold mb-0">Residual Risk Assessment</h5>
                </div>

                    <!-- Right: Back Button -->
            <a href="{{ route('one_link_residual_risk_main', [
                'proj_id' => $project->project_id,
                'user_id' => auth()->user()->id
            ]) }}" class="btn btn-secondary btn-lg">Back</a>
            </div>
        </div>

        <table class="table table-bordered table-hover text-center align-middle mt-2">
            <thead class="table-secondary">
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
                    action="/update_residual_risk_data/{{ $project->project_id }}/{{ auth()->user()->organization->id }}/{{ auth()->user()->id }}"
                    method="POST">
                    @csrf

                    <input type="hidden" name="risk_id" value="{{ $record->risk_id }}">

                    <div class="mb-3">
                        <label for="" class="form-label fw-bold">Control Ref. No.</label>
                        <input class="form-control" type="text" name="" id=""
                            value="{{ $record->risk_id }}" readonly>
                    </div>


                         <div class="mb-3">
                            <label class="fw-bold" for="catalog_select" class="form-label">Choose from Control Objective Catalog
                                (optional)</label>

                            <div class="input-group">
                                <div class="input-group-text bg-white">
                                    <a href="/control-objective-catalog/{{$record->risk_id}}/{{ $project->project_id }}/{{auth()->user()->id}}" class="text-warning"
                                        title="Edit Catalog">
                                        <i class="fas fa-edit fa-2x"></i>
                                    </a>
                                </div>

                                <select id="control_objective_catalog_select" class="form-select">
                                    <option value="">-- Select Catalog Entry --</option>
                                    @foreach ($control_objective_catalogs as $cat)
                                        <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Editable Textarea -->
                        <div class="mb-3">
                            <label class="fw-bold" for="control_objective" class="form-label">Control Objective</label>
                            <textarea name="control_objective" id="control_objective" class="form-control" rows="4" required>{{ old('control_objective', $record->control_objective) }}</textarea>
                        </div>



                          <div class="mb-3">
                            <label class="fw-bold" for="catalog_select" class="form-label">Choose from Control Description Catalog
                                (optional)</label>

                            <div class="input-group">
                                <div class="input-group-text bg-white">
                                    <a href="/control-description-catalog/{{$record->risk_id}}/{{ $project->project_id }}/{{auth()->user()->id}}" class="text-warning"
                                        title="Edit Catalog">
                                        <i class="fas fa-edit fa-2x"></i>
                                    </a>
                                </div>

                                <select id="control_description_catalog_select" class="form-select">
                                    <option value="">-- Select Catalog Entry --</option>
                                    @foreach ($control_description_catalogs as $cat)
                                        <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Editable Textarea -->
                        <div class="mb-3">
                            <label class="fw-bold" for="control_description" class="form-label">Control Description</label>
                            <textarea name="control_description" id="control_description" class="form-control" rows="4" required>{{ old('control_description', $record->control_description) }}</textarea>
                        </div>




                        <div class="mb-3">
                            <label class="fw-bold" for="catalog_select" class="form-label">Choose from Control Type Catalog
                                (optional)</label>

                            <div class="input-group">
                                <div class="input-group-text bg-white">
                                    <a href="/control-type-catalog/{{$record->risk_id}}/{{ $project->project_id }}/{{auth()->user()->id}}" class="text-warning"
                                        title="Edit Catalog">
                                        <i class="fas fa-edit fa-2x"></i>
                                    </a>
                                </div>

                                <select id="control_type_catalog_select" class="form-select">
                                    <option value="">-- Select Catalog Entry --</option>
                                    @foreach ($control_type_catalogs as $cat)
                                        <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Editable Textarea -->
                        <div class="mb-3">
                            <label class="fw-bold" for="control_type" class="form-label">Control Type</label>
                            <textarea name="control_type" id="control_type" class="form-control" rows="4" required>{{ old('control_type', $record->control_type) }}</textarea>
                        </div>


                        

                     <div class="mb-3">
                        <label for="control_owner" class="form-label fw-bold">Control Owner</label>
                        <select name="control_owner" id="control_owner" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $selectedValue = old('control_owner', $record->control_owner);
                            @endphp
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $selectedValue == $user->id ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{$user->last_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="technology_support" class="form-label fw-bold">Technology Support</label>
                        <select name="technology_support" id="technology_support" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $selectedValue = old('technology_support', $record->technology_support);
                            @endphp
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ $selectedValue == $user->id ? 'selected' : '' }}>
                                    {{ $user->first_name }} {{$user->last_name}}
                                </option>
                            @endforeach
                        </select>
                    </div>




                         <div class="mb-3">
                            <label class="fw-bold" for="catalog_select" class="form-label">Choose from Document Reference Catalog
                                (optional)</label>

                            <div class="input-group">
                                <div class="input-group-text bg-white">
                                    <a href="/document-reference-catalog/{{$record->risk_id}}/{{ $project->project_id }}/{{auth()->user()->id}}" class="text-warning"
                                        title="Edit Catalog">
                                        <i class="fas fa-edit fa-2x"></i>
                                    </a>
                                </div>

                                <select id="document_reference_catalog_select" class="form-select">
                                    <option value="">-- Select Catalog Entry --</option>
                                    @foreach ($document_reference_catalogs as $cat)
                                        <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Editable Textarea -->
                        <div class="mb-3">
                            <label class="fw-bold" for="document_reference" class="form-label">Documenr or Process Reference</label>
                            <textarea name="document_reference" id="document_reference" class="form-control" rows="4" required>{{ old('document_reference', $record->document_reference) }}</textarea>
                        </div>




                        <div class="mb-3">
                            <label class="fw-bold" for="catalog_select" class="form-label">Choose from Sub Process Reference Catalog
                                (optional)</label>

                            <div class="input-group">
                                <div class="input-group-text bg-white">
                                    <a href="/sub-process-reference-catalog/{{$record->risk_id}}/{{ $project->project_id }}/{{auth()->user()->id}}" class="text-warning"
                                        title="Edit Catalog">
                                        <i class="fas fa-edit fa-2x"></i>
                                    </a>
                                </div>

                                <select id="sub_process_reference_catalog_select" class="form-select">
                                    <option value="">-- Select Catalog Entry --</option>
                                    @foreach ($sub_process_reference_catalogs as $cat)
                                        <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Editable Textarea -->
                        <div class="mb-3">
                            <label class="fw-bold" for="sub_process_reference" class="form-label">Sub-Process Reference</label>
                            <textarea name="sub_process_reference" id="sub_process_reference" class="form-control" rows="4" required>{{ old('sub_process_reference', $record->sub_process_reference) }}</textarea>
                        </div>



                        




                    <div class="mb-3">
                        <label for="coso_component" class="form-label fw-bold">COSO Document</label>
                        <select name="coso_component" id="coso_component" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = [
                                    'Control Environment',
                                    'Risk Assessment',
                                    'Control Activities',
                                    'Information and Communication',
                                    'Monitoring',
                                ];
                                $selectedValue = old('coso_component', $record->coso_component);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="nature_of_control" class="form-label fw-bold">Nature of Control</label>
                        <select name="nature_of_control" id="nature_of_control" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = ['Preventive', 'Detective', 'Corrective'];
                                $selectedValue = old('nature_of_control', $record->nature_of_control);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                            <label class="fw-bold" for="catalog_select" class="form-label">Choose from Application Catalog
                                (optional)</label>

                            <div class="input-group">
                                <div class="input-group-text bg-white">
                                    <a href="/application-catalog/{{$record->risk_id}}/{{ $project->project_id }}/{{auth()->user()->id}}" class="text-warning"
                                        title="Edit Catalog">
                                        <i class="fas fa-edit fa-2x"></i>
                                    </a>
                                </div>

                                <select id="application_catalog_select" class="form-select">
                                    <option value="">-- Select Catalog Entry --</option>
                                    @foreach ($application_catalogs as $cat)
                                        <option value="{{ $cat->description }}">{{ $cat->description }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <!-- Editable Textarea -->
                        <div class="mb-3">
                            <label class="fw-bold" for="application" class="form-label">Application</label>
                            <textarea name="application" id="application" class="form-control" rows="4" required>{{ old('application', $record->application) }}</textarea>
                        </div>


                    <div class="mb-3">
                        <label for="control_mechanism" class="form-label fw-bold">Control Mechanism</label>
                        <select name="control_mechanism" id="control_mechanism" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = ['Automated', 'Semi-Automated', 'Manual'];
                                $selectedValue = old('control_mechanism', $record->control_mechanism);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="mb-3">
                        <label for="recurrence_of_control" class="form-label fw-bold">Recurrence of Control</label>
                        <select name="recurrence_of_control" id="recurrence_of_control" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = ['Recurring', 'Non-Recurring', 'Exceptional'];
                                $selectedValue = old('recurrence_of_control', $record->recurrence_of_control);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="frequency_application" class="form-label fw-bold">Frequency of Control Mechanism</label>
                        <select name="frequency_application" id="frequency_application" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = [
                                    'Daily',
                                    'On need basis',
                                    'Multiple times a day',
                                    'For every transaction',
                                ];
                                $selectedValue = old('frequency_application', $record->frequency_application);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                  

    <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <!-- Left: Title Box -->
                <div class="p-3 fw-bold rounded shadow"
                    style="background: linear-gradient(135deg, #70e292, #3c866a); transition: 0.3s;">
                    <h5 class="fw-bold mb-0">Control Design Effective Factors</h5>
                </div>

            </div>
        </div>



                    @php
                        $numberFields = [
                            'policy' => 'Policy in Written Form',
                            'sop' => 'SOP in written Form',
                            'marker_checker_control' => 'Marker/Checker Control',
                            'ownership' => 'Ownership',
                            'control_design_review' => 'Control design review from second line of defense',
                            'diagnosis_of_control' => 'Diagnosis of control by external/ internal audits',
                            'meets_control_obj' => 'Meets Control Objective',
                            'complaints_management' => 'Complaints Management from Customers',
                            'control_design_ass' => 'Control Design Assessment',
                            'control_implementation' => 'Control Implementation (Operating) Effectiveness',
                            'control_rating' => 'Control Rating',
                        ];

                        $allowedValues = range(1, 5);
                    @endphp

                    @foreach ($numberFields as $field => $label)
                        <div class="mb-3">
                            <label for="{{ $field }}" class="form-label fw-bold">{{ $label }}</label>
                            <select name="{{ $field }}" id="{{ $field }}" class="form-select" required>
                                <option value="0">-- NA --</option>
                                @php
                                    $selectedValue = old($field, $record->$field);
                                @endphp
                                @foreach ($allowedValues as $val)
                                    <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                        {{ $val }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endforeach

                      <div class="mb-3">
                        <label for="key_control" class="form-label fw-bold">Key Control</label>
                        <select name="key_control" id="key_control" class="form-select">
                            <option value="">-- None --</option>
                            @php
                                $allowedValues = ['Yes', 'No'];
                                $selectedValue = old('key_control', $record->key_control);
                            @endphp
                            @foreach ($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>



                    <div class="mb-3">
                        <label for="residual_risk_rating" class="form-label fw-bold">Residual Risk Rating (COntrol rating multiply by blank3(inherent risk rating))</label>
                        <input type="text" id="residual_risk_rating" name="residual_risk_rating" class="form-control"
                            readonly>
                    </div>


                    <div class="text-end">
                        <button class="btn btn-success" type="submit">Submit Risk Record</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="text-end">
            <a href="/initiate_risk_response_assessment_form/{{ $record->risk_id }}/{{ $project->project_id }}/{{ auth()->user()->id }}"
                class="btn btn-md mb-2 mt-4 fw-bold fw-bold"
                style="background: linear-gradient(135deg, #41da92, #1869e2); transition: 0.3s;">Initiate Risk Response
                </a>
        </div>


    </div> <!-- END .container -->

@section('scripts')

    <script>
        document.getElementById('control_objective_catalog_select').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('control_objective').value = selectedValue;
            }
        });

        document.getElementById('control_description_catalog_select').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('control_description').value = selectedValue;
            }
        });

         document.getElementById('control_type_catalog_select').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('control_type').value = selectedValue;
            }
        });

           document.getElementById('document_reference_catalog_select').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('document_reference').value = selectedValue;
            }
        });


          document.getElementById('sub_process_reference_catalog_select').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('sub_process_reference').value = selectedValue;
            }
        });

         document.getElementById('application_catalog_select').addEventListener('change', function() {
            const selectedValue = this.value;
            if (selectedValue) {
                document.getElementById('application').value = selectedValue;
            }
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const controlRatingSelect = document.getElementById('control_rating');
        const residualRiskInput = document.getElementById('residual_risk_rating');

        // Get blank3 value from the backend (convert it to float if needed)
        const blank3 = parseFloat("{{ $record->blank3 ?? 0 }}");

        function updateResidualRiskRating() {
            const controlRating = parseFloat(controlRatingSelect.value);
            if (!isNaN(controlRating) && !isNaN(blank3)) {
                const result = blank3 * controlRating;
                residualRiskInput.value = result.toFixed(2);
            } else {
                residualRiskInput.value = '';
            }
        }

        // Initial load
        updateResidualRiskRating();

        // Update when dropdown changes
        controlRatingSelect.addEventListener('change', updateResidualRiskRating);
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
