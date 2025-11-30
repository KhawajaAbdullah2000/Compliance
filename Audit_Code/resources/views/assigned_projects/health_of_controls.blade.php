

@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <!-- Page Heading -->
    <p class="fw-bold fs-5">Organization: {{ auth()->user()->organization->name }}</p>
    <p class="fw-bold fs-5">Project Name: {{ $project->name }}</p>
    <p class="fw-bold fs-5">User: {{ auth()->user()->email }}</p>

    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead>
                <tr>
                    <th rowspan="2" class="align-middle text-start fs-4" style="width: 25%;">Health of Controls</th>
                    <th rowspan="2" class="align-middle" style="width: 8%;">Type</th>

                    <th colspan="2">Confidentiality</th>
                    <th colspan="2">Integrity</th>
                    <th colspan="2">Availability</th>
                    <th colspan="2">Overall</th>
                </tr>
                <tr>
                    <th>Score</th>
                    <th>Level</th>
                    <th>Score</th>
                    <th>Level</th>
                    <th>Score</th>
                    <th>Level</th>
                    <th>Score</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($domainNames as $id => $name)
                    @php
                        // ISO main clauses (4–10) are Compliance, Annex (11–14) are Risk
                        $type = $id <= 10 ? 'Compliance' : 'Risk';

                        // Left bar colour: yellow for clauses, blue for annex (just like your screenshot)
                        $leftBg = $id <= 10 ? '#f9b233' : '#0070a8';
                        $leftTextColor = '#ffffff';
                    @endphp

                    <tr>
                        {{-- Left coloured label cell --}}
                        <td class="text-start fw-bold" 
                            style="background-color: {{ $leftBg }}; color: {{ $leftTextColor }};">
                            {{ $id . '. ' . $name }}
                        </td>

                        {{-- Type --}}
                        <td>{{ $type }}</td>

                        {{-- Confidentiality / Integrity / Availability / Overall – empty for now --}}
                        <td></td>
                        <td></td>

                        <td></td>
                        <td></td>

                        <td></td>
                        <td></td>

                        <td></td>
                        <td></td>
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
                title: "{{ Session::get('success') }}",
                icon: "success",
                closeOnClickOutside: true,
                timer: 3000,
            });
        </script>
    @endif

    @if(Session::has('error'))
        <script>
            swal({
                title: "{{ Session::get('error') }}",
                icon: "error",
                closeOnClickOutside: true,
                timer: 3000,
            });
        </script>
    @endif
@endsection

@endsection
