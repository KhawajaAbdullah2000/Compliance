@extends('master')

@section('content')

@include('user-nav')

<div class="container">

    <h3 class="mt-4">Documents Repo for {{$organizationData->name}}</h3>

    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-4">
                <form action="/org_doc_repo_submit/{{auth()->user()->organization->id}}" method="POST" enctype="multipart/form-data" class="p-3 border rounded bg-light">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}">
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="source" class="form-label">Source</label>
                        <select class="form-control" name="source" id="source">
                            <option value="Regulatory">Regulatory</option>
                            <option value="Business Partner">Business Partner</option>
                            <option value="Other">Other</option>
                        </select>
                        @error('source')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-control" name="type" id="type">
                            <option value="Internal">Internal</option>
                            <option value="External">External</option>
                        </select>
                        @error('type')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="attachment" class="form-label">Attachment (optional)</label>
                        <input class="form-control" type="file" name="attachment" id="attachment">
                        <small class="text-muted">Allowed: pdf, docx, xlsx, jpg, png (max 10MB)</small>
                        @error('attachment')<small class="text-danger d-block">{{ $message }}</small>@enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Source</th>
                                <th>Uploaded</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($org_documents as $i => $doc)
                            @php
                            $url = asset('storage/'.$doc->path); // e.g. /storage/org_documents_repo/....
                            $ext = strtolower(pathinfo($doc->path, PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                            $isPdf = $ext === 'pdf';
                            $isOffice = in_array($ext, ['doc','docx','xls','xlsx','ppt','pptx']);
                            @endphp
                            <tr>
                                <td>{{ $i + 1 }}</td>
                                <td class="fw-semibold">
                                    {{ $doc->name }}
                                    <span class="badge text-bg-secondary ms-2">{{ strtoupper($ext) }}</span>
                                </td>
                                <td><span class="badge text-bg-info-subtle border">{{ $doc->type ?? '—' }}</span></td>
                                <td><span class="badge text-bg-light border">{{ $doc->source ?? '—' }}</span></td>
                                <td>
                                    {{ \Carbon\Carbon::parse($doc->created_at)->format('d M Y, h:i A') }}
                                </td>
                                <td class="text-nowrap">

                                    {{-- View / Preview --}}
                                    @if($isImage)
                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#imgModal-{{ $doc->id }}">
                                        Preview
                                    </button>

                                    <!-- Image Modal -->
                                    <div class="modal fade" id="imgModal-{{ $doc->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ $doc->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ $url }}" alt="{{ $doc->name }}" class="img-fluid rounded">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($isPdf)
                                    <a class="btn btn-sm btn-outline-primary" href="{{ $url }}" target="_blank" rel="noopener">
                                        View PDF
                                    </a>
                                    @elseif($isOffice)
                                    {{-- Office docs: offer download + (optional) online viewer link --}}
                                    <a class="btn btn-sm btn-outline-primary" href="{{ $url }}" download>
                                        Download
                                    </a>

                                    @else
                                    <a class="btn btn-sm btn-outline-primary" href="{{ $url }}" download>
                                        Download
                                    </a>
                                    @endif

                                    {{-- Always: open in new tab --}}
                                    <a class="btn btn-sm btn-outline-secondary" href="{{ $url }}" target="_blank" rel="noopener">
                                        Open
                                    </a>

                                 

                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete({{ $doc->id }})">
                                        Delete
                                    </button>

                                    <form id="delete-form-{{ $doc->id }}" action="{{ url('/delete_org_doc_repo/'.$doc->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No documents yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



</div>


@section('scripts')

@if(Session::has('success'))
<script>
    swal({
        title: "{{ Session::get('success') }}"
        , icon: "success"
        , closeOnClickOutside: true
        , timer: 3000
    , });

</script>

@endif



@if (Session::has('error'))
<script>
    swal({
        title: "{{ Session::get('error') }}"
        , icon: "error"
        , closeOnClickOutside: true
        , timer: 6000
    , });

</script>
@endif

<script>
function confirmDelete(id) {
    swal({
        title: "Are you sure?",
        text: "This will permanently delete the document.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}
</script>


@endsection
@endsection
