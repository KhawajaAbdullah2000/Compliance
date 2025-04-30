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


    <h4 class="fw-bold">Enter Data for {{$data_catalog->name}}</h4>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    {{-- <form method="POST" action="/dataset_attributes_submit/{{$data_catalog->project_id}}/{{auth()->user()->id}}">
        @csrf
        <input type="hidden" name="data_catalog_id" value="{{ $data_catalog->id }}">
    
        <div id="field-group">

            <div class="row mb-3 field-set" data-index="0">
                <div class="col-md-4">
                    <input type="text" name="attributes[0][name]" placeholder="Field Name" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <select name="attributes[0][type]" class="form-control type-select" data-index="0" required>
                        <option value="string">Text</option>
                        <option value="date">Date</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="attributes[0][value]" placeholder="Value" class="form-control value-input" id="input-0" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-field w-100">Remove</button>
                </div>
            </div>
            
            
            
        </div>
    
        <button type="button" id="add-field" class="btn btn-sm btn-secondary mb-3">+ Add Field</button>
    
        <button type="submit" class="btn btn-primary mb-3">Save Dataset</button>
    </form> --}}
    
    <form method="POST" action="/dataset_attributes_submit/{{ $data_catalog->project_id }}/{{ auth()->user()->id }}">
        @csrf
        <input type="hidden" name="data_catalog_id" value="{{ $data_catalog->id }}">
    
        <div id="field-group">
            @if(count($template_attributes))
                @foreach($template_attributes as $index => $attr)
                    <div class="row mb-3 field-set" data-index="{{ $index }}">
                        <div class="col-md-4">
                            <input type="text" class="form-control" value="{{ $attr->attribute_name }}" readonly>
                            <input type="hidden" name="attributes[{{ $index }}][name]" value="{{ $attr->attribute_name }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" value="{{ ucfirst($attr->attribute_type) }}" readonly>
                            <input type="hidden" name="attributes[{{ $index }}][type]" value="{{ $attr->attribute_type }}">
                        </div>
                        <div class="col-md-3">
                            <input type="{{ $attr->attribute_type === 'date' ? 'date' : 'text' }}"
                                   name="attributes[{{ $index }}][value]"
                                   placeholder="Enter value"
                                   class="form-control"
                                   required>
                        </div>
                    </div>
                @endforeach
            @else
                {{-- First dataset: allow full entry --}}
                <div class="row mb-3 field-set" data-index="0">
                    <div class="col-md-4">
                        <input type="text" name="attributes[0][name]" placeholder="Field Name" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <select name="attributes[0][type]" class="form-control type-select" data-index="0" required>
                            <option value="string">Text</option>
                            <option value="date">Date</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="attributes[0][value]" placeholder="Value" class="form-control value-input" id="input-0" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-field w-100">Remove</button>
                    </div>
                </div>
            @endif
        </div>
    
        @if(!count($template_attributes))
            <button type="button" id="add-field" class="btn btn-sm btn-secondary mb-3">+ Add Field</button>
        @endif
    
        <button type="submit" class="btn btn-primary mb-3">Save Dataset</button>
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
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif



<script>
    let fieldIndex = 1;
    
    document.getElementById('add-field').addEventListener('click', function () {
        const fieldGroup = document.getElementById('field-group');
    
        const newField = `
            <div class="row mb-3 field-set" data-index="${fieldIndex}">
                <div class="col-md-4">
                    <input type="text" name="attributes[${fieldIndex}][name]" placeholder="Field Name" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <select name="attributes[${fieldIndex}][type]" class="form-control type-select" data-index="${fieldIndex}" required>
                        <option value="string">Text</option>
                        <option value="date">Date</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="text" name="attributes[${fieldIndex}][value]" placeholder="Value" class="form-control value-input" id="input-${fieldIndex}" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-field w-100">Remove</button>
                </div>
            </div>
        `;
    
        fieldGroup.insertAdjacentHTML('beforeend', newField);
        fieldIndex++;
    });
    
    // Change input type to date or text when type is selected
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('type-select')) {
            const index = e.target.getAttribute('data-index');
            const input = document.getElementById('input-' + index);
            const selectedType = e.target.value;
    
            if (input) {
                input.type = selectedType === 'date' ? 'date' : 'text';
                input.value = ''; // reset value when type changes
            }
        }
    });
    
    // Remove a row on "Remove" button click
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-field')) {
            const row = e.target.closest('.field-set');
            if (row) {
                row.remove();
            }
        }
    });
    </script>
    





@endsection

@endsection
