<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

            <li class="nav-item active">
                <a class="nav-link" href="{{route('user_home')}}">Home <span class="sr-only">(current)</span></a>
              </li>

              {{-- <li class="nav-item">
                <a class="nav-link" href="#">Projects</a>
              </li> --}}



              @role('super user')
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  End Users
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item"
                  href="/add_end_user/{{auth()->user()->org_id}}">
                    Add end user</a>
                  <a class="dropdown-item" href="/end_users/{{auth()->user()->org_id}}">
                    End users</a>

                </div>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="/custom_roles">GLobal Custom roles</a>
              </li>

              @endrole

              @role('end user')
              @can('Project Creator')
              <li class="nav-item">
                <a class="nav-link" href="/projects/{{auth()->user()->id}}">Projects created by me</a>
              </li>
              @endcan

              <li class="nav-item">
                <a class="nav-link" href="/assigned_projects/{{auth()->user()->id}}">Projects Assigned to me</a>
              </li>

              @endrole




        </ul>

            <a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>

      </div>
    </div>
  </nav>
