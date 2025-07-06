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
            <div class="p-3 text-white rounded shadow"
                style="background: linear-gradient(135deg, #FF512F, #F09819); transition: 0.3s;">
                <h5 class="fw-bold mb-0">Gross Risk Assessment</h5>
            </div>

            <!-- Right: Back Button -->
            <a href="{{ route('one_link_gross_risk_main', [
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
            <form action="/update_gross_risk_data/{{ $project->project_id }}/{{ auth()->user()->organization->id }}/{{ auth()->user()->id }}" method="POST">
                @csrf

                <input type="hidden" name="risk_id" value="{{ $record->risk_id }}">

               @php
                    $businessImpactFields = [
                        'financial_impact' => 'Financial Impact',
                        'criticality_on_revenue' => 'Criticality on Revenue',
                        'financial_ecosystem' => 'Financial Ecosystem',
                        'geog_service_devilery' => 'Geographical Service Delivery',
                        'strategic_importance' => 'Strategic Importance',
                        'criticality_of_customer_base' => 'Criticality of Customer Base',
                        'monthly_transactions' => 'Monthly Transactions',
                        'reg_comp_obligations' => 'Regulatory & Compliance Obligations',
                        'dependency_on_external_vendors' => 'Dependency on External Vendors'
                    ];

                    $allowedValues = range(1, 9);
                @endphp

                @foreach($businessImpactFields as $field => $label)
                    <div class="mb-3">
                        <label for="{{ $field }}" class="form-label fw-bold">{{ $label }}</label>
                        <select name="{{ $field }}" id="{{ $field }}" class="form-select" required>
                            <option value="0">-- NA --</option>
                            @php
                                $selectedValue = old($field, $record->$field);
                            @endphp
                            @foreach($allowedValues as $val)
                                <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach


                <div class="mb-3">
            <label for="total_impact_rating" class="form-label fw-bold">Total Impact Rating</label>
            <input type="number" class="form-control" id="total_impact_rating" name="total_impact_rating"
                value="{{ old('total_impact_rating', $record->total_impact_rating) }}" readonly>
        </div>

                <div class="mb-3">
            <label for="blank1" class="form-label fw-bold">Blank1 (Name not known)</label>
            <input type="number" class="form-control" id="blank1" name="blank1"
                value="{{ old('blank1', $record->blank1) }}" readonly>
        </div>


        <div class="mb-3">
            <label class="form-label fw-bold d-block">Overall Impact:</label>

            <div class="d-flex flex-column w-25">
                <div id="impact-high" class="impact-box">HIGH</div>
                <div id="impact-medium" class="impact-box">MEDIUM</div>
                <div id="impact-low" class="impact-box">LOW</div>
            </div>

            <input type="hidden" name="overall_impact" id="overall_impact" value="{{ old('overall_impact', $record->overall_impact) }}">
        </div>



        
                 <div class="mb-3">
                    <label for="extent_of_functions" class="form-label fw-bold">Extent of Functions Impacted by Process</label>
                    <select name="extent_of_functions" id="extent_of_functions" class="form-select" required>
                        <option value="0">-- NA --</option>
                        @php
                            $allowedValues = [1,2,3,4,5,6,7,8,9];
                            $selectedValue = old('extent_of_functions', $record->extent_of_functions);
                        @endphp
                        @foreach($allowedValues as $val)
                            <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>

                 <div class="mb-3">
                    <label for="likelihood" class="form-label fw-bold">Likelihood</label>
                    <select name="likelihood" id="likelihood" class="form-select">
                        <option value="">-- None --</option>
                        @php
                            $allowedValues = ["High", "Medium","Low"];
                            $selectedValue = old('likelihood', $record->likelihood);
                        @endphp
                        @foreach($allowedValues as $val)
                            <option value="{{ $val }}" {{ $selectedValue == $val ? 'selected' : '' }}>
                                {{ $val }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
            <label for="blank2" class="form-label fw-bold">Blank2 (NAme not known)</label>
            <input type="text" id="blank2" name="blank2" class="form-control" readonly
                value="{{ old('blank2', $record->blank2) }}">
        </div>

        

                <div class="mb-3">
            <label for="blank3" class="form-label fw-bold">Blank3 (NAme not known)</label>
            <input type="text" id="blank3" name="blank3" class="form-control" readonly
                value="{{ old('blank3', $record->blank2) }}">
        </div>

        <div class="mb-3">
    <label class="form-label fw-bold d-block">Inherent Risk Rating:</label>

    <div class="d-flex flex-column w-25">
        <div id="risk-high" class="impact-box">HIGH</div>
        <div id="risk-medium" class="impact-box">MEDIUM</div>
        <div id="risk-low" class="impact-box">LOW</div>
    </div>

    <input type="hidden" name="inherent_risk_rating" id="inherent_risk_rating" value="{{ old('inherent_risk_rating', $record->inherent_risk_rating) }}">
</div>


                 

                <div class="text-end">
                    <button class="btn btn-success" type="submit">Submit Risk Record</button>
                </div>
            </form>
        </div>
    </div>


    
        <div class="text-end">
            <a href="/initiate_residual_assessment_form/{{ $record->risk_id }}/{{ $project->project_id }}/{{ auth()->user()->id }}"
                class="btn btn-md mb-2 mt-4 fw-bold"
                style="background: linear-gradient(135deg, #70e292, #F09819); transition: 0.3s;">Initiate Residual Risk Assessment</a>
        </div>

</div> <!-- END .container -->

@section('scripts')

{{-- SweetAlert for success --}}
@if(Session::has('success'))
    <script>
        swal({
            title: "{{ Session::get('success') }}",
            icon: "success",
            closeOnClickOutside: true,
            timer: 3000,
        });
    </script>
@endif

{{-- 🔁 Global Function: Calculate Blank3 --}}
<script>
    function calculateBlank3() {
        const blank1 = parseFloat(document.getElementById('blank1')?.value) || 0;
        const blank2 = parseInt(document.getElementById('blank2')?.value) || 0;
        const product = (blank1 * blank2).toFixed(2);
        document.getElementById('blank3').value = isNaN(product) ? 0 : product;
        updateInherentRiskRating();
    }
</script>

{{-- 🎯 Likelihood Dropdown Logic for Blank2 --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const likelihoodDropdown = document.getElementById('likelihood');
        const blank2Input = document.getElementById('blank2');

        function updateBlank2FromLikelihood() {
            const value = likelihoodDropdown.value;
            let score = '';

            if (value === 'Low') score = 1;
            else if (value === 'Medium') score = 2;
            else if (value === 'High') score = 3;

            blank2Input.value = score;
            calculateBlank3(); // ⬅️ Trigger calculation after updating blank2
        }

        if (likelihoodDropdown) {
            likelihoodDropdown.addEventListener('change', updateBlank2FromLikelihood);
            updateBlank2FromLikelihood(); // Initial load
        }
    });
</script>

{{-- 📊 Business Impact Fields Calculation --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownIds = [
            'financial_impact',
            'criticality_on_revenue',
            'financial_ecosystem',
            'geog_service_devilery',
            'strategic_importance',
            'criticality_of_customer_base',
            'monthly_transactions',
            'reg_comp_obligations',
            'dependency_on_external_vendors'
        ];

        function calculateTotal() {
            let total = 0;
            let count = 0;

            dropdownIds.forEach(id => {
                const val = parseInt(document.getElementById(id)?.value || 0);
                if (!isNaN(val)) {
                    total += val;
                    count++;
                }
            });

            const average = count ? (total / count).toFixed(2) : 0;

            document.getElementById('total_impact_rating').value = total;
            document.getElementById('blank1').value = average;

            updateOverallImpact(total);

            // ⬅️ Now triggers blank3 update as well
            calculateBlank3();
        }

        function updateOverallImpact(total) {
            let overallImpact = '';

            if (total <= 14) {
                overallImpact = 'LOW';
            } else if (total > 20) {
                overallImpact = 'HIGH';
            } else {
                overallImpact = 'MEDIUM';
            }

            document.getElementById('overall_impact').value = overallImpact;

            ['high', 'medium', 'low'].forEach(type => {
                document.getElementById(`impact-${type}`).classList.remove(`active-${type}`);
            });

            const selected = overallImpact.toLowerCase();
            document.getElementById(`impact-${selected}`).classList.add(`active-${selected}`);
        }

        dropdownIds.forEach(id => {
            const dropdown = document.getElementById(id);
            if (dropdown) {
                dropdown.addEventListener('change', calculateTotal);
            }
        });

        calculateTotal(); // Initial load
    });
</script>

<script>
    function updateInherentRiskRating() {
    const blank3 = parseFloat(document.getElementById('blank3')?.value) || 0;
    let rating = '';

    if (blank3 <= 3) {
        rating = 'LOW';
    } else if (blank3 > 6) {
        rating = 'HIGH';
    } else {
        rating = 'MEDIUM';
    }

    document.getElementById('inherent_risk_rating').value = rating;

    ['high', 'medium', 'low'].forEach(type => {
        document.getElementById(`risk-${type}`).classList.remove(`active-${type}`);
    });

    document.getElementById(`risk-${rating.toLowerCase()}`).classList.add(`active-${rating.toLowerCase()}`);
}

</script>

@endsection


@endsection


