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
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="fw-bold">Project Name:</td>
                        <td> <a href="/iso_sections/{{$project->project_id}}/{{auth()->user()->id}}"> {{$project->project_name}}
                        </a>
                        </td>
                        <td class="fw-bold">Your Email:</td>
                        <td>{{auth()->user()->email}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Type:</td>
                        <td>{{$project->type}}</td>
                        <td class="fw-bold">Organization Name:</td>
                        <td>{{auth()->user()->organization->name}}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">Project Status:</td>
                        <td>{{$project->status}}</td>
                        <td class="fw-bold">Sub-Organization:</td>
                        <td>{{auth()->user()->organization->sub_org}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <h4 class="text-center fw-bold mb-3 mt-4">Undertake and information security risk assessment on the Services and/or Assets</h4>


{{--
@if(in_array('Data Inputter',$permissions))
<a class="btn btn-success btn-md float-end mb-2" href="/iso_sec_2_1_new/{{$project_id}}/{{auth()->user()->id}}"
    role="button">Add new Asset manually <i class="fas fa-plus"></i></a>
@endif --}}

    <table id="myTable2" class="table table-responsive table-primary table-striped mt-4">
        <thead class="thead-dark table-pointer">
          <tr style="vertical-align: middle">
            <th onclick="sortTable(0)">Asset Group Name</th>
            <th onclick="sortTable(1)">Asset Name</th>
            <th onclick="sortTable(2)">Asset Component Name</th>
            <th onclick="sortTable(3)">Asset Owner Dept</th>
            <th onclick="sortTable(4)">Asset Physical Location</th>
            <th onclick="sortTable(5)">Asset Logical Location</th>
            <th onclick="sortTable(6)">Service Name for which this is an underlying asset </th>
            <th>Risk Assessment</th>
            {{-- <th>Risk Treatment</th> --}}

          </tr>
        </thead>
        <tbody>
            @if($data->count()==0)

            <tr>
                <td colspan="11" class="text-center"><h4>Please enter at least one service and/or asset
                     before a risk assessment can be initiated</h4></td>
            </tr>

@endif
@foreach ($data as $d)
            <tr>
                <td class="fw-bold">{{$d->g_name}}</td>
                <td>{{$d->name}} </td>
                <td>{{$d->c_name}}</td>
                <td>{{$d->owner_dept}} </td>
                <td>{{$d->physical_loc}} </td>
                <td>{{$d->logical_loc}} </td>
                <td>{{$d->s_name}}</td>

          <td>
            <a href="/iso_sec_2_3_1/{{$d->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white">Initiate or Edit</a>
          </td>
          {{-- <td>
            <a href="/iso_sec2_3_1_risk_treat_controls/{{$d->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm text-white my_bg_color2">Risk Treatment</a>

          </td> --}}

            {{-- <td>
            @if(in_array('Data Inputter',$permissions))

             <a href="/iso_sec_2_1_edit/{{$d->assessment_id}}/{{$d->project_id}}/{{auth()->user()->id}}">
                <i class="fas fa-edit fa-lg" style="color: #124903;"></i>
            </a>

            <a href="/iso_sec_2_1_delete/{{$d->assessment_id}}/{{$d->project_id}}/{{auth()->user()->id}}">
                <i class="fas fa-trash-alt fa-lg" style="color: #e60000;"></i>
            </a>
        @else
        <i class="fas fa-lock fa-lg" style="color: #cc0f0f;"></i>

        @endif

            <a href="/iso_sec_2_1_details/{{$d->assessment_id}}/{{$d->project_id}}/{{auth()->user()->id}}">
                <i class="fas fa-eye fa-lg" style="color: #00d123;"></i>
            </a>

                </td> --}}






            </tr>
     @endforeach


        </tbody>

      </table>



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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "error",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif

<script>
    document.getElementById('fileLabel').addEventListener('click', function () {
        document.getElementById('file').click();
    });
    function displayFileName(input) {
            var fileNameElement = document.getElementById('fileName');
            fileNameElement.innerHTML = input.files[0].name;
        }

</script>

<script>
    function sortTable(n) {
      var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
      table = document.getElementById("myTable2");
      switching = true;
      // Set the sorting direction to ascending:
      dir = "asc";
      /* Make a loop that will continue until
      no switching has been done: */
      while (switching) {
        // Start by saying: no switching is done:
        switching = false;
        rows = table.rows;
        /* Loop through all table rows (except the
        first, which contains table headers): */
        for (i = 1; i < (rows.length - 1); i++) {
          // Start by saying there should be no switching:
          shouldSwitch = false;
          /* Get the two elements you want to compare,
          one from current row and one from the next: */
          x = rows[i].getElementsByTagName("TD")[n];
          y = rows[i + 1].getElementsByTagName("TD")[n];
          /* Check if the two rows should switch place,
          based on the direction, asc or desc: */
          if (dir == "asc") {
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          } else if (dir == "desc") {
            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
              // If so, mark as a switch and break the loop:
              shouldSwitch = true;
              break;
            }
          }
        }
        if (shouldSwitch) {
          /* If a switch has been marked, make the switch
          and mark that a switch has been done: */
          rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
          switching = true;
          // Each time a switch is done, increase this count by 1:
          switchcount ++;
        } else {
          /* If no switching has been done AND the direction is "asc",
          set the direction to "desc" and run the while loop again. */
          if (switchcount == 0 && dir == "asc") {
            dir = "desc";
            switching = true;
          }
        }
      }
    }
    </script>




@endsection



@endsection
