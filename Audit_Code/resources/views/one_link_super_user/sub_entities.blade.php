@extends('master')

@section('content')

@include('user-nav')

<div class="container py-5">
    <h3 >Sub-Entities for the Organization : <span class="fw-bold">{{auth()->user()->organization->name}}</span></h3>

    @php
        $grouped = collect($sub_entities)->groupBy('sub_entity_type');
        $types = [
            'products' => 'Products',
            'cycles' => 'Cycles/Processes',
            'sub_processes' => 'Sub-Processes',
        ];
    @endphp

    <div class="text-end">
        <a href="/add_sub_entity/{{auth()->user()->organization->id}}/{{auth()->user()->id}}" class="btn btn-md btn-success mb-2">Add new Sub Entity</a>
    </div>

    @foreach($types as $key => $label)
        @if($grouped->has($key))
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">{{ $label }}</h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0 text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Created By (User ID)</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grouped[$key] as $index => $item)
                            {{-- <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->name }}</td>
                              <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, h:i A') }}</td>
                            </tr> --}}
                            <tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $item->name }}</td>
    <td>{{ $item->first_name }} {{ $item->last_name }}</td>
    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y, h:i A') }}</td>
    <td>
        <a href="{{ route('sub_entity.edit', $item->id) }}" class="btn btn-sm btn-warning me-1">Edit</a>

    <form class="delete-form" data-id="{{ $item->id }}" method="POST" action="{{ route('sub_entity.destroy', $item->id) }}"  style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-sm btn-danger delete-btn">Delete</button>
</form>
    </td>
</tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    @endforeach

</div>

@section('scripts')


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

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const form = this.closest('form');

                swal({
                    title: "Are you sure?",
                    text: "This action will permanently delete the sub-entity.",
                    icon: "warning",
                    buttons: ["Cancel", "Yes, delete it!"],
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

@endsection

@endsection
