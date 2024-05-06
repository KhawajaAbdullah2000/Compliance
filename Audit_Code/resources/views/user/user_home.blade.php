@extends('master')

@section('content')

@include('user-nav')

<div class="">
    {{-- <h2 class="text-center">Welcome {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h2> --}}


    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-md-6  d-flex align-items-center justify-content-center flex-column">
                <img src="https://img.freepik.com/free-vector/auditor-concept-business-operation-specialist-professional-financial-management-financial-inspection-analytics-isolated-flat-vector-illustration_613284-2577.jpg?size=626&ext=jpg&ga=GA1.1.2008272138.1708387200&semt=ais" alt="Image" style="width: 100%;">
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center">
                <div>
                    <h2 class="fw-bold">Welcome {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h2>

                                    @role('end user')
                <h4 class="mt-4">Email: {{auth()->user()->email}}</h4>
                <h4 class="mt-4">Global roles: @foreach (auth()->user()->permissions as $per)
                                    {{ $per->name}}
                                    @unless ($loop->last), @endunless
                                    @endforeach
                </h4>

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


