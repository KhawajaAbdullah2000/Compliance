@extends('master')

@section('content')

@include('user-nav')

<div class="container mt-5">
    <h4 class="fw-bold mb-4">Select the Control Domains to View Statement of Applicability (SOA)</h4>

    <form action="/show_soa/{{$project->project_id}}/{{auth()->user()->id}}" method="POST">
        @csrf

        {{-- Control Domains --}}
        <div class="mb-3">
            <input type="checkbox" id="selectAll" class="form-check-input me-2">
            <label for="selectAll" class="form-check-label fw-bold">
                Select all control domains
            </label>
        </div>

        <div class="d-flex flex-column gap-2 mb-5">
            @foreach($titles as $number => $title)
            <div class="d-flex align-items-center col-6">
                <input type="checkbox" name="selected_titles[]" value="{{ $number }}" 
                       class="form-check-input me-3 item-checkbox" id="checkbox-{{ $number }}" checked>

                <label for="checkbox-{{ $number }}" class="btn btn-warning w-100 text-start fw-bold rounded-pill shadow-sm">
                    {{ $number }}. {{ $title }}
                </label>
            </div>
            @endforeach
        </div>

        {{-- Asset Selection --}}
        <div class="mt-4 fs-4 fw-bold"><p>Select an Asset</p></div>

        <table class="table table-bordered table-hover text-center table-secondary align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Select</th>
                    <th>Service</th>
                    <th>Asset Type</th>
                    <th>Asset Subtype</th>
                    <th>Asset Component</th>
                    <th>Owner Dept</th>
                    <th>Physical Loc</th>
                    <th>Logical Loc</th>
                    <th>Service Risk Owner</th>
                    <th>Component Risk Owner</th>
                    <th>Service Custodian</th>
                    <th>Component Custodian</th>
                </tr>
            </thead>
            <tbody>
               @foreach($assets as $asset)
               <tr>
                    <td>
                        <input class="form-check-input" type="radio" name="selected_asset" value="{{ $asset->assessment_id }}" required>
                    </td>
                    <td>{{ $asset->s_name }}</td>
                    <td>{{ $asset->g_name }}</td>
                    <td>{{ $asset->name }}</td>
                    <td>{{ $asset->c_name }}</td>
                    <td>{{ $asset->owner_dept }}</td>
                    <td>{{ $asset->physical_loc }}</td>
                    <td>{{ $asset->logical_loc }}</td>
                    <td>{{ $asset->service_risk_owner_name }}</td>
                    <td>{{ $asset->component_risk_owner_name }}</td>
                    <td>{{ $asset->service_custodian_name }}</td>
                    <td>{{ $asset->component_custodian_name }}</td>
                </tr>
               @endforeach
            </tbody>
        </table>

        {{-- Submit Button --}}
        <div class="text-end mt-4">
            <button type="submit" class="btn btn-success px-5 mb-2">Submit</button>
        </div>

    </form>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.item-checkbox');

        // Default: all checkboxes checked
        selectAll.checked = true;

        selectAll.addEventListener('change', function () {
            checkboxes.forEach(cb => cb.checked = this.checked);
        });

        checkboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                selectAll.checked = [...checkboxes].every(cb => cb.checked);
            });
        });
    });
</script>
@endsection
