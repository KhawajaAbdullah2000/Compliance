
    <nav id="sidebar">
        <div class="p-4 pt-5">
          <a href="#" class="img logo rounded-circle mb-5" style=""></a>
    <ul class="list-unstyled components mb-5">
      {{-- <li class="active">
        <a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Home</a>
        <ul class="collapse list-unstyled" id="homeSubmenu">
        <li>
            <a href="#">Home 1</a>
        </li>
        <li>
            <a href="#">Home 2</a>
        </li>
        <li>
            <a href="#">Home 3</a>
        </li>
        </ul>
      </li> --}}
      <li>
        <a href="{{route('root_home')}}">Home</a>
    </li>
      <li>
          <a href="{{route('organizations')}}">Organizations</a>
      </li>
      <li>
      <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">Users</a>
      <ul class="collapse list-unstyled" id="pageSubmenu">
        <li>
            <a href="{{route('add_user')}}">Add a user</a>
        </li>
        <li>
            <a href="{{route('users')}}">All users</a>
        </li>
      </ul>
      </li>

    </ul>


  </div>
</nav>


