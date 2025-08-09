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


</div>

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

@endsection

@endsection
