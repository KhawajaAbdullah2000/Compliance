
@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')


@php
$permissions = json_decode($project_permissions);
@endphp

<div class="container my-2">


    <!-- Project Details Table -->
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{ $project->project_id }}/{{ auth()->user()->id }}">
                                {{ $project->project_name }}
                            </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{ $project->type }}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{ auth()->user()->organization->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{ $project->status }}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{ auth()->user()->organization->sub_org }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <h2 class="text-center fw-bold mb-4">Services & Assets</h2>

    <!-- Service and Asset Management Section -->
    {{-- <h4 class="text-center fw-bold mb-4">Upload or Enter Services and Assets in Scope</h4>

    @if ($org_projects->count() > 0 && in_array('Data Inputter', $permissions))
    <div class="mb-5">
        <form action="/copy_assets/{{ $project_id }}/{{ auth()->user()->id }}" method="get" class="d-flex align-items-center">
            <div class="form-group w-50">
                <label for="project_to_copy" class="form-label fw-semibold">Copy Service or Asset from</label>
                <select class="form-select rounded-pill" name="project_to_copy">
                    @foreach ($org_projects as $proj)
                    <option value="{{ $proj->project_id }}" {{ old('project_to_copy') == $proj->project_id ? 'selected' : '' }}>
                        {{ $proj->project_name }}
                    </option>
                    @endforeach
                </select>
                @if ($errors->has('project_to_copy'))
                <div class="text-danger small mt-2">{{ $errors->first('project_to_copy') }}</div>
                @endif
            </div>
            <button type="submit" class="btn btn-success btn-sm rounded-pill ms-3">Copy</button>
        </form>
    </div>
    @endif --}}

    <!-- Filtering Section -->
    <div class="row mt-4 mb-4">
        <div class="col-md-3">
            <label for="s_name" class="form-label fw-semibold">Select Service</label>
            <select id="s_name" name="s_name" class="form-select rounded-pill">
                <option value="">Select --</option>
                @foreach($distinctServices as $d)
                <option value="{{ $d->s_name }}">{{ $d->s_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="g_name" class="form-label fw-semibold">Select Group</label>
            <select id="g_name" name="g_name" class="form-select rounded-pill">
                <option value="">Select --</option>
                @foreach($distinctGroups as $d)
                <option value="{{ $d->g_name }}">{{ $d->g_name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="name" class="form-label fw-semibold">Select Asset</label>
            <select id="name" name="name" class="form-select rounded-pill">
                <option value="">Select --</option>
                @foreach($distinctAssets as $d)
                <option value="{{ $d->name }}">{{ $d->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label for="c_name" class="form-label fw-semibold">Select Asset Component</label>
            <select id="c_name" name="c_name" class="form-select rounded-pill">
                <option value="">Select --</option>
                @foreach($distinctComponents as $d)
                <option value="{{ $d->c_name }}">{{ $d->c_name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Table with Toggle Columns -->
    <div class="row">
            <h5 class="fw-bold">Table Columns View:</h5>
        <div class="col-md-6">
    
            <div class="border p-3" style="border: 1px solid #ccc; border-radius: 5px;">
                <div class="d-flex flex-column">
                    <div class="form-check">
                        <input class="form-check-input toggle-column" type="checkbox" id="toggleGroup" data-column="1">
                        <label class="form-check-label" for="toggleGroup">Asset Group</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input toggle-column" type="checkbox" id="toggleAsset" data-column="2">
                        <label class="form-check-label" for="toggleAsset">Asset</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input toggle-column" type="checkbox" id="toggleOwner" data-column="4">
                        <label class="form-check-label" for="toggleOwner">Owner Dept</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input toggle-column" type="checkbox" id="togglePhysical" data-column="5">
                        <label class="form-check-label" for="togglePhysical">Physical Location</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input toggle-column" type="checkbox" id="toggleLogical" data-column="6">
                        <label class="form-check-label" for="toggleLogical">Logical Location</label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (in_array('Data Inputter', $permissions))
    <a class="btn btn-success btn-md float-end mb-2"
        href="/iso_sec_2_1_new/{{ $project_id }}/{{ auth()->user()->id }}" role="button">Enter Service or Asset
        <i class="fas fa-plus"></i></a>
@endif

    <!-- Data Table -->
    <table id="myTable2" class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark ">
            <tr style="cursor: pointer">
                <th onclick="sortTable(0)">Service</th>
                    <th onclick="sortTable(1)">Asset Group</th>
                    <th onclick="sortTable(2)">Asset</th>
                    <th onclick="sortTable(3)">Asset Component</th>
                    <th onclick="sortTable(4)">Asset Owner Dept</th>
                    <th onclick="sortTable(5)">Asset Physical Location</th>
                    <th onclick="sortTable(6)">Asset Logical Location</th>
                 <th>Enter Evidence</th>
           
        
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr class="service-row" data-service="{{ $d->s_name }}"
                    data-group="{{ $d->g_name }}" data-name="{{ $d->name }}" data-c_name="{{ $d->c_name }}">
                <td>{{ $d->s_name }}</td>
                <td>{{ $d->g_name }}</td>
                <td>{{ $d->name }}</td>
                <td>{{ $d->c_name }}</td>
                <td>{{ $d->owner_dept }}</td>
                <td>{{ $d->physical_loc }}</td>
                <td>{{ $d->logical_loc }}</td>
           

                <td>
                    <a href="/iso_sec_2_2_evidence/{{ $d->assessment_id }}/{{ $project_id }}/{{ auth()->user()->id }}" class="btn btn-warning btn-sm rounded-pill">Enter</a>
                </td>
          
             
            </tr>
            @endforeach
        </tbody>
    </table>

 
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
var c_name=$(this).data('c_name');
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

document.addEventListener('DOMContentLoaded', function () {
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
    checkboxes.forEach(function (checkbox) {
        const column = checkbox.getAttribute('data-column');
        const isVisible = localStorage.getItem(`column_${column}`) === 'false' ? false : true; // Default to visible
        checkbox.checked = !isVisible; // Checkbox unchecked by default for visible columns
        toggleColumn(column, isVisible);
    });

    // Add event listener for each checkbox
    checkboxes.forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
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