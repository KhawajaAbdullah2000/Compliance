@extends('master')
@section('content')
<div class="container mt-5">
    <h1 class="text-center">PDF Chatbot</h1>
    
    <!-- File Upload Section -->
    <form method="POST" action="{{ route('upload-pdf') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="pdfFile" class="form-label">Upload PDF:</label>
            <input type="file" class="form-control" id="pdfFile" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload PDF</button>
    </form>

    @if (isset($fileName))
        <div class="mt-4 p-4 border bg-light">
            <h5>Uploaded File:</h5>
            <p>{{ $fileName }}</p>
        </div>
    @elseif (isset($error))
        <div class="mt-4 p-4 border bg-light text-danger">
            <p>{{ $error }}</p>
        </div>
    @endif

    <!-- Question Form Section -->
    <form method="POST" action="{{ route('ask-question') }}" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="question" class="form-label">Ask a Question:</label>
            <input type="text" class="form-control" id="question" name="question" value="{{ old('question', $question ?? '') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Ask</button>
    </form>

    @if (isset($response))
        <div class="mt-4 p-4 border bg-light">
            <h5>Response:</h5>
            <p>{{ $response }}</p>
        </div>
    @elseif (isset($error))
        <div class="mt-4 p-4 border bg-light text-danger">
            <p>{{ $error }}</p>
        </div>
    @endif
</div>
@endsection