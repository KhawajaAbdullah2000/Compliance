@extends('master')

@section('content')

@include('user-nav')
@include('iso_sec_nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">



    <h3 class="text-center fw-bold mb-3">Project name: {{$project_name}} </h3>

    <h2 class="text-center">      Section2.3.1 Information Security Risk Assessment And Treatment</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<p class="text-center fw-bold">
    Risk Assessment for <br>

    Assetid: {{$assetData->assessment_id}}

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

<form action="/iso_sec2_3_1_initial_add/{{$assetData->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" method="post" class="mx-4">
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


                   <select name="applicability[]" class="form-select">
                    <option value=""> Select--  </option>

                    <option value='yes+{{$sec2_4_a5_rows[$i][0]}}'>Yes</option>

                    <option value='no+{{$sec2_4_a5_rows[$i][0]}}'>No</option>
                </select>


                </td>

                <td style="text-align: center">
                    <input type="number" name="control_compliance[]" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}" >
                </td>

                <td>
                    <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>

                </td>

                <td>
                    <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a5_rows[$i][0]}}">

                </td>

                <td>
                    <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a5_rows[$i][0]}}" readonly>

                </td>




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


               <select name="applicability[]" class="form-select">
                <option value=""> Select--  </option>

                <option value='yes+{{$sec2_4_a6_rows[$i][0]}}'>Yes</option>

                <option value='no+{{$sec2_4_a6_rows[$i][0]}}'>No</option>
            </select>


            </td>

            <td style="text-align: center">
                <input type="number" name="control_compliance[]" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}" >
            </td>

            <td>
                <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>

            </td>

            <td>
                <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a6_rows[$i][0]}}">

            </td>

            <td>
                <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a6_rows[$i][0]}}" readonly>

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


            <select name="applicability[]" class="form-select">
             <option value=""> Select--  </option>

             <option value='yes+{{$sec2_4_a7_rows[$i][0]}}'>Yes</option>

             <option value='no+{{$sec2_4_a7_rows[$i][0]}}'>No</option>
         </select>


         </td>

         <td style="text-align: center">
             <input type="number" name="control_compliance[]" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}" >
         </td>

         <td>
             <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>

         </td>

         <td>
             <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a7_rows[$i][0]}}">

         </td>

         <td>
             <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a7_rows[$i][0]}}" readonly>

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


           <select name="applicability[]" class="form-select">
            <option value=""> Select--  </option>

            <option value='yes+{{$sec2_4_a8_rows[$i][0]}}'>Yes</option>

            <option value='no+{{$sec2_4_a8_rows[$i][0]}}'>No</option>
        </select>


        </td>

        <td style="text-align: center">
            <input type="number" name="control_compliance[]" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}" >
        </td>

        <td>
            <input type="number" name="vulnerability[]"  class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>

        </td>

        <td>
            <input type="number" name="threat[]" class="form-control" min=0 max=100 data-control-id="{{$sec2_4_a8_rows[$i][0]}}">

        </td>

        <td>
            <input type="number" name="risk_level[]" class="form-control" data-control-id="{{$sec2_4_a8_rows[$i][0]}}" readonly>

        </td>




        </tr>
@endfor






            </tbody>

            @if(in_array('Data Inputter',$permissions))
          <div class="float-end mb-4">
            <button type="submit" class="btn btn-primary btn-lg mt-5"  id="submitForm">Save and stay on same page</button>
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
        var assetValue;
        var newVulnerabilityValue;

        $('#assetSelect').change(function(){
                // Get the selected value
                assetValue = $(this).val();

            });

        $("input[name^='control_compliance']").on("input", function () {
        var controlId = $(this).data('control-id');
        var vulnerabilityField = $("input[name='vulnerability[]'][data-control-id='" + controlId + "']");

        // Calculate the new value for vulnerability
         newVulnerabilityValue = 100 - parseFloat($(this).val());

        // Update the value of the vulnerability input box
        vulnerabilityField.val(newVulnerabilityValue);
    });

    $("input[name^='threat']").on("input", function () {
        var threat = $(this).val();
        var controlId = $(this).data('control-id');
        var vulnerabilityField = $("input[name='vulnerability[]'][data-control-id='" + controlId + "']");
        var riskLevelField = $("input[name='risk_level[]'][data-control-id='" + controlId + "']");


        var newRiskValue = parseFloat(newVulnerabilityValue) / 100 * parseFloat(threat) / 100 * parseFloat(assetValue);

        // Update the values of the vulnerability and risk level input boxes
       // vulnerabilityField.val(newVulnerabilityValue);
        riskLevelField.val(newRiskValue);
    });




    });

</script>

@endsection



@endsection
