@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

@php
    $permissions = json_decode($project_permissions, true);
    $isDataInputter = in_array('Data Inputter', $permissions ?? []);
@endphp

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
                    <button type="button" class="btn btn-outline-primary btn-sm" id="toggleApplicability" @if(!$isDataInputter) disabled @endif>Set All to Yes</button>
                </div>
            </div>

            <div class="col-md-3 text-start">
                <span class="fw-bold">Compliance Status</span>
            </div>

            <div class="col-md-1 text-end">
                <button @disabled(!$isDataInputter) class="btn btn-md btn-success px-4">Save</button>
            </div>
        </div>

        @foreach($domainNames as $title => $label)
            @php
                $status = $finalStatusByTitle->get($title);
                $applicability = $finalApplicabilityByTitle->get($title);
            @endphp

            <div class="row mb-3 align-items-start">
                <div class="col-md-5">
                    <a href="/ksa_nca_section_2_2/{{ $title }}/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" 
                       class="btn btn-lg btn-warning w-100 text-start fw-bold">
                        {{ $title }}. {{ $label }}
                    </a>
                </div>

                <div class="col-md-3">
                    <input type="hidden" name="titles[]" value="{{ $title }}">
                    <select name="applicabilities[]" class="form-select rounded-pill applicability-select" data-index="{{ $loop->index }}" @disabled(!$isDataInputter)>
                        <option value="">Select --</option>
                        <option value="yes" {{ old('applicabilities.' . $loop->index, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                        <option value="no" {{ old('applicabilities.' . $loop->index, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                    </select>

                    @if(trim($applicability) === 'different')
                        <div class="mt-1">
                            <span class="badge bg-secondary fs-6">Applicability differs in lower layers</span>
                        </div>
                    @endif

                    <textarea @disabled(!$isDataInputter) name="justifications[]" 
                              class="form-control mt-2 justification-textarea justification-{{ $loop->index }}" 
                              style="display: {{ (old('applicabilities.' . $loop->index, $applicability) === 'no') ? 'block' : 'none' }};" 
                              placeholder="Enter justification">{{ old('justifications.' . $loop->index) }}</textarea>
                </div>

                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2">
                        <select name="comp_statuses[]" class="form-select rounded-pill w-100" @disabled(!$isDataInputter)>
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
                        <a class="btn btn-sm btn-primary" style="min-width:100px;" href="#">AI Input</a>
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
