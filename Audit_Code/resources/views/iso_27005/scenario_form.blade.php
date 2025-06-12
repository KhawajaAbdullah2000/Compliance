@extends('master')

@section('content')

@include('user-nav')




<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Compliance Framework:</td>
                        <td>{{$complianceFramework->framework_name}}</td>
                        <td class="fw-bold">Risk Management Methodology:</td>
                        <td>{{$framework_approach->approach_name}} - {{$risk_assessment_approach->global_assessment_approach}} </td>
                    </tr>
                </tbody>
            </table>
      
        </div>
    </div>
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])

    <div class="text-end mb-3">
        <a href="{{route('iso_27005_risk_assessment',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id,
        'asset_id'=>$asset->assessment_id])}}" class="btn btn-md btn-secondary">
         Back
        </a>
    </div>
    
<div class="row">

    <div class="col-md-6 mt-4">
        <div class="card shadow-sm">
            <div class="card-header py-2 px-3 bg-dark text-white">
                <strong>Risk Sources (Threats)</strong>
            </div>
            <div class="card-body px-3 py-2">
                <ul class="list-group list-group-flush small">
                    @foreach ($riskSources as $risk)
                        <li class="list-group-item py-1 px-2">{{ $risk->global_risk_source }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header py-2 px-3 bg-dark text-white">
                <strong>Target Objectives</strong>
            </div>
            <div class="card-body px-3 py-2" style="max-height: 250px; overflow-y: auto;">
                <ul class="list-group list-group-flush small">
                    @foreach ($targetObjectives as $target)
                        <li class="list-group-item py-1 px-2">{{ $target->target_objective }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        
        <div class="card shadow-sm mt-4">
            <div class="card-header py-2 px-3 bg-dark text-white">
                <strong>Threats</strong>
            </div>
            <div class="card-body px-3 py-2" style="max-height: 250px; overflow-y: auto;">
                <ul class="list-group list-group-flush small">
                    @foreach ($threats as $threat)
                        <li class="list-group-item py-1 px-2">{{ $threat->threat_description }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-4">
        <h4 class="fw-bold">Risk Scenarios</h4>

        <a href="/add_risk_scenario/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-sm btn-success float-end mb-2">Add Risk Scenario</a>

        <table class="table table-responsive table-hover">
            <thead class="table-primary">
                <tr>
                    <th>Scenario</th>
                </tr>
            </thead>
            <tbody>
                @forelse($risk_scenarios as $risk_scene)
                    <tr>
                        <td>{{ $risk_scene->scenario }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="1" class="text-center text-muted">No scenarios found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        




    </div>

  

    
</div>

 
    










</div>

@section('scripts')


@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif



@endsection

@endsection
