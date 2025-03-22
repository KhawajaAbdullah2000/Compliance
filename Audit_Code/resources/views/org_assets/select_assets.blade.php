
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
       <h2 class="fw-bold">Set up asset categories and asset types</h2>
    
       <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-dark">Select Asset Categories</h4>
                    <p class="text-primary small">
                        <i class="fa fa-bullhorn me-2"></i>
                        Asset categories are mandatory to assign to asset components, as they determine which controls are applicable. You can make any control non-applicable at any time.
                    </p>
    
                    <form action="/add_asset_categories_in_org/{{auth()->user()->organization->id}}" method="POST">
                        @csrf
                        <div class="form-group">
                            @foreach ($global_categories as $category)
                            <div class="form-check mb-2">
                                @php
                                    $isChecked = $org_categories->contains('asset_category_selected', $category->asset_category_id);
                                @endphp
                                <input 
                                    class="form-check-input" 
                                    type="checkbox" 
                                    name="asset_categories[]" 
                                    value="{{ $category->asset_category_id }}" 
                                    id="cat-{{ $category->asset_category_id }}"
                                    {{ $isChecked ? 'checked' : '' }}
                                >
                                <label class="form-check-label" for="cat-{{ $category->asset_category_id }}">
                                    {{ $category->asset_category }}
                                </label>
                            </div>
                        @endforeach
                        
                            
                        </div>

    
                        <button type="submit" class="btn btn-primary mt-3">Save Categories</button>
                    </form>

                                <!-- Custom Asset Categories Section -->
<div class="card mt-4 shadow-sm border-0 rounded-3">
    <div class="card-body">
        <h5 class="card-title fw-bold text-dark mb-3">Custom Asset Categories</h5>

        @if($custom_org_categories->isEmpty())
            <p class="text-muted">No custom asset categories added yet.</p>
        @else
            <ul class="list-group list-group-flush">
                @foreach ($custom_org_categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $category->asset_category }}</span>
                        <div>
                            <!-- Edit Button -->
                            <a href="{{ url('/edit_custom_category/' . $category->asset_category_id) }}" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fa fa-pencil-alt"></i> Edit
                            </a>

                            <!-- Delete Button (confirm before deleting) -->
                            <form action="{{ url('/delete_custom_category/' . $category->asset_category_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fa fa-trash"></i> Delete from Organization
                                </button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

                    
                </div>
            </div>
            <a href="/add_new_category_in_org/{{auth()->user()->organization->id}}" class="btn btn-success btn-md">Add new Category</a>
        </div>
    </div>
    
        
    </div>
    
    
    
    
    
    
    </div>
</section>

@section('scripts')
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


@endsection

@endsection

