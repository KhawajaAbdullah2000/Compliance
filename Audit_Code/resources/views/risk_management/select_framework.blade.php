
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
       <h3 class="fw-bold">Set up Risk Management Methodology by project type</h3>
    
       <div class="row">
        <div class="col-md-4 me-md-4">
            <h5 class="fw-bold mb-3 mt-4">Project Types Selected</h5>
            
            <ul class="list-group shadow-sm rounded">
                @forelse ($projects as $proj)
                    <li class="list-group-item d-flex align-items-center bg-light">
                        <i class="bi bi-check-circle-fill text-success me-2"></i>
                        {{$proj->type}}
                    </li>
                @empty
                    <li class="list-group-item text-muted">No project types selected.</li>
                @endforelse
            </ul>
        </div>

        <div class="col-md-4 mt-4">
            <form action="/selected_project_and_framework/{{auth()->user()->organization->id}}" method="POST">
                @csrf
                <h4 class="fw-bold mb-3">Select a Framework</h4>
        
                @forelse ($frameworks as $framework)

                @if($framework->framework_id==1 ||$framework->framework_id==2 || $framework->framework_id==5 )
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" 
                               name="framework" 
                               id="framework_{{$framework->framework_id}}" 
                               value="{{$framework->framework_id}}">
                        <label class="form-check-label" for="framework_{{$framework->framework_id}}">
                            {{$framework->framework_name}}
                        </label>
                    </div>
                    @endif
                @empty
                    <p class="text-muted">No frameworks available.</p>
                @endforelse

                @foreach ($projects as $proj)
                <input type="hidden" name="selected_projects[]" value="{{ $proj->id }}">
            @endforeach
        
                {{-- Optional Submit Button --}}
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
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

