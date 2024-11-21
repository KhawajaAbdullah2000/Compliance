@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')
@php
$permissions=json_decode($project_permissions);
@endphp

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

    @if(session('evidenceLevel')!='project')

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
    @endif

    @if(Session('evidenceLevel')=='project')

<a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>

@endif



<h3>Selet From below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
    @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
    @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
    @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
    @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif


      <h2 class="text-center fw-bold mt-4 mb-4">
        @if($title==1)
        PCI-DSS v4.0 Requirement 1: Install and Maintain Network Security Controls
        @elseif ($title==2)
        PCI-DSS v4.0 Requirement 2: Apply Secure Configurations to All System Components
        @elseif ($title==3)
        PCI-DSS v4.0 Requirement 3: Protect Stored Account Data
        @elseif ($title==4)
        PCI-DSS v4.0 Requirement 4: Protect Cardholder Data with Strong Cryptography During Transmission Over Open, Public Networks
        @elseif ($title==5)
        PCI-DSS v4.0 Requirement 5: Protect All Systems and Networks from Malicious Software
        @elseif ($title==6)
        PCI-DSS v4.0 Requirement 6: Develop and Maintain Secure Systems and Software
       @elseif ($title==7)
       PCI-DSS v4.0 Requirement 7: Restrict Access to System Components and Cardholder Data by Business Need to Know
       @elseif ($title==8)
       PCI-DSS v4.0 Requirement 8: Identify Users and Authenticate Access to System Components
       @elseif ($title==9)
       PCI-DSS v4.0 Requirement 9: Restrict Physical Access to Cardholder Data
       @elseif ($title==10)
       PCI-DSS v4.0 Requirement 10: Log and Monitor All Access to System Components and Cardholder Data
       @elseif ($title==11)
       PCI-DSS v4.0 Requirement 11: Test Security of Systems and Networks Regularly
       @elseif ($title==12)
       PCI-DSS v4.0 Requirement 12: Support Information Security with Organizational Policies and Programs
       @elseif ($title=='A2')
       Appendix A2: Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present POS POI Terminal Connections        @endif
    </h2>


    <table class="table table-bordered table-responsive table-primary">

        <thead>
            <td>Title of Mandatory Requirement</td>
            <td>Actions</td>
        </thead>

        <tbody>
            <tr>

                <td>
                <p>{!! nl2br($data[0][1]) !!} {!! nl2br($data[0][2]) !!}</p>

                </td>
                <td><a href="/pci_sec_2_2_req/{{($data[0][1]) }}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-sm my_bg_color text-white">View</a></td>

            </tr>

            @for ($i = 1; $i < count($data); $i++)
            <tr style="vertical-align: middle;text-align:initial">

                    @php
                    $my_prev_main_req_num=$data[$i-1][1];
                     $my_current_main_req_num=$data[$i][1];
                    @endphp


                    @if ($my_prev_main_req_num==$my_current_main_req_num)
                        @continue

                    @else
                    <td>
                        <p> {!! nl2br($data[$i][1]) !!} {!! nl2br($data[$i][2]) !!}</p>

                       </td>

                       <td><a href="/pci_sec_2_2_req/{{$my_current_main_req_num}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-sm my_bg_color text-white">View</a></td>
                    @endif









                              {{-- <p>{!! nl2br($data[$i][2]) !!}</p> --}}

             @endfor
            {{-- @foreach ($data as $d)

            <tr>
                <td>{!! nl2br($d[2]) !!}</td>
                <td style="text-align:center">
                    <a href="/"><i class="fas fa-eye fa-lg" style="color: #114a1d;"></i>
                    </a></td>

            </tr>

            @endforeach --}}

        </tbody>

    </table>

</div>

@endsection
