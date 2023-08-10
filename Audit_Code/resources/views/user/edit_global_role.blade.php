@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">

<h1 class="text-center">Edit {{$permission->name}}</h1>


<div class="row justify-content-center">

    <div class="col-md-6">
    
        <div class="card">
            <div class="card-header bg-primary text-center">
                <h2 class="">Edit</h2>
             </div>

            <div class="card-body">
                

                <form method="post" action="/edit_globalrole/{{$permission->id}}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                      <label for="name">Role name:</label>
                      <input type="text" class="form-control" id="name" name='name' value="{{old('name',$permission->name)}}">
                      @if($errors->has('name'))
                      <p class="text-danger">{{$errors->first('name')}}</p>
                      @endif
                    </div>
              
                    <div class="text-center">
         
                      <button type="submit" class="btn btn-primary btn-lg mt-2">Edit role</button>
                                     
                    </div>

                    </div>
    
                    </form>
              
            </div>
    
        </div>
    
    
    </div>
    
    
    
    </div>
    












</div>

</div>


@endsection