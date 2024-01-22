@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

@php
$permissions=json_decode($project_permissions);
@endphp

<div class="container">
    <div class="float-end">
        <a href="{{route('download_asset_template')}}">Download Excel template to upload assets</a>
        <br>
        {{-- <a href="/upload_assets/{{$project_id}}/{{auth()->user()->id}}">Upload a populated excel sheet</a> --}}
        <div class="container">
            <form action="/upload_assets/{{$project_id}}/{{auth()->user()->id}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file" class="text-primary" style="cursor: pointer">Upload a populated excel sheet</label>
                    <span id="fileName"></span>
                    <input type="file" name="file" id="file" class="form-control" style="display:none;"
                    onchange="displayFileName(this)">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Upload assets</button>
                @error('file')
                <div class="text-danger">{{ $errors->first('file') }}</div>

                @enderror
            </form>


      </div>


    <h3 class="text-center fw-bold mb-3"> Project name: {{$project_name}} Section2.1 Scope of Assets and Services</h3>




@if($data->count()==0)

@if(in_array('Data Inputter',$permissions))

<div class="row">

    <div class="col-md-12">

        <div class="card mt-2">
            <div class="card-header bg-primary text-center">
                <h2>Add your first Asset of this project</h2>
              </div>
            <div class="card-body">


        <form action="/new_iso_sec_2_1/{{$project_id}}/{{auth()->user()->id}}" method="post">
            @csrf
            <div class="form-group">
                <label for="">Asset Group Name:</label>
                    <textarea name="g_name" cols="70" rows="10" class="form-control">{{old('g_name')}}</textarea>
                @if($errors->has('g_name'))
                <div class="text-danger">{{ $errors->first('g_name') }}</div>
            @endif
              </div>

                <div class="form-group mt-4">
                <label for="">Asset Name:</label>
                    <textarea name="name" cols="70" rows="10" class="form-control">{{old('name')}}</textarea>
                @if($errors->has('name'))
                <div class="text-danger">{{ $errors->first('name') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Component Name:</label>
                    <textarea name="c_name" cols="70" rows="10" class="form-control">{{old('c_name')}}</textarea>
                @if($errors->has('c_name'))
                <div class="text-danger">{{ $errors->first('c_name') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Owner Dept.:</label>
                    <textarea name="owner_dept" cols="70" rows="10" class="form-control">{{old('owner_dept')}}</textarea>
                @if($errors->has('owner_dept'))
                <div class="text-danger">{{ $errors->first('owner_dept') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Asset Physical Location:</label>
                    <textarea name="physical_loc" cols="70" rows="10" class="form-control">{{old('physical_loc')}}</textarea>
                @if($errors->has('physical_loc'))
                <div class="text-danger">{{ $errors->first('physical_loc') }}</div>
            @endif
              </div>


              <div class="form-group mt-4">
                <label for="">Asset Logical Location:</label>
                    <textarea name="logical_loc" cols="70" rows="10" class="form-control">{{old('logical_loc')}}</textarea>
                @if($errors->has('logical_loc'))
                <div class="text-danger">{{ $errors->first('logical_loc') }}</div>
            @endif
              </div>

              <div class="form-group mt-4">
                <label for="">Service Name for which this is an underlying asset:</label>
                    <textarea name="s_name" cols="70" rows="10" class="form-control">{{old('s_name')}}</textarea>
                @if($errors->has('s_name'))
                <div class="text-danger">{{ $errors->first('s_name') }}</div>
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
{{-- if data inputter --}}


@endif
{{-- if !issset $data --}}


@if($data->count()>0)

@if(in_array('Data Inputter',$permissions))
<a class="btn btn-success btn-md float-end mb-2" href="/iso_sec_2_1_new/{{$project_id}}/{{auth()->user()->id}}"
    role="button">Add new Asset <i class="fas fa-plus"></i></a>
@endif

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
            <th>Risk Treatment</th>
            <th>Actions</th>
            <th>Details</th>
          </tr>
        </thead>
        <tbody>
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
            <a href="/iso_sec_2_3_1/{{$d->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-warning">Risk Assessment</a>
            {{-- <a href="/iso_sec_2_3_1/{{$d->assessment_id}}/{{$d->c_name}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-warning">Risk Assessment</a> --}}
          </td>
          <td>
            <a href="/iso_sec2_3_1_risk_treat_controls/{{$d->assessment_id}}/{{$project_id}}/{{auth()->user()->id}}" class="btn btn-sm btn-secondary">Risk Treatment</a>

          </td>

            <td>
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

                <td>
                <a href="/iso_sec_2_1_details/{{$d->assessment_id}}/{{$d->project_id}}/{{auth()->user()->id}}">
                    <i class="fas fa-eye fa-lg" style="color: #00d123;"></i>
                </a>
            </td>








            </tr>
     @endforeach


        </tbody>

      </table>
      @endif
      {{-- if issset $data --}}


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
