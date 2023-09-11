@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="card-header bg-primary text-center">
        <h2>Assessor Info</h2>
    </div>

    <div class="card-body">
        <form method="post" action="/v3_2_s4_4_8_asses_editform/{{$data2->assessment_id}}/{{$data2->project_id}}/{{auth()->user()->id}}">
            @csrf
            @method('PUT')
            <div class="form-group mt-2">
              <label for="requirement1">Provide the name of the assessor who attests that all PA-DSS
                validated payment applications were reviewed to verify they have been implemented in a PCI DSS compliant
                manner according to the payment application vendor's PA-DSS Implementation Guide</label>
              <input type="text" class="form-control" id="requirement1" name='requirement1' value="{{old('requirement1',$data2->requirement1)}}">
              @if($errors->has('requirement1'))
              <div class="text-danger">{{ $errors->first('requirement1') }}</div>
          @endif
            </div>

            <div class="form-group mt-2">
                <label for="requirement2">Provide the name of the assessor who attests that all PCI
                    SSC-validated P2PE applications and solutions were reviewed to verify they have been
                    implemented in a PCI DSS compliant manner according to the P2PE application
                    vendor's P2PE Application Implementation Guide and the P2PE solution vendor's
                    P2PE Instruction Manual (PIM).</label>
                <input type="text" class="form-control" id="requirement2" name='requirement2' value="{{old('requirement2',$data2->requirement2)}}">
                @if($errors->has('requirement2'))
                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement3">For any of the above Third-Party Payment Applications and/or
                     solutions that are not listed on the PCI SSC website,
                    identify any being considered for scope reduction/exclusion/etc. </label>
                <input type="text" class="form-control" id="requirement3" name='requirement3' value="{{old('requirement3',$data2->requirement3)}}">
                @if($errors->has('requirement3'))
                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
            @endif
              </div>

              <div class="form-group mt-2">
                <label for="requirement4">Any additional comments or findings the assessor would like to include,
                    as applicable:</label>
                <input type="text" class="form-control" id="requirement4" name='requirement4' value="{{old('requirement4',$data2->requirement4)}}">
                @if($errors->has('requirement4'))
                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
            @endif
              </div>




              <div class="text-center mt-2">
                <button type="submit" class="btn btn-primary btn-md">Submit details</a>
              </div>


        </form>

    </div>
</div>


@endsection
