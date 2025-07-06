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
                    style="background: linear-gradient(135deg, #70e292, #F09819); transition: 0.3s;">
                    <h5 class="fw-bold mb-0">Residual Risk Assessment</h5>
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
                                        <th>Date of Risk Identification</th>
                                        <th>Date of Rosk ReAssessment</th>
                                        <th>Department (SBU)</th>
                                        <th>Unit</th>
                                        <th>Product</th>
                                        <th>Cycle</th>
                                        <th>Sub-Process</th>
                                        <th>Created By</th>
                                        <th>Gross Risk Assessment Output</th>

                                        <th>Edit Attributes</th>
                                        <th>Edit Table</th>
                                        {{-- <th>Created At</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riskRecords as $index => $record)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>R-IPS-{{ $record->risk_id }}</td>
                                            <td>{{ $record->risk_identification_date }}</td>
                                            <td>{{ $record->risk_reassessment_date }}</td>
                                            <td>{{ $record->department_name }}</td>
                                            <td>{{ $record->unit_name }}</td>
                                            <td>{{ $record->product_name }}</td>
                                            <td>{{ $record->cycle_name }}</td>
                                            <td>{{ $record->sub_process_name }}</td>

                                            <td>{{ $record->created_by_name ?? 'N/A' }}</td>

                                            <td>
                                                <a href="javascript:void(0);" class="text-info view-risk-output"
                                                    data-overall="{{ $record->overall_impact }}"
                                                    data-likelihood="{{ $record->likelihood }}"
                                                    data-inherent="{{ $record->inherent_risk_rating }}"
                                                    data-blank1="{{ $record->blank1 }}"
                                                    data-blank3="{{ $record->blank3 }}">
                                                    <i class="fas fa-eye fa-2x" style="cursor: pointer;"></i>
                                                </a>
                                            </td>




                                            {{-- <td>{{ \Carbon\Carbon::parse($record->created_at)->format('d M Y, h:i A') }}</td> --}}
                                            <td>
                                                <a href="/initiate_residual_assessment_form/{{ $record->risk_id }}/{{ $project->project_id }}/{{ auth()->user()->id }}"
                                                    class="text-primary me-2">
                                                    <i class="fas fa-edit fa-2x"></i>
                                                </a>
                                            </td>

                                            <td>
                                                <a href="/edit_risk_record_initial/{{ $record->risk_id }}/{{ $project->project_id }}/{{ auth()->user()->id }}"
                                                    class="text-success me-2">
                                                    <i class="fas fa-edit fa-2x"></i>
                                                </a>
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






    @endsection

    <!-- Modal HTML OUTSIDE content section -->
    <div class="modal gross_risk_modal fade" id="grossRiskModal" tabindex="-1" aria-labelledby="grossRiskModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title" id="grossRiskModalLabel">Gross Risk Assessment Output</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Overall Impact:</strong> <span id="modal-overall-impact"></span></p>
                    <p><strong>Likelihood:</strong> <span id="modal-likelihood"></span></p>
                    <p><strong>Inherent Risk Rating:</strong> <span id="modal-inherent-rating"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.view-risk-output').forEach(function(icon) {
                    icon.addEventListener('click', function() {
                        const overallImpact = this.getAttribute('data-overall') || 'N/A';
                        const likelihood = this.getAttribute('data-likelihood') || 'N/A';
                        const inherent = this.getAttribute('data-inherent') || 'N/A';
                        const blank1 = this.getAttribute('data-blank1') || '-';
                        const blank3 = this.getAttribute('data-blank3') || '-';

                        document.getElementById('modal-overall-impact').textContent =
                            `${overallImpact} (${blank1})`;
                        document.getElementById('modal-likelihood').textContent = likelihood;
                        document.getElementById('modal-inherent-rating').textContent =
                            `${inherent} (${blank3})`;

                        const modal = new bootstrap.Modal(document.getElementById('grossRiskModal'));
                        modal.show();
                    });
                });
            });
        </script>
    @endsection
