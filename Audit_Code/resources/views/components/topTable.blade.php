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
        <tr>
            <td class="fw-bold">Compliance Framework:</td>
            <td>{{$project->type}}</td>
            <td class="fw-bold">Information Security Risk Management Methodology:</td>
            <td>{{$complianceFramework->framework_name}} {{$framework_approach->approach_name}} - {{$risk_assessment_approach->global_assessment_approach}} </td>
        </tr>
    </tbody>
</table>