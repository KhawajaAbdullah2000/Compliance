<nav class="navbar navbar-expand-lg bg-light mh-20">
    <div class="container-fluid">
      <a class="navbar-brand" href="{{route('user_home')}}"><img src="https://static.wixstatic.com/media/74ef13_47f028fb4d874165906ceed4ba2d8d6f~mv2.png/v1/fill/w_600,h_600,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/GRC.png" alt="GRCT" style="max-height: 150px;overflow: hidden;"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">

            <li class="nav-item active">
                <a class="nav-link" href="{{route('user_home')}}">Home <span class="sr-only">(current)</span></a>
              </li>




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
                <a class="nav-link" href="/assigned_projects/{{auth()->user()->id}}">Projects where roles are assigned to me</a>
              </li>

              {{-- <li class="nav-item">
                <a class="nav-link" href="">Activity Logs</a>
              </li>

              <li class="nav-item">
                <a class="nav-link" href="">Reports</a>
              </li> --}}
              @endrole




        </ul>

        {{-- @if(Session::has('projectid'))

        <div class="">
           <div class="row float-end">
             <div class="col-md-2 mr-2">
               <a href="{{route('iso_section2_1',['proj_id'=>Session::get('projectid'),'user_id'=>Auth()->user()->id])}}" class="navigation-box">2.1</a>
             </div>
             <div class="col-md-2 mx-2">
               <a href="{{route('iso_sec_2_2_subsections',['proj_id'=>Session::get('projectid'),'user_id'=>Auth()->user()->id])}}" class="navigation-box">2.2</a>
             </div>
             <div class="col-md-2 mx-2">
               <a href="/iso_section2_3/{{Session::get('projectid')}}/{{auth()->user()->id}}" class="navigation-box">2.3</a>
             </div>
             <div class="col-md-2 mx-2">
               <a href="{{url('iso_section2_4_subsections',['proj_id'=>Session::get('projectid'),'user_id'=>Auth()->user()->id])}}" class="navigation-box">2.4</a>
             </div>
           </div>
         </div>


         @endif --}}



            <a href="{{ url('/logout') }}" class="btn my_bg_color2 text-white">Log out</a>

      </div>
    </div>
  </nav>
