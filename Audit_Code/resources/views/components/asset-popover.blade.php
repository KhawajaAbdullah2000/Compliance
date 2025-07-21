 <table class="table table-bordered table-sm text-center mb-0">
    <thead class='table-dark'>
        <tr>
            <th>Service</th>
            <th>Asset Type</th>
            <th>Asset Subtype</th>
            <th>Component</th>
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
        <tr>
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
    </tbody>
</table>
