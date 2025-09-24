@extends('master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    
@include('root_nav')


<!-- Page Content  -->
<div id="content" class="p-4 p-md-5">

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
    
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
          <i class="fa fa-bars"></i>
          <span class="sr-only">Toggle Menu</span>
        </button>
        <a href="{{ url('/logout') }}" class="btn btn-primary">Log out</a>

      </div>
    </nav>

    {{-- <div class="mt-4">


    
    <table class="table table-responsive table-hover" id="myTable" style="">
        <thead>
            <tr>
                <th>Name</th>
            
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orgs as $org)

   
            <tr>
                <td>{{$org->name}}</td>

        
 <td> <a class="btn btn-warning btn-md" href="{{route('add_new_user',['id'=>$org->id])}}">Add a user  </a>  </td>
            </tr>
            @endforeach
   
        </tbody>
    </table>

  </div> --}}

  <div class=" mt-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white text-center py-3">
            <h3 class="mb-0 fw-bold">Organizations List</h3>
        </div>

        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th class="py-3">Organization Name</th>
                            <th class="py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orgs as $org)
                        <tr>
                            <td class="fw-semibold">{{ $org->name }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm fw-bold px-3 py-2 shadow-sm" href="{{ route('add_new_user', ['id' => $org->id]) }}">
                                    <i class="fas fa-user-plus"></i> Add a User
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



</div>
</div>


@section('scripts')

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

<script>

let table = new DataTable('#myTable',
    {
    language: {
       searchPlaceholder: "organization"
    },
      "ordering": false



     } 
     );

</script>
@endsection





@endsection