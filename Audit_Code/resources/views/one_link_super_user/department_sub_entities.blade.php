@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <h3 >Sub-Entities for the Department : <span class="fw-bold">{{$department->name}}</span></h3>

    @php
        $grouped = collect($sub_entities)->groupBy('sub_entity_type');
        $types = [
            'functions' => 'Functions (Units)',
            'products' => 'Products',
            'cycles' => 'Cycles/Processes',
            'sub_processes' => 'Sub-Processes',
        ];
    @endphp

    @foreach($types as $key => $label)
        @if($grouped->has($key))
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">{{ $label }}</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Created By (User ID)</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grouped[$key] as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                              <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, h:i A') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    @endforeach

</div>

@endsection
