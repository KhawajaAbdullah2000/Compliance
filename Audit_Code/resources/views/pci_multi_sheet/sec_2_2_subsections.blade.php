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

    @if(Session('evidenceLevel')!='project')
   @include('components.sec2_2_asset_details',[
    'asset'=>$asset
  ])



@endif

@if(Session('evidenceLevel')=='project')

<a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>

@endif



<h3>Select From below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
    @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
    @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
    @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
    @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif

</h3>

<div class="row h-100 w-75">
    <div class="row mt-2" >
        <div class="col-md-8">

     <a href="/pci_multi_section_2_2/{{1}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold" style="text-align: left;">PCI-DSS v4.0 Requirement 1: Install and Maintain Network Security Controls</p></a>
    </div>
    @php
    $title = 1;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>


    <div class="row mt-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{2}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 2: Apply Secure Configurations to All System Components</p></a>
    </div>
   @php
    $title = 2;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{3}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 3: Protect Stored Account Data</p></a>
    </div>
    @php
    $title = 3;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>

    <div class="row mt-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{4}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 4: Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks</p></a>
    </div>
    @php
    $title = 4;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{5}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 5: Protect All Systems and Networks from Malicious Software</p></a>
    </div>
     @php
    $title = 5;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>


    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{6}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning  w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 6: Develop and Maintain Secure Systems and Software</p></a>
    </div>
    @php
    $title = 6;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>


    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{7}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 7: Restrict Access to System Components and Cardholder Data by Business Need to Know</p></a>
    </div>
   @php
    $title = 7;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{8}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 8: Identify Users and Authenticate Access to System Components</p></a>
    </div>
     @php
    $title = 8;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{9}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 9: Restrict Physical Access to Cardholder Data</p></a>
    </div>
     @php
    $title = 9;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{10}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 10: Log and Monitor All Access to System Components and Cardholder Data</p></a>
    </div>
     @php
    $title = 10;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{11}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 11: Test Security of Systems and Networks Regularly</p></a>
    </div>
    @php
    $title = 11;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/{{12}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">PCI-DSS v4.0 Requirement 12: Support Information Security with Organizational Policies and Programs</p></a>
    </div>
    @php
    $title = 12;                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>

    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/A1/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">Appendix A1: Additional PCI DSS Requirements for Multi-Tenant Service Providers</p></a>
    </div>
     @php
    $title = "A1";                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>



    <div class="row mt-2 mb-2">
        <div class="col-md-8">
     <a href="/pci_multi_section_2_2/A2/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100"><p class="fw-bold " style="text-align: left;">Appendix A2: Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections</p></a>
    </div>
     @php
    $title = "A2";                             
    $status = $finalStatusByTitle->get($title); 
    @endphp
        <div class="col-md-4">

            <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}"
                  method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $title }}">

                <div class="d-flex align-items-center">
                    <select name="comp_status"
                            class="form-select rounded-pill me-2"
                            style="max-width:130px;min-width:130px;">
                        <option value="">Select --</option>

                        @foreach(['yes' => 'In Place',
                                  'no'  => 'Not in Place',
                                  'not_applicable' => 'Not Applicable',
                                  'not_tested'     => 'Not Tested',
                                  'partial'        => 'Partial'] as $value => $label)
                            <option value="{{ $value }}"
                                    {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>

                    <button class="btn btn-sm btn-success me-2 px-3" style="min-width:150px;max-width:150px;" type="submit">Submit</button>
                    <button class="btn btn-sm btn-primary px-3" style="min-width:150px;max-width:150px;" type="submit">AI Input</button>

               
     
               {{-- Badge for "different" --}}
            @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
            @endif
             </div>
         </form>
    </div>
    </div>
        {{-- <a href="/v_3_2_section1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning">Section1</a> --}}





</div>

 

    
</div>

@section('scripts')

@if(Session::has('success'))
<script>
    swal({
  title: "{{Session::get('success')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script> 
@endif


@endsection


@endsection
