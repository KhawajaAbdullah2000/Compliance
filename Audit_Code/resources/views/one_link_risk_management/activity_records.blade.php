@extends('master')

@section('content')

    @include('user-nav')


    @php
        $permissions = json_decode($project_permissions);
    @endphp
    <div class="container">

        <div class="row mt-5">
            <div class="col-lg-12">

                @include('components.one_link_topTable')

            </div>

    

            <div class="col-12 col-md-4 col-lg-3">
                <div class="p-3 text-white text-center rounded shadow"
                    style="background: linear-gradient(135deg, #f878d296, #ee15d1); transition: 0.3s;">
                    <h5 class="fw-bold mb-0">Risk Management Plan</h5>
                </div>
            </div>


                   @if(in_array('Data Inputter',$permissions))

            <div class="text-end">
                <a href="/add_risk_management_activity/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-lg btn-success">Add Activity</a>
            </div>

            @endif



            @if ($activities->isEmpty())
                <div class="alert alert-info mt-2">No Activity found.</div>
            @else
                <div class="card shadow-md mt-2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Activity Name</th>
                                        <th>Activity Type</th>
                                        <th>Responsible Team</th>
                                        <th>Frequency</th>
                                         <th>Scheduled Date</th>
                                         <th>Completion Status</th>
                                         <th>Comments/Updates</th>
                                         <th>Edit</th>
                                         <th>Delete</th>
                                
                                
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($activities as $item)
                                    <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$item->activity_name}}</td>
                                    <td>{{$item->activity_type}}</td>
                                    <td>{{$item->unit_name}}</td>
                                    <td>{{$item->frequency}}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->scheduled_date)->format('d M Y') }}</td> 
                                    <td>{{$item->completion_status}}</td>
                                     <td>{{$item->comments}}</td>
                                     <td><a href="/edit_activity_form/{{$project->project_id}}/{{auth()->user()->id}}/{{$item->activity_id}}"><i class="fas fa-edit fa-2x"></i></a></td>

                                     <td><a href="/delete_activity_form/{{$project->project_id}}/{{auth()->user()->id}}/{{$item->activity_id}}"><i class="text-danger fas fa-trash fa-2x"></i></a></td>
                                    </tr>    
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif




        </div>


 @section('scripts')
        @if (Session::has('success'))
            <script>
                swal({
                    title: "{{ Session::get('success') }}",
                    icon: "success",
                    closeOnClickOutside: true,
                    timer: 3000,
                });
            </script>
        @endif

       
    @endsection




    @endsection


   