@extends('master')

@section('content')

@include('user-nav')
@include('iso_sec_nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">


    <h3 class="text-center fw-bold mb-3">Project id: {{$project_id}} Project name: {{$project_name}} Section2.3.1 Information Security Risk Assessment And Treatment</h3>


    @if($assets->count()>0)

    <form action="/iso_sec2_3_1_initial_add/{{$project_id}}/{{auth()->user()->id}}" method="post">
@csrf

<input type="hidden" name="asset_id" value="{{$asset_id}}">


<div class="row">

<div class="col-lg-6 fw-bold">


<label for="">Select Object of Risk Assesment</label>
<select name="asset" id="" class="form-control">
    <option value="">Select--</option>

    <option value="group+{{$group}}">{{$group}}</option>
    <option value="name+{{$name}}">{{$name}}</option>


    @foreach ($components as $c)
    <option value="component+{{$c->assessment_id}}">{{$c->c_name}}</option>
    @endforeach

</select>

</div>

<div class="col-lg-6">



<div class="fw-bold">
    <label for="">Select Asset value</label>
    <select name="asset_value" class="form-control">Asset value

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


@else
<h2>Please add Assets first in section 2.1</h2>
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

@endsection



@endsection
