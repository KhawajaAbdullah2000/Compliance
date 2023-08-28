@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions)
@endphp


<div class="container">
    <h2 class="text-center">
        Section 3.5 for Project id: {{$project_id}} Project name:{{$project_name}}
        </h2>
        @if(in_array('Data Inputter',$permissions))

        @if($data->count()==0)


    <div class="row">

        <div class="col-md-12">

            <div class="card mt-2">
                <div class="card-header bg-primary text-center">
                    <h2>Connected entities for payment processing and transmission</h2>
                  </div>
                <div class="card-body">


            <form action="/v3_2_s3_3_5_insert/{{$project_id}}/{{auth()->user()->id}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="">Identify a Processing and Transmitting Entity </label>
                        <textarea name="requirement1" cols="70" rows="5" class="form-control">{{old('requirement1')}}</textarea>
                    @if($errors->has('requirement1'))
                    <div class="text-danger">{{ $errors->first('requirement1') }}</div>
                @endif
                  </div>



            <div class="form-group col-md-6 mt-2">
                <label for="type" class="form-label">Directly Conected?</label>
                <select class="boxstyling bg-primary form-select fw-bold" name="requirement2">
                    <option value="yes" {{ old('requirement2') == 'yes' ? 'selected' : '' }}>Yes</option>
                    <option value="no" {{ old('requirement2') == 'no' ? 'selected' : '' }}>No</option>
                </select>
                @if($errors->has('requirement2'))
                <div class="text-danger">{{ $errors->first('requirement2') }}</div>
            @endif

            </div>

            <div class="form-group col-md-6 mt-4">
                <label for="type" class="form-label fw-bold">Reason(s) for Connection:</label>
                <label for="processing">Procesing</label>
                <input type="checkbox" id="processing" name="requirement3[]" value="processing"
                @if(is_array(old('requirement3')) && in_array('processing', old('requirement3'))) checked @endif>

                <label for="processing">Transmission</label>
                <input type="checkbox" id="transmission" name="requirement3[]" value="transmission"
                @if(is_array(old('requirement3')) && in_array('transmission', old('requirement3'))) checked @endif>

                @if($errors->has('requirement3'))
                <div class="text-danger">{{ $errors->first('requirement3') }}</div>
            @endif

            </div>

            <div class="form-group mt-3">
                <label for="">Description of any discussions/issues between the
                    QSA and Processing Entity on behalf of the
                    Assessed Entity for this PCI DSS Assessment(if any)
                    </label>
                    <textarea name="requirement4" cols="70" rows="10" class="form-control">{{old('requirement4')}}</textarea>
                @if($errors->has('requirement4'))
                <div class="text-danger">{{ $errors->first('requirement4') }}</div>
            @endif
              </div>


                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-md mt-2">Submit Details</button>
                  </div>


            </form>

        </div>
    </div>


        </div>
    </div>


        @endif
        {{-- if data->count()==0 --}}



        @endif
        {{-- if data inputter --}}

        @if ($data->count()>0)

        <h2 class="text-center fw-bold">Connected entities for payment processing and transmission</h2>

        @if(in_array('Data Inputter',$permissions))
        <a class="btn btn-success btn-md float-end mb-5" href="/v3_2_s3_3_5_new/{{$project_id}}/{{auth()->user()->id}}"
        role="button">Add new entity <i class="fas fa-plus"></i></a>
        @endif

        @foreach ($data as $d)

        <p class="lead mt-4">Processing and Transmitting Entity</p>
        <p><span class="fw-bold">Answer: </span>{{$d->requirement1}}</p>

        <p class="lead mt-4">Directly Connected?</p>
        <p><span class="fw-bold">Answer: </span>{{$d->requirement2}}</p>




        <p class="lead mt-4">Reason(s) for connection</p>
        <p><span class="fw-bold">Answer: </span>
            @php
                $connections=json_decode($d->requirement3)
            @endphp

          @foreach ($connections as $conn)
          {{$conn}}
          @unless ($loop->last), @endunless

          @endforeach

          <p class="lead mt-4">Description of any discussions/issues between the
            QSA and Processing Entity on behalf of the
            Assessed Entity for this PCI DSS Assessment(if any)</p>
          <p><span class="fw-bold">Answer: </span>{{$d->requirement4}}</p>

          <span class="badge rounded-pill bg-primary fs-6">Last edited by: {{$d->first_name}} {{$d->last_name}}</span>
          <span class="badge rounded-pill bg-success fs-6">Last edited at: {{date('F d, Y H:i:A', strtotime($d->last_edited_at))}}</span>

          @if(in_array('Data Inputter',$permissions))

          <a href="/v3_2_s3_3_5_delete/{{$d->assessment_id}}/{{$d->project_id}}/{{auth()->user()->id}}" class="btn btn-danger btn-md float-end mx-2"> Delete </a>

          <a href="/v3_2_s3_3_5_edit/{{$d->assessment_id}}/{{$d->project_id}}/{{auth()->user()->id}}" class="btn btn-primary btn-md float-end mx-2"> Edit </a>
          @endif

        @endforeach
        {{-- for each data --}}


        @endif
        {{-- if data->count>0 --}}


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



 @endsection


@endsection
