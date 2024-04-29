@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')


<div class="container">

    @foreach ($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach

    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3>Project Name from where Groups will be copied: {{$project_to_copy->project_name}}</h3>

    <form action="/copy_groups/{{$project->project_id}}/{{auth()->user()->id}}/{{$project_to_copy->project_id}}/{{$servicename}}" method="post">
        @csrf

    <table class="table table-info table-responsive">

        <tr>
            <th>Group Name</th>
            <th>Action</th>
        </tr>
        @if($groups->count()>0)

        @foreach ($groups as $grp )

     <tr>
        <td>{{$grp->g_name}}</td>
        <td>   <input type="checkbox" name="group_to_copy[]" id="" value={{$grp->g_name}} checked></td>

     </tr>

        @endforeach

        @else
        <tr>
            <td colspan="2">No Groups found</td>
        </tr>
        @endif

    </table>

    <button type="submit" class="btn btn-success btn-md float-end">Copy Assets in the group</button>
</form>

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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 6000,
    });
</script>
@endif




@endsection



@endsection
