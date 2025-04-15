@extends('master')

@section('content')

@include('user-nav')




<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2">Information Security Risk Assessment for</h3>

    @include('components.asset-summary_component', ['asset' => $asset])
    
        
        <h5 class="fw-bold mt-4">Risk Source</h5>
        <p class="fs-5">{{$global_risk_source->global_risk_source}}</p>
     

        <h5 class="fw-bold mt-4">Threats posed by the Risk Source</h5>
        <div class="col-md-8">

            @php
            $grouped = $global_threat_and_descs;
            $headers = [];
            $maxRows = 0;
        
            foreach($grouped as $groupId => $items) {
                $headers[$groupId] = $items->first()->global_threat_posed ?? 'Group ' . $groupId;
                $maxRows = max($maxRows, $items->count());
            }
        @endphp
  

  @php
    $grouped = $global_threat_and_descs;
    $headers = [];
    $maxRows = 0;

    foreach($grouped as $groupId => $items) {
        $headers[$groupId] = $items->first()->global_threat_posed ?? 'Group ' . $groupId;
        $maxRows = max($maxRows, $items->count());
    }
@endphp

<form action="/proj_asset_threat_desc_selected/{{$project->project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}/{{$global_risk_source->qualitative_asset_based_risk_sources_id}}" method="POST">
    @csrf
    <div class="mt-3 mb-3 d-flex justify-content-end gap-2">
        <a href="{{route('route_for_risk_source',[
            'proj_id'=>$project->project_id,
            'user_id'=>auth()->user()->id,
            'asset_id'=>$asset->assessment_id
            ])}}" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    <table class="table table-responsive table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                @foreach($headers as $groupId => $header)
                    <th class="text-center">
                        {{ $header }}
                        <div class="form-check mt-2">
                            <input class="form-check-input select-all-checkbox" type="checkbox" data-group="{{ $groupId }}" id="select_all_{{ $groupId }}">
                          
                        </div>
                    </th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < $maxRows; $i++)
                <tr>
                    @foreach($grouped as $groupId => $group)
                        <td>
                            @if(isset($group[$i]))
                                <div class="form-check">
                                    <input 
                                    class="form-check-input group-checkbox-{{ $groupId }}" 
                                    type="checkbox" 
                                    name="selected[{{ $groupId }}][]" 
                                    value="{{ $group[$i]->threat_desc_for_global_threats_id }}" 
                                    id="checkbox_{{ $groupId }}_{{ $i }}"
                                    @if(in_array($group[$i]->threat_desc_for_global_threats_id, $selected_threat_ids)) checked @endif
                                >
                                    <label class="form-check-label" for="checkbox_{{ $groupId }}_{{ $i }}">
                                        {{ $group[$i]->threat_description }}
                                    </label>
                                </div>
                            @else
                                <div class="text-muted">N/A</div>
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endfor
        </tbody>
    </table>

    <div class="mt-4 mb-4 d-flex justify-content-end gap-2">
        <a href="{{route('route_for_risk_source',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id,
        'asset_id'=>$asset->assessment_id
        ])}}" class="btn mt-3 btn-secondary">Back</a>
    <button type="submit" class="btn btn-primary mt-3">Save</button>
    </div>
</form>

        



          

        
        
        </div>









</div>

@section('scripts')

<script>
    document.querySelectorAll('.select-all-checkbox').forEach(selectAll => {
        selectAll.addEventListener('change', function () {
            const groupId = this.getAttribute('data-group');
            const checkboxes = document.querySelectorAll(`.group-checkbox-${groupId}`);
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    });
</script>

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
