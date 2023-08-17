@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-6">

<div class="card">
    <div class="card-body">
        <h4 class="card-title text-center">Add new Assessor for project id: {{$project_id}}</h4>
        <form method="post" action="/v_3_2_s1_assessors/{{$project_id}}/{{auth()->user()->id}}">
            @csrf
            <div class="form-group">
                <label for="name">Assessor name:</label>
                <input type="text" class="form-control" id="" name='assessor_name' value="{{old('assessor_name')}}">
                @if($errors->has('assessor_name'))
                <div class="text-danger">{{ $errors->first('assessor_name') }}</div>
            @endif
              </div>

              <div class="form-group">
                  <label for="name">Assessor PCI Credentials:</label>
                  <input type="text" class="form-control" id="" name='assessor_pci_cred' value="{{old('assessor_pci_cred')}}">
                  @if($errors->has('assessor_pci_cred'))
                  <div class="text-danger">{{ $errors->first('assessor_pci_cred') }}</div>
              @endif
                </div>

                <div class="form-group">
                  <label for="name">Assessor Phone number</label>
                  <input type="text" class="form-control" id="" name='assessor_phone' value="{{old('assessor_phone')}}">
                  @if($errors->has('assessor_phone'))
                  <div class="text-danger">{{ $errors->first('assessor_phone') }}</div>
              @endif
                </div>


                <div class="form-group">
                    <label for="name">Assessor Email</label>
                    <input type="text" class="form-control" id="" name='assessor_email' value="{{old('assessor_email')}}">
                    @if($errors->has('assessor_email'))
                    <div class="text-danger">{{ $errors->first('assessor_email') }}</div>
                @endif
                  </div>


                <div class="text-center mt-2">
                  <button type="submit" class="btn btn-primary btn-md">Add Assessor</a>
                </div>



        </form>

    </div>
</div>

        </div>
    </div>

</div>





@endsection
