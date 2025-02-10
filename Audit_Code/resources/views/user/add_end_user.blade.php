@extends('master')

@section('content')

@include('user-nav')


<div class="container">


  <div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header bg-primary text-white text-center py-4 rounded-top">
                    @if($org->type == 'guest')
                        <h2 class="mb-0 fw-bold">Add New End User in {{ $org->name }}</h2>
                    @else
                        <h2 class="mb-0 fw-bold">Add New End User</h2>
                    @endif
                </div>

                <div class="card-body p-4">
                    {{-- Display Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 p-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="post" action="/add_new_end_user">
                        @csrf

                        {{-- Organization Selection (if type is host) --}}
                        @if($org->type == 'host')
                            <div class="mb-3">
                                <label class="form-label fw-bold">Organization</label>
                                <select class="form-select rounded-3 shadow-sm" name="org_id">
                                    <option value="">Select Organization</option>
                                    @foreach ($allorgs as $allorg)
                                        <option value="{{ $allorg->id }}" {{ old('org_id') == $allorg->id ? 'selected' : '' }}>
                                            {{ $allorg->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        @if($org->type == 'guest')
                            <input type="hidden" name="org_id" value="{{ $org->id }}">
                        @endif

                        {{-- Name Fields --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">First Name *</label>
                                <input type="text" class="form-control rounded-3 shadow-sm" name="first_name" value="{{ old('first_name') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Last Name *</label>
                                <input type="text" class="form-control rounded-3 shadow-sm" name="last_name" value="{{ old('last_name') }}">
                            </div>
                        </div>

                        {{-- Department --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Department</label>
                            <select class="form-select rounded-3 shadow-sm" name="department_id">
                                <option value="">Select Department (Optional)</option>
                                @foreach ($departments as $d)
                                    <option value="{{ $d->id }}" {{ old('department_id') == $d->id ? 'selected' : '' }}>
                                        {{ $d->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- National ID --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">National ID </label>
                            <input type="text" class="form-control rounded-3 shadow-sm" name="national_id" value="{{ old('national_id') }}">
                        </div>

                        {{-- Email & Telephone --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email *</label>
                                <input type="email" class="form-control rounded-3 shadow-sm" name="email" value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Telephone</label>
                                <input type="text" class="form-control rounded-3 shadow-sm" name="telephone" value="{{ old('telephone') }}">
                            </div>
                        </div>

                        {{-- Address Fields --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <input type="text" class="form-control rounded-3 shadow-sm" name="address" value="{{ old('address') }}">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">City</label>
                                <input type="text" class="form-control rounded-3 shadow-sm" name="city" value="{{ old('city') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">State</label>
                                <input type="text" class="form-control rounded-3 shadow-sm" name="state" value="{{ old('state') }}">
                            </div>
                        </div>

                        {{-- Country & Zip Code --}}
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Country</label>
                                <input type="text" class="form-control rounded-3 shadow-sm" name="country" value="{{ old('country') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Zip Code</label>
                                <input type="text" class="form-control rounded-3 shadow-sm" name="zip_code" value="{{ old('zip_code') }}">
                            </div>
                        </div>

                        {{-- Roles --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Roles </label>
                            <br>
                            @foreach ($permissions as $p)
                                @if($p->name == 'Project Creator')
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $p->name }}">
                                        <label class="form-check-label">{{ $p->name }}</label>
                                    </div>
                                @endif
                            @endforeach

                            <small class="text-warning fw-bold d-block mt-2">
                                <i class="fas fa-exclamation-triangle"></i> If the checkbox is not selected, the user will not have the rights to create any project, but project-level rights can be assigned if the user is added to a project.
                            </small>
                        </div>

                        {{-- Password --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Password *</label>
                            <input type="password" class="form-control rounded-3 shadow-sm" name="password" value="{{ old('password') }}">
                        </div>

                        <input type="hidden" name="privilege_id" value="5">
                        <input type="hidden" name="2FA" value="N">

                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status *</label>
                            <select class="form-select rounded-3 shadow-sm" name="status">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        {{-- Submit Button --}}
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary btn-lg px-5 py-2 rounded-3 shadow">
                                <i class="fas fa-user-plus"></i> Add End User
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





</div>



@section('scripts')


@endsection





@endsection


