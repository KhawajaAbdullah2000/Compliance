@extends('master')

@section('content')

@include('user-nav')

@php
$permissions = json_decode($project_permissions);
@endphp

<div class="container">
    <!-- Project Details -->
    <div class="row mt-5 mb-4">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>



    <!-- Form Section -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-warning text-white text-center">
                    <h3 class="mb-0">Edit Service and/or Asset Data</h3>
                    <small class="text-danger fw-bold d-block mt-2">
                        <i class="fas fa-exclamation-triangle"></i> Editing this will override the previous values.
                    </small>
                </div>
                <div class="card-body p-5">
                    <form action="/iso_sec_2_1_submit_edit/{{ $data->assessment_id }}/{{ $data->project_id }}/{{ auth()->user()->id }}" method="post">
                        @csrf
                        @method('PUT')

                        <!-- Service Name -->
                        <div class="mb-4">
                            <label for="s_name" class="form-label fw-semibold">Service Name</label>
                            <input type="text" name="s_name" id="s_name" class="form-control rounded-pill" value="{{ old('s_name', $data->s_name) }}">
                            @if($errors->has('s_name'))
                            <div class="text-danger small mt-2">{{ $errors->first('s_name') }}</div>
                            @endif
                        </div>

             
                        
<!-- Asset Category -->
<div class="mb-4">
    <label for="asset_category" class="form-label fw-semibold">Asset Type</label>
    <select name="g_name" id="asset_category" class="form-control">
        <option value="None">None</option>
        @foreach($selectedCategories as $category)
            <option value="{{ $category->asset_category }}" 
                {{ $category->asset_category == $selected_category ? 'selected' : '' }}>
                {{ $category->asset_category }}
            </option>
        @endforeach
    </select>
</div>

<!-- Asset SubType -->
<div class="mb-4">
    <label for="asset_type" class="form-label fw-semibold">Asset Subtype</label>
    <select name="name" id="asset_type" class="form-control">
        <option value="None">None</option> <!-- default -->
        <!-- Options will be dynamically loaded -->
    </select>
</div>
                    

                        <!-- Asset Component Name -->
                        <div class="mb-4">
                            <label for="c_name" class="form-label fw-semibold">Asset Component Name</label>
                            <input type="text" name="c_name" id="c_name" class="form-control rounded-pill" value="{{ old('c_name', $data->c_name) }}">
                            @if($errors->has('c_name'))
                            <div class="text-danger small mt-2">{{ $errors->first('c_name') }}</div>
                            @endif
                        </div>

                        <!-- Asset Owner Sub-Organization -->
                        <div class="mb-4">
                            <label for="owner_dept" class="form-label fw-semibold">Asset Owner Dept</label>
                            <input type="text" name="owner_dept" id="owner_dept" class="form-control rounded-pill" value="{{ old('owner_dept', $data->owner_dept) }}">
                            @if($errors->has('owner_dept'))
                            <div class="text-danger small mt-2">{{ $errors->first('owner_dept') }}</div>
                            @endif
                        </div>

                        <!-- Asset Physical Location -->
                        <div class="mb-4">
                            <label for="physical_loc" class="form-label fw-semibold">Asset Physical Location</label>
                            <input type="text" name="physical_loc" id="physical_loc" class="form-control rounded-pill" value="{{ old('physical_loc', $data->physical_loc) }}">
                            @if($errors->has('physical_loc'))
                            <div class="text-danger small mt-2">{{ $errors->first('physical_loc') }}</div>
                            @endif
                        </div>

                        <!-- Asset Logical Location -->
                        <div class="mb-4">
                            <label for="logical_loc" class="form-label fw-semibold">Asset Logical Location</label>
                            <input type="text" name="logical_loc" id="logical_loc" class="form-control rounded-pill" value="{{ old('logical_loc', $data->logical_loc) }}">
                            @if($errors->has('logical_loc'))
                            <div class="text-danger small mt-2">{{ $errors->first('logical_loc') }}</div>
                            @endif
                        </div>

                        <div class="mb-4">
    <label for="service_risk_owner" class="form-label fw-semibold">Service Risk Owner</label>
    <select name="service_risk_owner" class="form-select">
        @foreach($users as $user)
            <option value=""></option>
            <option value="{{ $user->id }}" {{ $data->service_risk_owner == $user->id ? 'selected' : '' }}>
                {{ $user->first_name }} {{ $user->last_name }}
            </option>
        @endforeach
    </select>
    @if($errors->has('service_risk_owner'))
        <div class="text-danger small mt-2">{{ $errors->first('service_risk_owner') }}</div>
    @endif
</div>

<div class="mb-4">
    <label for="component_risk_owner" class="form-label fw-semibold">Asset Component Risk Owner</label>
    <select name="component_risk_owner" class="form-select">
        @foreach($users as $user)
             <option value=""></option>
            <option value="{{ $user->id }}" {{ $data->component_risk_owner == $user->id ? 'selected' : '' }}>
                {{ $user->first_name }} {{ $user->last_name }}
            </option>
        @endforeach
    </select>
    @if($errors->has('component_risk_owner'))
        <div class="text-danger small mt-2">{{ $errors->first('component_risk_owner') }}</div>
    @endif
</div>

<div class="mb-4">
    <label for="service_custodian" class="form-label fw-semibold">Service Custodian</label>
    <select name="service_custodian" class="form-select">
        @foreach($users as $user)
                <option value=""></option>
            <option value="{{ $user->id }}" {{ $data->service_custodian == $user->id ? 'selected' : '' }}>
                {{ $user->first_name }} {{ $user->last_name }}
            </option>
        @endforeach
    </select>
    @if($errors->has('service_custodian'))
        <div class="text-danger small mt-2">{{ $errors->first('service_custodian') }}</div>
    @endif
</div>

<div class="mb-4">
    <label for="component_custodian" class="form-label fw-semibold">Asset Component Custodian</label>
    <select name="component_custodian" class="form-select">
        @foreach($users as $user)
                  <option value=""></option>
            <option value="{{ $user->id }}" {{ $data->component_custodian == $user->id ? 'selected' : '' }}>
                {{ $user->first_name }} {{ $user->last_name }}
            </option>
        @endforeach
    </select>
    @if($errors->has('component_custodian'))
        <div class="text-danger small mt-2">{{ $errors->first('component_custodian') }}</div>
    @endif
</div>


                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')

<script>
    $(document).ready(function () {
        const assetTypeDropdown = $('#asset_type');
        const selectedCategory = $('#asset_category').val();
        const selectedType = "{{ $selected_type ?? '' }}"; // comes from controller

        function loadAssetTypes(categoryName, preselect = null) {
            assetTypeDropdown.empty();
            assetTypeDropdown.append('<option value="None">None</option>');

            if (categoryName && categoryName !== "None") {
                $.ajax({
                    url: '/get-asset-types/' + categoryName,
                    type: 'GET',
                    success: function (data) {
                        data.forEach(function (type) {
                            const isSelected = type.asset_type === preselect ? 'selected' : '';
                            assetTypeDropdown.append(
                                `<option value="${type.asset_type}" ${isSelected}>${type.asset_type}</option>`
                            );
                        });
                    },
                    error: function () {
                        assetTypeDropdown.append('<option value="">Error loading types</option>');
                    }
                });
            }
        }

        // On category change
        $('#asset_category').on('change', function () {
            const categoryId = $(this).val();
            loadAssetTypes(categoryId);
        });

        // On page load (for edit form only)
        @if(isset($selected_category) && isset($selected_type))
            loadAssetTypes("{{ $selected_category }}", "{{ $selected_type }}");
        @endif
    });
</script>


@endsection

@endsection

