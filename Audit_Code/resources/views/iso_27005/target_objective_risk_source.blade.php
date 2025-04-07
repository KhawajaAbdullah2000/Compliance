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
    
        
        <h5 class="fw-bold mt-4">Risk Source</h5>
        <p class="fs-5">{{$global_risk_source->global_risk_source}}</p>

        <h5 class="fw-bold mt-4">Target Objective of the Risk Source</h5>
        <div class="col-md-8">

            <form action="/proj_assets_selected_risk_source_and_target/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/{{$global_risk_source->qualitative_asset_based_risk_sources_id}}" method="post">
            @csrf
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>
                        Select
                        </th>
                        <th scope="col">Target Objective</th>
                        <th scope="col">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($global_target_objects as $target_object)
                        <tr>
                            <td>
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="target_object[]"
                                       value="{{ $target_object->qualitative_asset_global_target_object_risk_source_id }}"
                                       {{ in_array($target_object->qualitative_asset_global_target_object_risk_source_id, $selected_target_object_ids) ? 'checked' : '' }}>
                            </td>
                            <td>{{ $target_object->target_objective }}</td>
                            <td>{{$target_object->description}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end">
                <a href="/route_for_risk_source/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-secondary btn-md mb-4">Back</a>
                <button type="submit" class="btn btn-primary btn-md mb-4">Save</button>
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
