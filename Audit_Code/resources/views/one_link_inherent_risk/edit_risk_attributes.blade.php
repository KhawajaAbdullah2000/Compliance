
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

    
<div class="row mb-3">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <!-- Left: Title Box -->
        <div class="p-3 text-white rounded shadow"
             style="background: linear-gradient(135deg, #FF512F, #DD2476);">
            <h5 class="fw-bold mb-0">Risk Identification and Classification</h5>
        </div>

        <!-- Right: Back Button -->
        <a href="{{ route('one_link_inherent_risk_main',[
        'proj_id'=>$project->project_id,
        'user_id'=>auth()->user()->id
        ])}}" class="btn btn-secondary btn-lg">Back</a>
    </div>
</div>

   <table class="table table-bordered table-hover text-center align-middle mt-2">
                        <thead class="table-dark">
                            <tr>
                                <th>Risk Id</th>
                                <th>Date of Risk Identification</th>
                                <th>Date of Risk ReAssessment</th>
                                <th>Department (SBU)</th>
                                <th>Unit</th>
                                <th>Product</th>
                                <th>Cycle</th>
                                <th>Sub-Process</th>
                             
                            </tr>
                        </thead>
                        <tbody>
                         
                                <tr>
                                    <td>R-IPS-{{$record->risk_id}}</td>
                                    <td>{{$record->risk_identification_date}}</td>
                                      <td>{{$record->risk_reassessment_date}}</td>
                                    <td>{{ $record->department_name }}</td>
                                    <td>{{ $record->unit_name }}</td>
                                    <td>{{ $record->product_name }}</td>
                                    <td>{{ $record->cycle_name }}</td>
                                    <td>{{ $record->sub_process_name }}</td>
                            
                                </tr>
                         
                        </tbody>
                    </table>

               

    
        <div class="card">

        <div class="card-body">
            <form action="/update_risk_record/{{$project->project_id}}/{{auth()->user()->organization->id}}/{{auth()->user()->id}}" method="POST">
                @csrf

                <input type="hidden" name="risk_id" value="{{$record->risk_id}}">

       <div class="mb-3">
    <label class="fw-bold" for="catalog_select" class="form-label">Choose from Catalog (optional)</label>
    
    <div class="input-group">
        <div class="input-group-text bg-white">
            <a href="/risk-description-catalog/{{$project->project_id}}" class="text-warning" title="Edit Catalog">
                <i class="fas fa-edit fa-2x"></i>
            </a>
        </div>

        <select id="catalog_select" class="form-select">
            <option value="">-- Select Catalog Entry --</option>
            @foreach($catalogs as $cat)
                <option value="{{ $cat->description }}">{{ $cat->description }}</option>
            @endforeach
        </select>
    </div>
</div>


    <!-- Editable Textarea -->
    <div class="mb-3">
        <label class="fw-bold" for="risk_description" class="form-label">Risk Description</label>
        <textarea name="risk_description" id="risk_description" class="form-control" rows="4" required>{{ old('risk_description', $record->risk_description) }}</textarea>
    </div>


     <div class="mb-3">
            <label class="fw-bold"  for="risk_owner" class="form-label">Risk Owner</label>
            <select name="risk_owner" id="risk_owner" class="form-select" required>
                <option value="">-- Select --</option>

                @php
                    $selectedValue = old('risk_owner', $record->risk_owner);
                @endphp

                @foreach($risk_owners as $owner)
                    <option value="{{ $owner->id }}" {{ $selectedValue === $owner->id ? 'selected' : '' }}>
                        {{ $owner->first_name }} {{$owner->last_name}}
                    </option>
                @endforeach
            </select>
        </div>



        <div class="mb-3">
            <label class="fw-bold" for="erm_risk_classification" class="form-label">ERM Risk Classification</label>
            <select name="erm_risk_classification" id="erm_risk_classification" class="form-select" required>
                <option value="">-- Select ERM Risk Classification --</option>

                @php
                    $classifications = ['None', 'Strategic', 'Financial', 'Compliance', 'Operational'];
                    $selectedValue = old('erm_risk_classification', $record->erm_risk_classification);
                @endphp

                @foreach($classifications as $classification)
                    <option value="{{ $classification }}" {{ $selectedValue === $classification ? 'selected' : '' }}>
                        {{ $classification }}
                    </option>
                @endforeach
            </select>
        </div>


        <div class="mb-3">
    <label class="fw-bold" for="op_loss_event_type_one" class="form-label">Basel II Operational Loss Event Type I</label>
    <select name="op_loss_event_type_one" id="op_loss_event_type_one" class="form-select" required>
        <option value="">-- Select Loss Event Type I --</option>

        @php
            $eventTypes = [
                'N/A',
                'Internal Fraud',
                'External Fraud',
                'Employment Practices & Workplace Safety',
                'Clients, Products & Business Practices',
                'Damage to Physical Assets',
                'Business Disruption & System Failures',
                'Execution, Delivery & Process Management',
            ];
            $selectedEventType = old('op_loss_event_type_one', $record->op_loss_event_type_one);
        @endphp

        @foreach($eventTypes as $type)
            <option value="{{ $type }}" {{ $selectedEventType === $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>
</div>


<div class="mb-3">
    <label class="fw-bold" for="op_loss_event_type_two" class="form-label">Basel II Operational Loss Event Type II</label>
    <select name="op_loss_event_type_two" id="op_loss_event_type_two" class="form-select" required>
        <option value="">-- Select Loss Event Type II --</option>

        @php
            $eventTypesTwo = [
                'None',
                'Unauthorized Activity',
                'Theft & Fraud',
                'Systems Security',
                'Employee Relations',
                'Safe Environment',
                'Diversity & Discrimination',
                'Suitability, Disclosure & Fiduciary',
                'Improper Business or Market Practices',
                'Product Flaws',
                'Selection, Sponsorship & exposure',
                'Advisory Activities',
                'Disaster & Other Events',
            ];
            $selectedEventTypeTwo = old('op_loss_event_type_two', $record->op_loss_event_type_two);
        @endphp

        @foreach($eventTypesTwo as $type)
            <option value="{{ $type }}" {{ $selectedEventTypeTwo === $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>
</div>

                <div class="text-end">
                    <button class="btn btn-success" type="submit">Submit Risk Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="text-end">
    <a href="/initiate_gross_assessment_form/{{$record->risk_id}}/{{$project->project_id}}/{{auth()->user()->id}}" class="btn btn-md mb-2 mt-4 fw-bold text-white" style="background: linear-gradient(135deg, #FF512F, #F09819); transition: 0.3s;">Initiate Gross Risk Assessment</a>
</div>







</div>



        @section('scripts')

        <script>
    document.getElementById('catalog_select').addEventListener('change', function () {
        const selectedValue = this.value;
        if (selectedValue) {
            document.getElementById('risk_description').value = selectedValue;
        }
    });
</script>

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