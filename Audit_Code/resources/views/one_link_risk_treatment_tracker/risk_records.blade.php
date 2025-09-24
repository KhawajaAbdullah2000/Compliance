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
                    style="background: linear-gradient(135deg, #883354, #1869e2); transition: 0.3s;">
                    <h5 class="fw-bold mb-0">Risk Treatment Tracker</h5>
                </div>
            </div>



            @if ($riskRecords->isEmpty())
                <div class="alert alert-info mt-2">No risk records found.</div>
            @else
                <div class="card shadow-md mt-2">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center align-middle">
                                <thead class="table-secondary">
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Risk Id</th>
                                        <th>ERM Risk Classification</th>
                                        <th>Risk Description</th>
                                        <th>Residual Risk Rating</th>
                                        <th>Actionable Item</th>
                                        <th>Responsible Team (Unit)</th>
                                        <th>Action Owner</th>
                                        <th>Target Completion Date</th>
                                        <th>Status</th>
                                        <th style="min-width: 250px;">Comments/Updates</th>
                                
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riskRecords as $index => $record)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>R-IPS-{{ $record->risk_id }}</td>
                                            <td>{{ $record->erm_risk_classification }}</td>
                                            <td>{{ $record->risk_description }}</td>
                                            <td>{{ $record->residual_risk_rating }}</td>
                                            <td>{{ $record->risk_mitigation_plan }}</td>
                                            <td>{{ $record->unit_name }}</td>
                                            <td>{{ $record->risk_owner_name }}</td>
                                            <td>{{ $record->risk_reassessment_date }}</td>
                                            <td>{{ $record->implementation_status }}</td>
                                            <td style="min-width: 250px;">
                               <form action="/update_comments_one_link_risk_record/{{$project->project_id}}/{{auth()->user()->id}}" method="post" class="d-flex align-items-center gap-2">
                                @csrf
                                <input type="hidden" name="risk_id" value="{{ $record->risk_id }}">
                                <input type="text" name="comments" class="form-control form-control-sm" placeholder="Enter comment"
                                    value="{{ old('comments', $record->comments) }}">
                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                            </form>

                                </td>

            
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


   