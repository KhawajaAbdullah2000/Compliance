@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp

<div class="container">
    <h2 class="text-center">
        Section 1.5 for Project id: {{$project_id}} Project name:{{$project_name}}
        </h2>

        @if(in_array('Data Inputter',$permissions))

        @if(!isset($summary))

        @if ($errors->any())
        <div class="alert alert-danger">
     <p>Please check one value for each requirement</p>
        </div>
    @endif
    {{-- for errors --}}

        <form action="/v3_2_s1_1_5_summary/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            <h2 class="text-center fw-bold">Summary of Findings</h2>
            <table class="table table-bordered">
                <thead style="vertical-align: middle;">
                    <tr>
                        <th width="">Requirements</th>
                        <th>Compliant</th>
                        <th>Non-Compliant</th>
                        <th>Not Applicable</th>
                        <th>Not Tested</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1. Install and maintain a firewall configuration to protect cardholder data</td>
                        <td><input type="radio" name="requirement1" value="compliant"></td>
                        <td><input type="radio" name="requirement1" value="non compliant"></td>
                        <td><input type="radio" name="requirement1" value="not applicable"></td>
                        <td><input type="radio" name="requirement1" value="not tested"></td>
                    </tr>
                    <tr>
                        <td>2. Do not use vendor-supplied defaults for system passwords and other security parameters</td>
                        <td><input type="radio" name="requirement2" value="compliant"></td>
                        <td><input type="radio" name="requirement2" value="non compliant"></td>
                        <td><input type="radio" name="requirement2" value="not applicable"></td>
                        <td><input type="radio" name="requirement2" value="not tested"></td>
                    </tr>
                    <tr>
                        <td>3. Protect stored cardholder data</td>
                        <td><input type="radio" name="requirement3" value="compliant"></td>
                        <td><input type="radio" name="requirement3" value="non compliant"></td>
                        <td><input type="radio" name="requirement3" value="not applicable"></td>
                        <td><input type="radio" name="requirement3" value="not tested"></td>
                    </tr>
                    <tr>
                        <td>4. Encrypt transmission of cardholder data across open, public networks</td>
                        <td><input type="radio" name="requirement4" value="compliant"></td>
                        <td><input type="radio" name="requirement4" value="non compliant"></td>
                        <td><input type="radio" name="requirement4" value="not applicable"></td>
                        <td><input type="radio" name="requirement4" value="not tested"></td>
                    </tr>
                    <tr>
                        <td>5. Protect all systems against malware and regularly update anti-virus software or programs</td>
                        <td><input type="radio" name="requirement5" value="compliant"></td>
                        <td><input type="radio" name="requirement5" value="non compliant"></td>
                        <td><input type="radio" name="requirement5" value="not applicable"></td>
                        <td><input type="radio" name="requirement5" value="not tested"></td>
                    </tr>


                    <tr>
                        <td>6. Develop and maintain secure systems and applications</td>
                        <td><input type="radio" name="requirement6" value="compliant"></td>
                        <td><input type="radio" name="requirement6" value="non compliant"></td>
                        <td><input type="radio" name="requirement6" value="not applicable"></td>
                        <td><input type="radio" name="requirement6" value="not tested"></td>
                    </tr>



                    <tr>
                        <td>7. Restrict access to cardholder data by business need to know</td>
                        <td><input type="radio" name="requirement7" value="compliant"></td>
                        <td><input type="radio" name="requirement7" value="non compliant"></td>
                        <td><input type="radio" name="requirement7" value="not applicable"></td>
                        <td><input type="radio" name="requirement7" value="not tested"></td>
                    </tr>

                    <tr>
                        <td>8. Identify and authenticate access to system components</td>
                        <td><input type="radio" name="requirement8" value="compliant"></td>
                        <td><input type="radio" name="requirement8" value="non compliant"></td>
                        <td><input type="radio" name="requirement8" value="not applicable"></td>
                        <td><input type="radio" name="requirement8" value="not tested"></td>
                    </tr>

                    <tr>
                        <td>9. Restrict physical access to cardholder data</td>
                        <td><input type="radio" name="requirement9" value="compliant"></td>
                        <td><input type="radio" name="requirement9" value="non compliant"></td>
                        <td><input type="radio" name="requirement9" value="not applicable"></td>
                        <td><input type="radio" name="requirement9" value="not tested"></td>
                    </tr>

                    <tr>
                        <td>10. Track and monitor all access to network resources and cardholder data</td>
                        <td><input type="radio" name="requirement10" value="compliant"></td>
                        <td><input type="radio" name="requirement10" value="non compliant"></td>
                        <td><input type="radio" name="requirement10" value="not applicable"></td>
                        <td><input type="radio" name="requirement10" value="not tested"></td>
                    </tr>

                    <tr>
                        <td>11. Regularly test security systems and processes</td>
                        <td><input type="radio" name="requirement11" value="compliant"></td>
                        <td><input type="radio" name="requirement11" value="non compliant"></td>
                        <td><input type="radio" name="requirement11" value="not applicable"></td>
                        <td><input type="radio" name="requirement11" value="not tested"></td>
                    </tr>

                    <tr>
                        <td>12. Mainintain a policy that addresses information security for all personnel</td>
                        <td><input type="radio" name="requirement12" value="compliant"></td>
                        <td><input type="radio" name="requirement12" value="non compliant"></td>
                        <td><input type="radio" name="requirement12" value="not applicable"></td>
                        <td><input type="radio" name="requirement12" value="not tested"></td>
                    </tr>

                    <tr>
                        <td>Appendix A1: Additional PCI DSS Requirements for Shared Hosting Providers</td>
                        <td><input type="radio" name="appendix_A1" value="compliant"></td>
                        <td><input type="radio" name="appendix_A1" value="non compliant"></td>
                        <td><input type="radio" name="appendix_A1" value="not applicable"></td>
                        <td><input type="radio" name="appendix_A1" value="not tested"></td>
                    </tr>

                    <tr>
                        <td>Appendix A2: Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present
                            POS POI Terminal Connections</td>
                        <td><input type="radio" name="appendix_A2" value="compliant"></td>
                        <td><input type="radio" name="appendix_A2" value="non compliant"></td>
                        <td><input type="radio" name="appendix_A2" value="not applicable"></td>
                        <td><input type="radio" name="appendix_A2" value="not tested"></td>
                    </tr>

                    <tr>
                        <td>Appendix A3: Designated Entities Supplemental Validation</td>
                        <td><input type="radio" name="appendix_A3" value="compliant"></td>
                        <td><input type="radio" name="appendix_A3" value="non compliant"></td>
                        <td><input type="radio" name="appendix_A3" value="not applicable"></td>
                        <td><input type="radio" name="appendix_A3" value="not tested"></td>
                    </tr>

                </tbody>
            </table>
            <button type="submit" class="float-end btn btn-primary btn-lg mb-2"> Submit details</button>
        </form>



        @endif
        {{-- if !isset $summary --}}



        @endif
        {{-- if datainputter --}}


        @if (isset($summary))

        <h2 class="text-center fw-bold">Summary of Findings</h2>

        <table class="table table-bordered">
            <thead style="vertical-align: middle;">
                <tr>
                    <th width="">Requirements</th>
                    <th>Compliant</th>
                    <th>Non-Compliant</th>
                    <th>Not Applicable</th>
                    <th>Not Tested</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1. Install and maintain a firewall configuration to protect cardholder data</td>
                    <td><input type="radio" disabled name="requirement1" value="compliant" {{$summary->requirement1== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement1" value="non compliant" {{$summary->requirement1== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement1" value="not applicable" {{$summary->requirement1== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement1" value="not tested" {{$summary->requirement1== "not tested"?'checked':''}}></td>
                </tr>
                <tr>
                    <td>2. Do not use vendor-supplied defaults for system passwords and other security parameters</td>
                    <td><input type="radio" disabled name="requirement2" value="compliant" {{$summary->requirement2== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement2" value="non compliant" {{$summary->requirement2== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement2" value="not applicable" {{$summary->requirement2== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement2" value="not tested" {{$summary->requirement2== "not tested"?'checked':''}}></td>
                </tr>
                <tr>
                    <td>3. Protect stored cardholder data</td>
                    <td><input type="radio" disabled name="requirement3" value="compliant" {{$summary->requirement3== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement3" value="non compliant" {{$summary->requirement3== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement3" value="not applicable" {{$summary->requirement3== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement3" value="not tested" {{$summary->requirement3== "not tested"?'checked':''}}></td>
                </tr>
                <tr>
                    <td>4. Encrypt transmission of cardholder data across open, public networks</td>
                    <td><input type="radio" disabled name="requirement4" value="compliant" {{$summary->requirement4== "compliant"?'checked':''}}></td>
                    <td><input type="radio"  disabled name="requirement4" value="non compliant" {{$summary->requirement4== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement4" value="not applicable" {{$summary->requirement4== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement4" value="not tested" {{$summary->requirement4== "not tested"?'checked':''}}></td>
                </tr>
                <tr>
                    <td>5. Protect all systems against malware and regularly update anti-virus software or programs</td>
                    <td><input type="radio" disabled name="requirement5" value="compliant" {{$summary->requirement5== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement5" value="non compliant" {{$summary->requirement5== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement5" value="not applicable" {{$summary->requirement5== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled  name="requirement5" value="not tested" {{$summary->requirement5== "not tested"?'checked':''}}></td>
                </tr>


                <tr>
                    <td>6. Develop and maintain secure systems and applications</td>
                    <td><input type="radio"  disabled name="requirement6" value="compliant" {{$summary->requirement6== "compliant"?'checked':''}}></td>
                    <td><input type="radio"  disabled name="requirement6" value="non compliant" {{$summary->requirement6== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement6" value="not applicable" {{$summary->requirement6== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement6" value="not tested" {{$summary->requirement6== "not tested"?'checked':''}}></td>
                </tr>



                <tr>
                    <td>7. Restrict access to cardholder data by business need to know</td>
                    <td><input type="radio" disabled name="requirement7" value="compliant" {{$summary->requirement7== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement7" value="non compliant" {{$summary->requirement7== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement7" value="not applicable" {{$summary->requirement7== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement7" value="not tested" {{$summary->requirement7== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>8. Identify and authenticate access to system components</td>
                    <td><input type="radio" disabled name="requirement8" value="compliant" {{$summary->requirement8== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement8" value="non compliant" {{$summary->requirement8== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement8" value="not applicable" {{$summary->requirement8== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement8" value="not tested" {{$summary->requirement8== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>9. Restrict physical access to cardholder data</td>
                    <td><input type="radio" disabled  name="requirement9" value="compliant" {{$summary->requirement9== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled  name="requirement9" value="non compliant" {{$summary->requirement9== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled  name="requirement9" value="not applicable" {{$summary->requirement9== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement9" value="not tested" {{$summary->requirement9== "not tested"?'checked':''}} ></td>
                </tr>

                <tr>
                    <td>10. Track and monitor all access to network resources and cardholder data</td>
                    <td><input type="radio" disabled name="requirement10" value="compliant" {{$summary->requirement10== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement10" value="non compliant" {{$summary->requirement10== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement10" value="not applicable" {{$summary->requirement10== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement10" value="not tested" {{$summary->requirement10== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>11. Regularly test security systems and processes</td>
                    <td><input type="radio" disabled name="requirement11" value="compliant" {{$summary->requirement11== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement11" value="non compliant" {{$summary->requirement11== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement11" value="not applicable" {{$summary->requirement11== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement11" value="not tested" {{$summary->requirement11== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>12. Mainintain a policy that addresses information security for all personnel</td>
                    <td><input type="radio" disabled name="requirement12" value="compliant" {{$summary->requirement12== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement12" value="non compliant" {{$summary->requirement12== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement12" value="not applicable" {{$summary->requirement12== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="requirement12" value="not tested" {{$summary->requirement12== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>Appendix A1: Additional PCI DSS Requirements for Shared Hosting Providers</td>
                    <td><input type="radio" disabled name="appendix_A1" value="compliant" {{$summary->appendix_A1== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="appendix_A1" value="non compliant" {{$summary->appendix_A1== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="appendix_A1" value="not applicable" {{$summary->appendix_A1== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="appendix_A1" value="not tested" {{$summary->appendix_A1== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>Appendix A2: Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present
                        POS POI Terminal Connections</td>
                    <td><input type="radio" disabled name="appendix_A2" value="compliant" {{$summary->appendix_A2== "compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="appendix_A2" value="non compliant" {{$summary->appendix_A2== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="appendix_A2" value="not applicable" {{$summary->appendix_A2== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="appendix_A2" value="not tested" {{$summary->appendix_A2== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>Appendix A3: Designated Entities Supplemental Validation</td>
                    <td><input type="radio" disabled name="appendix_A3" value="compliant" {{$summary->appendix_A3== "compliant"?'checked':''}}></td>
                    <td><input type="radio"  disabled name="appendix_A3" value="non compliant" {{$summary->appendix_A3== "non compliant"?'checked':''}}></td>
                    <td><input type="radio" disabled name="appendix_A3" value="not applicable" {{$summary->appendix_A3== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" disabled name="appendix_A3" value="not tested" {{$summary->appendix_A3== "not tested"?'checked':''}}></td>
                </tr>

            </tbody>
        </table>

        <div class="row">
            <div class="col-md-6">
            <p class="lead">Last edited by: {{$summary->first_name}}  {{$summary->last_name}}</p>
            <p class="lead">Last edited at: {{date('F d, Y H:i:A', strtotime($summary->last_edited_at))}}</p>
            </div>
            <div class="col-md-6">
                @if(in_array('Data Inputter',$permissions))
                <a href="" class="float-end btn btn-primary btn-lg mb-2 px-8">Edit</a>
                      @endif
            </div>
        </div>





        @endif
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

{{-- <script>

let table = new DataTable('#myTable',
    {
    language: {
       searchPlaceholder: "search"
    },
      "ordering": false

     }
     );

</script> --}}

 @endsection





@endsection
