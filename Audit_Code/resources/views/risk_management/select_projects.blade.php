
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
       <h3 class="fw-bold">Set up information security risk management methodology by project type</h3>
    
       <div class="row">
        <div class="col-md-4">

            <form action="/selected_projects_for_framework/{{auth()->user()->organization->id}}" method="GET">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="checkAll">
                    <label class="form-check-label" for="checkAll">
                      All
                    </label>
                </div>
            
                @foreach ($org_projects as $proj)
                <div class="form-check">
                    <input class="form-check-input project-checkbox" value="{{$proj->project_type_id}}" type="checkbox" name="risk_management_methodology[]">
                    <label class="form-check-label">
                      {{$proj->type}}
                    </label>
                </div>
                @endforeach

                <button type="submit" class="btn btn-primary btn-md">Select Information Security Risk
                    Management Methodology for the
                    project types selected
                    </button>
            </form>

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

