@extends('master')

@section('content')

@include('user-nav')





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
                    <tr>
                        <td class="fw-bold">Compliance Framework:</td>
                        <td>{{$complianceFramework->framework_name}}</td>
                        <td class="fw-bold">Risk Management Methodology:</td>
                        <td>{{$framework_approach->approach_name}} - {{$risk_assessment_approach->global_assessment_approach}} </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>




        <div class="d-flex justify-content-center mb-4">
            <div class="col-md-6">
                <div class="card mt-4 shadow-lg border-0 rounded-3">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center fw-bold mb-2">Add New Party</h3>
                        <form class="row g-4" method="POST" action="/submit_new_party/{{$project->project_id}}/{{auth()->user()->id}}">
                            @csrf
        
                            <div class="col-md-12">
                           
                                 <label for="party_name">Party Name</label>
                                <input type="text" class="form-control" 
                                name="party_name" value="{{old('party_name')}}" required>
                        
                                
                                @if($errors->has('party_name'))
                                    <div class="text-danger mt-2 small">{{ $errors->first('party_name') }}</div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <label for="">Party Type</label>
                        <select name="party_type" class="form-select">
                            <option value="External">External</option>
                            <option value="Internal">Internal</option>
                        </select>

                            </div>

                            <div class="col-md-12">
                                <label for="">Party Type</label>
                        <select name="party_category" class="form-select">
                            <option value="Customer">Customer</option>
                            <option value="Partner">Partner</option>
                            <option value="Contractor">Contractor</option>
                            <option value="IT Service Provider">IT Service Provider</option>
                            <option value="Business Service Provider">Business Service Provider</option>
                            <option value="End User">End User</option>
                            <option value="Other">Other</option>
                        </select>

                            </div>
        
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary btn-lg px-5 py-2 fw-semibold">Add Party</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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



@endsection

@endsection
