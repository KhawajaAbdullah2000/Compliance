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

        <h5 class="fw-bold mt-4">Target Objective of the Risk Source</h5>
        <div class="col-md-8">

            <form action="/proj_selected_risk_source_and_target_qual_event/{{$project->project_id}}/{{auth()->user()->id}}/{{$global_risk_source->qualitative_asset_based_risk_sources_id}}" method="post">
            @csrf
            
            <table class="table table-bordered align-middle table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAllCheckbox">
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
                                <input class="form-check-input target-checkbox"
                                       type="checkbox"
                                       name="target_object[]"
                                       value="{{ $target_object->qualitative_asset_global_target_object_risk_source_id }}"
                                       {{ in_array($target_object->qualitative_asset_global_target_object_risk_source_id, $selected_target_object_ids) ? 'checked' : '' }}>
                            </td>
                            <td>{{ $target_object->target_objective }}</td>
                            <td>{{ $target_object->description }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            

            <div class="text-end">
                <a href="/iso_sec_2_3_1_risk_selection_qual_event/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-secondary btn-md mb-4">Back</a>
              <button type="button" id="confirmSaveBtn" class="btn btn-primary btn-md mb-4">Save</button>

            </div>

            </form>

          

        
        
        </div>









</div>

@section('scripts')

<script>
    const selectAll = document.getElementById('selectAllCheckbox');
    const targets = document.querySelectorAll('.target-checkbox');

    selectAll.addEventListener('change', function () {
        targets.forEach(cb => cb.checked = this.checked);
    });

    targets.forEach(cb => {
        cb.addEventListener('change', function () {
            if (!this.checked) selectAll.checked = false;
            else if ([...targets].every(input => input.checked)) selectAll.checked = true;
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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>

@endif


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



@endsection

@endsection
