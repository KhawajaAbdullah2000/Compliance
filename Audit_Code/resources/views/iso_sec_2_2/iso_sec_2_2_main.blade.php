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


    @if(session('evidenceLevel')!='project')

       @include('components.sec2_2_asset_details',[
    'asset'=>$asset
  ])

    @endif

    @if(Session('evidenceLevel')=='project')

<a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>

@endif


      <h2 class="fw-bold mt-4 mb-4">
        @if($title==4)
        Context Of the Organization
        @elseif ($title==5)
        Leadership
        @elseif ($title==6)
        Planning
        @elseif ($title==7)
        Support
        @elseif ($title==8)
        Operation
        @elseif ($title==9)
       Performance Evaluation
       @elseif ($title==10)
     Improvement
        @endif
    </h2>

    <h4>Select one {{$project->type}}  subdomain from below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
        @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
        @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
        @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
        @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif
    
    </h4>


    <table class="table table-bordered table-responsive table-primary">

        <thead class="fw-bold table-dark">
            <td>Subdomain</td>
            <td>Actions</td>
            <td>Edit</td>
        </thead>

        <tbody>
            <tr>
                @php
                $my_main_req_num=explode(' ',$data[0][2]);
                @endphp
                <td>
                <p>{!! nl2br($data[0][2]) !!}</p>
                </td>
                <td><a href="/iso_sec_2_2_req/{{$my_main_req_num[0]}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-sm my_bg_color text-white">Select</a></td>

                <td>
                    <form action="/add_mandatory_all_domain/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                        @csrf
                        <input type="hidden" name="domain" value="{{$my_main_req_num[0]}}">
                        <div class="d-flex align-items-center">
                            <select name="comp_status" class="form-select rounded-pill me-2">
                           
                                <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                                <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                                <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                                <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                                <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-success">Submit</button>
                        </div>
                    </form>
                </td>
            </tr>

            @for ($i = 1; $i < count($data); $i++)
            <tr style="vertical-align: middle;text-align:initial">

                    @php
                    $my_prev_main_req_num=explode(' ',$data[$i-1][2]);
                     $my_current_main_req_num=explode(' ',$data[$i][2]);
                    @endphp


                    @if ($my_prev_main_req_num[0]==$my_current_main_req_num[0])
                        @continue

                    @else
                    <td>
                        <p> {!! nl2br($data[$i][2]) !!} </p>
                       </td>

                       <td><a href="/iso_sec_2_2_req/{{$my_current_main_req_num[0]}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-sm my_bg_color text-white">Select</a></td>
                       <td>
                        <form action="/add_mandatory_all_domain/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="Post">
                            @csrf
                            <input type="hidden" name="domain" value="{{$data[$i][2]}}">
                            <div class="d-flex align-items-center">
                                <select name="comp_status" class="form-select rounded-pill me-2">
                               
                                    <option value="yes" {{ old('comp_status', ) == 'yes' ? 'selected' : '' }}>In Place</option>
                                    <option value="no" {{ old('comp_status', ) == 'no' ? 'selected' : '' }}>Not in Place</option>
                                    <option value="not_applicable" {{ old('comp_status', ) == 'not_applicable' ? 'selected' : '' }}>Not Applicable</option>
                                    <option value="not_tested" {{ old('comp_status', ) == 'not_tested' ? 'selected' : '' }}>Not Tested</option>
                                    <option value="partial" {{ old('comp_status' ) == 'partial' ? 'selected' : '' }}>Partial</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-success">Submit</button>
                            </div>
                        </form>
                    </td>
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
