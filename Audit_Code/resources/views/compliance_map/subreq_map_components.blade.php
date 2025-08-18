@extends('master')

@section('content')

@include('user-nav')

<div class="container">
      <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-warning">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{ $project->project_id }}/{{ auth()->user()->id }}">
                                {{ $project->project_name }}
                            </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{ $project->type }}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{ auth()->user()->organization->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{ $project->status }}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>


     <h3 class="fw-bold text-center mt-4">View @if(!session('comp_status')) or Download @endif Compliance Map (Selected Domain-Selected Service-Selected Asset-Selected Subdomain-All Applicable Controls)</h3>


         <div class="row">

        <div class="col-md-6">


            <h4><span class="fw-bold">Service Selected : </span>
                @if($service=='_all')
                All services - All Controls
                @else
                {{$service}} - All Controls
                @endif
            </h4>

            <h5><span class="fw-bold">Assets Selected : </span>
                @isset($group)
                @if($group=='_all')
                All Asset Types -
                @else
                {{$group}} -
                @endif
                @endisset


                @isset($subgroup)
                @if($subgroup=='_all')
                All Asset Sub Types -
                @else
                {{$subgroup}} -
                @endif
                @endisset

                @if($component=='_all')

                All Asset Components

                @else

                {{$component}}
                @endif
            </h5>

        </div>

        @if(session('comp_status'))
        <div class="col-md-6 position-relative">
            <a href="/compliance_map_all_services_comp_type/{{$project->project_id}}/{{auth()->user()->id}}/{{session('comp_status')}}" class="btn btn-primary btn-md position-absolute" style="right: 0;">Compliance Map - All Services - All Controls</a>
        </div>

        @else
        <div class="col-md-6 position-relative">
            <a href="/compliance_map_all_services/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md position-absolute" style="right: 0;">Compliance Map - All Services - All Controls</a>
        </div>
        @endif

    </div>


    <h5 class="mb-3">Domain: {{$MainDomainNum}} - {{$MainDomainTitle}}</h5>
    <h5 class="mb-3">Domain: {{$SubDomainNum}} - {{$SubDomainTitle}}</h5>
{{-- <table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>Component</th>
            <th>Domain</th>
            <th>Yes</th><th>No</th><th>Partial</th>
            <th>Not Tested</th><th>Not Applicable</th>
            <th>Total Assets</th><th>Missing</th>
        </tr>
    </thead>
    <tbody>
        @forelse($summary as $r)
            <tr>
                <td class="fw-semibold">{{ $r->c_name }}</td>
                <td>{{$SubReqNum}}-{{$SubReqTitle}}</td>
                <td>{{ $r->yes_count }}</td>
                <td>{{ $r->no_count }}</td>
                <td>{{ $r->partial_count }}</td>
                <td>{{ $r->not_tested_count }}</td>
                <td>{{ $r->not_applicable_count }}</td>
                <td>{{ $r->total_assets }}</td>
                <td>{{ $r->missing_count }}</td>
            </tr>
        @empty
            <tr><td colspan="8" class="text-center">No data.</td></tr>
        @endforelse
    </tbody>
</table> --}}
<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>Component</th>
            <th>Asset ID</th>
            <th>iso_sec_2_2 ID</th>
            <th>Status</th>
            <th>Last Edited</th>
        </tr>
    </thead>
    <tbody>
        @forelse($rows as $r)
            <tr>
                <td class="fw-semibold">{{ $r->c_name }}</td>
                <td>{{ $r->asset_id }}</td>
                <td>{{ $r->compliance_id }}</td>
                <td class="text-capitalize">{{ $r->comp_status }}</td>
                <td>{{ $r->last_edited_at }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">No records found for selected filters.</td></tr>
        @endforelse
    </tbody>
</table>

{{-- Details table with exact IDs --}}
{{-- <h5 class="mt-4 mb-3">Per-Asset Details (latest row per asset/sub-req)</h5>
<table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>Component</th>
            <th>Asset ID</th>
            <th>iso_sec_2_2 ID</th>
            <th>Status</th>
            <th>Last Edited</th>
        </tr>
    </thead>
    <tbody>
        @forelse($details as $d)
            <tr>
                <td>{{ $d->c_name }}</td>
                <td>{{ $d->asset_id }}</td>
                <td>{{ $d->compliance_id ?? '—' }}</td>
                <td>{{ $d->comp_status ?? '—' }}</td>
                <td>{{ $d->last_edited_at ?? '—' }}</td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center">No assets for current filters.</td></tr>
        @endforelse
    </tbody>
</table> --}}
</div>

@endsection