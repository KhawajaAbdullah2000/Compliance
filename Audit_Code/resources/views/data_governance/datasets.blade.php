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

    <h4 class="fw-bold">Enter , Import or Upload Dataset : {{$data_catalog->name}} </h4>
 
    <div class="mt-4 d-flex justify-content-end gap-2 mb-2">
        @if ($isEditable)
            <a class="btn btn-success btn-md"
               href="/dataset_attributes/{{$data_catalog->id}}/{{ $project->project_id }}/{{ auth()->user()->id }}" role="button">
                Import Dataset from API
                <i class="fas fa-plus"></i>
            </a>
    
            <a class="btn btn-success btn-md"
               href="/dataset_attributes/{{$data_catalog->id}}/{{ $project->project_id }}/{{ auth()->user()->id }}" role="button">
                Enter Dataset
                <i class="fas fa-plus"></i>
            </a>

            <a class="btn btn-secondary btn-md"
            href="/data_catalog_list/{{ $project->project_id }}/{{ auth()->user()->id }}" role="button">
             Back
        
         </a>
        @endif
    </div>
    

{{--  
    @forelse($datasets as $dataset)
    <h5 class="mt-4">Dataset #{{ $dataset->id }}</h5>
    <table id="dataCatalogTable" class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr class="text-center">
                @foreach($dataset->attributes as $attribute)
                    <th>{{ $attribute->attribute_name }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
                @foreach($dataset->attributes as $attribute)
                    <td>
                        {{ $attribute->attribute_type === 'date' ? \Carbon\Carbon::parse($attribute->attribute_value)->format('Y-m-d') : $attribute->attribute_value }}
                    </td>
                @endforeach
            </tr>
        </tbody>
    </table>
@empty
    <div class="alert alert-warning">No datasets found.</div>
@endforelse
    
         --}}

         @if($datasets->isNotEmpty())
    <h5 class="mt-4">Datasets (Total: {{ $datasets->count() }})</h5>

    <table id="dataCatalogTable" class="table table-bordered table-striped">
        <thead class="table-dark text-center">
            <tr>
                @foreach($datasets->first()->attributes as $attribute)
                    <th>{{ $attribute->attribute_name }}</th>
                @endforeach
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach($datasets as $dataset)
                <tr>
                    @foreach($dataset->attributes as $attribute)
                        <td>
                            {{ $attribute->attribute_type === 'date' && $attribute->attribute_value
                                ? \Carbon\Carbon::parse($attribute->attribute_value)->format('Y-m-d')
                                : $attribute->attribute_value }}
                        </td>
                    @endforeach
                    <td>    
                    <a href="/edit_dataset/{{ $dataset->id }}/{{$data_catalog->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="text-success">
                        <i class="fa fa-edit fa-lg"></i>
                    </a></td>
                    <td>    <a href="/delete_dataset/{{ $dataset->id }}/{{$data_catalog->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="text-danger">
                        <i class="fa fa-trash fa-lg"></i>
                    </a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div class="alert alert-warning">No datasets found.</div>
@endif

<a href="/calculate_quality_score/{{$data_catalog->id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-success btn-md mt-4 mb-2 float-end">Calculate Quality Score</a>

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
