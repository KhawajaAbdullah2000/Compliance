@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">Project id: {{$project_id}} Project name: {{$project_name}} Section4 Subsections</h1>

    <div class="row text-center justify-content-center section3_subsections">
{{-- section4.1 --}}
        <div class="row mt-2 mb-2">
        <div class="col-12">
         <a href="/v3_2_s4_4_1/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">
            Section 4- 4.1: Detailed network diagram(s)</p></a>
        </div>
        </div>

        {{-- Section4.2 --}}
        <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_2/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.2: Description of cardholder data flows</p></a>

            </div>
        </div>

         {{-- Section4.3 --}}
         <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_3/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.3: Cardholder Data Storage</p></a>

            </div>
        </div>


         {{-- Section3.4 --}}
         <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s3_3_4/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section3- 3.4: Network segment details</p></a>

            </div>
        </div>

          {{-- Section3.5 --}}
          <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s3_3_5/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section3- 3.5: Connected entities for payment processing
                    and transmission</p></a>

            </div>
        </div>

           {{-- Section3.6 --}}
           <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s3_3_6/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section3- 3.6: Other business entities that require compliance with the
                    PCI DSS</p></a>

            </div>
        </div>


           {{-- Section3.7 --}}
           <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s3_3_7/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section3- 3.7: Wireless summary</p></a>

            </div>
        </div>

        {{-- Section3.8 --}}
        <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s3_3_8/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section3- 3.8: Wireless details</p></a>

            </div>
        </div>


    </div>


</div>



@endsection
