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



    <h4 class="text-center fw-bold mb-3 mt-4">Upload or Enter Services and Assets in scope</h4>


    @if($org_projects->count()>0)

    @if(in_array('Data Inputter',$permissions))
<form action="/copy_assets/{{$project_id}}/{{auth()->user()->id}}" class="float-end mb-4 d-inline-block" method="get">


<div class="row">

    <div class="form-group">
        <label for="">Copy Service or Asset from</label>
        <select class=" bg-info form-select" name="project_to_copy">

                @foreach ($org_projects as $proj)
    <option value="{{$proj->project_id}}" {{ old('project_to_copy') == $proj->project_id ? 'selected' : '' }}>
        {{$proj->project_name}}
    </option>
                   @endforeach
            </select>
           </div>
           @if($errors->has('project_to_copy'))
           <div class="text-danger">{{ $errors->first('project_to_copy') }}</div>
       @endif

       <div>
        <button type="submit" class="btn btn-success btn-sm mt-2">Copy</button>

       </div>

</div>




</form>

@endif
@endif

    <table id="myTable2" class="table table-responsive table-primary table-striped mt-4">
        <thead class="thead-dark table-pointer">
          <tr style="vertical-align: middle">
            <th onclick="sortTable(0)">Service Name for which this is an underlying asset </th>
            <th onclick="sortTable(1)">Asset Group Name</th>
            <th onclick="sortTable(2)">Asset Name</th>
            <th onclick="sortTable(3)">Asset Component Name</th>
            <th onclick="sortTable(4)">Asset Owner Dept</th>
            <th onclick="sortTable(5)">Asset Physical Location</th>
            <th onclick="sortTable(6)">Asset Logical Location</th>

@if($project->project_type==4)

            <th>Risk Assessment</th>
            @endif
            {{-- <th>Risk Treatment</th> --}}
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
@foreach ($data as $d)
            <tr>
                <td class="fw-bold">{{ strlen($d->s_name) > 12 ? substr($d->s_name, 0, 12) . '...' : $d->s_name }}</td>
                <td >{{ strlen($d->g_name) > 12 ? substr($d->g_name, 0, 12) . '...' : $d->g_name }}</td>
                <td>{{ strlen($d->name) > 12 ? substr($d->name, 0, 12) . '...' : $d->name }}</td>
                <td>{{ strlen($d->c_name) > 12 ? substr($d->c_name, 0, 12) . '...' : $d->c_name }}</td>
                <td>{{ strlen($d->owner_dept) > 12 ? substr($d->owner_dept, 0, 12) . '...' : $d->owner_dept }} </td>
                <td>{{ strlen($d->physical_loc) > 12 ? substr($d->physical_loc, 0, 12) . '...' : $d->physical_loc }} </td>
                <td> {{ strlen($d->logical_loc) > 12 ? substr($d->logical_loc, 0, 12) . '...' : $d->logical_loc }} </td>


                @if($project->project_type==4)
          <td>
            <a href="/iso_sec_2_3_1/{{$d->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm my_bg_color text-white">Initiate or Edit</a>
            {{-- <a href="/iso_sec_2_3_1/{{$d->assessment_id}}/{{$d->c_name}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-warning">Risk Assessment</a> --}}
          </td>
          @endif
          {{-- <td>
            <a href="/iso_sec2_3_1_risk_treat_controls/{{$d->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm text-white my_bg_color2">Risk Treatment</a>

          </td> --}}

          <td style="text-align:center">
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



                </td>






            </tr>
     @endforeach


        </tbody>

      </table>

      @if(in_array('Data Inputter',$permissions))
<a class="btn btn-success btn-md float-end mb-2" href="/iso_sec_2_1_new/{{$project_id}}/{{auth()->user()->id}}"
    role="button">Enter Service or Asset <i class="fas fa-plus"></i></a>
@endif


      <div class="float-start">
        <a href="{{route('download_asset_template')}}">Download Excel template to upload assets</a>
        <br>
        {{-- <a href="/upload_assets/{{$project_id}}/{{auth()->user()->id}}">Upload a populated excel sheet</a> --}}
        <div class="">
            <form action="/upload_assets/{{$project_id}}/{{auth()->user()->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file" class="text-primary"
                    style="cursor: pointer;text-decoration: underline;">Upload a populated excel sheet</label>
                    <span id="fileName"></span>
                    <input type="file" name="file" id="file" class="form-control" style="display:none;"
                    onchange="displayFileName(this)">
                </div>
                <button type="submit" class="btn my_bg_color text-white btn-sm mt-2">Upload</button>
                @error('file')
                <div class="text-danger">{{ $errors->first('file') }}</div>

                @enderror
            </form>


      </div>

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
  timer: 6000,
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
