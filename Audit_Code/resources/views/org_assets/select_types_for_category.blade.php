
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
      <div class="row">
        <div class="col-md-8">
            <h2 class="fw-bold">Set up asset subtypes for the asset type: {{$categoryDetails->asset_category}}</h2>
        </div>

        <div class="col-md-4 text-end">
          <a href="/select_assets/{{auth()->user()->organization->id}}" class="btn btn-success btn-md">GO back to All Asset Categories</a>
        </div>
      </div>
    
       <div class="row justify-content-center mt-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-1 rounded-3">
                <div class="card-body">
                    <h4 class="fw-bold mb-3 text-dark text-center">Select Asset SubTypes</h4>
                
                     <form action="/add_asset_types_in_org/{{ auth()->user()->organization->id }}/{{$categoryDetails->asset_category_id}}" method="POST">
                        @csrf

                        <div class="form-group">
                            @foreach ($global_types as $category)
                                <div class="form-check mb-2 d-flex align-items-center justify-content-between">
                                    @php
                                    $isFirstTime = $org_types->isEmpty();
                                    $isChecked = $isFirstTime || $org_types->contains('asset_type_selected', $category->asset_type_id);
                                @endphp
                                    <div>
                                      
                                        <input 
                                            class="form-check-input me-2" 
                                            type="checkbox" 
                                            name="asset_types[]" 
                                            value="{{ $category->asset_type_id }}" 
                                            id="cat-{{ $category->asset_type_id }}"
                                            {{ $isChecked ? 'checked' : '' }}
                                           
                                        >
                                        <label class="form-check-label" for="cat-{{ $category->asset_type_id }}">
                                            {{ $category->asset_type }}
                                        </label>
                                    </div>
                
                                </div>
                            @endforeach

                        </div>
                        @if($global_types->count()>0)
                        <button type="submit" class="btn btn-primary mt-3">Save Asset SubTypes</button>
                        @else
                        Since Its a Custom Asset Type, We do not have Asset SubTypes by default
                        @endif

                     </form>
                                                     <!-- Custom Asset Types Section -->
<div class="card mt-4 shadow-sm border-1 rounded-3 mb-2">
    <div class="card-body">
        <h5 class="card-title fw-bold text-dark mb-3">Custom Asset SubTypes</h5>

        @if($custom_org_types->isEmpty())
            <p class="text-muted">No custom asset subtypes added yet.</p>
        @else
            <ul class="list-group list-group-flush">
                @foreach ($custom_org_types as $category)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $category->asset_type }}</span>
                        <div>
                            <!-- Edit Button -->
                            <a href="{{ url('/edit_custom_asset_type/' . $category->asset_type_id) }}" class="btn btn-sm btn-outline-secondary me-2">
                                <i class="fa fa-pencil-alt"></i> Edit
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ url('/delete_custom_asset_type/' . $category->asset_type_id) }}" method="POST" class="d-inline">
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
            <a href="/add_new_asset_type_in_org/{{auth()->user()->organization->id}}/{{$categoryDetails->asset_category_id}}" class="btn btn-success btn-md">Add new Asset SubType</a>
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

