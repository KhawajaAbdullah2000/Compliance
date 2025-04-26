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
        <table id="" class="table table-bordered table-hover table-striped">
            <thead class="table-dark">
                <tr style="cursor: pointer" class="text-center">
                    <th>Dataset ID/Name</th>
                    <th>Datasource</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($data_catalog) && count($data_catalog) > 0)

                    @foreach($data_catalog as $catalog)
                        <tr class="">
                            <td>{{ $catalog->dataset_id ?? 'N/A' }}</td>
                            <td>{{ $catalog->datasource ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="fw-bold fs-6">Data not present</td>
                    </tr>
                @endif
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
