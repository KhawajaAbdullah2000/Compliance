@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">

    
    <h4 class="fw-bold">Set up Sub-Entities within Departments (SBUs)</h4>
               
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <div class="card shadow-sm border-0">
             

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Department</th>
                                    <th scope="col">Edit Sub-Entity</th>
                                 <th scope="col">View Existing Sub-Entities</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($departments as $dept)
                                <tr>
                                    <td>{{ $dept->name }}</td>
                                    <td>
                                        <a href="/add_sub_entity/{{auth()->user()->organization->id}}/{{$dept->id}}/{{auth()->user()->id}}" data-bs-toggle="tooltip" title="Edit {{ $dept->name }}">
                                            <i class="fas fa-edit fa-lg text-success"></i>
                                        </a>
                                    </td>

                                       <td>
                                        <a href="/view_sub_entities/{{auth()->user()->organization->id}}/{{$dept->id}}/{{auth()->user()->id}}" data-bs-toggle="tooltip" title="Edit {{ $dept->name }}">
                                            <i class="fas fa-eye fa-lg text-primary"></i>
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
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>

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
