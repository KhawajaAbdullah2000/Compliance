@extends('master')

@section('content')

@include('user-nav')


<div class="container mt-4">
    <h4 class="fw-bold">Compliance Assessment History of Asset Component: {{$asset->c_name??''}}
    </h4>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-info">
                <tr>
                    <th>Project Name</th>
                    <th>Project Type</th>
                    <th>Controls Domains Assessed</th>
                    <th>Controls Subdomains Assessed</th>
                    <th>Controls Assessed</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($complianceSummary as $summary)
                <tr>
                    <td>{{$summary->project_name}}</td>
                    <td>{{$summary->project_type}}</td>
                    <td><a href="/compliance_domains_assessed_history/{{$summary->project_id}}/{{$asset->assessment_id}}">{{$summary->domains_assessed}}</a></td>
                    <td><a href="/compliance_subdomains_assessed_history/{{$summary->project_id}}/{{$asset->assessment_id}}">{{$summary->subdomains_assessed}}</a></td>

                    <td><a href="/compliance_controls_assessed_history/{{$summary->project_id}}/{{$asset->assessment_id}}">{{$summary->controls_assessed}}</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">Compliance Not Done</td>
                </tr>

                @endforelse

            </tbody>
        </table>
    </div>

</div>

@endsection
