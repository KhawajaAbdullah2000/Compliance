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

    <div class="container">
    
    <h1 class="text-center mb-5">Organizations</h1>

    <input type="text" placeholder="search"> 
    <button type="button" class="btn btn-sm btn-primary">Search</button>

    <a class="btn btn-success btn-md float-end" href="#" role="button">Add new <i class="fas fa-plus"></i></a>
    <table class="table table-responsive table-sm table-hover mt-4">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Sub-org</th>
                <th>Country</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($organizations as $org)

   
            <tr>
                <td>{{$org->name}}</td>
                <td>{{$org->type}}</td>
                <td>{{$org->sub_org}}</td>
                <td>{{$org->country}}</td>
                <td> <a href="" data-toggle="tooltip" data-placement="top" title="See more details"><i class="fas fa-eye" style="color: blue;"></i></a>
                <a href="" data-toggle="tooltip" data-placement="top" title="Edit info"> <i class="fas fa-edit" style="color: #146e02;"></i></a>
             
                    <a href="" data-toggle="tooltip" data-placement="top" title="Delete record"><i class="fas fa-trash" style="color: #d01616;"></i></a>
                
                </td>
            </tr>
            @endforeach
   
        </tbody>
    </table>

</div>

</div>
</div>

@section('scripts')
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection

@endsection