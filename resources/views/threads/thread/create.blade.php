@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="  ">
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
            

                <label for="name" class="form-label">Upload picture</label>
                
                
                <input type="file" name="threads_image" id="threads_image" class="form-control" type="file" accept="image/*"></input>
            </div>

            <button type="submit" class="btn btn-primary">Create Thread</button>
        </form>
    </div>
</div>
@endsection