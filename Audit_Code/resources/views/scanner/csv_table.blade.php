@extends('master')

@section('content')

@include('user-nav')

<h3 class="fw-bold text-center mt-4">Scanner Results for : {{auth()->user()->organization->name}}</h3>

<div class="container">
{{-- Column Visibility Section --}}

<div class="mb-4">
    <div class="card border shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-bold">⚙️ Toggle Column Visibility</h6>
            <button type="button" id="selectAllBtn" class="btn btn-sm btn-outline-primary">
                Select All
            </button>
        </div>
        <div class="card-body py-2">
            <div class="d-flex flex-wrap gap-3">
                @foreach($headers as $index => $header)
                    <div class="form-check">
                        <input class="form-check-input column-toggle"
                               type="checkbox"
                               id="col_{{ $index }}"
                               data-col="{{ $index }}"
                               @if($loop->count - $index <= 20) checked @endif>
                        <label class="form-check-label small" for="col_{{ $index }}">
                            {{ $header }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover" id="csvTable">
            <thead class="table-dark">
                <tr>
                    @foreach($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($values as $row)
                    <tr>
                        @foreach($row as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const table = document.getElementById("csvTable");
    const checkboxes = document.querySelectorAll(".column-toggle");
    const selectAllBtn = document.getElementById("selectAllBtn");

    // Initialize table based on checked state
    checkboxes.forEach(cb => toggleColumn(table, cb.dataset.col, !cb.checked));

    // Toggle visibility on change
    checkboxes.forEach(cb => {
        cb.addEventListener("change", function () {
            toggleColumn(table, this.dataset.col, !this.checked);
        });
    });

    // Select All / Deselect All
    selectAllBtn.addEventListener("click", function () {
        // Check if all are already selected (checked = hidden)
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);

        checkboxes.forEach(cb => {
            cb.checked = !allChecked; // toggle state
            toggleColumn(table, cb.dataset.col, !cb.checked);
        });

        // Update button text
        this.textContent = allChecked ? "Select All" : "Deselect All";
    });

    function toggleColumn(table, colIndex, show) {
        let rows = table.rows;
        for (let i = 0; i < rows.length; i++) {
            let cell = rows[i].cells[colIndex];
            if (cell) {
                cell.style.display = show ? "" : "none";
            }
        }
    }
});
</script>
@endsection
