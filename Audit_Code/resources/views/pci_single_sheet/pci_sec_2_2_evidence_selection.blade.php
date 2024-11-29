@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <table  class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark ">
            <tr>
                <th>Service</th>
                    <th>Asset Group</th>
                    <th>Asset</th>
                    <th>Asset Component</th>
                    <th>Asset Owner Dept</th>
                    <th>Asset Physical Location</th>
                    <th>Asset Logical Location</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $asset->s_name }}</td>
                <td>{{ $asset->g_name }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->c_name }}</td>
                <td>{{ $asset->owner_dept }}</td>
                <td>{{ $asset->physical_loc }}</td>
                <td>{{ $asset->logical_loc }}</td>
               
            </tr>
          
        </tbody>
    </table>


    <div class="row">
        <h5 class="fw-bold">Select the level at which to apply the evidence by selecting from the 
            selections below:</h5>
        <div class="col-md-6">
    
            <div class="border p-3" style="border: 1px solid #ccc; border-radius: 5px;">
                <div class="d-flex flex-column">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="evidenceLevel" value="project" checked>
                        <label class="form-check-label" for="project">Project</label>
                    </div>
    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="evidenceLevel" value="service">
                        <label class="form-check-label" for="service">Service</label>
                    </div>
    
                    @if($asset->g_name!=null)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="evidenceLevel" value="group">
                        <label class="form-check-label" for="assetGroup">Asset Group</label>
                    </div>
                    @endif
    
                    @if($asset->name!=null)
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="evidenceLevel" value="name">
                        <label class="form-check-label" for="asset">Asset</label>
                    </div>
                    @endif
    
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="evidenceLevel" value="component">
                        <label class="form-check-label" for="assetComponent">Asset Component</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <div class="row h-100 w-75">
        <div class="row mt-2" >
            <div class="col-12">

         <a href="/pci_single_sheet_subsections/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">Upload or enter evidence against the mandatory requirements of PCI-DSS v4-Single-Tenant Service Provider (stSP)</p></a>
        </div>
        </div>

        

    </div>

</div>

<input type="hidden" id="selectedLevel" name="selectedLevel" value="">

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const radioButtons = document.querySelectorAll('input[name="evidenceLevel"]');
    const links = document.querySelectorAll('.btn-warning'); // Select all buttons with links


    function updateLinks(selectedValue) {
        links.forEach(link => {
            const originalUrl = link.getAttribute('href').split('?')[0]; // Remove any existing query params
            const newUrl = `${originalUrl}?evidenceLevel=${selectedValue}`;
            link.setAttribute('href', newUrl);
        });
    }

    const defaultChecked = document.querySelector('input[name="evidenceLevel"]:checked');
    if (defaultChecked) {
        updateLinks(defaultChecked.value);
    }

    // Listen for changes in the radio buttons
    radioButtons.forEach(radio => {
        radio.addEventListener('change', function () {
            const selectedValue = this.value;
            document.getElementById('selectedLevel').value = selectedValue; // Update hidden input value
            updateLinks(selectedValue); // Update URLs
        });
    });
});



</script>


@endsection




@endsection
