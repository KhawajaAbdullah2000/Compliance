@extends('master')

@section('content')

@include('user-nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">

    <h3 class="text-center fw-bold mb-3">Project id: {{$project_id}} Project name: {{$project_name}} Section2.4 A:7 Physical Controls</h3>
    @if($errors->has('applicability'))
    <div class="text-danger">{{ $errors->first('applicability') }}</div>
@endif
<form action="/iso_sec2_4_a7_new/{{$project_id}}/{{auth()->user()->id}}" method="post">
@csrf


    <table class="table table-responsive table-primary table-striped">
        <thead class="thead-dark">
          <tr>
            <th>Control Number</th>
            <th>Title Of Control</th>
            <th>Description of Control</th>
            <th>Control is Applicable?</th>
            <th>Add/Edit Info</th>
            <th>Last Edited by</th>
            <th>Last Edited at</th>
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
                {{-- <td>yes/no {{$data[$i][0]}}</td> --}}

            <td style="text-align: center">

         @if($results->count()>0)

                @foreach ($results as $r)
                @if($r->control_num===strval($data[$i][0]))
                    <p class="fw-bold">{{$r->applicability}} <span><a
                    href="/edit_app_iso_sec2_4_a7/{{$data[$i][0]}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-warning btn-sm">
                        Edit
                    </a></span></p>

                @break
                @endif

               @if($loop->remaining==0)
               <select name="applicability[]" class="form-select">
                <option value=""> Select--  </option>

                <option value='yes+{{$data[$i][0]}}'>Yes</option>


                <option value='no+{{$data[$i][0]}}'>No</option>
            </select>
               @endif

                @endforeach

                @else

                <select name="applicability[]" class="form-select">
                    <option value=""> Select--  </option>

                    <option value='yes+{{$data[$i][0]}}'>Yes</option>


                    <option value='no+{{$data[$i][0]}}'>No</option>
                </select>
                @endif
            </td>



                @if(in_array('Data Inputter',$permissions))

                @if($results->count()>0)
                @foreach ($results as $r)
                @if($r->control_num===strval($data[$i][0]))
                <td style="text-align:center"><a href="/iso_sec2_4_a7_edit/{{$data[$i][0]}}/{{$project_id}}/{{auth()->user()->id}}"><i class="fas fa-edit fa-lg" style="color: #114a1d;"></i></a></td>
               @break
                @endif

                @if ($loop->last)
                <td style="text-align:center"><i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i></td>

                @endif

                @endforeach
                @else
                <td style="text-align:center"><i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i></td>

                @endif

              @else
              <td style="text-align:center"><i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i></td>

                @endif


               <td>
                @if($results->count()>0)
                @foreach ($results as $r)
                @if($r->control_num===strval($data[$i][0]))
          <p>{{$r->first_name}} {{$r->last_name}}</p>
                    @break
                    @endif


                @endforeach
                @else
                {{-- <p>Not yet</p> --}}
                @endif
               </td>


               <td>
                @if($results->count()>0)
                @foreach ($results as $r)
                @if($r->control_num===strval($data[$i][0]))
                <p>{{date('F d, Y H:i:A', strtotime($r->last_edited_at))}}</p>
                    @break
                    @endif

                @endforeach

                @else

                @endif
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

    </form>




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
