@extends('master')

@section('content')

@include('user-nav')

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>

    <h4 class="fw-bold">Edit Dataset for {{ $data_catalog->name }}</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="/update_dataset/{{ $dataset->id }}/{{$project->project_id}}/{{auth()->user()->id}}">
        @csrf
        <input type="hidden" name="data_catalog_id" value="{{ $data_catalog->id }}">

        <div id="field-group">
            @foreach($attributes as $index => $attr)
            <div class="row mb-3 field-set" data-index="{{ $index }}">
                <div class="col-md-4">
                    <input type="text" name="attributes[{{ $index }}][name]" value="{{ $attr->attribute_name }}" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <select name="attributes[{{ $index }}][type]" class="form-control type-select" data-index="{{ $index }}" required>
                        <option value="string" {{ $attr->attribute_type === 'string' ? 'selected' : '' }}>Text</option>
                        <option value="date" {{ $attr->attribute_type === 'date' ? 'selected' : '' }}>Date</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="{{ $attr->attribute_type === 'date' ? 'date' : 'text' }}"
                        name="attributes[{{ $index }}][value]"
                        value="{{ $attr->attribute_value }}"
                        class="form-control value-input"
                        id="input-{{ $index }}"
                        required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-field w-100">Remove</button>
                </div>
            </div>
            @endforeach
            <script>var fieldIndex = {{ count($attributes) }};</script>
        </div>

        <button type="button" id="add-field" class="btn btn-sm btn-secondary mb-3">+ Add Field</button>
        <button type="submit" class="btn btn-primary mb-3">Update Dataset</button>
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
        timer: 3000,
    });
</script>
@endif

<script>
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

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('type-select')) {
            const index = e.target.getAttribute('data-index');
            const input = document.getElementById('input-' + index);
            const selectedType = e.target.value;

            if (input) {
                input.type = selectedType === 'date' ? 'date' : 'text';
                input.value = '';
            }
        }
    });

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