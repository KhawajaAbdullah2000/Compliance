@extends('master')

@section('content')
    
@include('user-nav')

<div class="container">

<h1 class="text-center">Add new Global custom role</h1>


<div class="row justify-content-center">

    <div class="col-md-6">
    
        <div class="card">
            <div class="card-header bg-primary text-center">
                <h2 class="">Add new global role</h2>
             </div>

            <div class="card-body">
                

                <form method="post" action="/add_new_role">
                    @csrf
                    <div class="form-group">
                      <label for="name">Role name:</label>
                      <input type="text" class="form-control" id="name" name='name'>
                      @if($errors->has('name'))
                      <p class="text-danger">{{$errors->first('name')}}</p>
                      @endif
                    </div>
              
                    <div class="text-center">
         
                      <button type="submit" class="btn btn-primary btn-lg mt-2">Add new role</button>
                                     
                    </div>

                    </div>
    
                    </form>
              
            </div>
    
        </div>
    
    
    </div>
    
    
    
    </div>
    












</div>

</div>



{{-- 
<div>
    <input type="text" class="form-control" id="name" name='name'>
    @if($errors->has('name'))
    <p class="text-danger">{{$errors->first('name')}}</p>
    @endif
</div> --}}
@endsection