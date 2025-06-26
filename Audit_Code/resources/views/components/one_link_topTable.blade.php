<table class="table table-bordered table-secondary">
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
            <td>{{ optional(auth()->user()->department)->name ?? 'Not Assigned' }}</td>
        </tr>

    </tbody>
</table>