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
            @include('components.topTable')
        </div>
    </div>



    <h4 class="text-center fw-bold mb-3 mt-4">Undertake information security risk treatment</h4>

    {{--
@if(in_array('Data Inputter',$permissions))
<a class="btn btn-success btn-md float-end mb-2" href="/iso_sec_2_1_new/{{$project_id}}/{{auth()->user()->id}}"
    role="button">Add new Asset manually <i class="fas fa-plus"></i></a>
    @endif --}}

    <table id="myTable2" class="table table-responsive table-striped mt-4">
        <thead class="table-dark table-pointer">
            <tr style="vertical-align: middle">
                <th onclick="sortTable(0)">Service</th>
                <th onclick="sortTable(1)">Asset Type</th>
                <th onclick="sortTable(2)">Asset Subtype</th>
                <th onclick="sortTable(3)">Asset Component Name</th>
                <th>Confidentiality Classification</th>
                <th>Integrity CLassfication</th>
                <th>Availability Classification</th>
                <th onclick="sortTable(4)">Asset Component Owner Dept</th>
                <th onclick="sortTable(5)">Asset Component Physical Location</th>
                <th onclick="sortTable(6)">Asset Component Logical Location</th>

                {{-- <th>Risk Assessment</th> --}}
                <th>Treat Risk</th>


            </tr>
        </thead>
        <tbody>
            @if($data->count()==0)

            <tr>
                <td colspan="11" class="text-center">
                    <h4>Please enter at least one service and/or asset
                        before a risk assessment can be initiated</h4>
                </td>
            </tr>

            @endif
            @foreach ($data as $d)
            <tr>
                <td class="fw-bold">{{$d->s_name}}</td>
                <td class="fw-bold">{{$d->g_name}}</td>
                <td>{{$d->name}} </td>
                <td>{{$d->c_name}}</td>
                <td>{{$d->risk_confidentiality}}</td>
                <td>{{$d->risk_integrity}}</td>
                <td>{{$d->risk_availability}}</td>
                <td>{{$d->owner_dept}} </td>
                <td>{{$d->physical_loc}} </td>
                <td>{{$d->logical_loc}} </td>


                <td>
                    <a href="/asset_based_risk_treatment/{{$d->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm text-white fw-bold bg-success">Enter</a>

                </td>










            </tr>
            @endforeach


        </tbody>

    </table>



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

@if(Session::has('error'))
<script>
    swal({
        title: "{{Session::get('error')}}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>
@endif

<script>
    document.getElementById('fileLabel').addEventListener('click', function() {
        document.getElementById('file').click();
    });

    function displayFileName(input) {
        var fileNameElement = document.getElementById('fileName');
        fileNameElement.innerHTML = input.files[0].name;
    }

</script>



@endsection



@endsection
