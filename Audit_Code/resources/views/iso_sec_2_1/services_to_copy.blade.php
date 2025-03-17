{{-- @extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')


<div class="container">
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

    <h3>Project Name from where Services and its Assets will be copied: {{$project_to_copy->project_name}}</h3>

    <table class="table table-info table-responsive">

        <tr>
            <th>Service Name</th>
            <th>Action</th>
        </tr>
        @if($services->count()>0)

        @foreach ($services as $ser )

     <tr>
        <td>{{$ser->s_name}}</td>
        <td><a href="/show_groups/{{$project->project_id}}/{{auth()->user()->id}}/{{$project_to_copy->project_id}}/{{$ser->s_name}}" class="btn btn-md btn-success">Copy</a></td>
     </tr>

        @endforeach

        @else
        <tr>
            <td colspan="2">No Service found</td>
        </tr>
        @endif

    </table>

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



@endsection --}}


@extends('master')

@section('content')

@include('user-nav')
@include('iso_sec_nav')

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}</a></td>
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

    <h3>Project Name from where Services and its Assets will be copied: {{$project_to_copy->project_name}}</h3>

    <form action="{{ route('show_groups') }}" method="POST">
        @csrf
        <input type="hidden" name="proj_id" value="{{ $project->project_id }}">
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
        <input type="hidden" name="proj_to_copy" value="{{ $project_to_copy->project_id }}">

        <table class="table table-info table-responsive">
            <thead>
                <tr>
                    <th style="width: 20%">
                        <input type="checkbox" id="select-all"> Select All
                    </th>
                    <th>Service Name</th>
                </tr>
            </thead>
            <tbody>
                @if($services->count() > 0)
                    @foreach ($services as $ser)
                        <tr>
                            <td>
                                <input type="checkbox" name="services[]" value="{{ $ser->s_name }}" class="service-checkbox">
                            </td>
                            <td>{{ $ser->s_name }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2">No Service found</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <button type="submit" class="btn btn-md btn-success mt-3">Copy Assets in the Selected Service</button>
    </form>
</div>

@section('scripts')

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}",
        icon: "success",
        closeOnClickOutside: true,
        timer: 3000,
    });
</script>
@endif

@if(Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}",
        icon: "error",
        closeOnClickOutside: true,
        timer: 6000,
    });
</script>
@endif

<script>
    // Select All Checkbox Functionality
    document.getElementById('select-all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('.service-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });
</script>

@endsection
@endsection
