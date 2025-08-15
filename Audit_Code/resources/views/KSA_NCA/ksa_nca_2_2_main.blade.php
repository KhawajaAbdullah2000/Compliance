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


    @if($project->project_type==7)
    <h2 class="fw-bold mt-4 mb-2">
        @if($title==1)
        1: CyberSecurity Governance

        @elseif ($title==2)
        2: Cybersecurity Defense
        @elseif ($title==3)
        3: Cybersecurity Resilience

        @elseif ($title==4)
        4: Third-Party and Cloud Computing Cybersecurity

        @elseif ($title==5)
        5: Industrial Control Systems Cybersecurity

        @endif
    </h2>
    @endif

    @if($project->project_type==18)
    <h2 class="fw-bold mt-4 mb-2">
        {{$data[0][1]}}
        @endif

        @if($project->project_type==19)
        <h2 class="fw-bold mt-4 mb-2">
            {{$data[0][1]}}
        </h2>
        @endif


        <div class="text-end">
            <a href="{{route('ksa_nca_subsections',[
            'proj_id'=>$project->project_id,
            'user_id'=>auth()->user()->id,
            'asset_id'=>$asset->assessment_id

            ])}}" class="btn btn-primary btn-md mb-2">Go to All Requirements</a>
        </div>
        {{-- <h4>Select one {{$project->type}} subdomain from below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
        @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
        @if(Session('evidenceLevel')=='group') All Asset Types in the group: {{$asset->g_name}} @endif
        @if(Session('evidenceLevel')=='name') All Asset Subtypes in: {{$asset->name}} @endif
        @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif

        </h4> --}}
        <div class="text-end">
            <i class="fas fa-lightbulb fa-2x text-warning" style="cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="left" title="The hierarchy of control requirements are at 3 tiers:
Control Domain
Control Sub-domain
Control Requirement


If you choose to select values for “Applicable” and “Compliance Status” on this page, then the same values will apply to the controls at each sub-domain’s lower layers, however you can edit values at the lower layers
">
            </i>
        </div>


        <form action="/add_mandatory_all_domain_all_controls/{{ $project_id }}/{{ auth()->user()->id }}/{{ $asset->assessment_id }}" method="POST">
            @csrf

            <!-- Top Bar: Save Button -->
            <div class="row mb-3 align-items-start">
                <div class="col-md-8">
                    @if($project->project_type==4)
                    <h2 class="fw-bold">
                        {{$data[0][0]}}. {{$data[0][1]}}
                    </h2>
                    @endif
                </div>
                <div class="col-md-4 text-end">
                    <button @disabled(!$isDataInputter) type="submit" class="btn btn-success btn-md px-5">Save All</button>
                </div>
            </div>

            <table class="table table-bordered table-responsive table-primary">
                <thead class="fw-bold table-dark">
                    <tr>
                        <td style="width: 50%;">Subdomain</td>
                        <td>Applicability</td>
                        <td>Compliance Status</td>
                    </tr>
                </thead>

                <tbody>
                    @for ($i = 0; $i < count($data); $i++) @php if ($i> 0 && $data[$i][2] == $data[$i-1][2]) {
                        continue; // skip duplicate subdomains
                        }
                        $subdomain = trim((string) $data[$i][2]);
                        $status = $finalStatusBySubdomain->get($subdomain);
                        $applicability = $finalApplicabilityByTitle->get($subdomain);
                        @endphp

                        <tr>
                            <td>
                                <a style="color: inherit;" href="/ksa_nca_sec_2_2_req/{{$subdomain}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}">
                                    <p class="fw-bold mb-0">{!! nl2br($data[$i][2]) !!} {!! nl2br($data[$i][3]) !!}</p>
                                </a>
                            </td>

                            <td>
                                <input type="hidden" name="domains[]" value="{{ $subdomain }}">

                                <select @disabled(!$isDataInputter) name="applicabilities[]" class="form-select form-select-sm rounded-pill applicability-select" data-index="{{ $i }}" style="max-width:150px;min-width:150px;">
                                    <option value="">Select --</option>
                                    <option value="yes" {{ old('applicabilities.' . $i, $applicability) === 'yes' ? 'selected' : '' }}>Yes</option>
                                    <option value="no" {{ old('applicabilities.' . $i, $applicability) === 'no' ? 'selected' : '' }}>No</option>
                                </select>

                                @if(trim($applicability) == "different")
                                <div class="mt-1">
                                    <span class="badge fs-6 bg-secondary">Applicability differs in lower layers</span>
                                </div>
                                @endif

                                <!-- Justification Field -->
                                <textarea @disabled(!$isDataInputter) name="justifications[]" class="form-control form-control-sm mt-2 justification-textarea justification-{{ $i }}" style="display: {{ (old('applicabilities.' . $i, $applicability) === 'no') ? 'block' : 'none' }};" placeholder="Enter justification">{{ old('justifications.' . $i) }}</textarea>
                            </td>


                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <select @disabled(!$isDataInputter) name="comp_statuses[]" class="form-select form-select-sm rounded-pill" style="max-width:150px;min-width:150px;">
                                        <option value="">Select --</option>
                                        @foreach([
                                        'yes' => 'In Place',
                                        'no' => 'Not in Place',
                                        'not_applicable' => 'Not Applicable',
                                        'not_tested' => 'Not Tested',
                                        'partial' => 'Partial'
                                        ] as $value => $label)
                                        <option value="{{ $value }}" {{ old('comp_statuses.' . $i, $status) === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                        @endforeach
                                    </select>

                                    <a href="#" class="btn btn-primary btn-sm" style="min-width:100px;">AI Input</a>
                                </div>

                                @if(trim($status) == "different")
                                <div class="mt-1">
                                    <span class="badge fs-6 bg-secondary">Compliance differs in lower layers</span>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @endfor
                </tbody>
            </table>


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
                    justification.value = ''; // Clear the value when hidden
                }
            });
        });
    });

</script>


@endsection
@endsection
