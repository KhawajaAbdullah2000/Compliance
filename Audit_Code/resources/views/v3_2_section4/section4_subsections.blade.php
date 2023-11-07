@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h1 class="text-center">Project id: {{$project_id}} Project name: {{$project_name}} Section4 Subsections</h1>

    <div class="row text-center justify-content-center section4_subsections">
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


         {{-- Section4.4 --}}
         <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s3_4_4/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.4: Critical hardware and software in use in the cardholder data environment</p></a>

            </div>
        </div>

          {{-- Section4.5 --}}
          <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_5/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section- 4.5: Sampling</p></a>

            </div>
        </div>

           {{-- Section4.6 --}}
           <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_6/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.6: Sample sets for reporting</p></a>

            </div>
        </div>


           {{-- Section4.7 --}}
           <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_7/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.7: Service
                    providers and other third parties with which the entity shares
                    cardholder data or that could affect the security of cardholder data </p></a>

            </div>
        </div>

        {{-- Section4.8 --}}
        <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_8/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.8: Third-party payment applications/solutions </p></a>

            </div>
        </div>

        {{-- section4.9 --}}
        <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_9/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.9: Documentation Reviewed</p></a>

            </div>
        </div>

        {{-- section4.10 --}}
        <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_10/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.10: Individuals interviewed</p></a>

            </div>
        </div>

         {{-- section4.11 --}}
         <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_11/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.11: Managed service providers</p></a>

            </div>
        </div>

        {{-- section4.12 --}}
        <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_12/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.12: Disclosure summary for "In Place with Compensating Control" responses</p></a>

            </div>
        </div>

     {{-- section4.13 --}}
        <div class="row mb-2">
            <div class="col-12">
                <a href="/v3_2_s4_4_13/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-warning"><p class="fw-bold">Section4- 4.13: Disclosure summary for "Not Tested" responses</p></a>

            </div>
        </div>




    </div>


</div>



@endsection
