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
                        <td class="fw-bold">Information Security Risk Management Methodology:</td>
                        <td>{{$framework_approach->approach_name}} - {{$risk_assessment_approach->global_assessment_approach}} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])
    
        
        <h4 class="fw-bold mt-4">Identify which risk sources could exploit vulnerabilities in the asset component 
        </h4>
        <div class="col-md-8 mb-4">

            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Risk Source</th>
                        <th scope="col">Target Objective of Risk Source</th>
                        <th scope="col">Threat Posed by Risk Source</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($global_risk_sources as $risk_source)
                        <tr>
                            <td>{{ $risk_source->global_risk_source }}</td>
            
                            <td class='text-center'>
                                <a href="/target_objective_of_risk_source/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/{{$risk_source->qualitative_asset_based_risk_sources_id}}" title="Edit Target Objective">
                                    <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
                                </a>
                            </td>
            
                            <td class='text-center'>
                                <a href="/threat_posed_by_risk_source/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/{{$risk_source->qualitative_asset_based_risk_sources_id}}" title="Edit Target Objective">
                                    <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            <h5 class="fw-bold">Consolidated Level of Threats</h5>

            <form action="/proj_assets_level_of_threat/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
            @csrf
            <select name="threat_level" class="form-select">
                @foreach($global_level_of_threats as $threat)
                    <option value="{{ $threat->global_level_of_threats_id }}"
                        {{ $threat->global_level_of_threats_id == $selected_level_of_threat ? 'selected' : '' }}>
                        {{ $threat->global_threat }}
                    </option>
                @endforeach
            </select>
            

            <div class="mt-4 mb-4 d-flex justify-content-end gap-2">
                
                <a href="/iso_sec_2_3_1_risk_selection/{{$asset->assessment_id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-secondary">Back</a>
                <button type="submit" name="action" value="save_and_stay" class="btn btn-primary">
                    Save & Stay
                </button>
                <button type="submit" name="action" value="save_and_next" class="btn btn-primary">
                    Save & go to next step
                </button>

            </div>
            </form>
            
        
        
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
