@extends('master')

@section('content')

@include('user-nav')


<div class="container mt-4">
    <h4 class="fw-bold">Compliance, Risk and Classification Assessment History of Asset Component: {{$asset->c_name??''}}
    </h4>

    <div class="table-responsive">
        <table class="table table-striped table-hover text-center align-middle">
            <thead class="table-info">
                <tr>
                    <th>Compliance Assessment</th>
                    <th>Risk Assessment</th>
                    <th>Classification Assessment</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @if(!empty($asset->assessment_id))
                        <a href="/compliance_comp_history_projects_list/{{ $asset->assessment_id }}/{{ auth()->user()->id }}">
                            {{ $complianceProjectCount }}
                        </a>
                        @else
                        {{ $complianceProjectCount }}
                        @endif
                    </td>
                    <td>5</td>
                    <td>5</td>
                    <td>{{$complianceProjectCount+5+5}}</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

@endsection
