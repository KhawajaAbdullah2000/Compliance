@extends('master')

@section('content')

@include('user-nav')


<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">

    <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center text-bold mb-3">Assign end userto {{$project_id}}</h3>

          <form action="/assign_enduser_to_project/{{$project_id}}" method="post">
            @csrf

            <div class="form-group">
                <label for="" class="form-label">End user</label>
                   <select class="boxstyling bg-info form-select" name="assigned_enduser">
                   <option value="">Select User</option>
                    @foreach ($users as $user)
    <option value="{{$user->id}}" {{ old('assigned_enduser') == $user->id ? 'selected' : '' }}>
            {{$user->first_name}} {{$user->last_name}}</option>
                          @endforeach
                   </select>
                  </div>
                  @if($errors->has('assigned_enduser'))
                  <div class="text-danger">{{ $errors->first('assigned_enduser') }}</div>
              @endif

              <div class="form-group mt-4">
                <label for=""><h3>Project Permissions</h3></label>
                @foreach ($permissions as $p)
                <br>
                   {{ $p->name}} <input type="checkbox" name="project_permissions[]" value="{{$p->name}}">
                @endforeach

              </div>

              <div class="text-center">
                <button class="btn btn-primary btn-md">Create user</button>
              </div>


          </form>


        </div>
      </div>
    </div>
    </div>

</div>




@endsection


