<div class="card col-md-6 mt-4">
  <div class="card-body">
    <div class="row mb-2">
      <div class="col-md-6">
        <p class="mb-0 text-muted">Consolidated Level of Threats</p>
     <a href="{{ route('route_for_risk_source', [
    'proj_id'  => $project->project_id,
    'user_id'  => auth()->user()->id,
    'asset_id' => $asset->assessment_id,
]) }}">
    <h5 class="fw-bold text-danger">
        {{ $threat ?? 'N/A' }}
    </h5>
</a>
      </div>
     
    </div>
  </div>
</div>
