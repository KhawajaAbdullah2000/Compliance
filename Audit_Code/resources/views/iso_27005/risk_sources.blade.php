@extends('master')

@section('content')

@include('user-nav')




<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2">Assess Risk Sources (Threats) for</h3>

    <div class="col-12">
    @include('components.asset-summary_component', ['asset' => $asset])
    
    </div>


    <div class="col-12">
    @include('components.consequence_of_loss', ['asset' => $asset,'project'=>$project])
    
    </div>


    <div class="row">
        <div class="col-md-8">
   <h4 class="fw-bold mt-4">Identify which risk sources (threats) could exploit vulnerabilities in the asset component 
        </h4>
        </div>
        <div class="col-md-4 text-end">
                   <div class="text-end mt-2">
       @include('components.back_to_flow_chart_btn',['asset'=>$asset,'project'=>$project])
    </div>
        </div>
    </div>
        
     
     

        <small class="text-warning fw-bold d-block mt-2 mb-2">
            <i class="fas fa-exclamation-triangle"></i> If at least one value for either Target Objective or Threat Posed is not selected, then the Risk Source will not be selected and saved for this asset component
        </small>

        <div class="col-md-8 mb-4">

            <table class="table table-bordered align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th scope="col">Risk Source (Threats)</th>
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
                
                {{-- <a href="/iso_sec_2_3_1_risk_selection/{{$asset->assessment_id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-secondary">Back</a> --}}
                <button type="submit" name="action" value="save_and_stay" class="btn btn-secondary">
                    Save
                </button>
                <button type="submit" name="action" value="save_and_next" class="btn btn-primary">
                    Save & Next
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
