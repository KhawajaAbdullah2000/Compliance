{{-- 
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
       <h2 class="fw-bold">Set up Asset Types</h2>
    
       <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-1 rounded-3">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-dark">Select Asset Types</h4>
                    <p class="text-primary small">
                        <i class="fa fa-bullhorn me-2"></i>
                        Asset types are mandatory to assign to asset components, as they determine which controls are applicable. You can make any control non-applicable at any time.
                    </p>

                    <form action="/add_asset_categories_in_org/{{ auth()->user()->organization->id }}" method="POST">
                        @csrf
                        <div class="form-group">
                            @foreach ($global_categories as $category)
                                <div class="form-check mb-2 d-flex align-items-center justify-content-between">
                                    <div>
                                        @php
                                            $isFirstTime = $org_categories->isEmpty();
                                            $isChecked = $isFirstTime || $org_categories->contains('asset_category_selected', $category->asset_category_id);
                                            $show_btn=$org_categories->contains('asset_category_selected', $category->asset_category_id);
                                      @endphp
                                        <input 
                                            class="form-check-input me-2" 
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
                    
                                    @if ($show_btn)
                                        <a href="{{ url('/select_asset_types_for_category/' . $category->asset_category_id) }}" class="btn btn-sm btn-outline-success">
                                            Select Asset Subtypes
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    
                        <button type="submit" class="btn btn-primary mt-3">Save Asset Types</button>
                    </form>
                    

                                <!-- Custom Asset Categories Section -->
<div class="card mt-4 shadow-sm border-1 rounded-3">
    <div class="card-body">
        <h5 class="card-title fw-bold text-dark mb-3">Custom Asset Types</h5>

        @if($custom_org_categories->isEmpty())
            <p class="text-muted">No custom asset types added yet.</p>
        @else
            <ul class="list-group list-group-flush">
                @foreach ($custom_org_categories as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $category->asset_category }}</span>
                        <div>

                             <a href="{{ url('/select_asset_types_for_category/' . $category->asset_category_id) }}" class="btn btn-sm btn-outline-success">
                                            Select Asset Subtypes
                                        </a>


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
            <div class="mt-2">
            <a href="/add_new_category_in_org/{{auth()->user()->organization->id}}" class="btn btn-success btn-md">Add new Asset Type</a>
        </div>
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
 --}}


 
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
       <h2 class="fw-bold">Set up Asset Types and Asset Subtypes</h2>
    
       <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm border-1 rounded-3">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-dark">Select Asset Types</h4>
                    <p class="text-primary small">
                        <i class="fa fa-bullhorn me-2"></i>
                        Asset types are mandatory to assign to asset components, as they determine which controls are applicable. Adding Asset Subtypes is optional.
                    </p>

        
                    <form action="/add_asset_categories_in_org/{{ auth()->user()->organization->id }}" method="POST">
                        @csrf
                        <div class="form-group">
                            @foreach ($global_categories as $category)
                            @php
                                $isFirstTime = $org_categories->isEmpty();
                                $isChecked = $isFirstTime || $org_categories->contains('asset_category_selected', $category->asset_category_id);
                                $show_btn = $org_categories->contains('asset_category_selected', $category->asset_category_id);
                                $subtypes = $all_global_asset_types[$category->asset_category_id] ?? collect();
                                $subtypesText = $subtypes->isNotEmpty() 
                                    ? $subtypes->pluck('asset_type')->implode(', ') 
                                    : 'No subtypes available.';
                            @endphp
                            <div class="form-check mb-2 d-flex align-items-center justify-content-between">
                                <div>
                                    <input class="form-check-input me-2" type="checkbox" name="asset_categories[]" value="{{ $category->asset_category_id }}"
                                        id="cat-{{ $category->asset_category_id }}" {{ $isChecked ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat-{{ $category->asset_category_id }}">
                                        {{ $category->asset_category }}
                                    </label>
                                </div>
                        
                                <div class="d-flex align-items-center">
                                    @if ($show_btn)
                                        <a href="{{ url('/select_asset_types_for_category/' . $category->asset_category_id) }}" class="btn btn-sm btn-outline-success me-2">
                                            Select Asset Subtypes
                                        </a>
                                    @endif
                        
                                    <!-- Always-visible View Subtypes button -->
                                    <div class="position-relative d-inline-block">
                                        <button type="button" class="btn btn-sm btn-outline-warning">
                                            View Subtypes
                                        </button>
                                        <div class="subtype-tooltip shadow p-2 rounded">
                                            @if($subtypes->isNotEmpty())
                                                @foreach($subtypes as $sub)
                                                    <div>{{ $sub->asset_type }}</div>
                                                @endforeach
                                            @else
                                                <div class="text-muted">No subtypes available</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                
                               
                                </div>
                            </div>
                        @endforeach
                        
                        
                        </div>
                    <button type="submit" name="action" value="save_categories" class="btn btn-primary mt-3">
    Save Categories
</button>

<button type="submit" name="action" value="save_with_subtypes" class="btn btn-success mt-3 ms-2">
    Save Categories + All Subtypes
</button>

                        {{-- <button type="submit" class="btn btn-primary mt-3">Save Asset Types</button> --}}
                    </form>
                    
{{-- 
                    Custom Asset types --}}
    @if($custom_org_categories->isEmpty())

    @else
    <div class="card mt-4 shadow-sm border-1 rounded-3">
        <div class="card-body">
            <h5 class="card-title fw-bold text-dark mb-3">Custom Asset Types 
                 <p class="text-primary small mt-2" style="font-size: 13px;">
                <i class="fa fa-bullhorn me-2"></i>
                Adding a custom Asset type will make that Asset type and its subtypes by default avaiable to your organization
            </p>
</h5>
            @foreach ($custom_org_categories as $category)
            @php
                $subtypes = $org_custom_asset_types[$category->asset_category_id] ?? collect();
            @endphp
            <li class="list-group-item d-flex justify-content-between align-items-center mt-2">
                <span>{{ $category->asset_category }}</span>
        
                <div class="d-flex align-items-center">
                    <!-- Conditional Select Subtypes Button -->
                    <a href="{{ url('/select_asset_types_for_category/' . $category->asset_category_id) }}" class="btn btn-sm btn-outline-success me-2">
                        Select Asset Subtypes
                    </a>
        
                    <!-- Always-visible View Subtypes Hover Box -->
                    <div class="position-relative d-inline-block me-2">
                        <button type="button" class="btn btn-sm btn-outline-warning">
                            View Subtypes
                        </button>
                        <div class="subtype-tooltip shadow p-2 rounded">
                            @if($subtypes->isNotEmpty())
                                @foreach($subtypes as $sub)
                                    <div>{{ $sub->asset_type }}</div>
                                @endforeach
                            @else
                                <div class="text-muted">No subtypes available</div>
                            @endif
                        </div>
                    </div>
        
                    <!-- Edit and Delete -->
                    <a href="{{ url('/edit_custom_category/' . $category->asset_category_id) }}" class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fa fa-pencil-alt"></i> Edit
                    </a>
        
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
        

         
        </div>
    </div> 
    @endif

                    
                </div>
            </div>
            <div class="mt-2">
            <a href="/add_new_category_in_org/{{auth()->user()->organization->id}}" class="btn btn-success btn-md">Add Custom Asset Type</a>
        </div>
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

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
</script>

@endsection

@endsection

