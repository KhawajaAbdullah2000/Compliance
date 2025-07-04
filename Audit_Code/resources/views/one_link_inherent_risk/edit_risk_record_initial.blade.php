
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

    
   <div class="col-12 col-md-4 col-lg-3">
    <div class="p-3 text-white text-center rounded shadow"
         style="background: linear-gradient(135deg, #FF512F, #DD2476);">
        <h5 class="fw-bold mb-0">Risk Identification and Classification</h5>
    </div>
</div>


 <div class="card shadow-lg w-100 justify-content-center col-lg-8">
    <div class="card-header bg-dark text-white">
        <h5 class="mb-0">Edit Risk Record</h5>
    </div>

    <div class="card-body">
        <form action="/edit_initial_risk_record/{{ $project->project_id }}/{{ auth()->user()->organization->id }}/{{ auth()->user()->id }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $record->risk_id }}">

            <!-- Risk Identification Date -->
            <div class="mb-3">
                <label for="risk_identification_date" class="form-label">Date of Risk Identification</label>
                <input class="form-control" type="date" name="risk_identification_date" id="risk_identification_date"
                       value="{{ old('risk_identification_date', $record->risk_identification_date) }}">
            </div>

            <!-- Risk Reassessment Date -->
            <div class="mb-3">
                <label for="risk_reassessment_date" class="form-label">Date of Risk Reassessment</label>
                <input class="form-control" type="date" name="risk_reassessment_date" id="risk_reassessment_date"
                       value="{{ old('risk_reassessment_date', $record->risk_reassessment_date) }}">
            </div>

            <!-- Department -->
            <div class="mb-3">
                <label for="department_id" class="form-label">Department</label>
                <select name="department_id" id="department_id" class="form-select" required>
                    <option value="">-- Select Department --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $record->department_id) == $dept->id ? 'selected' : '' }}>
                            {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Unit -->
            <div class="mb-3">
                <label for="unit_id" class="form-label">Unit</label>
                <select name="unit_id" id="unit_id" class="form-select" required>
                    <option value="">-- Select Unit --</option>
                    @foreach($units as $unit)
                        <option value="{{ $unit->id }}" {{ old('unit_id', $record->unit_id) == $unit->id ? 'selected' : '' }}>
                            {{ $unit->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Product -->
            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select name="product_id" id="product_id" class="form-select" required>
                    <option value="">-- Select Product --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $record->product_id) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Cycle -->
            <div class="mb-3">
                <label for="cycle_id" class="form-label">Cycle</label>
                <select name="cycle_id" id="cycle_id" class="form-select" required>
                    <option value="">-- Select Cycle --</option>
                    @foreach($cycles as $cycle)
                        <option value="{{ $cycle->id }}" {{ old('cycle_id', $record->cycle_id) == $cycle->id ? 'selected' : '' }}>
                            {{ $cycle->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sub-Process -->
            <div class="mb-3">
                <label for="sub_process_id" class="form-label">Sub-Process</label>
                <select name="sub_process_id" id="sub_process_id" class="form-select" required>
                    <option value="">-- Select Sub-Process --</option>
                    @foreach($sub_processes as $sub)
                        <option value="{{ $sub->id }}" {{ old('sub_process_id', $record->sub_process_id) == $sub->id ? 'selected' : '' }}>
                            {{ $sub->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="text-end">
                <button class="btn btn-success" type="submit">Submit Risk Record</button>
            </div>
        </form>
    </div>
</div>




</div>





        @section('scripts')

        <script>
    $(document).ready(function () {
        $('#department_id').on('change', function () {
            var deptId = $(this).val();
            $('#unit_id').html('<option value="">Loading...</option>');

            if (deptId) {
                $.ajax({
                    url: '/get-units-by-department/' + deptId,
                    method: 'GET',
                    success: function (units) {
                        var options = '<option value="">-- Select Unit --</option>';
                        units.forEach(function (unit) {
                            options += `<option value="${unit.id}">${unit.name}</option>`;
                        });
                        $('#unit_id').html(options);
                    },
                    error: function () {
                        $('#unit_id').html('<option value="">Error loading units</option>');
                    }
                });
            } else {
                $('#unit_id').html('<option value="">-- Select Unit --</option>');
            }
        });
    });
</script>


        @endsection


@endsection