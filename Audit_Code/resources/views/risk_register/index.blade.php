@extends('master')

@section('content')

@include('user-nav')

<div class="container py-4">

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0 text-capitalize">
                View Risk Register by {{ str_replace('_', ' ', $dimension) }}
            </h5>
        </div>



        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">

                        @php
                        $hiddenKeys = [
                        'data_confidentiality',
                        'data_integrity',
                         'data_availability',
                        'qualitative_likelihood_risk_confidentiality_selected',
                        'qualitative_likelihood_risk_integrity_selected',
                        'qualitative_likelihood_risk_availability_selected',
                        'framework_selected',
                        'assessment_approach_selected',
                        'framework_approach_types'
                        ];
                        @endphp

                        <thead class="table-dark">
                            <tr>
                                @foreach ($columns as $col)
                                @if (!in_array($col['key'], $hiddenKeys))
                                <th class="text-nowrap fw-semibold">{{ $col['label'] }}</th>
                                @endif
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                            <tr>
                                @foreach ($columns as $col)
                                @php $key = $col['key']; @endphp
                                @if (!in_array($key, $hiddenKeys))
                                <td>
                                    @if ($key === 'status')
                                    @php
                                    $status = $row->$key ?? '';
                                    $badgeClass = match (true) {
                                    str_contains(strtolower($status), 'approved') => 'bg-success',
                                    str_contains(strtolower($status), 'reject') => 'bg-danger',
                                    str_contains(strtolower($status), 'pending'),
                                    str_contains(strtolower($status), 'review') => 'bg-warning text-dark',
                                    default => 'bg-secondary',
                                    };
                                    @endphp
                                    <span class="badge rounded-pill {{ $badgeClass }}">
                                        {{ $status ?: '—' }}
                                    </span>
                                    @else
                                    {{ $row->$key ?: '—' }}
                                    @endif
                                </td>
                                @endif
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($columns) + 3 }}" class="text-center text-muted py-4">
                                    <i class="bi bi-inboxes fs-2 d-block mb-2"></i>
                                    No records found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>




    </div>
</div>


@endsection
