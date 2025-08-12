@extends('master')

@section('content')
@include('user-nav')

@php
  $total = $org_documents->count();
  $types = $org_documents->pluck('type')->filter()->unique()->values();
  $sources = $org_documents->pluck('source')->filter()->unique()->values();

  $iconMap = [
    'pdf'  => 'bi-file-earmark-pdf',
    'doc'  => 'bi-file-earmark-word',
    'docx' => 'bi-file-earmark-word',
    'xls'  => 'bi-file-earmark-excel',
    'xlsx' => 'bi-file-earmark-excel',
    'ppt'  => 'bi-file-earmark-ppt',
    'pptx' => 'bi-file-earmark-ppt',
    'jpg'  => 'bi-file-earmark-image',
    'jpeg' => 'bi-file-earmark-image',
    'png'  => 'bi-file-earmark-image',
    'gif'  => 'bi-file-earmark-image',
    'webp' => 'bi-file-earmark-image',
    'txt'  => 'bi-file-earmark-text',
  ];
@endphp



<div class="container py-4">

  <div class="page-head mb-3">
    <div>
      <h3 class="mb-1">Documents Repository</h3>
      <div class="muted">for {{ $organizationData->name }}</div>
    </div>
    <div class="">
      Total documents: <span class="fw-bold fs-4">{{ $total }}</span>
    </div>
  </div>

  <div class="row g-4">
    {{-- LEFT: Table + Filters --}}
    <div class="col-lg-8">
      <div class="card card-soft">
        <div class="card-body">
          {{-- Filters --}}
          <div class="row g-2 align-items-end mb-3">
            <div class="col-md-4">
              <label class="form-label mb-1">Search</label>
              <input type="text" id="repoSearch" class="form-control" placeholder="Search by name, type, or source">
            </div>
            <div class="col-md-3">
              <label class="form-label mb-1">Type</label>
              <select id="filterType" class="form-select">
                <option value="">All</option>
                @foreach($types as $t)
                  <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label mb-1">Source</label>
              <select id="filterSource" class="form-select">
                <option value="">All</option>
                @foreach($sources as $s)
                  <option value="{{ $s }}">{{ $s }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-md-1 text-md-end">
              <button class="btn btn-light w-100" id="clearFilters" title="Clear">
                <i class="bi bi-x-circle-fill"></i>
              </button>
            </div>
          </div>

          {{-- Table --}}
          <div class="table-responsive">
            <table class="table table_doc_repo table-hover align-middle mb-0" id="repoTable">
              <thead class="table-light">
                <tr>
                  <th style="width:56px;">#</th>
                  <th>Name</th>
                  <th>Type</th>
                  <th>Source</th>
                  <th>Uploaded</th>
                  <th style="width:260px;">Actions</th>
                </tr>
              </thead>
              <tbody>
              @forelse($org_documents as $i => $doc)
                @php
                  $url = asset('storage/'.$doc->path);
                  $ext = strtolower(pathinfo($doc->path, PATHINFO_EXTENSION));
                  $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                  $isPdf = $ext === 'pdf';
                  $isOffice = in_array($ext, ['doc','docx','xls','xlsx','ppt','pptx']);
                  $icon = $iconMap[$ext] ?? 'bi-file-earmark';
                @endphp
                <tr class="file-row"
                    data-name="{{ Str::lower($doc->name) }}"
                    data-type="{{ Str::lower($doc->type ?? '') }}"
                    data-source="{{ Str::lower($doc->source ?? '') }}">
                  <td class="text-muted">{{ $i + 1 }}</td>
                  <td class="fw-semibold">
                    <i class="bi {{ $icon }} me-2"></i>{{ $doc->name }}
                    <span class="badge badge-soft file-ext ms-2 text-dark">{{ strtoupper($ext) }}</span>
                  </td>
                  <td>
                    <span class="badge bg-info-subtle text-dark border">{{ $doc->type ?? '—' }}</span>
                  </td>
                  <td>
                    <span class="badge bg-light text-dark border">{{ $doc->source ?? '—' }}</span>
                  </td>
                  <td class="text-nowrap text-muted">
                    {{ \Carbon\Carbon::parse($doc->created_at)->format('d M Y, h:i A') }}
                  </td>
                  <td class="text-nowrap">

                    {{-- View / Preview --}}
                    @if($isImage)
                      <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#imgModal-{{ $doc->id }}">
                        <i class="bi bi-eye"></i> Preview
                      </button>

                      {{-- Image Modal --}}
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
                      <a class="btn btn-sm btn-outline-primary me-1" href="{{ $url }}" target="_blank" rel="noopener">
                        <i class="bi bi-file-earmark-pdf"></i> View PDF
                      </a>
                    @elseif($isOffice)
                      <a class="btn btn-sm btn-outline-primary me-1" href="{{ $url }}" download>
                        <i class="bi bi-download"></i> Download
                      </a>
                      {{-- Optional online viewer:
                      <a class="btn btn-sm btn-outline-secondary me-1" href="https://view.officeapps.live.com/op/view.aspx?src={{ urlencode($url) }}" target="_blank" rel="noopener">
                        Open Online
                      </a> --}}
                    @else
                      <a class="btn btn-sm btn-outline-primary me-1" href="{{ $url }}" download>
                        <i class="bi bi-download"></i> Download
                      </a>
                    @endif

                    <a class="btn btn-sm btn-outline-secondary me-1" href="{{ $url }}" target="_blank" rel="noopener">
                      <i class="bi bi-box-arrow-up-right"></i> Open
                    </a>

                    <button type="button" class="btn btn-sm btn-outline-danger"
                            onclick="confirmDelete({{ $doc->id }})">
                      <i class="bi bi-trash"></i> Delete
                    </button>

                    <form id="delete-form-{{ $doc->id }}" action="{{ url('/delete_org_doc_repo/'.$doc->id) }}" method="POST" style="display:none;">
                      @csrf
                      @method('DELETE')
                    </form>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" class="text-center text-muted py-5">
                    <i class="bi bi-folder2-open fs-3 d-block mb-2"></i>
                    No documents yet — upload your first file using the form on the right.
                  </td>
                </tr>
              @endforelse
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    {{-- RIGHT: Upload Form --}}
    <div class="col-lg-4">
      <div class="card card-soft">
        <div class="card-body">
          <h5 class="mb-1">Add Document</h5>
          <div class="muted small mb-3">Upload a file and tag it for easy discovery</div>

          <form action="/org_doc_repo_submit/{{ auth()->user()->organization->id }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
              <label for="name" class="form-label">Display Name</label>
              <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" placeholder="e.g., Vendor Agreement Q3">
              @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="row g-2">
              <div class="col-6">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" name="type" id="type">
                  <option value="Internal">Internal</option>
                  <option value="External">External</option>
                </select>
                @error('type')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
              <div class="col-6">
                <label for="source" class="form-label">Source</label>
                <select class="form-select" name="source" id="source">
                  <option value="Regulatory">Regulatory</option>
                  <option value="Business Partner">Business Partner</option>
                  <option value="Other">Other</option>
                </select>
                @error('source')<small class="text-danger">{{ $message }}</small>@enderror
              </div>
            </div>

            <div class="mb-3 mt-2">
              <label for="attachment" class="form-label">File</label>
              <input class="form-control" type="file" name="attachment" id="attachment">
              <div class="drop-hint mt-1">Allowed: pdf, docx, xlsx, jpg, png (max 10MB)</div>
              @error('attachment')<small class="text-danger d-block">{{ $message }}</small>@enderror
            </div>

            <button type="submit" class="btn btn-gradient w-100">
              <i class="bi bi-upload me-1"></i> Upload
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@section('scripts')
@if(Session::has('success'))
 <script>
    swal({
        title: "{{ Session::get('success') }}",
        icon: "success",
        closeOnClickOutside: true,
        timer: 3000,
    });
  </script>
@endif
@if(Session::has('error'))
  <script>
   swal({
        title: "{{ Session::get('error') }}",
        icon: "error",
        closeOnClickOutside: true,
        timer: 3000,
    });
  </script>
@endif

{{-- SweetAlert v1 delete confirm (uses hidden forms) --}}
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

{{-- Client-side filters --}}
<script>
(function(){
  const search  = document.getElementById('repoSearch');
  const typeSel = document.getElementById('filterType');
  const srcSel  = document.getElementById('filterSource');
  const clear   = document.getElementById('clearFilters');
  const rows    = document.querySelectorAll('#repoTable tbody tr.file-row');

  function applyFilters(){
    const q = (search.value || '').trim().toLowerCase();
    const t = (typeSel.value || '').toLowerCase();
    const s = (srcSel.value  || '').toLowerCase();

    rows.forEach(r => {
      const name   = (r.dataset.name   || '');
      const type   = (r.dataset.type   || '');
      const source = (r.dataset.source || '');

      const matchQ = !q || name.includes(q) || type.includes(q) || source.includes(q);
      const matchT = !t || type === t;
      const matchS = !s || source === s;

      r.style.display = (matchQ && matchT && matchS) ? '' : 'none';
    });
  }

  if (search)  search.addEventListener('input', applyFilters);
  if (typeSel) typeSel.addEventListener('change', applyFilters);
  if (srcSel)  srcSel.addEventListener('change', applyFilters);
  if (clear)   clear.addEventListener('click', () => {
    if (search)  search.value = '';
    if (typeSel) typeSel.value = '';
    if (srcSel)  srcSel.value = '';
    applyFilters();
  });
})();
</script>

@endsection
@endsection
