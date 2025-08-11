@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5 h-100 ">
        <div class="row align-items-center h-100">
            {{-- <div class="col-md-6 justify-content-center">
                @role('end user')
                <div class="mb-2">
                    <a href="/org_services_register/{{auth()->user()->organization->id}}" class="btn btn-md btn-warning w-75">
            Service/Asset Register
            </a>
        </div>

        <div class="mb-2">
            <a href="/org_doc_repo/{{auth()->user()->organization->id}}" class="btn btn-md btn-warning w-75">
                Documents Repository
            </a>
        </div>

        @endrole

    </div> --}}

    <div class="col-lg-5 col-md-7 mx-auto">
        @role('end user')
        <div class="card qa-card overflow-hidden">
            <div class="card-body p-4">
                <h5 class="mb-1">Quick Actions</h5>
                <div class="qa-sub small mb-4">Manage your services, assets, and documents</div>

                <div class="d-grid gap-3">

                    <a href="/assigned_projects/{{ auth()->user()->id }}" class="btn btn-tile btn-proj-register">
                        <span class="label">
                            <i class="bi bi-kanban"></i>
                            Project Register
                        </span>
                        <i class="bi bi-arrow-right"></i>
                    </a>


                    <a href="/org_services_register/{{ auth()->user()->organization->id }}" class="btn btn-tile btn-services">
                        <span class="label">
                            <i class="bi bi-diagram-3"></i>
                            Service/Asset Register
                        </span>
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    <a href="/org_doc_repo/{{ auth()->user()->organization->id }}" class="btn btn-tile btn-docs">
                        <span class="label">
                            <i class="bi bi-folder2"></i>
                            Documents Repository
                        </span>
                        <i class="bi bi-arrow-right"></i>
                    </a>

                    <a href="/compliances_all_projects_in_org/{{ auth()->user()->organization->id }}" class="btn btn-tile btn-comp-register">
                        <span class="label">
                         <i class="bi bi-shield-check"></i>
                            Compliance Register
                        </span>
                        <i class="bi bi-arrow-right"></i>
                    </a>

                      <a href="/create_project/{{ auth()->user()->id }}" class="btn btn-tile btn-create-project">
                        <span class="label">
                        <i class="bi bi-clipboard-plus"></i>
                            Create Project
                        </span>
                        <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endrole
    </div>

    <!-- Right Section: User Info -->
    <div class="col-md-6 d-flex justify-content-center">
        <div class="text-white p-4 bg-home-card rounded shadow-lg" style="max-width: 90%;">
            <h2 class="fw-bold mb-4">Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>

            @hasanyrole('end user|super user')
            <ul class="list-unstyled">
                <li>
                    <h4>Email: <span class="text-info">{{ auth()->user()->email }}</span></h4>
                </li>
                <li>
                    <h5>Organization: <span class="text-info">{{ auth()->user()->organization->name }}</span></h5>
                </li>
                <li>
                    <h5>Sub-Organization: <span class="text-info">{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</span></h5>
                </li>
                @role('end user')
                <li>

                    <h5 class="d-inline">Global Role:</h5>
                    <p class="d-inline">
                        @if (auth()->user()->permissions->isEmpty())
                        <span class="text-warning">End User</span>
                        @else
                        @foreach (auth()->user()->permissions as $per)
                        <span class="badge bg-success fs-6">{{ $per->name }}</span>
                        @endforeach
                        @endif
                    </p>
                </li>
                @endrole

                @role('super user')
                <li>

                    <h5 class="d-inline">Global Role:</h5>
                    <p class="d-inline">

                        <span class="badge bg-success fs-6">Super User</span>

                    </p>
                </li>
                @endrole
                <li class="mt-2">
                    <p>Last logged in at: {{date('F d, Y H:i:A', strtotime(auth()->user()->last_logged_in_at))}}</p>
                </li>
            </ul>

            @role('end user')
            <div class="d-grid gap-3">
                @can('Project Creator')
                <a href="/create_project/{{ auth()->user()->id }}" class="btn btn-outline-light btn-lg">Create New Project</a>
                @endcan
                <a href="/assigned_projects/{{ auth()->user()->id }}" class="btn btn-outline-info btn-lg">Go to Dashboard</a>

                {{-- <a href="/my_personal_dashboard/{{ auth()->user()->id }}" class="btn btn-outline-info btn-lg">Visual and AI Dashboard</a> --}}
                <div class="text-center mt-2">

                    @foreach($org_projects as $proj)

                    @if($proj->project_type_id==22)
                    {{-- 1 Link ERM --}}

                    <a href="/create_one_link_erm_project/{{auth()->user()->id}}/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary"> Create 1 Link ERM Project</a>


                    @break
                    @endif

                    @endforeach




                </div>
                @endrole

                @role('super user')
                <a href="/select_assets/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary" style="max-width:70%;">Set up asset types and
                    asset subtypes
                </a>
                @endrole

                @role('super user')
                <a href="/select_projects_for_framework/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary mt-4" style="max-width:70%;">Set up project types</a>
                @endrole





                @endhasanyrole
            </div>


        </div>

        @role('super user')
        <div class="text-center mt-2">

            @foreach($org_projects as $proj)

            @if($proj->project_type_id==22)
            {{-- 1 Link ERM --}}

            <a href="/sub_entities_list/{{auth()->user()->id}}/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary">Set up Sub Entities for 1Link ERM</a>

            <a href="/entities_list/{{auth()->user()->id}}/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary">Set up Function (Units) within Departments (SBUs) for 1LINK ERM</a>


            @break
            @endif

            @endforeach


            @endrole





        </div>


    </div>
</section>

@section('scripts')
@if(Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}"
        , icon: "success"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif
@endsection

@endsection
