
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h2 class="fw-bold">Edit Asset SubType for your Organization:{{auth()->user()->organization->name}} </h2>
    
       <div class="card mt-4 shadow-lg border-0 rounded-3">
        <div class="card-body p-4">

            <form class="row g-4" method="POST" action="/update_asset_type/{{$asset_type->asset_type_id}}">
                @csrf
                @method('PUT')
    
                <div class="col-md-12 mb-4">
                    <div class="form-floating">
                        <input type="text" class="form-control" 
                               name="asset_type" placeholder="Enter Asset SubType" value="{{old('asset_type',$asset_type->asset_type)}}" required>
                        <label for="asset_type">Asset SubType</label>
                    </div>
                    @if($errors->has('asset_category'))
                        <div class="text-danger mt-2 small">{{ $errors->first('asset_type') }}</div>
                    @endif
                </div>
    
                <!-- Submit Button -->
                <div class="col-12 text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg px-5 py-2 fw-semibold">Update Asset SubType</button>
                </div>
            </form>
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

