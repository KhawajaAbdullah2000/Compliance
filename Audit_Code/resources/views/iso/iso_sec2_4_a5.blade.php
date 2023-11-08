@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h3 class="text-center fw-bold mb-3">Project id: {{$project_id}} Project name: {{$project_name}} Section2.4 A:5 Organizational COntrols</h3>

<form action="" method="post">
@csrf
@method('PUT')

    <table class="table table-responsive table-primary table-striped">
        <thead class="thead-dark">
          <tr>
            <th >Control Number</th>
            <th>Title Of Control</th>
            <th>Description of Control</th>
            <th>Control is Applicable?</th>
            <th>Add/Edit Info</th>
          </tr>
        </thead>
        <tbody>

    @for ($i = 0; $i < count($data); $i++)
    <tr style="vertical-align: middle;text-align:initial">
                @foreach ($data[$i] as $col)
                @if(isset($col))
                   <td>
                      <p>{!! nl2br($col) !!}</p>
                    </td>

                @endif

                @endforeach
                <td>yes/no {{$data[$i][0]}}</td>
                <td><a href="/iso_sec2_4_a5_edit/{{$data[$i][0]}}"><i class="fas fa-edit fa-lg" style="color: #114a1d;"></i></a></td>
                {{-- <td><i class="fas fa-eye" style="color: blue;"></td> --}}
            </tr>
@endfor
          <tr>

          </tr>

        </tbody>
      </table>

    </form>



{{--
     @foreach ($data as $row )

            @foreach ($row as $col)
            @if(isset($col))
                <h2> {!! nl2br($col) !!}</h2>
            @endif
            @endforeach


    @endforeach

@endforeach --}}



</div>



@endsection
