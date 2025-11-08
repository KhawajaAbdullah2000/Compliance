@extends('master')

@section('content')
@include('user-nav')

<div class="container my-2">
    <h3 class="fw-bold mt-4">Service/Asset register for {{ $organizationData->name }}</h3>

  
   <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
    <h3 class="fw-bold m-0">Service/Asset register for {{ $organizationData->name }}</h3>
    <a class="btn btn-success btn-md"
       href="/service_register_new_form/{{ auth()->user()->organization->id }}/{{ auth()->user()->id }}"
       role="button">
       Enter Service or Asset <i class="fas fa-plus"></i>
    </a>
</div>

<div class="mb-3">
    <label class="fw-bold me-2">Toggle Columns:</label>
    @php
        $columns = [
            'Service','Asset Type','Asset SubType','Asset Component',
            'Risk Confidentiality','Risk Integrity','Risk Availability',
            'Owner Dept','Physical Location','Logical Location',
            'Service Risk Owner','Component Risk Owner','Service Custodian','Component Custodian','Actions','Asset Component History'
        ];

            $hiddenByDefault = [7, 8, 9, 10, 11, 12, 13]; 

    @endphp

@foreach ($columns as $index => $col)
    <div class="form-check form-check-inline">
        <input class="form-check-input toggle-column"
               type="checkbox"
               id="col-{{ $index }}"
               data-column="{{ $index }}"
               {{ in_array($index, $hiddenByDefault) ? '' : 'checked' }}>
        <label class="form-check-label" for="col-{{ $index }}">{{ $col }}</label>
    </div>
@endforeach
</div>



   <!-- Responsive Table Wrapper -->
<div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
    <table id="myTable2" class="table table-bordered table-hover table-striped text-center align-middle">
        <thead class="table-secondary">
            <tr style="cursor: pointer; white-space: nowrap;">
                <th onclick="sortTable(0)">Service</th>
                <th onclick="sortTable(1)">Asset Type</th>
                <th onclick="sortTable(2)">Asset SubType</th>
                <th onclick="sortTable(3)">Asset Component</th>
                <th onclick="sortTable(4)">Risk Confidentiality</th>
                <th onclick="sortTable(5)">Risk Integrity</th>
                <th onclick="sortTable(6)">Risk Availability</th>
                <th onclick="sortTable(7)">Owner Dept</th>
                <th onclick="sortTable(8)">Physical Location</th>
                <th onclick="sortTable(9)">Logical Location</th>
                <th onclick="sortTable(10)">Service Risk Owner</th>
                <th onclick="sortTable(11)">Component Risk Owner</th>
                <th onclick="sortTable(12)">Service Custodian</th>
                <th onclick="sortTable(13)">Component Custodian</th>
                <th>Actions</th>
                <th>Asset Component History</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $d)
            <tr class="service-row"
                data-service="{{ $d->s_name }}"
                data-group="{{ $d->g_name }}"
                data-name="{{ $d->name }}"
                data-c_name="{{ $d->c_name }}">
                <td>{{ $d->s_name }}</td>
                <td>{{ $d->g_name }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->c_name }}</td>
                <td>{{ $d->risk_confidentiality }}</td>
                <td>{{ $d->risk_integrity }}</td>
                <td>{{ $d->risk_availability }}</td>
                <td>{{ $d->owner_dept }}</td>
                <td>{{ $d->physical_loc }}</td>
                <td>{{ $d->logical_loc }}</td>
                <td>{{ $d->service_risk_owner_name }}</td>
                <td>{{ $d->component_risk_owner_name }}</td>
                <td>{{ $d->service_custodian_name }}</td>
                <td>{{ $d->component_custodian_name }}</td>
                <td>
                    <a href="/asset_catalog_2_1_edit/{{ $d->id }}/{{ auth()->user()->organization->id }}/{{ auth()->user()->id }}">
                        <i class="fas fa-edit text-success"></i>
                    </a>
                    <a href="/asset_catalog_2_1_delete/{{ $d->id }}/{{ auth()->user()->id }}">
                        <i class="fas fa-trash text-danger"></i>
                    </a>
                </td>
                <td>
                      <a href="/asset_component_history_main/{{ $d->id }}/{{ auth()->user()->id }}">
           <i class="bi bi-clock-fill fs-3"></i> 
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


    <div class="mt-4">
        <a href="{{ route('download_asset_template') }}" class="text-decoration-underline text-primary">
            Download Excel Template
        </a>

        <form action="/upload_org_global_assets/{{ auth()->user()->organization->id }}"
              method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            <div class="form-group col-md-3">
                <label for="file" class="form-label fw-bold">Upload a Populated Excel Sheet</label>
                <input type="file" name="file" id="file" class="form-control">
                @error('file')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-success btn-sm rounded-pill mt-2">Upload</button>
        </form>
    </div>
</div>

@section('scripts')

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

@if (Session::has('error'))
<script>
swal({
    title: "{{ Session::get('error') }}",
    icon: "error",
    closeOnClickOutside: true,
    timer: 6000,
});
</script>
@endif

<!-- ✅ Sort Table Function (Now includes Risk Columns) -->
<script>
function sortTable(n) {
    var table = document.getElementById("myTable2");
    var rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    switching = true;
    dir = "asc";

    while (switching) {
        switching = false;
        rows = table.rows;
        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            x = rows[i].getElementsByTagName("TD")[n];
            y = rows[i + 1].getElementsByTagName("TD")[n];
            if (dir == "asc") {
                if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            } else if (dir == "desc") {
                if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                    shouldSwitch = true;
                    break;
                }
            }
        }
        if (shouldSwitch) {
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            if (switchcount == 0 && dir == "asc") {
                dir = "desc";
                switching = true;
            }
        }
    }
}
</script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.toggle-column').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var colIndex = this.getAttribute('data-column');
            var table = document.getElementById("myTable2");
            for (var i = 0; i < table.rows.length; i++) {
                if (table.rows[i].cells[colIndex]) {
                    table.rows[i].cells[colIndex].style.display = this.checked ? '' : 'none';
                }
            }
        });

        // ✅ Apply the visibility state immediately when page loads
        checkbox.dispatchEvent(new Event('change'));
    });
});
</script>





@endsection
@endsection
