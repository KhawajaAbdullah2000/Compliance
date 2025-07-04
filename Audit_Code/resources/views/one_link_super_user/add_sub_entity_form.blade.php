@extends('master')

@section('content')

@include('user-nav')

{{-- ---------------  PAGE HEADER --------------- --}}
<div class="container py-5">
    <h4>
        Organization:
        <span class="fw-bold">{{ $user->organization->name ?? '-' }}</span>
    </h4>

    <h3 class="fw-bold">Set up Sub-Entities</h3>


    {{-- ---------------  FORM --------------- --}}
    <form action="/submit_sub_entities/{{auth()->user()->organization->id}}/{{auth()->user()->id}}" method="POST" class="mt-4">
        @csrf

        @php
            // Helper array to DRY-up the markup
            $blocks = [
        
                ['key' => 'products',      'label' => 'Product'],
                ['key' => 'cycles',        'label' => 'Cycle/Process'],
                ['key' => 'sub_processes', 'label' => 'Sub-Process'],
            ];
        @endphp

        @foreach ($blocks as $block)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                    <span>{{ $block['label'] }}{{ $block['label']==='Cycle' ? '' : 's' }}</span>
                    <button
                        type="button"
                        class="btn btn-sm btn-light add-row"
                        data-target="#wrapper-{{ $block['key'] }}"
                    >
                        <i class="fas fa-plus"></i>
                    </button>
                </div>

                <div class="card-body" id="wrapper-{{ $block['key'] }}">
                    {{-- prototype row --}}
                    <div class="row g-2 align-items-center input-row">
                        <div class="col-11">
                            <input
                                type="text"
                                name="{{ $block['key'] }}[]"
                                class="form-control"
                                placeholder="{{ $block['label'] }} name"
                             
                            >
                        </div>
                        <div class="col-1 text-end">
                            {{-- minus button appears via JS once >1 rows exist --}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-end">
            <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-save me-1"></i>Save Sub-Entities
            </button>
        </div>
    </form>
</div>


{{-- ---------------  SCRIPTS --------------- --}}
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {

    // Attach event to all Add buttons
    document.querySelectorAll('.add-row').forEach(addBtn => {
        addBtn.addEventListener('click', () => {
            const wrapper = document.querySelector(addBtn.dataset.target);
            const firstRow = wrapper.querySelector('.input-row');
            const newRow = firstRow.cloneNode(true);

            // Reset input value
            const input = newRow.querySelector('input');
            input.value = '';

            // Remove any old minus button
            const minusWrapper = newRow.querySelector('.col-1');
            minusWrapper.innerHTML = '';

            // Create a fresh minus button
            const minusBtn = document.createElement('button');
            minusBtn.type = 'button';
            minusBtn.className = 'btn btn-link text-danger p-1 remove-row';
            minusBtn.innerHTML = '<i class="fas fa-minus"></i>';

            // Attach event to the minus button
            minusBtn.addEventListener('click', () => {
                newRow.remove();
                toggleMinusButtons(wrapper);
            });

            minusWrapper.appendChild(minusBtn);

            // Append the new row and refresh minus visibility
            wrapper.appendChild(newRow);
            toggleMinusButtons(wrapper);
        });
    });

    
    // Function to show/hide minus buttons based on count
    function toggleMinusButtons(wrapper) {
        const rows = wrapper.querySelectorAll('.input-row');
        const show = rows.length > 1;
        wrapper.querySelectorAll('.remove-row').forEach(btn => {
            btn.style.visibility = show ? 'visible' : 'hidden';
        });
    }

});
</script>
@endsection
@endsection
