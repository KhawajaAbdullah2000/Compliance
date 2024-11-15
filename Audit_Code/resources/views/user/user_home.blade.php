@extends('master')

@section('content')

@include('user-nav')

<div class="">
    {{-- <h2 class="text-center">Welcome {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h2> --}}


    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-md-6  d-flex align-items-center justify-content-center flex-column">
                <img src="{{ asset('logo.png') }}" alt="Image" style="width: 80%; height:90%">
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div>
                    <h2 class="fw-bold">Welcome {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h2>

                                    @role('end user')
                <h4 class="mt-4">Email: {{auth()->user()->email}}</h4>

                <h5 class="mt-4">Organization: {{auth()->user()->organization->name}}</h5>
                <h5 class="mt-4">Department: {{auth()->user()->organization->sub_org}}</h5>


                <h5 class="mt-4">Global roles: 
                    @if (auth()->user()->permissions->isEmpty())
                        none
                    @else
                        @foreach (auth()->user()->permissions as $per)
                            {{ $per->name }}
                            @unless ($loop->last), @endunless
                        @endforeach
                    @endif
                </h5>
                

                @can('Project Creator')

        <a  type="button" href="/create_project/{{auth()->user()->id}}" class="btn text-light my_bg_color btn-rounded" >Create new project</a>

                {{-- <a href="/create_project/{{auth()->user()->id}}" class='btn btn-primary'>Create new project</a> --}}
                @endcan
                <br>
 <a  type="button" href="/my_personal_dashboard/{{auth()->user()->id}}" class="btn text-light my_bg_color btn-rounded mt-4" >Visual and AI dashboard</a>


                @endrole
                </div>
            </div>
        </div>
    </div>




    {{-- <br>
<a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>
</div> --}}



<div class="container">


    {{-- @role('end user')
<h3 class="mt-4">Email: {{auth()->user()->email}}</h3>
<h3 class="mt-4">Global roles: @foreach (auth()->user()->permissions as $per)
                     {{ $per->name}}
                     @unless ($loop->last), @endunless
                      @endforeach
</h3>

@can('Project Creator')

 <a href="/create_project/{{auth()->user()->id}}" class='btn btn-primary'>Create new project</a>
@endcan

@endrole --}}

</div>



@section('scripts')
@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif

@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif


@endsection

@endsection


