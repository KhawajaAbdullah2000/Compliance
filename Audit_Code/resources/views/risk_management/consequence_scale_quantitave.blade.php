
@extends('master')

@section('content')

@include('user-nav')

<section class="min-h-100">
    <div class="container py-5">
       <h4 class="fw-bold">Organization: {{auth()->user()->organization->name}}</h4>
    
  
       <div class="row">
        <div class="col-md-4">
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

            <h4 class="mt-4">Information Security Risk
                Management Framework selected:</h4>
                <p class="fw-bold fs-5">{{$framework_name}}</p>

                <div class="mt-2">

                </div>

                <h4 class="mt-4">Information Security Risk
           Management Approach selected:</h4>
                    <p class="fw-bold fs-5">{{$framework_approach}}</p>

                    <div class="mt-4">
                    
                            <a href="/select_projects_for_framework/{{auth()->user()->organization->id}}" class="btn btn-primary btn-md">Back
                            </a>
                    
            

                    </div>
        </div>

        <div class="col-md-8">
           
            <h4 class="fw-bold">Set Up Consequences Scale: Quantitative </h4>
            <p class="fs-5">(Quantitative consequences of loss of data confidentiality, integrity or
                availability)
                </p>

                <form action="/quantitave_consequence_scale/{{auth()->user()->organization->id}}" method="POST">
                    @csrf

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Consequence ( a loss of)</th>
                                <th>Currency</th>
                                <th>Log Expression</th>
                                <th>Scale Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rows = [
                                    ['log' => '10^6', 'scale' => 6],
                                    ['log' => '10^5', 'scale' => 5],
                                    ['log' => '10^4', 'scale' => 4],
                                    ['log' => '10^3', 'scale' => 3],
                                    ['log' => '10^2', 'scale' => 2],
                                    ['log' => '10^1', 'scale' => 1],
                                ];
                
                            @endphp
                
                            @foreach ($rows as $index => $row)
                                <tr>
                                    <td>To be entered by End User</td>
                                    <td>
                                        <select name="currency_selected[{{ $index }}]" required class="form-select">
                                            <option value="">Select</option>
                                            @foreach ($global_currency as $currency)
                                                <option value="{{ $currency->global_currency_id }}">{{ $currency->currency }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        {{ $row['log'] }}
                                        <input type="hidden" name="log_expression[{{ $index }}]" value="{{ $row['log'] }}">
                                    </td>
                                    <td>
                                        {{ $row['scale'] }}
                                        <input type="hidden" name="scale[{{ $index }}]" value="{{ $row['scale'] }}">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @foreach ($projects as $proj)
                    <input type="hidden" name="selected_projects[]" value="{{ $proj->id }}">
                @endforeach

                <input type="hidden" name="framework_approach" value="{{ $framework_approach }}">

                    <br>
                    <button class="btn btn-primary btn-md" type="submit">Submit</button>


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

