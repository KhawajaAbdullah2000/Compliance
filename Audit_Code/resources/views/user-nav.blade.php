

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-md">
    <div class="container-fluid">
        <!-- Brand Logo -->
        <a class="navbar-brand" href="{{ route('user_home') }}">
            <img src="{{ asset('logo.png') }}" alt="GRCT Logo" class="img-fluid" style="max-height: 120px;">
        </a>

        <!-- Toggle Button for Mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Links and Content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Links -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Home Link -->
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('user_home') }}">Home</a>
                </li>

                <!-- Super User Links -->
                @role('super user')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="superUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        End Users
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="superUserDropdown">
                        <li><a class="dropdown-item" href="/add_end_user/{{ auth()->user()->org_id }}">Add End User</a></li>
                        <li><a class="dropdown-item" href="/end_users/{{ auth()->user()->org_id }}">End Users</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/custom_roles">Global Custom Roles</a>
                </li>
                @endrole

                <!-- End User Links -->
                @role('end user')
                @can('Project Creator')
                <li class="nav-item">
                    <a class="nav-link" href="/projects/{{ auth()->user()->id }}">Projects Created</a>
                </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="/assigned_projects/{{ auth()->user()->id }}">Go to Dashboard</a>
                </li>
                @endrole
            </ul>

            <!-- Right Links -->
            <div class="d-flex align-items-center">
                <a href="{{ url('/logout') }}" class="btn btn-danger btn-md rounded-pill ms-3">Log Out</a>
            </div>
        </div>
    </div>
</nav>
