@extends('master')

@section('content')

@include('user-nav')

@include('iso_sec_nav')

@php
    $permissions = json_decode($project_permissions, true);
    $isDataInputter = in_array('Data Inputter', $permissions ?? []);
@endphp

<div class="container">

    <div class="row mt-5">
        <div class="col-lg-12">
            <table class="table table-bordered table-warning">
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



<h3 class="fw-bold text-center">Add a Custom Control</h3>

  <div class="container mt-5">

    <h3 class="fw-bold text-center">Add Non-Standard Control</h3>

    <form method="POST" action="/save_non_standard_custom_form/{{$project->project_id}}/{{$asset_id}}">
        @csrf

        <input type="hidden" name="project_id" value="{{ $project_id }}">

        {{-- Domain --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Domain</label>
            <select class="form-select" name="domain_num" id="domain_num">
                <option value="">-- Select Existing Domain --</option>
                @foreach($domains as $domain)
                    <option value="{{ $domain->domain_num }}">
                        {{ $domain->domain_num }} - {{ $domain->domain_title }}
                    </option>
                @endforeach
            </select>
            <input type="text" class="form-control mt-2" name="domain_num_new" placeholder="Or enter new Domain Number">
            <input type="text" class="form-control mt-2" name="domain_title" placeholder="Domain Title">
        </div>

        {{-- Subdomain --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Sub-Domain</label>
            <select class="form-select" name="sub_domain_num" id="sub_domain_num">
                <option value="">-- Select Existing Sub-Domain --</option>
                @foreach($subdomains as $sub)
                    <option value="{{ $sub->sub_domain_num }}" data-domain="{{ $sub->domain_num }}">
                        {{ $sub->sub_domain_num }} - {{ $sub->sub_domain_title }}
                    </option>
                @endforeach
            </select>
            <input type="text" class="form-control mt-2" name="sub_domain_num_new" placeholder="Or enter new Sub-Domain Number">
            <input type="text" class="form-control mt-2" name="sub_domain_title" placeholder="Sub-Domain Title">
        </div>

        {{-- Sub-Requirement --}}
        <div class="mb-3">
            <label class="form-label fw-bold">Sub-Requirement</label>
            
            <input type="text" class="form-control mt-2" name="sub_req_num_new" placeholder="Or enter new Sub-Req Number">
            <input type="text" class="form-control mt-2" name="sub_req_title" placeholder="Sub-Req Title">
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
    </form>

</div>





    @section('scripts')

    @if(Session::has('success'))
    <script>
        swal({
            title: "{{Session::get('success')}}"
            , icon: "success"
            , closeOnClickOutside: true
            , timer: 3000
        , });

    </script>
    @endif



    @endsection

    @endsection
