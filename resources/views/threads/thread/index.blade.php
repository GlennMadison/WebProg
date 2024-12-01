@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Threads</h1>

    <div class="list-group">
        @foreach ($threads as $thread)
        <div class="list-group-item " role="link" tabindex="0"
            onclick="window.location='{{ route('threads.thread.show', $thread) }}'">
            <h5 class="mb-1">
                <strong>{{ $thread->title }}</strong>
            </h5>
            <p class="mb-1">
                <small class="text-muted">By <span>{{ $thread->user->name }}</span> | {{
                    $thread->created_at->diffForHumans() }}</small>
            </p>
            <p class="mb-1">{{ Str::limit($thread->body, 100) }}</p>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $threads->links() }}
        <!-- Pagination links -->
    </div>
</div>
@endsection