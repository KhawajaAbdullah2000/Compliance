
 @extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5 h-100 ">
        <div class="row align-items-center h-100">
            <!-- Left Section: Logo -->
            <div class="col-md-6 d-flex justify-content-center">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="img-fluid rounded shadow-lg" style="max-width: 80%; height: auto;">
            </div>

            <!-- Right Section: User Info -->
            <div class="col-md-6 d-flex justify-content-center">
                <div class="text-white p-4 bg-home-card rounded shadow-lg" style="max-width: 90%;">
                    <h2 class="fw-bold mb-4">Welcome, {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</h2>

                    @role('end user')
                    <ul class="list-unstyled">
                        <li>
                            <h4>Email: <span class="text-info">{{ auth()->user()->email }}</span></h4>
                        </li>
                        <li>
                            <h5>Organization: <span class="text-info">{{ auth()->user()->organization->name }}</span></h5>
                        </li>
                        <li>
                            <h5>Department: <span class="text-info">{{ auth()->user()->organization->sub_org }}</span></h5>
                        </li>
                        <li>
                            <h5 class="d-inline">Global Role:</h5>
                            <p class="d-inline">
                                @if (auth()->user()->permissions->isEmpty())
                                    <span class="text-warning">None</span>
                                @else
                                    @foreach (auth()->user()->permissions as $per)
                                        <span class="badge bg-success fs-6">{{ $per->name }}</span>
                                    @endforeach
                                @endif
                            </p>
                        </li>
                    </ul>

                    @can('Project Creator')
                    <div class="d-grid gap-3">
                        <a href="/create_project/{{ auth()->user()->id }}" class="btn btn-outline-light btn-lg">Create New Project</a>
                        <a href="/my_personal_dashboard/{{ auth()->user()->id }}" class="btn btn-outline-info btn-lg">Visual and AI Dashboard</a>
                    </div>
                    @endcan

                    @endrole
                </div>
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
@endsection

@endsection

