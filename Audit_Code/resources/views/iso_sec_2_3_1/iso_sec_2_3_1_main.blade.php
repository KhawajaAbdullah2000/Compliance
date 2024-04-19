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



    <h2 class="text-center fw-bold">Information Security Risk Assessment</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<p class="fw-bold">

   Service Name: {{$assetData->s_name}}

    @isset($assetData->g_name)
    <br>
    Asset Group Name: {{$assetData->g_name}}
    @endisset

    @isset($assetData->name)
    <br>
    Asset Name: {{$assetData->name}}
    @endisset

    @isset($assetData->c_name)
    <br>
    Asset Component Name: {{$assetData->c_name}}
    @endisset



</p>


</div>

<form action="/iso_sec2_3_1_initial_add/{{$assetData->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" method="post" class="mx-4 mt-4">
    @csrf


    <div class="row">


    <div class="col-lg-6">



    <div class="fw-bold">
        <label for="">Select Asset value</label>
        <select name="asset_value" class="form-control" id="assetSelect">Asset value

            <option value="">Select --</option>
            <option value=10>High</option>
            <option value=5>Medium</option>
            <option value=1>Low</option>


        </select>
    </div>
    </div>

    </div>




    <div class="mt-4">
        <table class="table table-responsive table-primary table-striped">
            <thead class="thead-dark">
              <tr>
                <th>Control Number</th>
                <th>Title Of Control</th>
                <th>Description of Control</th>
                <th>Control is Applicable?</th>
                <th>Control Compliance%</th>
                <th>Vulnerability%</th>
                <th>Threat%</th>
                <th>Risk Level</th>
                <th>Edit</th>

              </tr>
            </thead>
            <tbody>

        @for ($i = 0; $i < count($sec2_4_a5_rows); $i++)
        <tr style="vertical-align: middle;text-align:initial">
                    @foreach ($sec2_4_a5_rows[$i] as $col)
                    @if(isset($col))
                       <td>
                          <p>{!! nl2br($col) !!}</p>
                        </td>

                    @endif

                    @endforeach
                    {{-- <td>yes/no {{$data[$i][0]}}</td> --}}

                <td style="text-align: center">
                    @if($a5_results->count()>0)
                    @foreach ($a5_results as $a5)

                    @if($a5->applicability!=null && $a5->control_num===strval($sec2_4_a5_rows[$i][0]))

                    <p>{{$a5->applicability}} </p>
                        @break
                    @endif

                    @if($loop->last)
                    <select name="applicability[]" class="form-select">
                        <option value=""> Select--  </option>

                        <option value='yes+{{$sec2_4_a5_rows[$i][0]}}'>Yes</option>

                        <option value='no+{{$sec2_4_a5_rows[$i][0]}}'>No</option>
                    </select>
                    @endif

                    @endforeach
                    @else
                    <select name="applicability[]" class="form-select">
                        <option value=""> Select--  </option>

                        <option value='yes+{{$sec2_4_a5_rows[$i][0]}}'>Yes</option>

                        <option value='no+{{$sec2_4_a5_rows[$i][0]}}'>No</option>
                    </select>
                    @endif


                </td>

                <td style="text-align: center">
                    @if($a5_results->count()>0)
                    @foreach ($a5_results as $a5)

                    @if($a5->control_num===strval($sec2_4_a5_rows[$i][0]))

                    <p>{{$a5->control_compliance}}%</p>
                        @break
                    @endif

                    @if($loop->last)
                    <input type="number" name="control_compliance[]" oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}" >

                    @endif

                    @endforeach
                    @else
                 <input type="number" name="control_compliance[]" oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}" >

                    @endif
                </td>

                <td>
                    @if($a5_results->count()>0)
                        @foreach ($a5_results as $a5)

                            @if( $a5->control_num===strval($sec2_4_a5_rows[$i][0]))

                                <p>{{$a5->vulnerability}}%</p>

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

                                <p>{{$a5->threat}}%</p>
                                    @break
                                @endif

                                @if($loop->last)
             <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}">
                    @endif

                        @endforeach
                    @else
            <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}">

                    @endif

                </td>

                <td>
                    @if($a5_results->count()>0)
                    @foreach ($a5_results as $a5)

                        @if($a5->risk_level!=null && $a5->control_num===strval($sec2_4_a5_rows[$i][0]))

                            <p>{{$a5->risk_level}}</p>
                                @break
                            @endif

                            @if($loop->last)
         <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>
                    @endif

                    @endforeach
                @else
    <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>

                @endif


                </td>

                <td>
                @if($a5_results->count()>0)
                    @foreach ($a5_results as $a5)

                        @if($a5->risk_level!=null && $a5->control_num===strval($sec2_4_a5_rows[$i][0]))
                        @if(in_array('Data Inputter',$permissions) )
                        <a href="">
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


                {{-- @if(in_array('Data Inputter',$permissions))
              <p>Edit</p>
                @endif --}}




                </tr>
    @endfor



    {{-- sec2_4_a6rows --}}

    @for ($i = 0; $i < count($sec2_4_a6_rows); $i++)
    <tr style="vertical-align: middle;text-align:initial">
                @foreach ($sec2_4_a6_rows[$i] as $col)
                @if(isset($col))
                   <td>
                      <p>{!! nl2br($col) !!}</p>
                    </td>

                @endif

                @endforeach
                {{-- <td>yes/no {{$data[$i][0]}}</td> --}}

            <td style="text-align: center">
                @if($a6_results->count()>0)
                @foreach ($a6_results as $a6)

                @if($a6->applicability!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))

                <p>{{$a6->applicability}} </p>
                    @break
                @endif

                @if($loop->last)

               <select name="applicability[]" class="form-select">
                <option value=""> Select--  </option>

                <option value='yes+{{$sec2_4_a6_rows[$i][0]}}'>Yes</option>

                <option value='no+{{$sec2_4_a6_rows[$i][0]}}'>No</option>
            </select>
                @endif

                @endforeach
                @else

               <select name="applicability[]" class="form-select">
                <option value=""> Select--  </option>

                <option value='yes+{{$sec2_4_a6_rows[$i][0]}}'>Yes</option>

                <option value='no+{{$sec2_4_a6_rows[$i][0]}}'>No</option>
            </select>
                @endif




            </td>

            <td style="text-align: center">
                @if($a6_results->count()>0)
                @foreach ($a6_results as $a6)

                    @if($a6->control_compliance!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))

                        <p>{{$a6->control_compliance}}%</p>
                            @break
                        @endif

                        @if($loop->last)
            <input type="number" name="control_compliance[]" oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}" >
                @endif

                @endforeach
            @else
        <input type="number" name="control_compliance[]" oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}" >

            @endif
            </td>


            <td>
                    @if($a6_results->count()>0)
                    @foreach ($a6_results as $a6)

                        @if($a6->vulnerability!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))

                            <p>{{$a6->vulnerability}}%</p>
                                @break
                            @endif

                            @if($loop->last)
        <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>
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

                        <p>{{$a6->threat}}%</p>
                            @break
                        @endif

                        @if($loop->last)
        <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}">
                @endif

                @endforeach
            @else
             <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}">

            @endif

            </td>

            <td>
                @if($a6_results->count()>0)
                @foreach ($a6_results as $a6)

                    @if($a6->risk_level!=null && $a6->control_num===strval($sec2_4_a6_rows[$i][0]))

                        <p>{{$a6->risk_level}} </p>
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




            </tr>
@endfor

 {{-- sec2_4_a7rows --}}

 @for ($i = 0; $i < count($sec2_4_a7_rows); $i++)
 <tr style="vertical-align: middle;text-align:initial">
             @foreach ($sec2_4_a7_rows[$i] as $col)
             @if(isset($col))
                <td>
                   <p>{!! nl2br($col) !!}</p>
                 </td>

             @endif

             @endforeach
             {{-- <td>yes/no {{$data[$i][0]}}</td> --}}

         <td style="text-align: center">
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->applicability!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))

                    <p>{{$a7->applicability}} </p>
                        @break
                    @endif

                    @if($loop->last)
                    <select name="applicability[]" class="form-select">
                        <option value=""> Select--  </option>

                        <option value='yes+{{$sec2_4_a7_rows[$i][0]}}'>Yes</option>

                        <option value='no+{{$sec2_4_a7_rows[$i][0]}}'>No</option>
                    </select>            @endif

            @endforeach
        @else
        <select name="applicability[]" class="form-select">
            <option value=""> Select--  </option>

            <option value='yes+{{$sec2_4_a7_rows[$i][0]}}'>Yes</option>

            <option value='no+{{$sec2_4_a7_rows[$i][0]}}'>No</option>
        </select>
        @endif




         </td>

         <td style="text-align: center">
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->control_compliance!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))

                    <p>{{$a7->control_compliance}}% </p>
                        @break
                    @endif

                    @if($loop->last)
        <input type="number" name="control_compliance[]" min=0 max=100 oninput="validateInput(this)" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" >


                    @endif

            @endforeach
        @else
 <input type="number" name="control_compliance[]" oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}" >

        @endif

         </td>

         <td>
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->vulnerability!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))

                    <p>{{$a7->vulnerability}}% </p>
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

                    <p>{{$a7->threat}}% </p>
                        @break
                    @endif

                    @if($loop->last)
         <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}">


                    @endif

            @endforeach
        @else
         <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}">

        @endif

         </td>

         <td>
            @if($a7_results->count()>0)
            @foreach ($a7_results as $a7)

                @if($a7->risk_level!=null && $a7->control_num===strval($sec2_4_a7_rows[$i][0]))

                    <p>{{$a7->risk_level}} </p>
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




         </tr>
@endfor

{{-- sec2_4_a8rows --}}

@for ($i = 0; $i < count($sec2_4_a8_rows); $i++)
<tr style="vertical-align: middle;text-align:initial">
            @foreach ($sec2_4_a8_rows[$i] as $col)
            @if(isset($col))
               <td>
                  <p>{!! nl2br($col) !!}</p>
                </td>

            @endif

            @endforeach
            {{-- <td>yes/no {{$data[$i][0]}}</td> --}}

        <td style="text-align: center">
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

                @if($a8->applicability!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))

                    <p>{{$a8->applicability}} </p>
                        @break
                    @endif

                    @if($loop->last)
                    <select name="applicability[]" class="form-select">
                        <option value=""> Select--  </option>

                        <option value='yes+{{$sec2_4_a8_rows[$i][0]}}'>Yes</option>

                        <option value='no+{{$sec2_4_a8_rows[$i][0]}}'>No</option>
                    </select>            @endif

            @endforeach
        @else
        <select name="applicability[]" class="form-select">
            <option value=""> Select--  </option>

            <option value='yes+{{$sec2_4_a8_rows[$i][0]}}'>Yes</option>

            <option value='no+{{$sec2_4_a8_rows[$i][0]}}'>No</option>
        </select>
        @endif


           {{-- <select name="applicability[]" class="form-select">
            <option value=""> Select--  </option>

            <option value='yes+{{$sec2_4_a8_rows[$i][0]}}'>Yes</option>

            <option value='no+{{$sec2_4_a8_rows[$i][0]}}'>No</option>
        </select> --}}


        </td>

        <td style="text-align: center">
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

                @if($a8->control_compliance!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))

                    <p>{{$a8->control_compliance}}%</p>
                        @break
                    @endif

                    @if($loop->last)
            <input type="number" name="control_compliance[]" oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}" >

                      @endif

            @endforeach
        @else
     <input type="number" name="control_compliance[]" oninput="validateInput(this)" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}" >

        @endif
        </td>

        <td>
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

                @if($a8->vulnerability!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))

                    <p>{{$a8->vulnerability}}%</p>
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

                    <p>{{$a8->threat}}%</p>
                        @break
                    @endif

                    @if($loop->last)
         <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}">

                      @endif

            @endforeach
        @else
             <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}">
        @endif


        </td>

        <td>
            @if($a8_results->count()>0)
            @foreach ($a8_results as $a8)

                @if($a8->risk_level!=null && $a8->control_num===strval($sec2_4_a8_rows[$i][0]))

                    <p>{{$a8->risk_level}}</p>
                        @break
                    @endif

                    @if($loop->last)
         <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>

                      @endif

            @endforeach
        @else
         <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>
            @endif

        </td>




        </tr>
@endfor






            </tbody>

            @if(in_array('Data Inputter',$permissions))
          <div class="float-end mb-4">
            <button type="submit" class="btn my_bg_color text-white btn-lg mt-5"  id="submitForm">Save and stay on same page</button>
          </div>
          @endif
          </table>

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



<script>
   $(document).ready(function(){
    var assetValue = null;
    var newVulnerabilityValue = null;
    var threat = null;
    var newRiskValue = null;
    var controlId = null;
    var riskLevelField = null;

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
});


</script>

<script>
    function validateInput(inputElement) {

      if (inputElement.value.indexOf(".") !== -1) {
        alert("Decimal values are not allowed.");
        inputElement.value = Math.floor(inputElement.value);
      }
    }
  </script>

@endsection



@endsection
