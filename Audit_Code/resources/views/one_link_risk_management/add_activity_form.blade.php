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
        </div>



        <div class="col-12 col-md-4 col-lg-3">
            <div class="p-3 text-white text-center rounded shadow"
                style="background: linear-gradient(135deg, #f878d296, #ee15d1); transition: 0.3s;">
                <h5 class="fw-bold mb-0">Risk Management Plan</h5>
            </div>
        </div>



        <div class="container min-vh-100 d-flex justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header fw-bold text-center">
                        Add Activity
                    </div>
                    <div class="card-body">
                        <form action="/insert_activity_form/{{ $project->project_id }}/{{ auth()->user()->id }}"
                            method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="activity_name" class="form-label">Activity Name</label>
                                <input type="text" name="activity_name" id="activity_name" class="form-control" required>
                            </div>


                            <div class="mb-3">
                                <label for="activity_type" class="form-label fw-bold">Activity Type</label>
                                <select name="activity_type" id="activity_type" class="form-select">

                                    @php
                                        $allowedValues = ['Assessment', 'Training', 'Review', 'Other', 'Monitoring'];

                                    @endphp
                                    @foreach ($allowedValues as $val)
                                        <option value="{{ old('activity_type', $val) }}">
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-3">
                                <label for="responsible_team" class="form-label fw-bold">Responsible Team</label>
                                <select name="responsible_team" id="responsible_team" class="form-select">

                                    @foreach ($units as $unit)
                                        <option value="{{ $unit->id }}">
                                            {{ $unit->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="frequency" class="form-label fw-bold">Frequency</label>
                                <select name="frequency" id="frequency" class="form-select">

                                    @php
                                        $allowedValues = ['Quarterly', 'Monthly', 'Annually'];

                                    @endphp
                                    @foreach ($allowedValues as $val)
                                        <option value="{{ old('frequency', $val) }}">
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                               <div class="mb-3">
                                <label for="completion_status" class="form-label fw-bold">Completion </label>

                                <input type="date" name="scheduled_date" id="" class="form-control">


                               </div>



                            <div class="mb-3">
                                <label for="completion_status" class="form-label fw-bold">Completion Status</label>
                                <select name="completion_status" id="completion_status" class="form-select">

                                    @php
                                        $allowedValues = ['Pending', 'In Progress', 'Completed'];

                                    @endphp
                                    @foreach ($allowedValues as $val)
                                        <option value="{{ old('completion_status', $val) }}">
                                            {{ $val }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="comments" class="form-label fw-bold">Comments/Updates</label>
                                <textarea class="form-control" name="comments" id="" cols="10" rows="3"></textarea>

                            </div>

                                <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
                    </div>
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
@endsection




@endsection
