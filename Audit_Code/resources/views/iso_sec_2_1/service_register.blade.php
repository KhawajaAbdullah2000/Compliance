@extends('master')

@section('content')

@include('user-nav')


<div class="container my-2">

    <h3 class="fw-bold mt-4">Service/Asset register for {{$organizationData->name}}</h3>

    <a class="btn btn-success btn-md float-end mb-2 mt-4" href="/service_register_new_form/{{ auth()->user()->organization->id }}/{{auth()->user()->id}}" role="button">Enter Service or
        Asset
        <i class="fas fa-plus"></i></a>

    <!-- Data Table -->
    <table id="myTable2" class="table table-bordered table-hover table-striped align-middle">
        <thead class="table-dark ">
            <tr style="cursor: pointer" class="text-center">
                <th onclick="sortTable(0)">Service</th>
                <th onclick="sortTable(1)">Asset Type</th>
                <th onclick="sortTable(2)">Asset SubType</th>
                <th onclick="sortTable(3)">Asset Component</th>
                <th onclick="sortTable(4)">Asset Component Owner Dept</th>
                <th onclick="sortTable(5)">Asset Component Physical Location</th>
                <th onclick="sortTable(6)">Asset Component Logical Location</th>
                <th onclick="sortTable(7)">Service Risk Owner</th>
                <th onclick="sortTable(8)">Asset Component Risk Owner</th>
                <th onclick="sortTable(9)">Service Custodian</th>
                <th onclick="sortTable(10)">Asset Component Custodian</th>
                <th>Actions</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr class="service-row" data-service="{{ $d->s_name }}" data-group="{{ $d->g_name }}" data-name="{{ $d->name }}" data-c_name="{{ $d->c_name }}">
                <td>{{ $d->s_name }}</td>
                <td>{{ $d->g_name }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->c_name }}</td>
                <td>{{ $d->owner_dept }}</td>
                <td>{{ $d->physical_loc }}</td>
                <td>{{ $d->logical_loc }}</td>
                <td>{{ $d->service_risk_owner_name }}</td>
                <td>{{ $d->component_risk_owner_name }}</td>
                <td>{{ $d->service_custodian_name }}</td>
                <td>{{ $d->component_custodian_name }}</td>
                <td> <a href="/asset_catalog_2_1_edit/{{ $d->id }}/{{auth()->user()->organization->id}}/{{ auth()->user()->id }}">
                        <i class="fas fa-edit text-success"></i>
                    </a>
                    <a href="/asset_catalog_2_1_delete/{{ $d->id }}/{{ auth()->user()->id }}">
                        <i class="fas fa-trash text-danger"></i>
                    </a></td>


            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        <a href="{{ route('download_asset_template') }}" class="text-decoration-underline text-primary">Download
            Excel Template</a>
        <form action="/upload_org_global_assets/{{ auth()->user()->organization->id }}" method="POST" enctype="multipart/form-data" class="mt-3">
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

{{-- @section('scripts') --}}
{{-- @if (Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}"
        , icon: "success"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif

@if (Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 6000
    , });

</script>
@endif --}}

@section('scripts')
@if (Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}"
        , icon: "success"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif

@if (Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 6000
    , });

</script>
@endif

<script>
    document.getElementById('fileLabel').addEventListener('click', function() {
        document.getElementById('file').click();
    });

    function displayFileName(input) {
        var fileNameElement = document.getElementById('fileName');
        fileNameElement.innerHTML = input.files[0].name;
    }

</script>

<script>
    function sortTable(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("myTable2");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }

</script>

<script>
    $(document).ready(function() {
        function filterRows() {
            var selectedService = $('#s_name').val();
            var selectedGroup = $('#g_name').val();
            var selectedName = $('#name').val();
            var selectedComponent = $('#c_name').val();


            $('.service-row').each(function() {
                var service = $(this).data('service');
                var group = $(this).data('group');
                var name = $(this).data('name');
                var c_name = $(this).data('c_name');
                var showRow = true;

                // Check if the row matches the selected service (if any)
                if (selectedService && service !== selectedService) {
                    showRow = false;
                }

                // Check if the row matches the selected group (if any)
                if (selectedGroup && group !== selectedGroup) {
                    showRow = false;
                }

                if (selectedName && name !== selectedName) {
                    showRow = false;
                }

                if (selectedComponent && c_name !== selectedComponent) {
                    showRow = false;
                }


                // Show or hide the row based on the above conditions
                if (showRow) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }

        // Listen for changes in the service filter
        $('#s_name').on('change', function() {
            filterRows();
        });

        // Listen for changes in the group filter
        $('#g_name').on('change', function() {
            filterRows();
        });

        $('#name').on('change', function() {
            filterRows();
        });

        $('#c_name').on('change', function() {
            filterRows();
        });
    });

</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('myTable2');
        const checkboxes = document.querySelectorAll('.toggle-column');

        // Function to toggle column visibility
        function toggleColumn(column, isVisible) {
            const display = isVisible ? '' : 'none';
            for (let i = 0; i < table.rows.length; i++) {
                table.rows[i].cells[column].style.display = display;
            }
        }

        // Initialize column visibility based on saved state or default
        checkboxes.forEach(function(checkbox) {
            const column = checkbox.getAttribute('data-column');
            const isVisible = localStorage.getItem(`column_${column}`) === 'false' ? false :
                true; // Default to visible
            checkbox.checked = !isVisible; // Checkbox unchecked by default for visible columns
            toggleColumn(column, isVisible);
        });

        // Add event listener for each checkbox
        checkboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                const column = this.getAttribute('data-column');
                const isVisible = !this.checked; // Invert the checkbox state for visibility
                toggleColumn(column, isVisible);

                // Save state to localStorage
                localStorage.setItem(`column_${column}`, isVisible);
            });
        });
    });

</script>



@endsection

@endsection
