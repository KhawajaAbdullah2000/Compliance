@extends('master')

@section('content')

@include('user-nav')

<div class="container my-2">
    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{ $project->project_id }}/{{ auth()->user()->id }}">
                                {{ $project->project_name }}
                            </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{ auth()->user()->email }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{ $project->type }}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{ auth()->user()->organization->name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{ $project->status }}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">No. of Services:</td>
                        <td>{{$uniqueServicesCount }}</td>
                        <td class="fw-bold">No. of Asset Subgroups:</td>
                        <td>{{ $uniqueSubGroupsCount }}</td>
                    </tr>

                    <tr>
                        <td class="fw-bold">No. of Asset Groups:</td>
                        <td>{{$uniqueGroupsCount }}</td>
                        <td class="fw-bold">No. of Asset Components:</td>
                        <td>{{ $uniqueComponentsCount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <h3 class="text-center fw-bold mt-2">View Risk Heatmap for : </h3>

    <form action="/heatmap_single_risk/{{$project->project_id}}" method="GET">
    <div class="row">

 
    <div class="col-md-6">
        <div class="list-group">
            @foreach($uniqueServices as $service)
                <label class="list-group-item">
                    <input type="radio" name="selected_service" value="{{ $service->s_name }}" class="form-check-input">
                    {{ $service->s_name }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="list-group">
                <label class="list-group-item">
                    <input type="radio" name="selected_risk" value="risk_level" class="form-check-input">
                    Data Confidentiality
                </label>

                <label class="list-group-item">
                    <input type="radio" name="selected_risk" value="risk_integrity" class="form-check-input">
                    Data Integrity
                </label>

                <label class="list-group-item">
                    <input type="radio" name="selected_risk" value="risk_availability" class="form-check-input">
                    Data Availability
                </label>


         
        </div>
        <button type="submit" class="btn btn-primary mt-3">Submit</button>
    </div>


    </div>

</form>
    
    
    
 </div>
  




@endsection