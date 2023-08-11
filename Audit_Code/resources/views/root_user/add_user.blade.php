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
    
    <table class="table table-responsive table-hover mt-4" id="myTable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Sub-org</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orgs as $org)

   
            <tr>
                <td>{{$org->name}}</td>
                <td>{{$org->sub_org}}</td>
        
 <td> <a class="btn btn-warning btn-md" href="{{route('add_new_user',['id'=>$org->org_id])}}">Add a user  </a>  </td>
            </tr>
            @endforeach
   
        </tbody>
    </table>


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