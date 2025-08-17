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
                        <thead class="table-dark">
                            <tr>
                                @foreach ($columns as $col)
                                <th class="text-nowrap fw-semibold">{{ $col['label'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                            <tr>
                                @foreach ($columns as $col)
                                @php $key = $col['key']; @endphp
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
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($columns) }}" class="text-center text-muted py-4">
                                    <i class="bi bi-inboxes fs-2 d-block mb-2"></i>
                                    No records found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $rows->links() }}
                </div>
            </div>
        </div>

    </div>
</div>


@endsection
