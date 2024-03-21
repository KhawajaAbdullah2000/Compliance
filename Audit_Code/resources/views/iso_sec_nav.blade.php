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
        <a href="/iso_section2_3/{{$project_id}}/{{auth()->user()->id}}" class="navigation-box">2.3</a>
      </div>
      <div class="col-md-2 mx-2">
        <a href="{{url('iso_section2_4_subsections',['proj_id'=>Session::get('projectid'),'user_id'=>Auth()->user()->id])}}" class="navigation-box">2.4</a>
      </div>
    </div>
  </div>


<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent2">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="{{route('iso_section2_1',['proj_id'=>Session::get('projectid'),'user_id'=>Auth()->user()->id])}}">
            Iso Section 2.1</a>
        </li>

        <li class="nav-item active">
            <a class="nav-link" href="{{route('iso_sec_2_2_subsections',['proj_id'=>Session::get('projectid'),'user_id'=>Auth()->user()->id])}}">
              Iso Section 2.2</a>
          </li>


          <li class="nav-item active">
            <a class="nav-link" href="{{route('iso_section2_1',['proj_id'=>Session::get('projectid'),'user_id'=>Auth()->user()->id])}}">
              Iso Section 2.3</a>
          </li>

          <li class="nav-item active">
            <a class="nav-link" href="{{url('iso_section2_4_subsections',['proj_id'=>Session::get('projectid'),'user_id'=>Auth()->user()->id])}}">
              Iso Section 2.4</a>
          </li>




      </ul>

    </div>
  </nav>
  @endif

 --}}
