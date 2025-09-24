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


            <div class="col-12 col-md-4 col-lg-3">
                <div class="p-3 text-white text-center rounded shadow"
                     style="background: linear-gradient(135deg, #35323296, #848680); transition: 0.3s;">
                    <h5 class="fw-bold mb-0">Risk Register</h5>
                </div>
            </div>



            @if ($riskRecords->isEmpty())
                <div class="alert alert-info mt-2">No risk records found.</div>
            @else
                <div class="card shadow-md mt-2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="riskTable" class="table table-bordered table-hover text-center align-middle">
                                <thead class="table-secondary">
                                   <tr>
                            <th onclick="sortTable(0, 'numeric')">S.NO</th>
                            <th onclick="sortTable(1, 'alpha')">Risk Id</th>
                            <th onclick="sortTable(2, 'alpha')">ERM Risk Classification</th>
                            <th onclick="sortTable(3, 'alpha')">n Basel II Loss Event Type I</th>
                            <th onclick="sortTable(4, 'alpha')">Basel II Loss Event Type II</th>
                            <th onclick="sortTable(5, 'alpha')">Risk Description</th>
                            <th onclick="sortTable(6, 'custom_inherent')">Inherent Risk Rating</th>
                            <th onclick="sortTable(7, 'numeric')">Residual Risk Rating</th>
                            <th onclick="sortTable(8, 'alpha')">Risk Owner</th>
                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riskRecords as $index => $record)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><a href="/risk_register_risk_record_details/{{$record->risk_id}}/{{$project->project_id}}">R-IPS-{{ $record->risk_id }}</a></td>
                                            <td>{{ $record->erm_risk_classification }}</td>
                                            <td>{{ $record->op_loss_event_type_one }}</td>
                                            <td>{{ $record->op_loss_event_type_two }}</td>
                                            <td>{{ $record->risk_description }}</td>
                                            <td>{{ $record->inherent_risk_rating }}</td>
                                            <td>{{ $record->residual_risk_rating }}</td>
                                            <td>{{ $record->risk_owner_name }}</td>
                                           
                                           

            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif




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


        <script>
    let sortDirection = {};

    function sortTable(columnIndex, type) {
        const table = document.getElementById("riskTable");
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.querySelectorAll("tr"));
        const direction = sortDirection[columnIndex] === "asc" ? "desc" : "asc";
        sortDirection[columnIndex] = direction;

        const getCellValue = (row) => row.children[columnIndex].innerText.trim();

        const inherentOrder = { 'LOW': 3, 'MEDIUM': 2, 'LOW': 1 };

        rows.sort((a, b) => {
            const valA = getCellValue(a);
            const valB = getCellValue(b);

            if (type === 'numeric') {
                return direction === "asc" ? Number(valA) - Number(valB) : Number(valB) - Number(valA);
            }

            if (type === 'custom_inherent') {
                const aValue = inherentOrder[valA] || 0;
                const bValue = inherentOrder[valB] || 0;
                return direction === "asc" ? aValue - bValue : bValue - aValue;
            }

            // Default: Alphabetical
            return direction === "asc"
                ? valA.localeCompare(valB)
                : valB.localeCompare(valA);
        });

        // Rebuild the table with sorted rows
        rows.forEach(row => tbody.appendChild(row));
    }
</script>

       
    @endsection




    @endsection


   