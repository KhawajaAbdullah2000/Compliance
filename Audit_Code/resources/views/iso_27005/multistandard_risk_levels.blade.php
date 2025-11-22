@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>


<h4>Risk Assessment Applicable to</h4>
    @include('components.asset-summary_component', ['asset' => $asset])


    <div class="col-12">
        @include('components.consequence_of_loss', ['asset' => $asset,'project'=>$project])
    </div>



<p class="fs-4">Likelihood of adverse events that could cause compromise of Confidentiality , Integrity and Availability
of information</p>

{{-- Page Title + Add New Button --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
       
        <button class="btn btn-success btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#addRiskLevelForm">
            + Add New
        </button>
    </div>

    {{-- Add New Risk Level Form (collapsible) --}}
    <div class="collapse mb-4" id="addRiskLevelForm">
        <div class="card">
            <div class="card-body">
               <form action="{{ route('multistandard_risk_levels.store') }}" method="POST">
    @csrf

    {{-- Project & Asset IDs --}}
    <input type="hidden" name="project_id" value="{{ $project->project_id }}">
    <input type="hidden" name="asset_id" value="{{ $asset->assessment_id }}">

    <div class="row mb-3">
        {{-- Threat (dropdown + free text) --}}
        <div class="col-md-6">
            <label class="form-label">Threat (Select)</label>

            <select name="threat_selected" class="form-select">
                <option value="">-- Select Threat --</option>
                @foreach($global_threats as $threat)
                    <option value="{{ $threat->qualitative_asset_based_risk_sources_id }}"
                        {{ old('threat_selected') == $threat->qualitative_asset_based_risk_sources_id ? 'selected' : '' }}>
                        {{ $threat->global_risk_source }}
                    </option>
                @endforeach
            </select>

            @error('threat_selected')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

            <small class="text-muted">Or type a custom threat below.</small>

            <input type="text"
                   name="threat_free_text"
                   class="form-control mt-2"
                   value="{{ old('threat_free_text') }}"
                   placeholder="Custom threat (optional)">

            @error('threat_free_text')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Vulnerability (dropdown + free text) --}}
        <div class="col-md-6">
            <label class="form-label">Vulnerability (Select)</label>

            <select name="vulnerability_selected" class="form-select">
                <option value="">-- Select Vulnerability --</option>
                @foreach($global_vulnerabilities as $vul)
                    <option value="{{ $vul->vul_desc_for_global_vul_id }}"
                        {{ old('vulnerability_selected') == $vul->vul_desc_for_global_vul_id ? 'selected' : '' }}>
                        {{ $vul->vulnerability_description }}
                    </option>
                @endforeach
            </select>

            @error('vulnerability_selected')
                <div class="text-danger small">{{ $message }}</div>
            @enderror

            <small class="text-muted">Or type a custom vulnerability below.</small>

            <input type="text"
                   name="vulnerability_free_text"
                   class="form-control mt-2"
                   value="{{ old('vulnerability_free_text') }}"
                   placeholder="Custom vulnerability (optional)">

            @error('vulnerability_free_text')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="row mb-3">
        {{-- Threat Level --}}
        <div class="col-md-4">
            <label class="form-label">Threat Level (1–5)</label>

            <select name="threat_level" id="threat_level" class="form-select">
                <option value="">-- Select --</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('threat_level') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>

            @error('threat_level')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Vulnerability Level --}}
        <div class="col-md-4">
            <label class="form-label">Vulnerability Level (1–5)</label>

            <select name="vulnerability_level" id="vulnerability_level" class="form-select">
                <option value="">-- Select --</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}" {{ old('vulnerability_level') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>

            @error('vulnerability_level')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        {{-- Risk Level --}}
        <div class="col-md-4">
            <label class="form-label">Risk Level (auto)</label>

            <input type="number"
                   name="risk_level"
                   id="risk_level"
                   class="form-control"
                   value="{{ old('risk_level') }}"
                   readonly>

            <small class="text-muted">Calculated as Threat Level × Vulnerability Level.</small>

            @error('risk_level')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="mb-3">
        <label class="form-label">Risk Description (optional)</label>

        <input type="text"
               name="risk_description"
               class="form-control"
               value="{{ old('risk_description') }}"
               placeholder="Short description of the risk">

        @error('risk_description')
            <div class="text-danger small">{{ $message }}</div>
        @enderror
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-success">
            Save Risk Level
        </button>
    </div>
</form>

            </div>
        </div>
    </div>

    {{-- Existing Risk Levels Table --}}
    @php
        // Maps to show readable names instead of IDs
        $threatMap = $global_threats->pluck('global_risk_source', 'qualitative_asset_based_risk_sources_id');
        $vulnMap   = $global_vulnerabilities->pluck('vulnerability_description', 'vul_desc_for_global_vul_id');
    @endphp

    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-3">Existing Risk Levels</h5>

            @if($existing_multistandard_risk_levels->isEmpty())
                <p class="text-muted mb-0">No risk levels defined yet for this asset.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Threat</th>
                                <th>Vulnerability</th>
                                <th>Threat Level</th>
                                <th>Vulnerability Level</th>
                                <th>Risk Level</th>
                                <th>Risk Description</th>
                                <th style="width: 140px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($existing_multistandard_risk_levels as $index => $risk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    {{-- Threat display: lookup name or free text or ID --}}
                                    <td>
                                        @if($risk->threat_selected && isset($threatMap[$risk->threat_selected]))
                                            {{ $threatMap[$risk->threat_selected] }}
                                        @elseif(!empty($risk->threat_free_text))
                                            {{ $risk->threat_free_text }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    {{-- Vulnerability display --}}
                                    <td>
                                        @if($risk->vulnerability_selected && isset($vulnMap[$risk->vulnerability_selected]))
                                            {{ $vulnMap[$risk->vulnerability_selected] }}
                                        @elseif(!empty($risk->vulnerability_free_text))
                                            {{ $risk->vulnerability_free_text }}
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>

                                    <td>{{ $risk->threat_level }}</td>
                                    <td>{{ $risk->vulnerability_level }}</td>
                                    <td>{{ $risk->risk_level }}</td>
                                    <td>{{ $risk->risk_description ?? '—' }}</td>
                                      <td>
                                    <a href="{{ route('multistandard_risk_levels.edit', $risk->id) }}"
                                       class="btn btn-sm btn-outline-primary mb-1">
                                        Edit
                                    </a>

                                    <form action="{{ route('multistandard_risk_levels.destroy', $risk->id) }}"
                                          method="POST"
                                          style="display:inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete this risk level?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>







</div>

@section('scripts')

<script>
    function updateRiskLevel() {
        const t = parseInt(document.getElementById('threat_level').value);
        const v = parseInt(document.getElementById('vulnerability_level').value);
        const riskField = document.getElementById('risk_level');

        if (!isNaN(t) && !isNaN(v)) {
            riskField.value = t * v;
        } else {
            riskField.value = '';
        }
    }

    document.getElementById('threat_level')?.addEventListener('change', updateRiskLevel);
    document.getElementById('vulnerability_level')?.addEventListener('change', updateRiskLevel);
</script>


@if(Session::has('success'))
<script>
    swal({
        title: "{{Session::get('success')}}"
        , icon: "success"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif



@endsection

@endsection
