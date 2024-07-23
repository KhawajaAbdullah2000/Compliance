<nav class="navbar navbar-expand-lg bg-light mh-20">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="navbar-brand" href="{{ route('user_home') }}">
            <img src="{{ asset('logo.png') }}" alt="GRCT" class="img-fluid" style="max-height: 120px;">
        </a>

        <!-- Toggler Button -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
                <!-- Home Link -->
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('user_home') }}">Home <span class="sr-only">(current)</span></a>
                </li>

                <!-- Super User Role -->
                @role('super user')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        End Users
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/add_end_user/{{ auth()->user()->org_id }}">Add end user</a></li>
                        <li><a class="dropdown-item" href="/end_users/{{ auth()->user()->org_id }}">End users</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/custom_roles">Global Custom roles</a>
                </li>
                @endrole

                <!-- End User Role -->
                @role('end user')
                @can('Project Creator')
                <li class="nav-item">
                    <a class="nav-link" href="/projects/{{ auth()->user()->id }}">Projects created by me</a>
                </li>
                @endcan
                <li class="nav-item">
                    <a class="nav-link" href="/assigned_projects/{{ auth()->user()->id }}">Projects where roles are assigned to me</a>
                </li>
                @endrole
            </ul>

            <!-- Logout Button -->
            <a href="{{ url('/logout') }}" class="btn my_bg_color2 text-white">Log out</a>
        </div>
    </div>
</nav>
