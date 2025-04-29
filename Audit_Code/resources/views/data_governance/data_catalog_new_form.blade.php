@extends('master')

@section('content')

@include('user-nav')


@php
$permissions = json_decode($project_permissions);

// User can edit data if they have "Data Inputter"
$isEditable = in_array('Data Inputter', $permissions);
@endphp

<div class="container">
    <div class="row mt-5">
        <div class="col-lg-12">
            @include('components.topTable')
        </div>
    </div>

    <div class="row justify-content-center mb-4">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white text-center">
                    <h2 class="mb-0">Add data and its metadata</h2>
                </div>
                <div class="card-body p-5">
                    <form action="/new_data_catalog_submit/{{$project->project_id}}/{{auth()->user()->id}}" enctype="multipart/form-data" method="post">
                        @csrf

                        <!-- Service Name -->
                        <div class="mb-4">
                            <label for="dataset_id" class="form-label fw-semibold">Data Set Id/Name</label>
                            <input type="text" name="name" id="name" class="form-control rounded-pill" value="{{old('name')}}">
                            @if($errors->has('name'))
                            <div class="text-danger small mt-2">{{ $errors->first('name') }}</div>
                            @endif
                        </div>


            
                        <div class="mb-4">
                            <label for="data_source" class="form-label fw-semibold">Data Source</label>
                            <input type="text" name="data_source" id="data_source" class="form-control rounded-pill" value="{{old('data_source')}}">
                            @if($errors->has('data_source'))
                            <div class="text-danger small mt-2">{{ $errors->first('data_source') }}</div>
                            @endif
                        </div>

                       
                        <div class="mb-4">
                            <label for="data_type" class="form-label fw-semibold">Data Type</label>
                            <input type="text" name="data_type" id="physical_loc" class="form-control rounded-pill" value="{{old('data_type')}}">
                            @if($errors->has('data_type'))
                            <div class="text-danger small mt-2">{{ $errors->first('data_type') }}</div>
                            @endif
                        </div>

                    
                        <div class="mb-4">
                            <label for="data_definition" class="form-label fw-semibold">Data Definition</label>
                            <input type="text" name="data_definition" id="logical_loc" class="form-control rounded-pill" value="{{old('data_definition')}}">
                            @if($errors->has('data_definition'))
                            <div class="text-danger small mt-2">{{ $errors->first('data_definition') }}</div>
                            @endif
                        </div>

                          <!-- Data Owner dept -->
                    <div class="mb-4">
                        <label for="owner_dept" class="form-label fw-semibold">Data Owner Dept</label>
                        <select name="owner_dept" id="owner_dept" class="form-control">
                            <option value="">--</option>
                            @foreach($sub_orgs as $sub)
                                <option value="{{ $sub->name }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>

                            <!-- Data User dept -->
                            <div class="mb-4">
                                <label for="user_dept" class="form-label fw-semibold">Data User Dept</label>
                                <select name="user_dept" id="user_dept" class="form-control">
                                    <option value="">--</option>
                                    @foreach($sub_orgs as $sub)
                                        <option value="{{ $sub->name }}">{{ $sub->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!--  governance_policy -->

                            <div class="mb-4">
                                <label for="attachment" class="form-label fw-semibold">Data Governance Policy</label>
                                <input type="file" name="governance_policy" class="form-control">
                                @if($errors->has('governance_policy'))
                                <div class="text-danger small mt-2">{{ $errors->first('governance_policy') }}</div>
                                @endif
                               
                        
                            </div>
                         

                        <div class="mb-4">
                            <label for="confidentiality_tag" class="form-label fw-semibold">Confidentiality Classification Tag</label>
                            <input type="text" name="confidentiality_tag" id="logical_loc" class="form-control rounded-pill" value="{{old('classification_tag')}}">
                            @if($errors->has('confidentiality_tag'))
                            <div class="text-danger small mt-2">{{ $errors->first('confidentiality_tag') }}</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="integrity_tag" class="form-label fw-semibold">Integrity Classification Tag</label>
                            <input type="text" name="integrity_tag" id="logical_loc" class="form-control rounded-pill" value="{{old('integrity_tag')}}">
                            @if($errors->has('integrity_tag'))
                            <div class="text-danger small mt-2">{{ $errors->first('integrity_tag') }}</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="availability_tag" class="form-label fw-semibold">Availability Classification Tag</label>
                            <input type="text" name="availability_tag" id="logical_loc" class="form-control rounded-pill" value="{{old('availability_tag')}}">
                            @if($errors->has('availability_tag'))
                            <div class="text-danger small mt-2">{{ $errors->first('availability_tag') }}</div>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill">Save Changes</button>
                        </div>
                    </form>
                </div>
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

@if(Session::has('error'))
<script>
    swal({
  title: "{{Session::get('error')}}",
  icon: "success",
  closeOnClickOutside: true,
  timer: 3000,
    });
</script>
@endif



@endsection

@endsection
