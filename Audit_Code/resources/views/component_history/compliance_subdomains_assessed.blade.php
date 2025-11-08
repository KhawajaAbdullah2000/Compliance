@extends('master')

@section('content')

@include('user-nav')


<div class="container mt-4">
    <h4 class="fw-bold">Control Sub Domains Assessed of Asset Component: {{$asset->c_name??''}}
    </h4>

    <p class="fw-bold">Project Name: {{$project->project_name}}</p>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-info">
                <tr>
                    <th>Control Sub Domain</th>
                    <th>Applicability</th>
                    <th>Compliance Assessed</th>
                </tr>
            </thead>
            <tbody>
                @foreach($domainSummary as $summary)
                    <tr>
                        <td>{{$summary['subdomain']}}</td>
                        <td>Yes</td>
                        <td>{{$summary['compliance']}}</td>
                    </tr>
                @endforeach
                
                    
               
            </tbody>
        </table>
    </div>

</div>

@endsection
