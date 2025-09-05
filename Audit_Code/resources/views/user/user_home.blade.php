@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    {{-- <div class="container py-5 h-100 ">
        <div class="row align-items-center justify-content-center h-100">

            <div class="col-lg-4 col-md-4 mx-auto">
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

                            <a href="/view_risk_register_from_home/{{ auth()->user()->organization->id }}" class="btn btn-tile btn-risk-register">
                                <span class="label">
                                    <i class="bi bi-projector"></i>
                                    VIew Risk Register
                                </span>
                                <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endrole
            </div>

            
            <div class="col-md-8 d-flex justify-content-center">
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
                     
                        <div class="text-center mt-2">

                            @foreach($org_projects as $proj)

                            @if($proj->project_type_id==22)
                         

                            <a href="/create_one_link_erm_project/{{auth()->user()->id}}/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary"> Create 1 Link ERM Project</a>


                            @break
                            @endif

                            @endforeach




                        </div>
                        @endrole



                        @endhasanyrole
                    </div>



                </div>

                <div class="col-md-8">
                    @role('super user')
                    <a href="/select_assets/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary" style="max-width:70%;">Set up asset types and
                        asset subtypes
                    </a>
                    @endrole

                    @role('super user')
                    <a href="/select_projects_for_framework/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary" style="max-width:70%;">Set up Project Types</a>
                    @endrole

                    @role('super user')
                    <a href="/select_projects_for_classification_level/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary">Set up Classification Levels</a>
                    @endrole
                </div>


                @role('super user')
                <div class="text-center mt-2">

                    @foreach($org_projects as $proj)

                    @if($proj->project_type_id==22)
                 

                    <a href="/sub_entities_list/{{auth()->user()->id}}/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary">Set up Sub Entities for 1Link ERM</a>

                    <a href="/entities_list/{{auth()->user()->id}}/{{auth()->user()->organization->id}}" class="btn btn-md btn-primary">Set up Function (Units) within Departments (SBUs) for 1LINK ERM</a>


                    @break
                    @endif

                    @endforeach


                    @endrole





                </div>


            </div>

        </div>

    </div> --}}

    <div class="container py-5 min-vh-100">
  <div class="row g-4 align-items-start">

    {{-- Left: Quick Actions --}}
    <div class="col-lg-6 col-md-6">
      @role('end user')
      <div class="card qa-card overflow-hidden h-100">
        <div class="card-body p-4">
          <h5 class="mb-1">Quick Actions</h5>
          <div class="qa-sub small mb-4">Manage your services, assets, and documents</div>

          <div class="d-grid gap-3">
            <a href="/assigned_projects/{{ auth()->user()->id }}" class="btn btn-tile btn-proj-register">
              <span class="label"><i class="bi bi-kanban"></i> Project Register</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            <a href="/org_services_register/{{ auth()->user()->organization->id }}" class="btn btn-tile btn-services">
              <span class="label"><i class="bi bi-diagram-3"></i> Service/Asset Register</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            <a href="/org_doc_repo/{{ auth()->user()->organization->id }}" class="btn btn-tile btn-docs">
              <span class="label"><i class="bi bi-folder2"></i> Documents Repository</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            <a href="/compliances_all_projects_in_org/{{ auth()->user()->organization->id }}" class="btn btn-tile btn-comp-register">
              <span class="label"><i class="bi bi-shield-check"></i> Compliance Register</span>
              <i class="bi bi-arrow-right"></i>
            </a>

            <a href="/view_risk_register_from_home/{{ auth()->user()->organization->id }}" class="btn btn-tile btn-risk-register">
              <span class="label"><i class="bi bi-projector"></i>Risk Register</span>
              <i class="bi bi-arrow-right"></i>
            </a>

             <a href="/create_project/{{ auth()->user()->id }}" class="btn btn-tile btn-create-project">
              <span class="label"><i class="bi bi-clipboard-plus"></i> Create Project</span>
              <i class="bi bi-arrow-right"></i>
            </a>


             <a href="/scanner_results/{{ auth()->user()->organization->id }}" class="btn btn-tile btn-scanner">
              <span class="label"><i class="bi bi-upc-scan"></i> Scanner Results</span>
              <i class="bi bi-arrow-right"></i>
            </a>
          </div>
        </div>
      </div>
      @endrole
    </div>

    {{-- Right: User Info & Admin Actions --}}
    <div class="col-lg-6 col-md-6">
      <div class="bg-home-card text-white p-4 rounded shadow-lg w-100">
        <h2 class="fw-bold mb-4">
          Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
        </h2>

        @hasanyrole('end user|super user')
        <ul class="list-unstyled mb-4">
          <li><h4>Email: <span class="text-info">{{ auth()->user()->email }}</span></h4></li>
          <li><h5>Organization: <span class="text-info">{{ auth()->user()->organization->name }}</span></h5></li>
          <li><h5>Sub-Organization:
            <span class="text-info">{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</span></h5>
          </li>

          @role('end user')
          <li class="mt-2">
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
          <li class="mt-2">
            <h5 class="d-inline">Global Role:</h5>
            <p class="d-inline"><span class="badge bg-success fs-6">Super User</span></p>
          </li>
          @endrole

          <li class="mt-2">
            <p class="mb-0">Last logged in at: {{ date('F d, Y h:i A', strtotime(auth()->user()->last_logged_in_at)) }}</p>
          </li>
        </ul>

        {{-- End User inline actions --}}
        @role('end user')
        <div class="text-center">
          @foreach($org_projects as $proj)
            @if($proj->project_type_id == 22)
              <a href="/create_one_link_erm_project/{{auth()->user()->id}}/{{auth()->user()->organization->id}}"
                 class="btn btn-primary btn-md">Create 1 Link ERM Project</a>
              @break
            @endif
          @endforeach
        </div>
        @endrole
        @endhasanyrole
      </div>

      {{-- Super User admin links under the card --}}
      @role('super user')
      <div class="row g-2 mt-3">
        <div class="col-12 col-lg-6">
          <a href="/select_assets/{{auth()->user()->organization->id}}" class="btn btn-primary w-100">
            Set up asset types & subtypes
          </a>
        </div>
        <div class="col-12 col-lg-6">
          <a href="/select_projects_for_framework/{{auth()->user()->organization->id}}" class="btn btn-primary w-100">
            Set up Risk Management Methodology
          </a>
        </div>
        <div class="col-12 col-lg-6">
          <a href="/select_projects_for_classification_level/{{auth()->user()->organization->id}}" class="btn btn-primary w-100">
            Set up Classification Levels
          </a>
        </div>
      </div>

      {{-- 1LINK ERM specific --}}
      <div class="d-flex flex-wrap gap-2 mt-3">
        @foreach($org_projects as $proj)
          @if($proj->project_type_id == 22)
            <a href="/sub_entities_list/{{auth()->user()->id}}/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md">
              Set up Sub Entities for 1LINK ERM
            </a>
            <a href="/entities_list/{{auth()->user()->id}}/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md">
              Set up Function (Units) within Departments (SBUs) for 1LINK ERM
            </a>
            @break
          @endif
        @endforeach
      </div>
      @endrole
    </div>

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
