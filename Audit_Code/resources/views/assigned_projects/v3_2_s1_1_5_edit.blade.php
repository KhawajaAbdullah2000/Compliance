@extends('master')

@section('content')

@include('user-nav')


<div class="container">

    <h2 class="text-center">
        Section 1.5 for Project id: {{$project_id}} Project name:{{$project_name}}
        </h2>
        <h2 class="text-center fw-bold">Edit Summary of Findings</h2>

        <form action="/v3_2_s1_1_5_edit_form/{{$summary->assessment_id}}/{{$summary->project_id}}/{{auth()->user()->id}}"
             method="post">
            @csrf
            @method('PUT')

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
                    <td><input type="radio" name="requirement1" value="compliant" {{$summary->requirement1== "compliant"?'checked':''}}></td>
                    <td><input type="radio"  name="requirement1" value="non compliant" {{$summary->requirement1== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"  name="requirement1" value="not applicable" {{$summary->requirement1== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" name="requirement1" value="not tested" {{$summary->requirement1== "not tested"?'checked':''}}></td>
                </tr>
                <tr>
                    <td>2. Do not use vendor-supplied defaults for system passwords and other security parameters</td>
                    <td><input type="radio"   name="requirement2" value="compliant" {{$summary->requirement2== "compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement2" value="non compliant" {{$summary->requirement2== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement2" value="not applicable" {{$summary->requirement2== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement2" value="not tested" {{$summary->requirement2== "not tested"?'checked':''}}></td>
                </tr>
                <tr>
                    <td>3. Protect stored cardholder data</td>
                    <td><input type="radio"   name="requirement3" value="compliant" {{$summary->requirement3== "compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement3" value="non compliant" {{$summary->requirement3== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement3" value="not applicable" {{$summary->requirement3== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement3" value="not tested" {{$summary->requirement3== "not tested"?'checked':''}}></td>
                </tr>
                <tr>
                    <td>4. Encrypt transmission of cardholder data across open, public networks</td>
                    <td><input type="radio"   name="requirement4" value="compliant" {{$summary->requirement4== "compliant"?'checked':''}}></td>
                    <td><input type="radio"    name="requirement4" value="non compliant" {{$summary->requirement4== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement4" value="not applicable" {{$summary->requirement4== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement4" value="not tested" {{$summary->requirement4== "not tested"?'checked':''}}></td>
                </tr>
                <tr>
                    <td>5. Protect all systems against malware and regularly update anti-virus software or programs</td>
                    <td><input type="radio"   name="requirement5" value="compliant" {{$summary->requirement5== "compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement5" value="non compliant" {{$summary->requirement5== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement5" value="not applicable" {{$summary->requirement5== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"    name="requirement5" value="not tested" {{$summary->requirement5== "not tested"?'checked':''}}></td>
                </tr>


                <tr>
                    <td>6. Develop and maintain secure systems and applications</td>
                    <td><input type="radio"    name="requirement6" value="compliant" {{$summary->requirement6== "compliant"?'checked':''}}></td>
                    <td><input type="radio"    name="requirement6" value="non compliant" {{$summary->requirement6== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement6" value="not applicable" {{$summary->requirement6== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement6" value="not tested" {{$summary->requirement6== "not tested"?'checked':''}}></td>
                </tr>



                <tr>
                    <td>7. Restrict access to cardholder data by business need to know</td>
                    <td><input type="radio"   name="requirement7" value="compliant" {{$summary->requirement7== "compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement7" value="non compliant" {{$summary->requirement7== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement7" value="not applicable" {{$summary->requirement7== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement7" value="not tested" {{$summary->requirement7== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>8. Identify and authenticate access to system components</td>
                    <td><input type="radio"   name="requirement8" value="compliant" {{$summary->requirement8== "compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement8" value="non compliant" {{$summary->requirement8== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement8" value="not applicable" {{$summary->requirement8== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement8" value="not tested" {{$summary->requirement8== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>9. Restrict physical access to cardholder data</td>
                    <td><input type="radio"    name="requirement9" value="compliant" {{$summary->requirement9== "compliant"?'checked':''}}></td>
                    <td><input type="radio"    name="requirement9" value="non compliant" {{$summary->requirement9== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"    name="requirement9" value="not applicable" {{$summary->requirement9== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement9" value="not tested" {{$summary->requirement9== "not tested"?'checked':''}} ></td>
                </tr>

                <tr>
                    <td>10. Track and monitor all access to network resources and cardholder data</td>
                    <td><input type="radio"   name="requirement10" value="compliant" {{$summary->requirement10== "compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement10" value="non compliant" {{$summary->requirement10== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement10" value="not applicable" {{$summary->requirement10== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement10" value="not tested" {{$summary->requirement10== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>11. Regularly test security systems and processes</td>
                    <td><input type="radio"   name="requirement11" value="compliant" {{$summary->requirement11== "compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement11" value="non compliant" {{$summary->requirement11== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement11" value="not applicable" {{$summary->requirement11== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement11" value="not tested" {{$summary->requirement11== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>12. Mainintain a policy that addresses information security for all personnel</td>
                    <td><input type="radio"   name="requirement12" value="compliant" {{$summary->requirement12== "compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement12" value="non compliant" {{$summary->requirement12== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement12" value="not applicable" {{$summary->requirement12== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="requirement12" value="not tested" {{$summary->requirement12== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>Appendix A1: Additional PCI DSS Requirements for Shared Hosting Providers</td>
                    <td><input type="radio"   name="appendix_A1" value="compliant" {{$summary->appendix_A1== "compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="appendix_A1" value="non compliant" {{$summary->appendix_A1== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="appendix_A1" value="not applicable" {{$summary->appendix_A1== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="appendix_A1" value="not tested" {{$summary->appendix_A1== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>Appendix A2: Additional PCI DSS Requirements for Entities Using SSL/Early TLS for Card-Present
                        POS POI Terminal Connections</td>
                    <td><input type="radio"  name="appendix_A2" value="compliant" {{$summary->appendix_A2== "compliant"?'checked':''}}></td>
                    <td><input type="radio"  name="appendix_A2" value="non compliant" {{$summary->appendix_A2== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"  name="appendix_A2" value="not applicable" {{$summary->appendix_A2== "not applicable"?'checked':''}}></td>
                    <td><input type="radio" name="appendix_A2" value="not tested" {{$summary->appendix_A2== "not tested"?'checked':''}}></td>
                </tr>

                <tr>
                    <td>Appendix A3: Designated Entities Supplemental Validation</td>
                    <td><input type="radio"   name="appendix_A3" value="compliant" {{$summary->appendix_A3== "compliant"?'checked':''}}></td>
                    <td><input type="radio"    name="appendix_A3" value="non compliant" {{$summary->appendix_A3== "non compliant"?'checked':''}}></td>
                    <td><input type="radio"   name="appendix_A3" value="not applicable" {{$summary->appendix_A3== "not applicable"?'checked':''}}></td>
                    <td><input type="radio"   name="appendix_A3" value="not tested" {{$summary->appendix_A3== "not tested"?'checked':''}}></td>
                </tr>

            </tbody>
        </table>
        <button type="submit" class="float-end btn btn-primary btn-lg mb-2">Edit</button>

    </form>






</div>

@endsection
