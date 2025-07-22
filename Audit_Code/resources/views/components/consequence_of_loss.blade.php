@php
$labels = [
    1 => 'Minor',
    2 => 'Significant',
    3 => 'Serious',
    4 => 'Critical',
    5 => 'Catastrophic'
];
@endphp

<div class="mt-4">
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle mb-0">
            <thead class="table-primary text-white fw-bold">
                <tr>
                    <th>Consequence of Loss of Data Confidentiality</th>
                    <th>Consequence of Loss of Data Integrity</th>
                    <th>Consequence of Loss of Data Availability</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-light">
                    <td>{{ $labels[$asset->risk_confidentiality] ?? 'N/A' }}</td>
                    <td>{{ $labels[$asset->risk_integrity] ?? 'N/A' }}</td>
                    <td>{{ $labels[$asset->risk_availability] ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
