@extends('master')

@section('content')

@include('user-nav')

<div class="container">

   
    <h3 class="fw-bold text-center mt-4 mb-4">View Action Plans on All Projects: {{auth()->user()->organization->name}}</h3>

    
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h2>Select one option and proceed</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                
                        <li class="list-group-item">
                            <a href="/all_projects_action_plan/Mandatory/{{auth()->user()->organization->id}}">
                               Action Plan for Compliance
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="/all_projects_action_plan/Treatment/{{auth()->user()->organization->id}}">
                             Risk Treatment Action Plan
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a href="/all_projects_action_plan/Both/{{auth()->user()->organization->id}}">
                           Both
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        
        </div>
    </div>

</div>


@endsection
