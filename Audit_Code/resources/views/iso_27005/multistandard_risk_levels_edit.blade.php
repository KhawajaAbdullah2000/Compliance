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



    {{-- Existing Risk Levels Table --}}
    @php
        // Maps to show readable names instead of IDs
        $threatMap = $global_threats->pluck('global_risk_source', 'qualitative_asset_based_risk_sources_id');
        $vulnMap   = $global_vulnerabilities->pluck('vulnerability_description', 'vul_desc_for_global_vul_id');
    @endphp

 


   <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
        <h4 class="mb-0">Edit Multistandard Risk Level</h4>
        <a href="{{ route('multistandard_risk_levels', ['proj_id' => $project->project_id, 'asset_id' => $asset->assessment_id]) }}"
           class="btn btn-secondary btn-sm">
            Back
        </a>
    </div>

     @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

     <div class="card">
        <div class="card-body">
            <form action="{{ route('multistandard_risk_levels.update', $risk->id) }}" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="project_id" value="{{ old('project_id', $risk->project_id) }}">
                <input type="hidden" name="asset_id" value="{{ old('asset_id', $risk->asset_id) }}">

                <div class="row mb-3">
                    {{-- Threat --}}
                    <div class="col-md-6">
                        <label class="form-label">Threat (Select)</label>
                        <select name="threat_selected" class="form-select">
                            <option value="">-- Select Threat --</option>
                            @foreach($global_threats as $threat)
                                <option value="{{ $threat->qualitative_asset_based_risk_sources_id }}"
                                    {{ old('threat_selected', $risk->threat_selected) == $threat->qualitative_asset_based_risk_sources_id ? 'selected' : '' }}>
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
                               value="{{ old('threat_free_text', $risk->threat_free_text) }}"
                               placeholder="Custom threat (optional)">
                        @error('threat_free_text')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Vulnerability --}}
                    <div class="col-md-6">
                        <label class="form-label">Vulnerability (Select)</label>
                        <select name="vulnerability_selected" class="form-select">
                            <option value="">-- Select Vulnerability --</option>
                            @foreach($global_vulnerabilities as $vul)
                                <option value="{{ $vul->vul_desc_for_global_vul_id }}"
                                    {{ old('vulnerability_selected', $risk->vulnerability_selected) == $vul->vul_desc_for_global_vul_id ? 'selected' : '' }}>
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
                               value="{{ old('vulnerability_free_text', $risk->vulnerability_free_text) }}"
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
                        <select name="threat_level" id="threat_level" class="form-select" required>
                            <option value="">-- Select --</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    {{ (int) old('threat_level', $risk->threat_level) === $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('threat_level')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Vulnerability Level --}}
                    <div class="col-md-4">
                        <label class="form-label">Vulnerability Level (1–5)</label>
                        <select name="vulnerability_level" id="vulnerability_level" class="form-select" required>
                            <option value="">-- Select --</option>
                            @for ($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}"
                                    {{ (int) old('vulnerability_level', $risk->vulnerability_level) === $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('vulnerability_level')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Risk Level (auto) --}}
                    <div class="col-md-4">
                        <label class="form-label">Risk Level (auto)</label>
                        <input type="number"
                               name="risk_level"
                               id="risk_level"
                               class="form-control"
                               value="{{ old('risk_level', $risk->risk_level) }}"
                               readonly>
                        <small class="text-muted">
                            Calculated as Threat Level × Vulnerability Level.
                        </small>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Risk Description (optional)</label>
                    <input type="text"
                           name="risk_description"
                           class="form-control"
                           value="{{ old('risk_description', $risk->risk_description) }}"
                           placeholder="Short description of the risk">
                    @error('risk_description')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        Update Risk Level
                    </button>
                </div>
            </form>
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

    // recompute once on load in case old() changed values
    updateRiskLevel();
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
