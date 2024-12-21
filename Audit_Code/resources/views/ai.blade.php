@extends('master')

<div class="container mt-5">
    <h1 class="text-center">Ask your query</h1>
    <form method="POST" action="/ai">
        @csrf
        <div class="mb-3">
            <label for="question" class="form-label">Enter your question:</label>
            <input type="text" class="form-control" id="question" name="question" value="{{ old('question', $question ?? '') }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Ask</button>
    </form>
    @if (isset($response))
        <div class="mt-4 p-4 border bg-light">
            <h5>Response:</h5>
            <p>{{ $response }}</p>
        </div>
    @endif
</div>


@section('scripts')


@endsection
