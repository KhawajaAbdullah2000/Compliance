
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
       <h3 class="fw-bold">Set up project types</h3>
    
       <div class="row">
        <div class="col-md-8">

            <table class="table table-bordered table-responsive">
                <thead class="table-secondary">
                    <th>Project Type</th>
                    <th>Current Classification Level</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($org_projects as $project)

                    <tr>
                        <td>{{$project->type}}</td>
                        <td>@if($project->risk_scheme=="none")
                            None (Default methodology)
                            @else
                       {{ \App\Support\RiskScheme::all()[$project->risk_scheme]['label'] ?? $project->risk_scheme }}

                            @endif
                        </td>
                        <td><a href="/selected_projects_for_classification_level/{{$project->project_type_id}}/{{$project->org_id}}" class="btn btn-sm btn-primary">Set Classification Level</a></td>
                    </tr>
                        
                    @endforeach
                </tbody>
            </table>

            {{-- <form action="/selected_projects_for_classification_level/{{auth()->user()->organization->id}}" method="GET">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkAll">
                    <label class="form-check-label" for="checkAll">
                      All
                    </label>
                </div>
            
                @foreach ($org_projects as $proj)
                @if($proj->project_type_id!=14 && $proj->project_type_id!=15 )
                <div class="form-check">
                    <input class="form-check-input project-checkbox" value="{{$proj->project_type_id}}" type="checkbox" name="project_types[]">
                    <label class="form-check-label">
                      {{$proj->type}}
                    </label>
                </div>@endif
                @endforeach

                <button type="submit" class="btn btn-primary btn-md">Select Classification Levels
                    </button>
            </form> --}}

        </div>
       </div>
    
    
    
    
    
    </div>
</section>

@section('scripts')
@if(Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}",
        icon: "error",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>
@endif

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}",
        icon: "success",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>

@endif

<script>
    // Select all checkbox logic
    document.addEventListener("DOMContentLoaded", function() {
        const checkAll = document.getElementById("checkAll");
        const checkboxes = document.querySelectorAll(".project-checkbox");

        checkAll.addEventListener("change", function() {
            checkboxes.forEach(cb => cb.checked = checkAll.checked);
        });

        // Optional: sync master checkbox if any child checkbox is manually changed
        checkboxes.forEach(cb => {
            cb.addEventListener("change", function() {
                const allChecked = Array.from(checkboxes).every(cb => cb.checked);
                checkAll.checked = allChecked;
            });
        });
    });

</script>
@endsection

@endsection

