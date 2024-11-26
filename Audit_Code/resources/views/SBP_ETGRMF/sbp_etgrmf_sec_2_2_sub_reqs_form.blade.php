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

    @if(Session('evidenceLevel')!='project')
    <table  class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark ">
            <tr>
                <th>Service</th>
                    <th>Asset Group</th>
                    <th>Asset</th>
                    <th>Asset Component</th>
                    <th>Asset Owner Dept</th>
                    <th>Asset Physical Location</th>
                    <th>Asset Logical Location</th>
                
            </tr>
        </thead>
        <tbody>
           
            <tr>
                <td>{{ $asset->s_name }}</td>
                <td>{{ $asset->g_name }}</td>
                <td>{{ $asset->name }}</td>
                <td>{{ $asset->c_name }}</td>
                <td>{{ $asset->owner_dept }}</td>
                <td>{{ $asset->physical_loc }}</td>
                <td>{{ $asset->logical_loc }}</td>
               
            </tr>
      
        </tbody>
    </table>
    
    
    @endif
    
    @if(Session('evidenceLevel')=='project')
    
    <a href="/iso_section2_1/{{$project_id}}/{{auth()->user()->id}}">View Services and Assets in this Project</a>
    
    @endif
    
    
    
    <h3>Select From below and apply to @if(Session('evidenceLevel')=='project') All Services and Assets in this Project @endif
        @if(Session('evidenceLevel')=='service') All Assets in the service: {{$asset->s_name}} @endif
        @if(Session('evidenceLevel')=='group') All Assets in the group: {{$asset->g_name}} @endif
        @if(Session('evidenceLevel')=='name') All Assets in: {{$asset->name}} @endif
        @if(Session('evidenceLevel')=='component') the Component: {{$asset->c_name}} @endif
    
    </h3>

    <a href="/sbp_etgrmf_subsections/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" class="btn btn-primary btn-md float-end mb-4">Go to All Requirements</a>



    <h2 class="text-center fw-bold mt-4 mb-4">
    Req No. {{$filteredData[0][4]}}
         </h2>

        <p>{{$filteredData[0][5]}} </p>

        @if(in_array('Data Inputter', $permissions))
        @isset($result)
        <div class="container d-flex justify-content-center">
        <div class="card shadow-lg border-0 mt-5 mb-5" style="max-width: 600px; width: 100%;">
            <div class="card-header bg-primary text-white text-center">
                <h3>Edit Status and/or assign action</h3>
            </div>
            <div class="card-body">
                <form action="/sbp_etgrmf_sec_2_2_edit_form/{{$sub_req}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Compliance Status -->
                    <div class="mb-4">
                        <label for="comp_status" class="form-label fw-semibold">Compliance Status</label>
                        <select name="comp_status" class="form-select rounded-pill">
                            <option value="yes" {{ old('comp_status', $result->comp_status) == 'yes' ? 'selected' : '' }}>Yes</option>
                            <option value="no" {{ old('comp_status', $result->comp_status) == 'no' ? 'selected' : '' }}>No</option>
                            <option value="partial" {{ old('comp_status', $result->comp_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                        </select>
                        @if($errors->has('comp_status'))
                        <div class="text-danger small mt-2">{{ $errors->first('comp_status') }}</div>
                        @endif
                    </div>

                    <!-- Comments -->
                    <div class="mb-4">
                        <label for="comments" class="form-label fw-semibold">Comments (Optional)</label>
                        <textarea name="comments" id="comments" rows="4" class="form-control rounded">{{ old('comments', $result->comments) }}</textarea>
                        @if($errors->has('comments'))
                        <div class="text-danger small mt-2">{{ $errors->first('comments') }}</div>
                        @endif
                    </div>

                    <!-- Attachment -->
                    <div class="mb-4">
                        <label for="attachment" class="form-label fw-semibold">Attachment (Optional)</label>
                        <input type="file" name="attachment" class="form-control">
                        @if(isset($result->attachment))
                        <p class="mt-3">Current Attachment: 
                            <a href="{{ asset('sbp_etgrmf_sec_2_2/'.$result->attachment) }}" download>{{ $result->attachment }}</a>
                        </p>
                        @endif
                    </div>

                    <h3 class="fw-bold">Assign Action</h3>

                    <div class="form-group mb-4">
                        <label for=""> Treatment Action</label>
                        <textarea name="treatment_action" cols="70" rows="5" class="form-control">{{old('treatment_action',$result->treatment_action)}}</textarea>
        
                            @if($errors->has('treatment_action'))
                            <div class="text-danger">{{ $errors->first('treatment_action') }}</div>
                        @endif
                      </div>
        
        
                      <div class="form-group mb-4">
                        <label for=""> Treatment Target Date</label>
                        <input type="date" name="treatment_target_date" value="{{old('treatment_target_date',$result->treatment_target_date)}}">
                            @if($errors->has('treatment_target_date'))
                            <div class="text-danger">{{ $errors->first('treatment_target_date') }}</div>
                        @endif
                      </div>
        
                       <div class="form-group mb-4">
                        <label for=""> Treatment Completion Date</label>
                        <input type="date" name="treatment_comp_date" value="{{old('treatment_comp_date',$result->treatment_comp_date)}}">
                            @if($errors->has('treatment_comp_date'))
                            <div class="text-danger">{{ $errors->first('treatment_comp_date') }}</div>
                        @endif
                      </div>
        
                      <div class="form-group mb-4">
                        <label for=""> Actual Acceptane date</label>
                        <input type="date" name="acceptance_actual_date" value="{{old('acceptance_actual_date',$result->acceptance_actual_date)}}">
                            @if($errors->has('acceptance_actual_date'))
                            <div class="text-danger">{{ $errors->first('acceptance_actual_date') }}</div>
                        @endif
                      </div>
        
        
        
        
                       <div class="form-group mb-4">
                        <label for=""> Responsbility for Treatment</label>
                        <select class="boxstyling form-select" name="responsibility_for_treatment">
                            <option value="">Select User</option>
                             @foreach ($users as $user)
             <option value="{{$user->id}}" {{ old('responsibility_for_treatment',$result->responsibility_for_treatment) == $user->id ? 'selected' : '' }}>
                     {{$user->first_name}} {{$user->last_name}}</option>
                                   @endforeach
                            </select>
                            @if($errors->has('responsibility_for_treatment'))
                            <div class="text-danger">{{ $errors->first('responsibility_for_treatment') }}</div>
                        @endif
                      </div>
        
        
        

                    <!-- Submit Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        @else
        <!-- New Compliance Status Form -->
        <div class="container d-flex justify-content-center">
            <div class="card shadow-lg border-0 mt-5 mb-5" style="max-width: 600px; width: 100%;">
                <div class="card-header bg-success text-white text-center">
                    <h3>Edit Status and/or assign action</h3>
                </div>
                <div class="card-body">
                    <form action="/sbp_etgrmf_sec_2_2_form/{{$sub_req}}/{{$title}}/{{$project_id}}/{{auth()->user()->id}}/{{$asset->assessment_id}}" method="post" enctype="multipart/form-data">
                        @csrf
        
                        <!-- Compliance Status -->
                        <div class="mb-4">
                            <label for="comp_status" class="form-label fw-semibold">Compliance Status</label>
                            <select name="comp_status" class="form-select rounded-pill">
                                <option value="">Select --</option>
                                <option value="yes" {{ old('comp_status') == 'yes' ? 'selected' : '' }}>Yes</option>
                                <option value="no" {{ old('comp_status') == 'no' ? 'selected' : '' }}>No</option>
                                <option value="partial" {{ old('comp_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                            </select>
                            @if($errors->has('comp_status'))
                            <div class="text-danger small mt-2">{{ $errors->first('comp_status') }}</div>
                            @endif
                        </div>
        
                        <!-- Comments -->
                        <div class="mb-4">
                            <label for="comments" class="form-label fw-semibold">Comments (Optional)</label>
                            <textarea name="comments" id="comments" rows="4" class="form-control rounded"></textarea>
                            @if($errors->has('comments'))
                            <div class="text-danger small mt-2">{{ $errors->first('comments') }}</div>
                            @endif
                        </div>
        
                        <!-- Attachment -->
                        <div class="mb-4">
                            <label for="attachment" class="form-label fw-semibold">Attachment (Optional)</label>
                            <input type="file" name="attachment" class="form-control">
                        </div>

                        <h3 class="fw-bold">Assign Action</h3>

                        <div class="form-group mb-4">
                            <label for=""> Treatment Action</label>
                            <textarea name="treatment_action" cols="70" rows="5" class="form-control">{{old('treatment_action')}}</textarea>
            
                                @if($errors->has('treatment_action'))
                                <div class="text-danger">{{ $errors->first('treatment_action') }}</div>
                            @endif
                          </div>
            
            
                          <div class="form-group mb-4">
                            <label for=""> Treatment Target Date</label>
                            <input type="date" name="treatment_target_date" value="{{old('treatment_target_date')}}">
                                @if($errors->has('treatment_target_date'))
                                <div class="text-danger">{{ $errors->first('treatment_target_date') }}</div>
                            @endif
                          </div>
            
                           <div class="form-group mb-4">
                            <label for=""> Treatment Completion Date</label>
                            <input type="date" name="treatment_comp_date" value="{{old('treatment_comp_date')}}">
                                @if($errors->has('treatment_comp_date'))
                                <div class="text-danger">{{ $errors->first('treatment_comp_date') }}</div>
                            @endif
                          </div>
            
                          <div class="form-group mb-4">
                            <label for=""> Actual Acceptane date</label>
                            <input type="date" name="acceptance_actual_date" value="{{old('acceptance_actual_date')}}">
                                @if($errors->has('acceptance_actual_date'))
                                <div class="text-danger">{{ $errors->first('acceptance_actual_date') }}</div>
                            @endif
                          </div>
            
            
            
            
                           <div class="form-group mb-4">
                            <label for=""> Responsbility for Treatment</label>
                            <select class="boxstyling form-select" name="responsibility_for_treatment">
                                <option value="">Select User</option>
                                 @foreach ($users as $user)
                 <option value="{{$user->id}}" {{ old('responsibility_for_treatment') == $user->id ? 'selected' : '' }}>
                         {{$user->first_name}} {{$user->last_name}}</option>
                                       @endforeach
                                </select>
                                @if($errors->has('responsibility_for_treatment'))
                                <div class="text-danger">{{ $errors->first('responsibility_for_treatment') }}</div>
                            @endif
                          </div>
            
        
                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg px-5 rounded-pill">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        @endisset
    @endif
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
