@extends('master')

@section('content')

@include('user-nav')

<div class="container py-4">
    <h3 class="fw-bold mt-4">View Risk Register for: {{auth()->user()->organization->name}}</h3>
</div>


<div class="col-lg-5 col-md-7 mx-auto">

    <div class="card qa-card overflow-hidden">
        <div class="card-body p-4">

            <div class="d-grid gap-3">

                <a href="/risk_register/project/{{auth()->user()->organization->id}}" class="btn btn-tile btn-proj-register">
                    <span class="label">
                        <i class="bi bi-amd"></i>
                        View Risk Register by Project
                    </span>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="/risk_register/services/{{auth()->user()->organization->id}}" class="btn btn-tile btn-services">
                    <span class="label">
                        <i class="bi bi-unity"></i>
                        View Risk Register by Services
                    </span>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="/risk_register/asset_types/{{auth()->user()->organization->id}}" class="btn btn-tile btn-docs">
                    <span class="label">
                        <i class="bi bi-kanban"></i>
                        View Risk Register by Asset Types
                    </span>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="/risk_register/asset_sub_types/{{auth()->user()->organization->id}}" class="btn btn-tile btn-comp-register">
                    <span class="label">
                        <i class="bi bi-folder2"></i>
                        View Risk Register by Asset Sub Types
                    </span>
                    <i class="bi bi-arrow-right"></i>
                </a>

                <a href="/risk_register/components/{{auth()->user()->organization->id}}" class="btn btn-tile btn-create-project">
                    <span class="label">
                        <i class="bi bi-cast"></i>
                        View Risk Register by Asset Components
                    </span>
                    <i class="bi bi-arrow-right"></i>
                </a>


            </div>
        </div>
    </div>

</div>

</div>

@endsection
