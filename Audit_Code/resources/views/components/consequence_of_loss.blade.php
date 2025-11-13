

@php
// Get active scheme
$allSchemes = config('risk_schemes');
$schemeKey = $project->risk_scheme ?? 'none';
$scheme = $allSchemes[$schemeKey] ?? $allSchemes['none'];


$isNamed = $scheme['named'] ?? false; // true => use map labels
$schemeMap = $scheme['map'] ?? []; // e.g. [5 => ['label'=>'Critical','class'=>'text-danger'], ...]

// Helper to render a value using the scheme's map
$render = function ($val) use ($isNamed, $schemeMap) {
$v = (int) $val;
if ($isNamed) {
// Show label (and color class if provided). Fallback to number if not mapped.
if (isset($schemeMap[$v]['label'])) {
$class = $schemeMap[$v]['class'] ?? '';
return '<span class="'.e($class).'">'.e($schemeMap[$v]['label']).'</span>';
}
return e($v);
}
// Numeric-only scheme
return e($v);
};

@endphp


<div class="mt-4">
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle mb-0">
            <thead class="table-primary text-white fw-bold">
                <tr>
                    <th>Business Impact (Consequence) of Loss of Data Confidentiality</th>
                    <th>Business Impact (Consequence) of Loss of Data Integrity</th>
                    <th>Business Impact (Consequence) of Loss of Data Availability</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-light">
                    <td>
                        <a href="/consequence_of_service/{{$asset->assessment_id}}/{{$project->project_id}}/{{auth()->user()->id}}">
                            {!! $asset->risk_confidentiality !== null ? $render($asset->risk_confidentiality) : 'N/A' !!}
                        </a>
                    </td>
                    <td>
                        <a href="/consequence_of_service/{{$asset->assessment_id}}/{{$project->project_id}}/{{auth()->user()->id}}">
                            {!! $asset->risk_integrity !== null ? $render($asset->risk_integrity) : 'N/A' !!}
                        </a>
                    </td>
                    <td>
                        <a href="/consequence_of_service/{{$asset->assessment_id}}/{{$project->project_id}}/{{auth()->user()->id}}">
                            {!! $asset->risk_availability !== null ? $render($asset->risk_availability) : 'N/A' !!}
                        </a>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
</div>
