@extends('master')

@section('content')

@include('user-nav')




<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>
    <h3 class="fw-bold mt-2">Risk Assessment for {{auth()->user()->organization->name}}</h3>

   <span class="fw-bold">Services: </span> {{ $services->pluck('s_name')->implode(', ') }}

    
        
        <h5 class="fw-bold mt-4">Risk Source (Threat)</h5>
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

<form action="/proj_asset_threat_desc_selected_qual_event/{{$project->project_id}}/{{auth()->user()->id}}/{{$global_risk_source->qualitative_asset_based_risk_sources_id}}" method="POST">
    @csrf
    <div class="mt-3 mb-3 d-flex justify-content-end gap-2">
        <a href="{{route('route_for_risk_source_qual_event',[
            'proj_id'=>$project->project_id,
            'user_id'=>auth()->user()->id,
            ])}}" class="btn btn-secondary">Back</a>
        <button id="confirmSaveBtn" type="submit" class="btn btn-primary">Save</button>
    </div>
    <table class="table table-responsive table-bordered table-hover">
        <thead class="table-secondary">
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
        <a href="{{route('route_for_risk_source_qual_event',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id,
        ])}}" class="btn mt-3 btn-secondary">Back</a>
    <button id="confirmSaveBtn2" type="submit" class="btn btn-primary mt-3">Save</button>
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

<script>
    document.getElementById('confirmSaveBtn').addEventListener('click', function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure you want to save?",
            text: "Please confirm your action.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willSave) => {
            if (willSave) {
                this.closest('form').submit();
            }
        });
    });
</script>

<script>
    document.getElementById('confirmSaveBtn2').addEventListener('click', function (e) {
        e.preventDefault();
        swal({
            title: "Are you sure you want to save?",
            text: "Please confirm your action.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willSave) => {
            if (willSave) {
                this.closest('form').submit();
            }
        });
    });
</script>

@endsection
