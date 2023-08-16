@extends('master')

@section('content')
    
@include('user-nav')


<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-6">

            @php
            $perm=json_decode($user->project_permissions);
   
            @endphp

    <div class="card">
        <div class="card-body">
          <h3 class="card-title text-center text-bold mb-3">Edit Permissions of {{$user->assigned_enduser}} for Project {{$user->project_code}}</h3>

          <form action="/edit_permissions/{{$user->project_code}}/{{$user->assigned_enduser}}" method="post">
            @csrf
            @method('PUT')

              <div class="form-group mt-4">
                <label for=""><h3>Project Permissions</h3></label>
                <br>
                @foreach ($permissions as $p)
                   {{ $p->name}} <input type="checkbox" name="project_permissions[]" value="{{$p->name}}"
                   {{in_array($p->name,$perm) ? 'checked':''}}
                   >
                @endforeach
                @if($errors->has('project_permissions'))
                <div class="text-danger">{{ $errors->first('project_permissions','Choose atleast 1 permission ') }}</div>
            @endif
    
  
              </div> 


              <div class="text-center">
                <button class="btn btn-primary btn-md">Edit permissions</button>
              </div>


          </form>


        </div>
      </div>
    </div>
    </div>
            
</div>




@endsection


