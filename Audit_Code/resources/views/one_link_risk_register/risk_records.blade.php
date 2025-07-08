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
                     style="background: linear-gradient(135deg, #35323296, #848680); transition: 0.3s;">
                    <h5 class="fw-bold mb-0">Risk Register</h5>
                </div>
            </div>



            @if ($riskRecords->isEmpty())
                <div class="alert alert-info mt-2">No risk records found.</div>
            @else
                <div class="card shadow-md mt-2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Risk Id</th>
                                        <th>ERM Risk Classification</th>
                                        <th>n Basel II Loss Event Type I</th>
                                        <th>Basel II Loss Event Type II</th>
                                        <th>Risk Description</th>
                                        <th>Inherent Risk Rating</th>
                                        <th>Residual Risk Rating</th>
                                        <th>Risk Owner</th>
                                  
                                
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riskRecords as $index => $record)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td><a href="/risk_register_risk_record_details/{{$record->risk_id}}/{{$project->project_id}}">R-IPS-{{ $record->risk_id }}</a></td>
                                            <td>{{ $record->erm_risk_classification }}</td>
                                            <td>{{ $record->op_loss_event_type_one }}</td>
                                            <td>{{ $record->op_loss_event_type_two }}</td>
                                            <td>{{ $record->risk_description }}</td>
                                            <td>{{ $record->inherent_risk_rating }}</td>
                                            <td>{{ $record->residual_risk_rating }}</td>
                                            <td>{{ $record->risk_owner_name }}</td>
                                           
                                           

            
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


   