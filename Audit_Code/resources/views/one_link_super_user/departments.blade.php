@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">

     <div id="unitFormModal" style="display:none;" class="modal">
    <div class="modal-content">
        <form method="POST" action="/save_unit">
            @csrf
            <input type="hidden" name="department_id" id="unit_department_id">
            <h5>Add Unit</h5>
            
            <div class="form-group">
                <label>Organization</label>
                <input type="text" class="form-control" id="org_name" readonly>
            </div>
            <div class="form-group">
                <label>Department</label>
                <input type="text" class="form-control" id="dept_name" readonly>
            </div>
            <div class="form-group">
                <label>Unit Name</label>
                <input type="text" class="form-control" name="unit_name" required>
            </div>

            <button type="submit" class="btn btn-success mt-2">Save Unit</button>
            <button type="button" onclick="closeUnitForm()" class="btn btn-secondary mt-2">Cancel</button>
        </form>
    </div>
</div>
    

   
    <h4 class="fw-bold">Set up Sub-Entities within Departments (SBUs)</h4>
               
    <div class="row justify-content-center">

        <div class="col-lg-8">


            <div class="card shadow-sm border-0">
             

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle text-center">
                            <thead class="table-secondary">
                                <tr>
                                    <th scope="col">Department</th>
                                    <th scope="col">Add Unit</th>
                                 <th scope="col">View Existing Units</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach($departments as $department)
<tr>

    <td>{{ $department->name }}</td>
    <td>
        <button class="btn btn-primary btn-sm" 
                onclick="openUnitForm({{ $department->id }}, '{{ $department->name }}', '{{ $department->organization->name }}')">
            Add Unit
        </button>
    </td>

  <td>
        <button class="btn btn-info btn-sm"
                onclick="viewUnits({{ $department->id }}, '{{ $department->name }}')">
            View Existing
        </button>
    </td>
</tr>
@endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- View Units Modal -->
<div id="viewUnitsModal" style="display:none;" class="modal">
    <div class="modal-content">
        <h5>Units under <span id="units_department_name"></span></h5>
        <ul id="unit_list" class="list-group">
            <!-- List items added via JS -->
        </ul>
        <br>
        <button class="btn btn-secondary" onclick="closeUnitsModal()">Close</button>
    </div>
</div>
</div>





@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

<script>
    function openUnitForm(deptId, deptName, orgName) {
    document.getElementById('unitFormModal').style.display = 'block';
    document.getElementById('unit_department_id').value = deptId;
    document.getElementById('dept_name').value = deptName;
    document.getElementById('org_name').value = orgName;
}

function closeUnitForm() {
    document.getElementById('unitFormModal').style.display = 'none';
}

</script>

<script>
    function viewUnits(departmentId, departmentName) {
        // Update heading
        document.getElementById('units_department_name').innerText = departmentName;

        // Clear any existing list
        const unitList = document.getElementById('unit_list');
        unitList.innerHTML = '<li>Loading units...</li>';

        // Show modal
        document.getElementById('viewUnitsModal').style.display = 'block';

        // Fetch units via AJAX
        fetch(`/departments/${departmentId}/units`)
            .then(response => response.json())
            .then(data => {
                unitList.innerHTML = '';

                if (data.length === 0) {
                    unitList.innerHTML = '<li class="list-group-item">No units found.</li>';
                    return;
                }

                data.forEach(unit => {
                   const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';

                // Construct the edit URL
                const editUrl = `/units/${unit.id}/edit`; 
                 const deleteUrl = `/units/${unit.id}/delete`; 
            li.innerHTML = `
    <div class="d-flex justify-content-between align-items-center w-100">
        <div class="text-truncate pe-3" style="max-width: 70%;">
            ${unit.name}
        </div>
        <div class="text-nowrap">
            <a href="${editUrl}" class="btn btn-sm btn-warning me-1">Edit</a>
            <a href="${deleteUrl}" class="btn btn-sm btn-danger">Delete</a>
        </div>
    </div>
`;

    unitList.appendChild(li);
                });
            })
            .catch(err => {
                unitList.innerHTML = '<li class="list-group-item text-danger">Error loading units.</li>';
            });
    }

    function closeUnitsModal() {
        document.getElementById('viewUnitsModal').style.display = 'none';
    }
</script>

@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif
@endsection

@endsection
