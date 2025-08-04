@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-secondary">
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

    <div class="text-end">
        <i class="fas fa-lightbulb fa-2x text-warning" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="left" title="The hierarchy of control requirements are at 3 tiers:
Control Domain
Control Sub-domain
Control Requirement

If you choose to select values for “Applicable” and “Compliance Status” on this page, then the same values will apply to the controls at each domain’s lower layers, however you can edit values at the lower layers
">
        </i>
    </div>


    {{-- <h4>Select one {{$project->type}} Compliance domain from below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
    @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
    @if(Session('evidenceLevel')=='group') All Assets in the Asset Type: {{$asset->g_name}} @endif
    @if(Session('evidenceLevel')=='name') All Assets in the Asset Subtype: {{$asset->name}} @endif
    @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif

    </h4> --}}



    @if($project->project_type==7)
    {{-- KSA --}}
    <div class="row h-100 w-100 mb-2">
        <div class="row mt-2 align-items-center">
            <div class="col-md-6">
                <a href="/ksa_nca_section_2_2/{{1}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                    <p class="fw-bold" style="text-align: left;">1. Cybersecurity Governance</p>
                </a>
            </div>
            @php
            $title = 1;
            $status = $finalStatusByTitle->get($title);
            @endphp

            <div class="col-md-4">
                <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $title }}">

                    <div class="d-flex align-items-center gap-2">
                        {{-- Dropdown --}}
                        <select name="comp_status" class="form-select rounded-pill" style="min-width:150px;max-width:150px;">
                            <option value="">Select --</option>

                            @foreach([
                            'yes' => 'In Place',
                            'no' => 'Not in Place',
                            'not_applicable' => 'Not Applicable',
                            'not_tested' => 'Not Tested',
                            'partial' => 'Partial'
                            ] as $value => $label)
                            <option value="{{ $value }}" {{ old('comp_status', $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>

                        {{-- Submit Button --}}
                        <button class="btn btn-sm btn-success flex-shrink-0" style="width:100px;" type="submit">Submit</button>


                        {{-- AI Input Button --}}
                        <a class="btn btn-sm btn-primary flex-shrink-0 d-flex justify-content-center align-items-center" style="width:100px;" href="#">
                            AI Input
                        </a>

                        {{-- Badge for "different" --}}
                        @if($status === 'different')
                        <span class="badge bg-secondary fs-6">Values are different in below levels</span>
                        @endif
                    </div>
                </form>
            </div>

        </div>


        <div class="row mt-2 align-items-center">
            <div class="col-md-6">
                <a href="/ksa_nca_section_2_2/{{2}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                    <p class="fw-bold " style="text-align: left;">2. Cybersecurity Defense</p>
                </a>
            </div>

            @php
            $title = 2;
            $status = $finalStatusByTitle->get($title);
            @endphp
            <div class="col-md-4">

                <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $title }}">

                    <div class="d-flex align-items-center">
                        <select name="comp_status" class="form-select rounded-pill me-2" style="max-width:150px;">
                            <option value="">Select --</option>

                            @foreach(['yes' => 'In Place',
                            'no' => 'Not in Place',
                            'not_applicable' => 'Not Applicable',
                            'not_tested' => 'Not Tested',
                            'partial' => 'Partial'] as $value => $label)
                            <option value="{{ $value }}" {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>

                        <button class="btn btn-sm btn-success me-2 px-3" type="submit">Submit</button>
                        <a class="btn btn-primary btn-sm px-3" style="min-width:80px;">AI Input</a>
                    </div>
                </form>

                @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
                @endif
                {{-- mixed values ⇒ show static badge (or whatever UI you prefer) --}}

            </div>
        </div>

        <div class="row mt-3 align-items-center">
            <div class="col-md-6">
                <a href="/ksa_nca_section_2_2/3/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
                    3. Cybersecurity Resilience
                </a>
            </div>

            @php
            $title = 3;
            $status = $finalStatusByTitle->get($title);
            @endphp
            <div class="col-md-4">

                {{-- uniform value ⇒ show dropdown with that value pre-selected --}}
                <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $title }}">

                    <div class="d-flex align-items-center">
                        <select name="comp_status" class="form-select rounded-pill me-2" style="max-width:150px;">
                            <option value="">Select --</option>

                            @foreach(['yes' => 'In Place',
                            'no' => 'Not in Place',
                            'not_applicable' => 'Not Applicable',
                            'not_tested' => 'Not Tested',
                            'partial' => 'Partial'] as $value => $label)
                            <option value="{{ $value }}" {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>

                        <button class="btn btn-sm btn-success me-2 px-3" type="submit">Submit</button>
                        <a class="btn btn-primary btn-sm px-3" style="min-width:80px;">AI Input</a>
                    </div>
                </form>
                {{-- Badge for "different" --}}
                @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
                @endif


            </div>
        </div>


        <div class="row mt-2 align-items-center">
            <div class="col-md-6">
                <a href="/ksa_nca_section_2_2/{{4}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                    <p class="fw-bold " style="text-align: left;">4. Third-Party and Cloud Computing Cybersecurity</p>
                </a>
            </div>
            @php
            $title = 4;
            $status = $finalStatusByTitle->get($title);
            @endphp
            <div class="col-md-4">

                <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $title }}">

                    <div class="d-flex align-items-center">
                        <select name="comp_status" class="form-select rounded-pill me-2" style="max-width:150px;">
                            <option value="">Select --</option>

                            @foreach(['yes' => 'In Place',
                            'no' => 'Not in Place',
                            'not_applicable' => 'Not Applicable',
                            'not_tested' => 'Not Tested',
                            'partial' => 'Partial'] as $value => $label)
                            <option value="{{ $value }}" {{ old('comp_status', $status) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>

                        <button class="btn btn-sm btn-success me-2 px-3" type="submit">Submit</button>
                        <a class="btn btn-primary btn-sm px-3" style="min-width:80px;">AI Input</a>
                    </div>
                </form>
                {{-- Badge for "different" --}}
                @if($status === 'different')
                <span class="badge bg-secondary fs-6">Values are different in below levels</span>
                @endif
            </div>
        </div>

        <div class="row mt-2 align-items-center">
            <div class="col-md-6">
                <a href="/ksa_nca_section_2_2/{{5}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-lg btn-warning w-100">
                    <p class="fw-bold " style="text-align: left;">5. Industrial Control Systems Cybersecurity</p>
                </a>
            </div>
            @php
            $title = 5;
            $status = $finalStatusByTitle->get($title);
            @endphp
            <div class="col-md-4">
                <form action="/add_mandatory_all_title/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $title }}">

                    <div class="d-flex align-items-center gap-2">
                        <select name="comp_status" class="form-select rounded-pill" style="max-width:150px;min-width:150px;">
                            <option value="">Select --</option>

                            @foreach([
                            'yes' => 'In Place',
                            'no' => 'Not in Place',
                            'not_applicable' => 'Not Applicable',
                            'not_tested' => 'Not Tested',
                            'partial' => 'Partial'
                            ] as $value => $label)
                            <option value="{{ $value }}" {{ old('comp_status', $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                            @endforeach
                        </select>

                        <button class="btn btn-sm btn-success flex-shrink-0" style="width:100px;" type="submit">Submit</button>

                        <a class="btn btn-sm btn-primary flex-shrink-0 d-flex justify-content-center align-items-center" style="width:100px;" href="#">
                            AI Input
                        </a>

                        @if($status === 'different')
                        <span class="badge bg-secondary fs-6 flex-shrink-0">Values are different in below levels</span>
                        @endif
                    </div>
                </form>
            </div>

        </div>



        {{-- ISO 27001  --}}

        @elseif($project->project_type==4)

        <div class="row h-100 w-100 mb-2">

            <form action="/add_mandatory_all_title_all_controls/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                @csrf

                <!-- Top Row: Save Button & Headings -->
                <div class="row align-items-center mb-3">
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-0">Control Domains</h5>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Applicability</span>
                        <div class="mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="toggleApplicability">Set All to Yes</button>
                        </div>
                    </div>

                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Compliance Status</span>
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-md btn-success px-4">Save</button>
                    </div>
                </div>

                @foreach([4 => 'Context of the Organization', 5 => 'Leadership', 6=>'Planning',7=>"Support",8=>"Operation",9=>"Performance Evaluation",10=>"Operation",11=>"Annex A"] as $title => $label)

                @php
                $status = $finalStatusByTitle->get($title);
                $applicability = $finalApplicabilityByTitle->get($title);
                @endphp

                <div class="row mb-3 align-items-start">
                    <div class="col-md-5">
                        <a href="/ksa_nca_section_2_2/{{ $title }}/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
                            {{ $title }}. {{ $label }}
                        </a>
                    </div>

                    <div class="col-md-3">
                        <input type="hidden" name="titles[]" value="{{ $title }}">

                        <select name="applicabilities[]" class="form-select rounded-pill applicability-select" data-index="{{ $loop->index }}">
                            <option value="">Select --</option>
                            <option value="yes" {{ old('applicabilities.' . $loop->index, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('applicabilities.' . $loop->index, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                        </select>


                        @if(trim($applicability) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Applicability differs in lower layers</span>
                        </div>
                        @endif

                        <!-- Justification Field (hidden by default, shown via JS) -->
                        <textarea name="justifications[]" class="form-control mt-2 justification-textarea justification-{{ $loop->index }}" style="display: {{ (old('applicabilities.' . $loop->index, $applicability) === 'no') ? 'block' : 'none' }};" placeholder="Enter justification">{{ old('justifications.' . $loop->index) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <select name="comp_statuses[]" class="form-select rounded-pill w-100">
                                <option value="">Select --</option>
                                @foreach([
                                'yes' => 'In Place',
                                'no' => 'Not in Place',
                                'not_applicable' => 'Not Applicable',
                                'not_tested' => 'Not Tested',
                                'partial' => 'Partial'
                                ] as $value => $labelOption)
                                <option value="{{ $value }}" {{ old('comp_statuses.' . $loop->index, $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                    {{ $labelOption }}
                                </option>
                                @endforeach
                            </select>

                            <a class="btn btn-sm btn-primary" style="min-width:100px;" href="#">
                                AI Input
                            </a>
                        </div>

                        @if(trim($status) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Compliance differs in lower layers</span>
                        </div>
                        @endif
                    </div>
                </div>


                @endforeach

            </form>

        </div>




        {{-- NIST CSF --}}
        @elseif($project->project_type==23)

        <div class="row h-100 w-100 mb-2">

            <form action="/add_mandatory_all_title_all_controls/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                @csrf

                <!-- Top Row: Save Button & Headings -->
                <div class="row align-items-center mb-3">
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-0">Control Domains</h5>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Applicability</span>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Compliance Status</span>
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-md btn-success px-4">Save</button>
                    </div>
                </div>

                @foreach([1 => 'Govern', 2 => 'Identify', 3=>'Protect',4=>"Detect",5=>"Respond",6=>"Recover"] as $title => $label)

                @php
                $status = $finalStatusByTitle->get($title);
                $applicability = $finalApplicabilityByTitle->get($title);
                @endphp

                <div class="row mb-3 align-items-start">
                    <div class="col-md-5">
                        <a href="/ksa_nca_section_2_2/{{ $title }}/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
                            {{ $title }}. {{ $label }}
                        </a>
                    </div>

                    <div class="col-md-3">
                        <input type="hidden" name="titles[]" value="{{ $title }}">

                        <select name="applicabilities[]" class="form-select rounded-pill applicability-select" data-index="{{ $loop->index }}">
                            <option value="">Select --</option>
                            <option value="yes" {{ old('applicabilities.' . $loop->index, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('applicabilities.' . $loop->index, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                        </select>

                        @if(trim($applicability) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Applicability differs in lower layers</span>
                        </div>
                        @endif

                        <!-- Justification Field (hidden by default, shown via JS) -->
                        <textarea name="justifications[]" class="form-control mt-2 justification-textarea justification-{{ $loop->index }}" style="display: {{ (old('applicabilities.' . $loop->index, $applicability) === 'no') ? 'block' : 'none' }};" placeholder="Enter justification">{{ old('justifications.' . $loop->index) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <select name="comp_statuses[]" class="form-select rounded-pill w-100">
                                <option value="">Select --</option>
                                @foreach([
                                'yes' => 'In Place',
                                'no' => 'Not in Place',
                                'not_applicable' => 'Not Applicable',
                                'not_tested' => 'Not Tested',
                                'partial' => 'Partial'
                                ] as $value => $labelOption)
                                <option value="{{ $value }}" {{ old('comp_statuses.' . $loop->index, $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                    {{ $labelOption }}
                                </option>
                                @endforeach
                            </select>

                            <a class="btn btn-sm btn-primary" style="min-width:100px;" href="#">
                                AI Input
                            </a>
                        </div>

                        @if(trim($status) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Compliance differs in lower layers</span>
                        </div>
                        @endif
                    </div>
                </div>


                @endforeach

            </form>

        </div>


        {{-- ISO 27701 2019 --}}
        @elseif($project->project_type==24)

        <div class="row h-100 w-100 mb-2">

            <form action="/add_mandatory_all_title_all_controls/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                @csrf

                <!-- Top Row: Save Button & Headings -->
                <div class="row align-items-center mb-3">
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-0">Control Domains</h5>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Applicability</span>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Compliance Status</span>
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-md btn-success px-4">Save</button>
                    </div>
                </div>

                @foreach(['5.2' => 'Context of the organization', '5.3' => 'Leadership', '5.4'=>'Planning','5.5'=>"Support",'5.6'=>"Operation",'5.7'=>'Performance Evaluation','5.8'=>'Improvement','6.2'=>'ISO 27002:2013 aspects of PII','6.3'=>'ISO 27002:2013 aspects of PII','6.4'=>'ISO 27002:2013 aspects of PII','6.5'=>'ISO 27002:2013 aspects of PII','6.6'=>'ISO 27002:2013 aspects of PII','6.6.2'=>'User access management aspects of PII','6.6.4'=>'System and application access control aspects of PII','6.7.1'=>'Cryptographic controls control aspects of PII','6.8.2'=>'Equipment control aspects of PII','6.9.3'=>'Backup control aspects of PII','6.9.4'=>'Logging and monitoring control aspects of PII','6.11.2'=>'Security requirements of information systems control aspects of PII','6.13.1'=>'Management of information security incidents and improvements aspects of PII','6.15.2'=>'Information security reviews aspects of PII','A'=>'PIMS-specific reference control objectives and controls for PII Controllers','B'=>'PIMS-specific reference control objectives and controls for PII Processors'] as $title => $label)

                @php
                $status = $finalStatusByTitle->get($title);
                $applicability = $finalApplicabilityByTitle->get($title);
                @endphp

                <div class="row mb-3 align-items-start">
                    <div class="col-md-5">
                        <a href="/ksa_nca_section_2_2/{{ $title }}/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
                            {{ $title }}. {{ $label }}
                        </a>
                    </div>

                    <div class="col-md-3">
                        <input type="hidden" name="titles[]" value="{{ $title }}">

                        <select name="applicabilities[]" class="form-select rounded-pill applicability-select" data-index="{{ $loop->index }}">
                            <option value="">Select --</option>
                            <option value="yes" {{ old('applicabilities.' . $loop->index, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('applicabilities.' . $loop->index, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                        </select>

                        @if(trim($applicability) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Applicability differs in lower layers</span>
                        </div>
                        @endif

                        <!-- Justification Field (hidden by default, shown via JS) -->
                        <textarea name="justifications[]" class="form-control mt-2 justification-textarea justification-{{ $loop->index }}" style="display: {{ (old('applicabilities.' . $loop->index, $applicability) === 'no') ? 'block' : 'none' }};" placeholder="Enter justification">{{ old('justifications.' . $loop->index) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <select name="comp_statuses[]" class="form-select rounded-pill w-100">
                                <option value="">Select --</option>
                                @foreach([
                                'yes' => 'In Place',
                                'no' => 'Not in Place',
                                'not_applicable' => 'Not Applicable',
                                'not_tested' => 'Not Tested',
                                'partial' => 'Partial'
                                ] as $value => $labelOption)
                                <option value="{{ $value }}" {{ old('comp_statuses.' . $loop->index, $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                    {{ $labelOption }}
                                </option>
                                @endforeach
                            </select>

                            <a class="btn btn-sm btn-primary" style="min-width:100px;" href="#">
                                AI Input
                            </a>
                        </div>

                        @if(trim($status) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Compliance differs in lower layers</span>
                        </div>
                        @endif
                    </div>
                </div>


                @endforeach

            </form>

        </div>


        {{-- PCI SIngle --}}
        @elseif($project->project_type==1)

        <div class="row h-100 w-100 mb-2">

            <form action="/add_mandatory_all_title_all_controls/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                @csrf

                <!-- Top Row: Save Button & Headings -->
                <div class="row align-items-center mb-3">
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-0">Control Domains</h5>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Applicability</span>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Compliance Status</span>
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-md btn-success px-4">Save</button>
                    </div>
                </div>

                @foreach(['1' => 'Install and Maintain Network Security Controls', '2' => 'Apply Secure Configurations to All System Components', '3'=>'Protect Stored Account Data','4'=>"Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks",'5'=>"Protect All Systems and Networks from Malicious Software",'6'=>"Develop and Maintain Secure Systems and Software",'7'=>"Restrict Access to System Components and Cardholder Data by Business Need to Know",'8'=>'Identify Users and Authenticate Access to System Components','9'=>'Restrict Physical Access to Cardholder Data','10'=>'Log and Monitor All Access to System Components and Cardholder Data','11'=>'Test Security of Systems and Networks Regularly','12'=>'Support Information Security with Organizational Policies and Programs','A2'=>'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'] as $title => $label)

                @php
                $status = $finalStatusByTitle->get($title);
                $applicability = $finalApplicabilityByTitle->get($title);
                @endphp

                <div class="row mb-3 align-items-start">
                    <div class="col-md-5">
                        <a href="/ksa_nca_section_2_2/{{ $title }}/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
                            {{ $title }}. {{ $label }}
                        </a>
                    </div>

                    <div class="col-md-3">
                        <input type="hidden" name="titles[]" value="{{ $title }}">

                        <select name="applicabilities[]" class="form-select rounded-pill applicability-select" data-index="{{ $loop->index }}">
                            <option value="">Select --</option>
                            <option value="yes" {{ old('applicabilities.' . $loop->index, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('applicabilities.' . $loop->index, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                        </select>

                        @if(trim($applicability) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Applicability differs in lower layers</span>
                        </div>
                        @endif

                        <!-- Justification Field (hidden by default, shown via JS) -->
                        <textarea name="justifications[]" class="form-control mt-2 justification-textarea justification-{{ $loop->index }}" style="display: {{ (old('applicabilities.' . $loop->index, $applicability) === 'no') ? 'block' : 'none' }};" placeholder="Enter justification">{{ old('justifications.' . $loop->index) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <select name="comp_statuses[]" class="form-select rounded-pill w-100">
                                <option value="">Select --</option>
                                @foreach([
                                'yes' => 'In Place',
                                'no' => 'Not in Place',
                                'not_applicable' => 'Not Applicable',
                                'not_tested' => 'Not Tested',
                                'partial' => 'Partial'
                                ] as $value => $labelOption)
                                <option value="{{ $value }}" {{ old('comp_statuses.' . $loop->index, $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                    {{ $labelOption }}
                                </option>
                                @endforeach
                            </select>

                            <a class="btn btn-sm btn-primary" style="min-width:100px;" href="#">
                                AI Input
                            </a>
                        </div>

                        @if(trim($status) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Compliance differs in lower layers</span>
                        </div>
                        @endif
                    </div>
                </div>


                @endforeach

            </form>

        </div>



        {{-- PCI MUlti --}}
        @elseif($project->project_type==2)

        <div class="row h-100 w-100 mb-2">

            <form action="/add_mandatory_all_title_all_controls/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                @csrf

                <!-- Top Row: Save Button & Headings -->
                <div class="row align-items-center mb-3">
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-0">Control Domains</h5>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Applicability</span>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Compliance Status</span>
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-md btn-success px-4">Save</button>
                    </div>
                </div>

                @foreach( [
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A1' => 'Additional PCI DSS Requirements for Multi-Tenant Service Providers',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'
                ] as $title => $label)

                @php
                $status = $finalStatusByTitle->get($title);
                $applicability = $finalApplicabilityByTitle->get($title);
                @endphp

                <div class="row mb-3 align-items-start">
                    <div class="col-md-5">
                        <a href="/ksa_nca_section_2_2/{{ $title }}/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
                            {{ $title }}. {{ $label }}
                        </a>
                    </div>

                    <div class="col-md-3">
                        <input type="hidden" name="titles[]" value="{{ $title }}">

                        <select name="applicabilities[]" class="form-select rounded-pill applicability-select" data-index="{{ $loop->index }}">
                            <option value="">Select --</option>
                            <option value="yes" {{ old('applicabilities.' . $loop->index, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('applicabilities.' . $loop->index, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                        </select>

                        @if(trim($applicability) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Applicability differs in lower layers</span>
                        </div>
                        @endif

                        <!-- Justification Field (hidden by default, shown via JS) -->
                        <textarea name="justifications[]" class="form-control mt-2 justification-textarea justification-{{ $loop->index }}" style="display: {{ (old('applicabilities.' . $loop->index, $applicability) === 'no') ? 'block' : 'none' }};" placeholder="Enter justification">{{ old('justifications.' . $loop->index) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <select name="comp_statuses[]" class="form-select rounded-pill w-100">
                                <option value="">Select --</option>
                                @foreach([
                                'yes' => 'In Place',
                                'no' => 'Not in Place',
                                'not_applicable' => 'Not Applicable',
                                'not_tested' => 'Not Tested',
                                'partial' => 'Partial'
                                ] as $value => $labelOption)
                                <option value="{{ $value }}" {{ old('comp_statuses.' . $loop->index, $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                    {{ $labelOption }}
                                </option>
                                @endforeach
                            </select>

                            <a class="btn btn-sm btn-primary" style="min-width:100px;" href="#">
                                AI Input
                            </a>
                        </div>

                        @if(trim($status) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Compliance differs in lower layers</span>
                        </div>
                        @endif
                    </div>
                </div>


                @endforeach

            </form>

        </div>



        {{-- PCI Merchant --}}
        @elseif($project->project_type==3)

        <div class="row h-100 w-100 mb-2">

            <form action="/add_mandatory_all_title_all_controls/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                @csrf
                <div class="row align-items-center mb-3">
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-0">Control Domains</h5>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Applicability</span>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Compliance Status</span>
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-md btn-success px-4">Save</button>
                    </div>
                </div>

                @foreach([
                1 => 'Install and Maintain Network Security Controls',
                2 => 'Apply Secure Configurations to All System Components',
                3 => 'Protect Stored Account Data',
                4 => 'Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks',
                5 => 'Protect All Systems and Networks from Malicious Software',
                6 => 'Develop and Maintain Secure Systems and Software',
                7 => 'Restrict Access to System Components and Cardholder Data by Business Need to Know',
                8 => 'Identify Users and Authenticate Access to System Components',
                9 => 'Restrict Physical Access to Cardholder Data',
                10 => 'Log and Monitor All Access to System Components and Cardholder Data',
                11 => 'Test Security of Systems and Networks Regularly',
                12 => 'Support Information Security with Organizational Policies and Programs',
                'A2' => 'Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections'] as $title => $label)

                @php
                $status = $finalStatusByTitle->get($title);
                $applicability = $finalApplicabilityByTitle->get($title);
                @endphp

                <div class="row mb-3 align-items-start">
                    <div class="col-md-5">
                        <a href="/ksa_nca_section_2_2/{{ $title }}/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
                            {{ $title }}. {{ $label }}
                        </a>
                    </div>

                    <div class="col-md-3">
                        <input type="hidden" name="titles[]" value="{{ $title }}">

                        <select name="applicabilities[]" class="form-select rounded-pill applicability-select" data-index="{{ $loop->index }}">
                            <option value="">Select --</option>
                            <option value="yes" {{ old('applicabilities.' . $loop->index, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('applicabilities.' . $loop->index, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                        </select>

                        @if(trim($applicability) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Applicability differs in lower layers</span>
                        </div>
                        @endif

                        <!-- Justification Field (hidden by default, shown via JS) -->
                        <textarea name="justifications[]" class="form-control mt-2 justification-textarea justification-{{ $loop->index }}" style="display: {{ (old('applicabilities.' . $loop->index, $applicability) === 'no') ? 'block' : 'none' }};" placeholder="Enter justification">{{ old('justifications.' . $loop->index) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <select name="comp_statuses[]" class="form-select rounded-pill w-100">
                                <option value="">Select --</option>
                                @foreach([
                                'yes' => 'In Place',
                                'no' => 'Not in Place',
                                'not_applicable' => 'Not Applicable',
                                'not_tested' => 'Not Tested',
                                'partial' => 'Partial'
                                ] as $value => $labelOption)
                                <option value="{{ $value }}" {{ old('comp_statuses.' . $loop->index, $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                    {{ $labelOption }}
                                </option>
                                @endforeach
                            </select>

                            <a class="btn btn-sm btn-primary" style="min-width:100px;" href="#">
                                AI Input
                            </a>
                        </div>

                        @if(trim($status) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Compliance differs in lower layers</span>
                        </div>
                        @endif
                    </div>
                </div>


                @endforeach

            </form>

        </div>

        {{-- SOC 2 Type 2 --}}
        @elseif($project->project_type==19)

        <div class="row h-100 w-100 mb-2">

            <form action="/add_mandatory_all_title_all_controls/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                @csrf
                <div class="row align-items-center mb-3">
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-0">Control Domains</h5>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Applicability</span>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Compliance Status</span>
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-md btn-success px-4">Save</button>
                    </div>
                </div>

                @foreach([
                1 => 'Asset Management',
                2 => 'Availability',
                3 => 'Change Management',
                4 => 'Communications',
                5 => 'Confidentiality',
                6 => 'Data Classification',
                7 => 'Fraud Management',
                8 => 'Human Resource aspects of Trust Services',
                9 => 'Information Assets Security Management Policy',
                10 => 'Information Security Events Monitoring',
                11 => 'Information Security Incident Management',
                12 => 'Information Security Monitoring',
                13 => 'IT Operational Anomalies Reporting',
                14 => 'Logical and Physical Access Controls',
                15 => 'Monitoring of Controls',
                16 => 'Organization & Management',
                17 => 'Risk Management',
                18 => 'Vendor and Business Partner Risk Management',
                19 => 'Vulnerability Management',
                ] as $title => $label)

                @php
                $status = $finalStatusByTitle->get($title);
                $applicability = $finalApplicabilityByTitle->get($title);
                @endphp

                <div class="row mb-3 align-items-start">
                    <div class="col-md-5">
                        <a href="/ksa_nca_section_2_2/{{ $title }}/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
                            {{ $title }}. {{ $label }}
                        </a>
                    </div>

                    <div class="col-md-3">
                        <input type="hidden" name="titles[]" value="{{ $title }}">

                        <select name="applicabilities[]" class="form-select rounded-pill applicability-select" data-index="{{ $loop->index }}">
                            <option value="">Select --</option>
                            <option value="yes" {{ old('applicabilities.' . $loop->index, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('applicabilities.' . $loop->index, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                        </select>

                        @if(trim($applicability) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Applicability differs in lower layers</span>
                        </div>
                        @endif

                        <!-- Justification Field (hidden by default, shown via JS) -->
                        <textarea name="justifications[]" class="form-control mt-2 justification-textarea justification-{{ $loop->index }}" style="display: {{ (old('applicabilities.' . $loop->index, $applicability) === 'no') ? 'block' : 'none' }};" placeholder="Enter justification">{{ old('justifications.' . $loop->index) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <select name="comp_statuses[]" class="form-select rounded-pill w-100">
                                <option value="">Select --</option>
                                @foreach([
                                'yes' => 'In Place',
                                'no' => 'Not in Place',
                                'not_applicable' => 'Not Applicable',
                                'not_tested' => 'Not Tested',
                                'partial' => 'Partial'
                                ] as $value => $labelOption)
                                <option value="{{ $value }}" {{ old('comp_statuses.' . $loop->index, $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                    {{ $labelOption }}
                                </option>
                                @endforeach
                            </select>

                            <a class="btn btn-sm btn-primary" style="min-width:100px;" href="#">
                                AI Input
                            </a>
                        </div>

                        @if(trim($status) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Compliance differs in lower layers</span>
                        </div>
                        @endif
                    </div>
                </div>


                @endforeach

            </form>

        </div>


        {{-- COBIT 2019 --}}
        @elseif($project->project_type==16)

        <div class="row h-100 w-100 mb-2">

            <form action="/add_mandatory_all_title_all_controls/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
                @csrf
                <div class="row align-items-center mb-3">
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-0">Control Domains</h5>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Applicability</span>
                    </div>
                    <div class="col-md-3 text-start">
                        <span class="fw-bold">Compliance Status</span>
                    </div>
                    <div class="col-md-1 text-end">
                        <button class="btn btn-md btn-success px-4">Save</button>
                    </div>
                </div>

                @foreach([
                '1'=>'EDM',
                '2'=>'APO',
                '3'=>'BAI',
                '4'=>'DSS',
                '5'=>'MEA'

                ] as $title => $label)

                @php
                $status = $finalStatusByTitle->get($title);
                $applicability = $finalApplicabilityByTitle->get($title);
                @endphp

                <div class="row mb-3 align-items-start">
                    <div class="col-md-5">
                        <a href="/ksa_nca_section_2_2/{{ $title }}/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" class="btn btn-lg btn-warning w-100 text-start fw-bold">
                            {{ $title }}. {{ $label }}
                        </a>
                    </div>

                    <div class="col-md-3">
                        <input type="hidden" name="titles[]" value="{{ $title }}">

                        <select name="applicabilities[]" class="form-select rounded-pill applicability-select" data-index="{{ $loop->index }}">
                            <option value="">Select --</option>
                            <option value="yes" {{ old('applicabilities.' . $loop->index, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('applicabilities.' . $loop->index, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                        </select>

                        @if(trim($applicability) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Applicability differs in lower layers</span>
                        </div>
                        @endif

                        <!-- Justification Field (hidden by default, shown via JS) -->
                        <textarea name="justifications[]" class="form-control mt-2 justification-textarea justification-{{ $loop->index }}" style="display: {{ (old('applicabilities.' . $loop->index, $applicability) === 'no') ? 'block' : 'none' }};" placeholder="Enter justification">{{ old('justifications.' . $loop->index) }}</textarea>
                    </div>

                    <div class="col-md-4">
                        <div class="d-flex align-items-center gap-2">
                            <select name="comp_statuses[]" class="form-select rounded-pill w-100">
                                <option value="">Select --</option>
                                @foreach([
                                'yes' => 'In Place',
                                'no' => 'Not in Place',
                                'not_applicable' => 'Not Applicable',
                                'not_tested' => 'Not Tested',
                                'partial' => 'Partial'
                                ] as $value => $labelOption)
                                <option value="{{ $value }}" {{ old('comp_statuses.' . $loop->index, $status !== 'different' ? $status : '') === $value ? 'selected' : '' }}>
                                    {{ $labelOption }}
                                </option>
                                @endforeach
                            </select>

                            <a class="btn btn-sm btn-primary" style="min-width:100px;" href="#">
                                AI Input
                            </a>
                        </div>

                        @if(trim($status) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Compliance differs in lower layers</span>
                        </div>
                        @endif
                    </div>
                </div>


                @endforeach

            </form>

        </div>

        @endif
    </div>



    @section('scripts')

    @if(Session::has('success'))
    <script>
        swal({
            title: "{{Session::get('success')}}"
            , icon: "success"
            , closeOnClickOutside: true
            , timer: 3000
        , });

    </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    html: false
                })
            })
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.applicability-select').forEach(function(select) {
                select.addEventListener('change', function() {
                    var index = this.getAttribute('data-index');
                    var justification = document.querySelector('.justification-' + index);

                    if (this.value === 'no') {
                        justification.style.display = 'block';
                    } else {
                        justification.style.display = 'none';
                        justification.value = ''; // Clear if hidden
                    }
                });
            });
        });

    </script>

    <script>
        let currentApplicabilityValue = 'yes'; // what button will set to on first click

        document.getElementById('toggleApplicability').addEventListener('click', function() {
            const selects = document.querySelectorAll('.applicability-select');
            const toggleBtn = this;

            // Apply the current value
            selects.forEach((select, index) => {
                select.value = currentApplicabilityValue;
                select.dispatchEvent(new Event('change'));
            });

            // Update button text for next toggle
            toggleBtn.textContent = `Set All to ${currentApplicabilityValue === 'yes' ? 'No' : 'Yes'}`;

            // Flip the value for the next click
            currentApplicabilityValue = currentApplicabilityValue === 'yes' ? 'no' : 'yes';
        });

        // Handle showing/hiding justification fields
        document.querySelectorAll('.applicability-select').forEach((select, index) => {
            select.addEventListener('change', function() {
                const justification = document.querySelector('.justification-' + index);
                if (this.value === 'no') {
                    justification.style.display = 'block';
                } else {
                    justification.style.display = 'none';
                }
            });
        });

    </script>






    @endsection

    @endsection
