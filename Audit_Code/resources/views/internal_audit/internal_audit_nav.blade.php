<nav id="sidebar">
    <div class="p-4 pt-5">
        <ul class="list-unstyled components mb-5">
            <li class="{{ Request::is('internal_audit_level_1/1*') ? 'active' : '' }}">
                <a href="/internal_audit_level_1/1/{{$project->project_id}}/{{auth()->user()->id}}">
                    <p>Internal Audit Strategy</p>
                </a>
            </li>
            <li class="{{ Request::is('internal_audit_level_1/2*') ? 'active' : '' }}">
                <a href="/internal_audit_level_1/2/{{$project->project_id}}/{{auth()->user()->id}}">
                    <p>Risk Based Audit Plan (RBAP)</p>
                </a>
            </li>
            <li class="{{ Request::is('internal_audit_level_1/3*') ? 'active' : '' }}">
                <a href="/internal_audit_level_1/3/{{$project->project_id}}/{{auth()->user()->id}}">
                    <p>Risk Assessment for Internal Audit</p>
                </a>
            </li>
            <li class="{{ Request::is('internal_audit_level_1/4*') ? 'active' : '' }}">
                <a href="/internal_audit_level_1/4/{{$project->project_id}}/{{auth()->user()->id}}">
                    <p>Audit Sampling Policies/Processes</p>
                </a>
            </li>
            <li class="{{ Request::is('internal_audit_level_1/5*') ? 'active' : '' }}">
                <a href="/internal_audit_level_1/5/{{$project->project_id}}/{{auth()->user()->id}}">
                    <p>Audit Results and Reporting</p>
                </a>
            </li>
            <li class="{{ Request::is('internal_audit_level_1/6*') ? 'active' : '' }}">
                <a href="/internal_audit_level_1/6/{{$project->project_id}}/{{auth()->user()->id}}">
                    <p>Follow-up on Recommendations</p>
                </a>
            </li>
            <li class="{{ Request::is('internal_audit_level_1/7*') ? 'active' : '' }}">
                <a href="/internal_audit_level_1/7/{{$project->project_id}}/{{auth()->user()->id}}">
                    <p>Record Keeping & Working Papers</p>
                </a>
            </li>
        </ul>
    </div>
</nav>
