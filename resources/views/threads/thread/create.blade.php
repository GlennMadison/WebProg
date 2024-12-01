@extends('layouts.app')

@section('content')
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <div class="card">
        <h1 class="mb-4">Create a New Thread</h1>
        <form action="{{ route('threads.thread.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control" required>
            </div>
    
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                <textarea name="body" id="body" class="form-control" rows="5" required></textarea>
            </div>

            <div class="mb-3">
                <label for="threads_image" class="form-label d-block">Upload Image</label>
                <label class="upload-favicon">
                    <input type="file" name="threads_image" id="threads_image" style="display: none;" accept="image/*">
                    <img src="https://img.icons8.com/?size=100&id=p1PffPicVmnz&format=png&color=000000" alt="Upload" style="cursor: pointer; width: 30px; height: 30px;">
                </label>
            </div>
    
            <button type="submit" class="btn btn-primary">Create Thread</button>
        </form>
    </div>
@endsection
