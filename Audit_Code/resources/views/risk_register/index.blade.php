@extends('master')

@section('content')

@include('user-nav')

<div class="container py-4">

    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0 text-capitalize">
                View Risk Register by {{ str_replace('_', ' ', $dimension) }}
            </h5>
        </div>



        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">

                        @php
                        $hiddenKeys = [
                        'data_confidentiality',
                        'data_integrity',
                         'data_availability',
                        'qualitative_likelihood_risk_confidentiality_selected',
                        'qualitative_likelihood_risk_integrity_selected',
                        'qualitative_likelihood_risk_availability_selected',
                        'framework_selected',
                        'assessment_approach_selected',
                        'framework_approach_types',
                        'project_id',
                        'assessment_id'
                        ];
                        @endphp

                        <thead class="table-dark">
                            <tr>
                                @foreach ($columns as $col)
                                @if (!in_array($col['key'], $hiddenKeys))
                                <th class="text-nowrap fw-semibold">{{ $col['label'] }}</th>
                                @endif
                                @endforeach

                                @if($dimension=="project")
                                 <th class="text-nowrap fw-semibold">Data Confidentiality</th>
                                  <th class="text-nowrap fw-semibold">Data Integrity</th>
                                   <th class="text-nowrap fw-semibold">Data Availability</th>
                                   <th>All</th>
                                 
                                @endif
                            
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rows as $row)
                            <tr>
                                @foreach ($columns as $col)
                                @php $key = $col['key']; @endphp
                                @if (!in_array($key, $hiddenKeys))
                                <td>
                                    @if ($key === 'status')
                                    @php
                                    $status = $row->$key ?? '';
                                    $badgeClass = match (true) {
                                    str_contains(strtolower($status), 'approved') => 'bg-success',
                                    str_contains(strtolower($status), 'reject') => 'bg-danger',
                                    str_contains(strtolower($status), 'pending'),
                                    str_contains(strtolower($status), 'review') => 'bg-warning text-dark',
                                    default => 'bg-secondary',
                                    };
                                    @endphp
                                    <span class="badge rounded-pill {{ $badgeClass }}">
                                        {{ $status ?: '—' }}
                                    </span>
                                    @elseif($key=='data_confidentiality_risk' && $dimension=="components")
                                    @if($row->risk_assessment!='Qualitative Event Based')
                                    <a href="/likelihood_and_consequence/risk_confidentiality/{{$row->project_id}}/{{auth()->user()->id}}/{{$row->assessment_id}}" target="_blank">{{ $row->$key ?: '—' }}</a>
                                    @else
                                    <a target="_blank" href="/iso_27005_likelihood_value_qual_event/{{$row->project_id}}/{{auth()->user()->id}}/risk_confidentiality">View</a>
                                    @endif
                                    @elseif($key=='data_integrity_risk' && $dimension=="components")
                                     @if($row->risk_assessment!='Qualitative Event Based')
                                    <a href="/likelihood_and_consequence/risk_integrity/{{$row->project_id}}/{{auth()->user()->id}}/{{$row->assessment_id}}" target="_blank">{{ $row->$key ?: '—' }}</a>
                                    @else
                                    <a target="_blank" href="/iso_27005_likelihood_value_qual_event/{{$row->project_id}}/{{auth()->user()->id}}/risk_integrity">View</a>

                                    @endif

                                    @elseif($key=='data_availability_risk' && $dimension=="components")
                                       @if($row->risk_assessment!='Qualitative Event Based')
                                    <a href="/likelihood_and_consequence/risk_availability/{{$row->project_id}}/{{auth()->user()->id}}/{{$row->assessment_id}}" target="_blank">{{ $row->$key ?: '—' }}</a>
                                 @else
                                 <a target="_blank" href="/iso_27005_likelihood_value_qual_event/{{$row->project_id}}/{{auth()->user()->id}}/risk_availability">View</a>


                                 @endif
                                    @else
                                    {{ $row->$key ?: '—' }}
                                    @endif
                                </td>

                               
                                @endif
                                @endforeach

                              

                                 @if($dimension=="project")
            @if($row->contains_assets=="Yes")
            <td><a href="/risk_register_by_project/components/{{auth()->user()->organization->id}}/{{$row->project_id}}">View</a></td>
              <td><a href="/risk_register_by_project/components/{{auth()->user()->organization->id}}/{{$row->project_id}}">View</a></td>
             <td><a href="/risk_register_by_project/components/{{auth()->user()->organization->id}}/{{$row->project_id}}">View</a></td>
             <td></td>
            @elseif($row->contains_assets=="No")
                {{-- Dont contains assets --}}
            @if($row->framework_selected==2 && $row->assessment_approach_selected==1 && $row->framework_approach_types==1)
            {{-- QUalitative Event Based --}}
            <td><a href="/iso_27005_likelihood_value_qual_event/{{$row->project_id}}/{{auth()->user()->id}}/risk_confidentiality">View</a></td>
               <td><a href="/iso_27005_likelihood_value_qual_event/{{$row->project_id}}/{{auth()->user()->id}}/risk_integrity">View</a></td>
              <td><a href="/iso_27005_likelihood_value_qual_event/{{$row->project_id}}/{{auth()->user()->id}}/risk_integrity">View</a></td>
            <td><a href="/iso_27005_likelihood_value_qual_event/{{$row->project_id}}/{{auth()->user()->id}}">View</a></td>
              @else
              {{-- not qualittave asset and doesnt have a asset --}}
              <td>No Assets Available</td>
                 <td>No Assets Available</td>
                    <td>No Assets Available</td>
                    <td>No Assets Available</td>
            @endif
            @endif
        @endif
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ count($columns) + 3 }}" class="text-center text-muted py-4">
                                    <i class="bi bi-inboxes fs-2 d-block mb-2"></i>
                                    No records found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>




    </div>
</div>


@endsection
