@extends('master')

@section('content')

@include('user-nav')


@php
$permissions = json_decode($project_permissions);

// User can edit data if they have "Data Inputter"
$isEditable = in_array('Data Inputter', $permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>

 
    <div class="mt-4">
        @if ($isEditable)
        <a class="btn btn-success btn-md float-end mb-2"
            href="/data_catalog_new/{{ $project->project_id }}/{{ auth()->user()->id }}" role="button">Enter Data Catalog
            <i class="fas fa-plus"></i></a>
    @endif

    <div class="row mb-2">
        <div class="col-md-4">
            <input type="text" id="tableSearch" class="form-control" placeholder="Search in table...">
        </div>
    </div>
    <table id="dataCatalogTable" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Data Source</th>
                <th>Data Type</th>
                <th>Data Definition</th>
                <th>Owner Dept</th>
                <th>User Dept</th>
                <th>Governance Policy</th>
                <th>Confidentiality Tag</th>
                <th>Integrity Tag</th>
                <th>Availability Tag</th>
                <th>Quality Score</th>
                <th>Enter , Import or Upload Dataset</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_catalog as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->data_source }}</td>
                <td>{{ $item->data_type }}</td>
                <td>{{ $item->data_definition }}</td>
                <td>{{ $item->owner_dept }}</td>
                <td>{{ $item->user_dept }}</td>
                <td>
                    @if($item->governance_policy)
                        <a href="{{ asset('data_catalog/' . $item->governance_policy) }}" target="_blank">
                            {{ $item->governance_policy }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $item->confidentiality_tag }}</td>
                <td>{{ $item->integrity_tag }}</td>
                <td>{{ $item->availability_tag }}</td>
                <td>{{ $item->quality_score ?? 'N/A' }}</td>
                <td class="text-center"> @if (in_array('Data Inputter', $permissions))
                    <a href="/datasets_list/{{ $item->id }}/{{ $item->project_id }}/{{ auth()->user()->id }}">
                        <i class="fas fa-edit fa-lg text-success"></i>
                    </a>
                 
                    @else
                    <i class="fas fa-lock text-secondary"></i>
                    @endif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
        
    </div>
    
    
        




</div>

@section('scripts')


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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif


<script>
    document.getElementById("tableSearch").addEventListener("keyup", function () {
        let input = this.value.toLowerCase();
        let table = document.getElementById("dataCatalogTable");
        let rows = table.querySelectorAll("tbody tr");

        rows.forEach(function (row) {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? "" : "none";
        });
    });
</script>


@endsection

@endsection
