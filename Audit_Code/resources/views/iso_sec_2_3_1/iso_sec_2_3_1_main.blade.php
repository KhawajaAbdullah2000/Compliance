@extends('master')

@section('content')

@include('user-nav')
@include('iso_sec_nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container-fluid">

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



    <h3 class="fw-bold">Information Security Risk Assessment Applicable to</h3>


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="col-md-6 mt-4">
<table class="table table-bordered table-responsive">
    <tr>
        <td class="bg-secondary text-white">Service</td>
        <td>{{$assetData->s_name}}</td>
        <td class="bg-secondary text-white">Asset Group</td>
        <td>{{$assetData->g_name}}</td>
        <td class="bg-secondary text-white">Asset</td>
        <td>{{$assetData->name}}</td>
        <td class="bg-secondary text-white">Asset Component</td>
        <td>{{$assetData->c_name}}</td>
    </tr>
</table>
</div>

<h3 class="fw-bold mt-2">Severity of Adverse Impacts</h3>
<div class="col-md-6">
<table class="table mt-2 table-bordered table-responsive">
    <tr>
        <td class="bg-secondary text-white">Risk to Data Confidentiality</td>
        <td>  @if($assetData->risk_confidentiality == 10)
            <span class="text-danger">High</span>
          @elseif($assetData->risk_confidentiality == 5)
            <span class="text-warning">Medium</span>
          @elseif($assetData->risk_confidentiality == 1)
            <span class="text-success">Low</span>
          @endif</td>
        <td class="bg-secondary text-white">Risk to Data Integrity</td>
        <td>    @if($assetData->risk_integrity == 10)
            <span class="text-danger">High</span>
          @elseif($assetData->risk_integrity == 5)
            <span class="text-warning">Medium</span>
          @elseif($assetData->risk_integrity == 1)
            <span class="text-success">Low</span>
          @endif</td>
        <td class="bg-secondary text-white">Risk to Data Availability</td>
        <td>    @if($assetData->risk_availability == 10)
            <span class="text-danger">High</span>
          @elseif($assetData->risk_availability == 5)
            <span class="text-warning">Medium</span>
          @elseif($assetData->risk_availability == 1)
            <span class="text-success">Low</span>
          @endif</td>
  
        
    </tr>
</table>

</div>







</div>

<div class="col-md-6">

<div class="card">
 
    <div class="card-body">
      <div class="row">
        <!-- Column 1 -->
        <div class="col-md-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="5" id="checkbox1" checked>
            <label class="form-check-label" for="checkbox1">
            Organization Controls
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="6" id="checkbox2" checked>
            <label class="form-check-label" for="checkbox2">
              People Controls
            </label>
          </div>
        </div>
        <!-- Column 2 -->
        <div class="col-md-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="7" id="checkbox3" checked>
            <label class="form-check-label" for="checkbox3">
              Physical Controls
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="8" id="checkbox4" checked>
            <label class="form-check-label" for="checkbox4">
            Technological Controls
            </label>
          </div>
        </div>

   
        </div>
      </div> 
    </div> 
  </div>

</div>

<form action="/iso_sec2_3_1_initial_add/{{$assetData->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" method="post" class="mx-4 mt-4">
    @csrf

    <input type="hidden" name="risk_confidentiality_value" value="{{$assetData->risk_confidentiality}}">
    <input type="hidden" name="risk_integrity_value" value="{{$assetData->risk_integrity}}">
    <input type="hidden" name="risk_availability_value" value="{{$assetData->risk_availability}}">




    @if(in_array('Data Inputter',$permissions))
    <div class="d-flex justify-content-end mb-4">
        <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md me-2">
          Assets in this Project
        </a>
        <button type="submit" class="btn my_bg_color text-white btn-md" id="submitForm">
          Update Changes
        </button>
      </div>
    @endif
    </table>

 

    <div class="mt-4">
        <table class="table table-responsive table-primary table-striped">
            <colgroup>
                <col style="width: 100px;">
                <col style="width: 300px;">
                <col style="width: 300px;">
                <col style="width: 400px;">
                <col style="width: 100px;">
                <col style="width: 100px;">
                <col style="width: 100px;">
                <col style="width: 150px;">
                <col style="width: 150px;">
                <col style="width: 150px;">
                <col style="width: 100px;">
            </colgroup>

            <thead class="thead-dark" style="vertical-align: middle">
              <tr>
                <th>Control Number</th>
                <th>Title Of Control</th>
                <th>Description of Control</th>
                <th>Control is Applicable?</th>
                <th>Control Compliance%</th>
                <th>Vulnerability%</th>
                <th>Threat%</th>
                <th>Risk Confidentiality</th>
                <th>Risk Integrity</th>
                <th>Risk Availability</th>
               <th>Edit</th>

              </tr>
            </thead>
            
            <tbody>

        @for ($i = 0; $i < count($sec2_4_a5_rows); $i++)
        <tr style="vertical-align: middle;text-align:center" class="control-row-5">
                    @foreach ($sec2_4_a5_rows[$i] as $col)
                    @if(isset($col))
                    @if($loop->index != 2)
                       <td>
                          <p>{!! nl2br($col) !!}</p>
                        </td>
                        @else
                        <td>
                       <p data-bs-toggle="tooltip" title="{!! nl2br($col) !!}">
                                 <i class="fas fa-eye fa-lg text-success"></i> </p>
                          </td>

                        @endif

                    @endif

                    @endforeach
                    {{-- <td>yes/no {{$data[$i][0]}}</td> --}}

                <td style="text-align: center">
                    @if($a5_results->count()>0)
                    @foreach ($a5_results as $a5)

                    @if($a5->applicability!=null && $a5->control_num===strval($sec2_4_a5_rows[$i][0]))

                 <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">

            <option value='yes+{{$sec2_4_a5_rows[$i][0]}}' {{$a5->applicability=="yes"?'selected':''}}>Only to this asset       component</option>

            <option value='yes_to_all+{{$sec2_4_a5_rows[$i][0]}}' {{$a5->applicability=="yes_to_all"?'selected':''}}>To all asset components in this Service</option>



                    <option value='no+{{$sec2_4_a5_rows[$i][0]}}' {{$a5->applicability=="no"?'selected':''}}>Not to this asset component</option>
                    </select>
                     {{-- <p>{{$a5->applicability}} </p> --}}
                        @break


                    @endif

                    @if($loop->last)
                    <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">


                        <option value='yes+{{$sec2_4_a5_rows[$i][0]}}'>Only to this Asset Component</option>
                        <option value='yes_to_all+{{$sec2_4_a5_rows[$i][0]}}'>To all asset components in this Service</option>

                        <option value='no+{{$sec2_4_a5_rows[$i][0]}}'>Not to this asset component</option>
                    </select>
                    @endif

                    @endforeach
                    @else
                    <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">

                        <option value='yes+{{$sec2_4_a5_rows[$i][0]}}'>Only to this Asset Component</option>
                        <option value='yes_to_all+{{$sec2_4_a5_rows[$i][0]}}'>To all asset components in this Service</option>
                        <option value='no+{{$sec2_4_a5_rows[$i][0]}}'>Not to this asset component</option>
                    </select>
                    @endif


                </td>

                <td style="text-align: center">
                    @if($a5_results->count()>0)
                    @foreach ($a5_results as $a5)

                    @if($a5->control_num===strval($sec2_4_a5_rows[$i][0]))

            <input type="number" name="control_compliance[]" value={{$a5->control_compliance}} oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}" >

                    {{-- <p>{{$a5->control_compliance}}%</p> --}}
                        @break
                    @endif

                    @if($loop->last)
                    <input type="number" name="control_compliance[]" value=100 oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}" >

                    @endif

                    @endforeach
                    @else
                 <input type="number" name="control_compliance[]" value=100 oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}" >

                    @endif
                </td>

                <td>
                    @if($a5_results->count()>0)
                        @foreach ($a5_results as $a5)

                            @if( $a5->control_num===strval($sec2_4_a5_rows[$i][0]))

       <input type="number" name="vulnerability[]" class="form-control" value={{$a5->vulnerability}}  data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>

                                 {{-- <p>{{$a5->vulnerability}}%</p> --}}

                                    @break
                                @endif

                                @if($loop->last)
                            <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>
                                @endif

                        @endforeach
                    @else
                        <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>

                    @endif

                </td>

                <td>
                    @if($a5_results->count()>0)
                        @foreach ($a5_results as $a5)

                            @if($a5->control_num===strval($sec2_4_a5_rows[$i][0]))
             <input type="number" name="threat[]" value={{$a5->threat}} class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}">

                                {{-- <p>{{$a5->threat}}%</p> --}}
                                    @break
                                @endif

                                @if($loop->last)
             <input type="number" name="threat[]" value=100 class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}">
                    @endif

                        @endforeach
                    @else
            <input type="number" name="threat[]" value=100 class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}">

                    @endif

                </td>

                <td>
                    @if($a5_results->count() > 0)
                        @foreach ($a5_results as $a5)
                            @if($a5->risk_level != null && $a5->control_num === strval($sec2_4_a5_rows[$i][0]))

                                {{-- Determine background color class --}}
                                @php
                                    $backgroundClass = '';
                                    if ($a5->risk_level >= 0 && $a5->risk_level <0.9) {
                                        $backgroundClass = 'green-background';
                                    } elseif ($a5->risk_level >= 0.9 && $a5->risk_level < 7.2) {
                                        $backgroundClass = 'orange-background';
                                    } elseif ($a5->risk_level >= 7.2 && $a5->risk_level <= 10) {
                                        $backgroundClass = 'red-background';
                                    }
                                @endphp

                                <input type="number" name="risk_level[]" value="{{ $a5->risk_level }}"
                                    class="form-control {{ $backgroundClass }}"
                                    data-control-id="{{ $sec2_4_a5_rows[$i][0] }}" readonly>
                                @break

                            @endif

                            @if($loop->last)
                                <input type="number" name="risk_level[]"
                                    class="form-control"
                                    data-control-id="{{ $sec2_4_a5_rows[$i][0] }}" readonly>
                            @endif
                        @endforeach
                    @else
                        <input type="number" name="risk_level[]"
                            class="form-control"
                            data-control-id="{{ $sec2_4_a5_rows[$i][0] }}" readonly>
                    @endif
                </td>



                <td>
                    @if($a5_results->count()>0)
                    @foreach ($a5_results as $a5)

                        @if($a5->risk_integrity!=null && $a5->control_num===strval($sec2_4_a5_rows[$i][0]))

                        @php
                                    $backgroundClass = '';
                                    if ($a5->risk_integrity >= 0 && $a5->risk_integrity <0.9) {
                                        $backgroundClass = 'green-background';
                                    } elseif ($a5->risk_integrity >= 0.9 && $a5->risk_integrity < 7.2) {
                                        $backgroundClass = 'orange-background';
                                    } elseif ($a5->risk_integrity >= 7.2 && $a5->risk_integrity <= 10) {
                                        $backgroundClass = 'red-background';
                                    }
                                @endphp

            <input type="number" name="risk_integrity[]" value={{$a5->risk_integrity}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>

                                @break
                            @endif

                            @if($loop->last)
         <input type="number" name="risk_integrity[]" class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>
                    @endif

                    @endforeach
                @else
    <input type="number" name="risk_integrity[]" class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>

                @endif


                </td>


                <td>
                    @if($a5_results->count()>0)
                    @foreach ($a5_results as $a5)

                        @if($a5->risk_availability!=null && $a5->control_num===strval($sec2_4_a5_rows[$i][0]))

                        @php
                        $backgroundClass = '';
                        if ($a5->risk_availability >= 0 && $a5->risk_availability <0.9) {
                            $backgroundClass = 'green-background';
                        } elseif ($a5->risk_availability >= 0.9 && $a5->risk_availability < 7.2) {
                            $backgroundClass = 'orange-background';
                        } elseif ($a5->risk_availability >= 7.2 && $a5->risk_availability <= 10) {
                            $backgroundClass = 'red-background';
                        }
                    @endphp

            <input type="number" name="risk_availability[]" value={{$a5->risk_availability}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>

                                @break
                            @endif

                            @if($loop->last)
         <input type="number" name="risk_availability[]" class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>
                    @endif

                    @endforeach
                @else
    <input type="number" name="risk_availability[]" class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>

                @endif


                </td>







                 <td>
                @if($a5_results->count()>0)
                    @foreach ($a5_results as $a5)

                        @if($a5->risk_level!=null && $a5->control_num===strval($sec2_4_a5_rows[$i][0]))
                        @if(in_array('Data Inputter',$permissions) )
                        <a href="/edit_risk_assessment/{{$project->project_id}}/{{auth()->user()->id}}/{{$assetData->assessment_id}}/{{$a5->control_num}}">
                            <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
                        </a>

                        @else
                        <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>
                        @endif


                                @break
                            @endif

                            @if($loop->last)
                            <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>
                          @endif

                    @endforeach
                @else
                <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>

                @endif


                </td>





                </tr>
    @endfor



    {{-- sec2_4_a6rows --}}

    @for ($i = 0; $i < count($sec2_4_a6_rows); $i++)
    <tr style="vertical-align: middle;text-align:center" class="control-row-6">
                @foreach ($sec2_4_a6_rows[$i] as $col)
                @if(isset($col))
                @if($loop->index != 2)
                <td>
                   <p>{!! nl2br($col) !!}</p>
                 </td>
                 @else
                 <td>
                <p data-bs-toggle="tooltip" title="{!! nl2br($col) !!}">
                          <i class="fas fa-eye fa-lg text-success"></i> </p>
                   </td>

                 @endif
                @endif

                @endforeach
                {{-- <td>yes/no {{$data[$i][0]}}</td> --}}

            <td style="text-align: center">
                @if($a6_results->count()>0)
                @foreach ($a6_results as $a6)

                @if($a6->applicability!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))
                <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">

                    <option value='yes+{{$sec2_4_a6_rows[$i][0]}}' {{$a6->applicability=="yes"?'selected':''}}>Only to this asset component</option>

                    <option value='yes_to_all+{{$sec2_4_a6_rows[$i][0]}}' {{$a6->applicability=="yes_to_all"?'selected':''}}>To all asset components in this Service</option>

                    <option value='no+{{$sec2_4_a6_rows[$i][0]}}' {{$a6->applicability=="no"?'selected':''}}>Not to this asset component</option>
                </select>

                    @break
                @endif

                @if($loop->last)

               <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">


                <option value='yes+{{$sec2_4_a6_rows[$i][0]}}'>Only to this asset component</option>
                <option value='yes_to_all+{{$sec2_4_a6_rows[$i][0]}}'>To all asset components in this Service</option>
                <option value='no+{{$sec2_4_a6_rows[$i][0]}}'>Not to this asset component</option>
            </select>
                @endif

                @endforeach
                @else

               <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">


                <option value='yes+{{$sec2_4_a6_rows[$i][0]}}'>Only to this asset component</option>
                <option value='yes_to_all+{{$sec2_4_a6_rows[$i][0]}}'>To all asset components in this Service</option>
                <option value='no+{{$sec2_4_a6_rows[$i][0]}}'>Not to this asset component</option>
            </select>
                @endif




            </td>

            <td style="text-align: center">
                @if($a6_results->count()>0)
                @foreach ($a6_results as $a6)

                    @if($a6->control_compliance!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))
                    <input type="number" name="control_compliance[]" value={{$a6->control_compliance}} oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}" >

                            @break
                        @endif

                        @if($loop->last)
            <input type="number" name="control_compliance[]" value=100 oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}" >
                @endif

                @endforeach
            @else
        <input type="number" name="control_compliance[]" value=100 oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}" >

            @endif
            </td>


            <td>
                    @if($a6_results->count()>0)
                    @foreach ($a6_results as $a6)

                        @if($a6->control_num===strval($sec2_4_a6_rows[$i][0]))

              <input type="number" name="vulnerability[]" class="form-control" value={{$a6->vulnerability}} data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>


                                @break
                            @endif

                            @if($loop->last)
        <input type="number" name="vulnerability[]"   class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>
                    @endif

                    @endforeach
                @else
    <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>

                @endif

            </td>

            <td>
                @if($a6_results->count()>0)
                @foreach ($a6_results as $a6)

                    @if($a6->threat!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))
                    <input type="number" name="threat[]" value={{$a6->threat}} class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}">

                        {{-- <p>{{$a6->threat}}%</p> --}}
                            @break
                        @endif

                        @if($loop->last)
        <input type="number" name="threat[]" value=100 class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}">
                @endif

                @endforeach
            @else
             <input type="number" name="threat[]" value=100 class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}">

            @endif

            </td>

            <td>
                @if($a6_results->count()>0)
                @foreach ($a6_results as $a6)

                    @if($a6->risk_level!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))
                    @php
                                    $backgroundClass = '';
                                    if ($a6->risk_level >= 0 && $a6->risk_level <0.9) {
                                        $backgroundClass = 'green-background';
                                    } elseif ($a6->risk_level >= 0.9 && $a6->risk_level < 7.2) {
                                        $backgroundClass = 'orange-background';
                                    } elseif ($a6->risk_level >= 7.2 && $a6->risk_level <= 10) {
                                        $backgroundClass = 'red-background';
                                    }
                                @endphp
                    <input type="number" name="risk_level[]" value={{$a6->risk_level}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>
                            @break
                        @endif

                        @if($loop->last)
     <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>
                @endif

                @endforeach
            @else
     <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>

            @endif

            </td>

            <td>
                @if($a6_results->count()>0)
                @foreach ($a6_results as $a6)
                @if($a6->risk_integrity!=null && $a6->control_num!=6.6)

                    @if($a6->risk_integrity!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))
                    @php
                                    $backgroundClass = '';
                                    if ($a6->risk_integrity >= 0 && $a6->risk_integrity <0.9) {
                                        $backgroundClass = 'green-background';
                                    } elseif ($a6->risk_integrity >= 0.9 && $a6->risk_integrity < 7.2) {
                                        $backgroundClass = 'orange-background';
                                    } elseif ($a6->risk_integrity >= 7.2 && $a6->risk_integrity <= 10) {
                                        $backgroundClass = 'red-background';
                                    }
                                @endphp
                    <input type="number" name="risk_integrity[]" value={{$a6->risk_integrity}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>
                            @break
                        @endif

                        @if($loop->last)
                      @if( $a6->control_num!=6.6)
     <input type="number" name="risk_integrity[]" class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>
              @else
              <input type="number" name="risk_integrity[]" class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly value=0>

              @endif

     
     @endif

                @else

                @endif

                @endforeach
            @else

     <input type="number" name="risk_integrity[]" class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>

            @endif

            </td>

            <td>
                @if($a6_results->count()>0)
                @foreach ($a6_results as $a6)

                @if($a6->risk_integrity!=null && $a6->control_num!=6.6)

                    @if($a6->risk_availability!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))
                    @php
                                    $backgroundClass = '';
                                    if ($a6->risk_availability >= 0 && $a6->risk_availability <0.9) {
                                        $backgroundClass = 'green-background';
                                    } elseif ($a6->risk_availability >= 0.9 && $a6->risk_availability < 7.2) {
                                        $backgroundClass = 'orange-background';
                                    } elseif ($a6->risk_availability >= 7.2 && $a6->risk_availability <= 10) {
                                        $backgroundClass = 'red-background';
                                    }
                                @endphp
                    <input type="number" name="risk_availability[]" value={{$a6->risk_availability}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>
                            @break
                        @endif

                        @if($loop->last)
     <input type="number" name="risk_availability[]" class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>
                @endif


                @endif

                @endforeach
            @else

     <input type="number" name="risk_availability[]" class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>

            @endif

            </td>




             <td>
                @if($a6_results->count()>0)
                    @foreach ($a6_results as $a6)

                        @if($a6->risk_level!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))
                        @if(in_array('Data Inputter',$permissions) )
                        <a href="/edit_risk_assessment/{{$project->project_id}}/{{auth()->user()->id}}/{{$assetData->assessment_id}}/{{$a6->control_num}}">
                            <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
                        </a>

                        @else
                        <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>
                        @endif


                                @break
                            @endif

                            @if($loop->last)
                            <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>
                          @endif

                    @endforeach
                @else
                <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>

                @endif


                </td>



            </tr>
@endfor

 {{-- sec2_4_a7rows --}}

 @for ($i = 0; $i < count($sec2_4_a7_rows); $i++)
 <tr style="vertical-align: middle;text-align:center" class="control-row-7">
             @foreach ($sec2_4_a7_rows[$i] as $col)
             @if(isset($col))
             @if($loop->index != 2)
             <td>
                <p>{!! nl2br($col) !!}</p>
              </td>
              @else
              <td>
             <p data-bs-toggle="tooltip" title="{!! nl2br($col) !!}">
                       <i class="fas fa-eye fa-lg text-success"></i> </p>
                </td>

              @endif
             @endif

             @endforeach
             {{-- <td>yes/no {{$data[$i][0]}}</td> --}}

         <td style="text-align: center">
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->applicability!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))

                <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">

                    <option value='yes+{{$sec2_4_a7_rows[$i][0]}}' {{$a7->applicability=="yes"?'selected':''}}>Only to this asset component</option>

                    <option value='yes_to_all+{{$sec2_4_a7_rows[$i][0]}}' {{$a7->applicability=="yes_to_all"?'selected':''}}>To all asset components in this Service</option>

                    <option value='no+{{$sec2_4_a7_rows[$i][0]}}' {{$a7->applicability=="no"?'selected':''}}>Not to this asset component</option>
                </select>
                        @break
                    @endif

                    @if($loop->last)
                    <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">


                        <option value='yes+{{$sec2_4_a7_rows[$i][0]}}'>Only to this asset component</option>
                        <option value='yes_to_all+{{$sec2_4_a7_rows[$i][0]}}'>To all asset components in this Service</option>

                        <option value='no+{{$sec2_4_a7_rows[$i][0]}}'>Not to this asset component</option>
                    </select>            @endif

            @endforeach
        @else
        <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">
            <option value='yes+{{$sec2_4_a7_rows[$i][0]}}'>Only to this asset component</option>
            <option value='yes_to_all+{{$sec2_4_a7_rows[$i][0]}}'>To all asset components in this Service</option>
            <option value='no+{{$sec2_4_a7_rows[$i][0]}}'>Not to this asset component</option>
        </select>
        @endif




         </td>

         <td style="text-align: center">
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->control_compliance!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))

                <input type="number" name="control_compliance[]" value={{$a7->control_compliance}} oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}" >

                        @break
                    @endif

                    @if($loop->last)
        <input type="number" name="control_compliance[]" value=100 min=0 max=100 oninput="validateInput(this)" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" >


                    @endif

            @endforeach
        @else
 <input type="number" name="control_compliance[]" value=100 oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}" >

        @endif

         </td>

         <td>
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if( $a7->control_num===strval($sec2_4_a7_rows[$i][0]))
                <input type="number" name="vulnerability[]" value={{$a7->vulnerability}} class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>

                    {{-- <p>{{$a7->vulnerability}}% </p> --}}
                        @break
                    @endif

                    @if($loop->last)
        <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>


                    @endif

            @endforeach
        @else
     <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>

        @endif


         </td>

         <td>

            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->threat!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))
                <input type="number" name="threat[]" value={{$a7->threat}} class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}">

                    {{-- <p>{{$a7->threat}}% </p> --}}
                        @break
                    @endif

                    @if($loop->last)
         <input type="number" name="threat[]" value=100 class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}">


                    @endif

            @endforeach
        @else
         <input type="number" name="threat[]" value=100 class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}">

        @endif

         </td>

         <td>
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->risk_level!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))
                @php
                $backgroundClass = '';
                if ($a7->risk_level >= 0 && $a7->risk_level <0.9) {
                    $backgroundClass = 'green-background';
                } elseif ($a7->risk_level >= 0.9 && $a7->risk_level < 7.2) {
                    $backgroundClass = 'orange-background';
                } elseif ($a7->risk_level >= 7.2 && $a7->risk_level <= 10) {
                    $backgroundClass = 'red-background';
                }
            @endphp
                <input type="number" name="risk_level[]" value={{$a7->risk_level}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>
                        @break
                    @endif

                    @if($loop->last)
            <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>


                    @endif

            @endforeach
        @else
             <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>

        @endif

         </td>


         <td>
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->risk_integrity!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))
                @php
                $backgroundClass = '';
                if ($a7->risk_integrity >= 0 && $a7->risk_integrity <0.9) {
                    $backgroundClass = 'green-background';
                } elseif ($a7->risk_integrity >= 0.9 && $a7->risk_integrity < 7.2) {
                    $backgroundClass = 'orange-background';
                } elseif ($a7->risk_integrity >= 7.2 && $a7->risk_integrity <= 10) {
                    $backgroundClass = 'red-background';
                }
            @endphp
                <input type="number" name="risk_integrity[]" value={{$a7->risk_integrity}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>
                        @break
                    @endif

                    @if($loop->last)
            <input type="number" name="risk_integrity[]" class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>


                    @endif

            @endforeach
        @else
             <input type="number" name="risk_integrity[]" class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>

        @endif

         </td>

         <td>
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->risk_availability!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))
                @php
                $backgroundClass = '';
                if ($a7->risk_availability >= 0 && $a7->risk_availability <0.9) {
                    $backgroundClass = 'green-background';
                } elseif ($a7->risk_availability >= 0.9 && $a7->risk_availability < 7.2) {
                    $backgroundClass = 'orange-background';
                } elseif ($a7->risk_availability >= 7.2 && $a7->risk_availability <= 10) {
                    $backgroundClass = 'red-background';
                }
            @endphp
                <input type="number" name="risk_availability[]" value={{$a7->risk_availability}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>
                        @break
                    @endif

                    @if($loop->last)
            <input type="number" name="risk_availability[]" class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>


                    @endif

            @endforeach
        @else
             <input type="number" name="risk_availability[]" class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>

        @endif

         </td>


          <td>
            @if($a7_results->count()>0)
                @foreach ($a7_results as $a7)

                    @if($a7->risk_level!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))
                    @if(in_array('Data Inputter',$permissions) )
                    <a href="/edit_risk_assessment/{{$project->project_id}}/{{auth()->user()->id}}/{{$assetData->assessment_id}}/{{$a7->control_num}}">
                        <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
                    </a>

                    @else
                    <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>
                    @endif


                            @break
                        @endif

                        @if($loop->last)
                        <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>
                      @endif

                @endforeach
            @else
            <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>

            @endif


            </td>


         </tr>
@endfor

{{-- sec2_4_a8rows --}}

@for ($i = 0; $i < count($sec2_4_a8_rows); $i++)
<tr style="vertical-align: middle;text-align:center" class="control-row-8">
            @foreach ($sec2_4_a8_rows[$i] as $col)
            @if(isset($col))
            @if($loop->index != 2)
            <td>
               <p>{!! nl2br($col) !!}</p>
             </td>
             @else
             <td>
            <p data-bs-toggle="tooltip" title="{!! nl2br($col) !!}">
                      <i class="fas fa-eye fa-lg text-success"></i> </p>
               </td>

             @endif

            @endif

            @endforeach
            {{-- <td>yes/no {{$data[$i][0]}}</td> --}}

        <td style="text-align: center">
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

                @if($a8->applicability!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))

                <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">

                    <option value='yes+{{$sec2_4_a8_rows[$i][0]}}' {{$a8->applicability=="yes"?'selected':''}}>Only to this asset component</option>
                    <option value='yes_to_all+{{$sec2_4_a8_rows[$i][0]}}' {{$a8->applicability=="yes_to_all"?'selected':''}}>To all asset components in this Service</option>

                    <option value='no+{{$sec2_4_a8_rows[$i][0]}}' {{$a8->applicability=="no"?'selected':''}}>Not to this asset component</option>
                </select>
                        @break
                    @endif

                    @if($loop->last)
                    <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">

                        <option value='yes+{{$sec2_4_a8_rows[$i][0]}}'>Only to this asset component</option>
                        <option value='yes_to_all+{{$sec2_4_a8_rows[$i][0]}}'>To all asset components in this Service</option>
                        <option value='no+{{$sec2_4_a8_rows[$i][0]}}'>Not to this asset component</option>
                    </select>            @endif

            @endforeach
        @else
        <select name="applicability[]" class="form-select" onchange="checkapplicability(this)">
            <option value='yes+{{$sec2_4_a8_rows[$i][0]}}'>Only to this asset component</option>
            <option value='yes_to_all+{{$sec2_4_a8_rows[$i][0]}}'>To all asset components in this Service</option>
            <option value='no+{{$sec2_4_a8_rows[$i][0]}}'>Not to this asset component</option>
        </select>
        @endif



        </td>

        <td style="text-align: center">
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

                @if($a8->control_compliance!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))

                <input type="number" name="control_compliance[]" value={{$a8->control_compliance}} oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}" >

                        @break
                    @endif

                    @if($loop->last)
            <input type="number" name="control_compliance[]" value=100 oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}" >

                      @endif

            @endforeach
        @else
     <input type="number" name="control_compliance[]" value=100 oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}" >

        @endif
        </td>

        <td>
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

                @if($a8->control_num===strval($sec2_4_a8_rows[$i][0]))
                <input type="number" name="vulnerability[]" value={{$a8->vulnerability}} class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>

                    {{-- <p>{{$a8->vulnerability}}%</p> --}}
                        @break
                    @endif

                    @if($loop->last)
        <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>

                      @endif

            @endforeach
        @else
    <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>

        @endif

        </td>

        <td>
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

                @if($a8->threat!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))
                <input type="number" name="threat[]" value={{$a8->threat}} class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}">

                    {{-- <p>{{$a8->threat}}%</p> --}}
                        @break
                    @endif

                    @if($loop->last)
         <input type="number" name="threat[]" value=100 class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}">

                      @endif

            @endforeach
        @else
             <input type="number" name="threat[]" value=100 class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}">
        @endif


        </td>

        <td>
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

            @if( $a8->control_num!=null && !in_array( $a8->control_num, array(8.6,8.13,8.14) ) )

                @if($a8->risk_level!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))
                @php
                $backgroundClass = '';
                if ($a8->risk_level >= 0 && $a8->risk_level <0.9) {
                    $backgroundClass = 'green-background';
                } elseif ($a8->risk_level >= 0.9 && $a8->risk_level < 7.2) {
                    $backgroundClass = 'orange-background';
                } elseif ($a8->risk_level >= 7.2 && $a8->risk_level <= 10) {
                    $backgroundClass = 'red-background';
                }
            @endphp
                <input type="number" name="risk_level[]" value={{$a8->risk_level}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>
                        @break
                    @endif

                    @if($loop->last)
         <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>

                      @endif
@else

@endif
            @endforeach
        @else
         <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>
            @endif

        </td>

        <td>
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

            @if( $a8->control_num!=null && !in_array( $a8->control_num, array(8.11,8.12,8.6,8.13,8.14)) )
            

                @if($a8->risk_integrity!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))
                @php
                $backgroundClass = '';
                if ($a8->risk_integrity >= 0 && $a8->risk_integrity <0.9) {
                    $backgroundClass = 'green-background';
                } elseif ($a8->risk_integrity >= 0.9 && $a8->risk_integrity < 7.2) {
                    $backgroundClass = 'orange-background';
                } elseif ($a8->risk_integrity >= 7.2 && $a8->risk_integrity <= 10) {
                    $backgroundClass = 'red-background';
                }
            @endphp
                <input type="number" name="risk_integrity[]" value={{$a8->risk_integrity}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>
                        @break
                    @endif

                    @if($loop->last)
         <input type="number" name="risk_integrity[]" class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>

                      @endif
@else

@endif



            @endforeach
        @else
         <input type="number" name="risk_integrity[]" class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>
            @endif

        </td>

        <td>
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

            @if( $a8->control_num!=null && !in_array( $a8->control_num, array(8.11,8.12) ) )


                @if($a8->risk_availability!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))
                @php
                $backgroundClass = '';
                if ($a8->risk_availability >= 0 && $a8->risk_availability <0.9) {
                    $backgroundClass = 'green-background';
                } elseif ($a8->risk_availability >= 0.9 && $a8->risk_availability < 7.2) {
                    $backgroundClass = 'orange-background';
                } elseif ($a8->risk_availability >= 7.2 && $a8->risk_availability <= 10) {
                    $backgroundClass = 'red-background';
                }
            @endphp
                <input type="number" name="risk_availability[]" value={{$a8->risk_availability}} class="form-control {{$backgroundClass}}" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>
                        @break
                    @endif

                    @if($loop->last)
         <input type="number" name="risk_availability[]" class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>

                      @endif
@else

@endif
            @endforeach
        @else
         <input type="number" name="risk_availability[]" class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>
            @endif

        </td>




         <td>
            @if($a8_results->count()>0)
                @foreach ($a8_results as $a8)

                    @if($a8->risk_level!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))
                    @if(in_array('Data Inputter',$permissions) )
                    <a href="/edit_risk_assessment/{{$project->project_id}}/{{auth()->user()->id}}/{{$assetData->assessment_id}}/{{$a8->control_num}}">
                        <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
                    </a>

                    @else
                    <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>
                    @endif


                            @break
                        @endif

                        @if($loop->last)
                        <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>
                      @endif

                @endforeach
            @else
            <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>

            @endif


            </td>


        </tr>

@endfor







            </tbody>
{{--
            @if(in_array('Data Inputter',$permissions))
          <div class="float-end mb-4">
            <button type="submit" class="btn my_bg_color text-white btn-lg mt-5"  id="submitForm">Save and stay on same page</button>
          </div>
          @endif
          </table> --}}

    </div>

   
   

        </form>


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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif

<script>
    $(document).ready(function () {
        console.log("Hello ")
      // Handle checkbox toggle
      $('.form-check-input').change(function () {
        console.log("Change detected")
        const controlValue = $(this).val(); // Get the value of the checkbox
        console.log("Control value is: "+ controlValue)
        const rowsToToggle = `.control-row-${controlValue}`; // Build the class selector for rows
console.log("rows to toggle: "+ rowsToToggle)
        if ($(this).is(':checked')) {
          // Show rows when checkbox is checked
          $(rowsToToggle).removeClass('hidden-row');
        } else {
          // Hide rows when checkbox is unchecked
          $(rowsToToggle).addClass('hidden-row');
        }
      });
    });
  </script>



{{-- <script>
    $(document).ready(function(){
        var assetValue = parseFloat($('#assetSelect').val()) || 10;
        var newVulnerabilityValue = null;
        var threat = null;
        var newRiskValue = null;
        var controlId = null;
        var riskLevelField = null;

        function initializeValues() {
            $("input[name^='control_compliance']").each(function () {
                controlId = $(this).data('control-id');
                var controlCompliance = parseFloat($(this).val()) || 100;

                var threatValue = parseFloat($("input[name='threat[]'][data-control-id='" + controlId + "']").val()) || 100;

                // Calculate vulnerability
                newVulnerabilityValue = 100 - controlCompliance;

                $("input[name='vulnerability[]'][data-control-id='" + controlId + "']").val(newVulnerabilityValue);


                // Calculate risk level
                newRiskValue = (newVulnerabilityValue / 100) * (threatValue / 100) * assetValue;
                $("input[name='risk_level[]'][data-control-id='" + controlId + "']").val(newRiskValue);
            });
        }

        $('#assetSelect').change(function(){
            // Get the selected value
            assetValue = parseFloat($(this).val());

            // Update all risk values based on the new assetValue
            $("input[name^='control_compliance']").each(function () {
                controlId = $(this).data('control-id');
                var threat = $("input[name='threat[]'][data-control-id='" + controlId + "']").val();
                var vulnerability = 100 - parseFloat($(this).val());
                var newRiskValue = (vulnerability / 100) * (threat / 100) * assetValue;

                // Update the risk level field
                $("input[name='risk_level[]'][data-control-id='" + controlId + "']").val(newRiskValue);
            });
        });

        $("input[name^='control_compliance']").on("input", function () {
            controlId = $(this).data('control-id');
            var vulnerabilityField = $("input[name='vulnerability[]'][data-control-id='" + controlId + "']");
            // Calculate the new value for vulnerability
            newVulnerabilityValue = 100 - parseFloat($(this).val());



            // Update the value of the vulnerability input box
            vulnerabilityField.val(newVulnerabilityValue);

            // Trigger the input event for threat to recalculate risk level
            $("input[name='threat[]'][data-control-id='" + controlId + "']").trigger("input");
        });

        $("input[name^='threat']").on("input", function () {
            threat = $(this).val();
            controlId = $(this).data('control-id');
            riskLevelField = $("input[name='risk_level[]'][data-control-id='" + controlId + "']");
            newRiskValue = parseFloat(newVulnerabilityValue) / 100 * parseFloat(threat) / 100 * assetValue;

            // Update the value of the risk level input box
            riskLevelField.val(newRiskValue);
        });

        $('#selectAllApplicability').change(function(){
            if ($(this).is(':checked')) {
                // Iterate over all applicability select elements and set the value to "yes+control_num"
                $("select[name^='applicability']").each(function () {
                    var controlId = $(this).find('option:eq(1)').val().split('+')[1]; // Get control num from second option value
                    $(this).val('no+' + controlId);
                });
            } else {
                // If the checkbox is unchecked, reset all applicability select elements to the default (empty) value
                $("select[name^='applicability']").each(function () {
                    var controlId = $(this).find('option:eq(1)').val().split('+')[1]; // Get control num from second option value
                    $(this).val('yes+' + controlId);
                });
            }
        });

        $('#selectAllControlCompliance').change(function(){
            if ($(this).is(':checked')) {
                $("input[name^='control_compliance']").each(function () {
                    // Only change the value if the user has not entered a value (default is empty)
                        $(this).val(0).trigger("input");




                });
            } else {

                 $("input[name^='control_compliance']").each(function () {
                 if ($(this).val() == 0) {
                        $(this).val(100).trigger("input");
                    }
                 });
            }
        });


        $('#selectAllThreat').change(function(){
            if ($(this).is(':checked')) {
                $("input[name^='threat']").each(function () {
                    if ($(this).val() == 100) {
                        $(this).val(0).trigger("input");
                    }

                });
            } else {

                 $("input[name^='threat']").each(function () {
                 if ($(this).val() == 0) {
                        $(this).val(100).trigger("input");
                    }
                 });
            }
        });


        // Initialize values on page load
        initializeValues();
    });
</script> --}}



<script>
    function validateInput(inputElement) {

      if (inputElement.value.indexOf(".") !== -1) {
        alert("Decimal values are not allowed.");
        inputElement.value = Math.floor(inputElement.value);
      }
    }

    // function checkapplicability(selectElement) {
    //     if (selectElement.value.startsWith("no+")) {
    //         alert("This action will apply only to this asset component and its risk level for this control will be changed to zero; this action will not affect the risk levels as they currently stand for the other asset components in this project. Changes will be applied when the 'Save Changes' button is pressed.");
    //     }
    // }

    function checkapplicability(selectElement) {
    if (selectElement.value.startsWith("no+")) {
        swal({

            text: "This action will apply only to this asset component and its risk level for this control will be changed to zero; this action will not affect the risk levels as they currently stand for the other asset components in this project. Changes will be applied when the 'Save Changes' button is pressed.",
            icon: "warning",  // You can change the icon to "info", "success", or "error" as needed
            button: "OK",
        });
    }
}

  </script>

@endsection



@endsection
