{{-- @extends('master')

@section('content')

@include('user-nav')

<div class="container mt-5">

    <h3 class="fw-bold text-center mb-4">Statement of Applicability (SOA)</h3>

    @php
    $groupedData = collect($finalData)->groupBy('title_num');
    @endphp

    @foreach($groupedData as $titleNum => $records)

        <h4 class="fw-bold text-primary mt-4">{{ $titleNum }}. {{ $records->first()['title'] }}</h4>

        <table class="table table-bordered table-hover text-center align-middle mt-3">
            <thead class="table-secondary">
                <tr>
                    <th>Subdomain</th>
                    <th>Sub Req</th>
                    <th>Requirement</th>
                    <th>Control is Applicable</th>
                    <th>Justification</th>
                </tr>
            </thead>
            <tbody>
                @foreach($records as $item)
                <tr>
                    <td>{{ $item['subdomain'] }}</td>
                    <td>{{ $item['sub_req'] }}</td>
                    <td class="text-start">{{ $item['requirement'] }}</td>
                    <td>{{ ucfirst($item['applicability']) }}</td>
                    <td>{{ $item['justification'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @endforeach

</div>

@endsection --}}

@extends('master')

@section('content')

@include('user-nav')

<div class="container mt-5">

    <div class="text-end">
        <a href="/view_soa_project/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-md btn-secondary">Back</a>
    </div>

    <h3 class="fw-bold text-center mb-4">Statement of Applicability (SOA)</h3>

    @php
    $groupedData = collect($finalData)->groupBy('title_num');
    @endphp

    @foreach($groupedData as $titleNum => $records)

        <h4 class="fw-bold text-primary mt-4">{{ $titleNum }}. {{ $records->first()['title'] }}</h4>

        @if($titleNum == 11)

            @php
            $annexGroups = $records->groupBy('subdomain');
            @endphp

            @foreach($annexGroups as $subdomain => $annexControls)
<h5 class="fw-bold text-secondary mt-3">
    Annex A Control: {{ $subdomain }} - {{ $annexControls->first()['subdomain_heading'] }}
</h5>
                <table class="table table-bordered table-hover text-center align-middle mt-2">
                    <thead class="table-secondary">
                        <tr>
                            <th>Sub Req</th>
                            <th>Requirement</th>
                            <th>Control is Applicable</th>
                            <th>Justification</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($annexControls as $item)
                        <tr>
                            <td>{{ $item['sub_req'] }}</td>
                            <td class="text-start">{{ $item['requirement'] }}</td>
                            <td>{{ ucfirst($item['applicability']) }}</td>
                            <td>{{ $item['justification'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endforeach

        @else

            <table class="table table-bordered table-hover text-center align-middle mt-3">
                <thead class="table-secondary">
                    <tr>
                        <th>Subdomain</th>
                        <th>Sub Req</th>
                        <th>Requirement</th>
                        <th>Control is Applicable</th>
                        <th>Justification</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $item)
                    <tr>
                        <td>{{ $item['subdomain'] }}</td>
                        <td>{{ $item['sub_req'] }}</td>
                        <td class="text-start">{{ $item['requirement'] }}</td>
                        <td>{{ ucfirst($item['applicability']) }}</td>
                        <td>{{ $item['justification'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        @endif

    @endforeach

</div>

@endsection
