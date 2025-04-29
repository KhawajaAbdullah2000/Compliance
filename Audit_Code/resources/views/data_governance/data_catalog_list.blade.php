@extends('master')

@section('content')

@include('user-nav')


@php
$permissions = json_decode($project_permissions);

// User can edit data if they have "Data Inputter"
$isEditable = in_array('Data Inputter', $permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>

 
    <div class="mt-4">
        @if ($isEditable)
        <a class="btn btn-success btn-md float-end mb-2"
            href="/data_catalog_new/{{ $project->project_id }}/{{ auth()->user()->id }}" role="button">Enter Service or Asset
            <i class="fas fa-plus"></i></a>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Data Source</th>
                <th>Data Type</th>
                <th>Data Definition</th>
                <th>Owner Dept</th>
                <th>User Dept</th>
                <th>Governance Policy</th>
                <th>Confidentiality Tag</th>
                <th>Integrity Tag</th>
                <th>Availability Tag</th>
                <th>Quality Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data_catalog as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->data_source }}</td>
                <td>{{ $item->data_type }}</td>
                <td>{{ $item->data_definition }}</td>
                <td>{{ $item->owner_dept }}</td>
                <td>{{ $item->user_dept }}</td>
                <td>
                    @if($item->governance_policy)
                        <a href="{{ asset('data_catalog/' . $item->governance_policy) }}" target="_blank">
                            {{ $item->governance_policy }}
                        </a>
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $item->confidentiality_tag }}</td>
                <td>{{ $item->integrity_tag }}</td>
                <td>{{ $item->availability_tag }}</td>
                <td>{{ $item->quality_score ?? 'N/A' }}</td>
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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif



@endsection

@endsection
