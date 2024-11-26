@extends('layouts.app')


@section('content')
<div class="container ">
    <div class="card my-4">
        <div class="card-body">
            <h1 class="card-title">{{ $thread->title }}</h1>

            <p class="text-muted mb-2">By
                @if($thread->user->role == 'doctor')
                <span class="badge bg-primary">Doctor</span>
                @endif
                {{ $thread->user->name }} | {{ $thread->created_at->diffForHumans() }}
            </p>
            <p>{{ $thread->body }}</p>
        </div>
    </div>

    <hr>
    <h2 class="my-4">Comments</h2>
    <ul class="list-group">
        @foreach ($thread->comments as $comment)
        <li class="list-group-item ">
            <div class="m-2">
                <p>{{ $comment->body }}</p>
                <p class="text-muted mb-2">By
                    @if($comment->user->role == 'doctor')
                    <span class="badge bg-primary">Doctor</span>
                    @endif
                    {{ $comment->user->name }} | {{ $comment->created_at->diffForHumans() }}
                </p>
            </div>
            <div class="px-2 py-1">
                @if ($comment->childComments->isNotEmpty())
                <ul class="list-group ">
                    @foreach ($comment->childComments as $child)
                    <li class="list-group-item ">
                        <p>{{ $child->body }}</p>
                        <p class="text-muted ">By
                            @if($child->user->role == 'doctor')
                            <span class="badge bg-primary">Doctor</span>
                            @endif
                            {{ $child->user->name }} | {{ $child->created_at->diffForHumans() }}
                        </p>
                    </li>
                    @endforeach
                </ul>
                @endif
    
    
                <div id="reply-form-{{ $comment->id }}" class="div mt-2 " style="display: none;">
                    <form action="{{ route('comments.store', $thread) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <textarea name="body" class="form-control" placeholder="Write a comment..." required></textarea>
                        </div>
                        <input type="hidden" name="parent_comment_id" value="{{ $comment->id }}">
                        <button type="submit" class="btn btn-primary">Reply</button>
                    </form>
                </div>
    
                <div class="d-flex justify-content-end mt-2">
                    <button class="btn btn-primary" onclick="toggleReplyForm({{ $comment->id }})">Reply</button>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
    <hr>

    <h3 class="my-4">Post a Comment</h3>
    <form action="{{ route('comments.store', $thread) }}" method="POST">
        @csrf
        <div class="mb-3">
            <textarea name="body" class="form-control" placeholder="Write a comment..." required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Post Comment</button>
    </form>



</div>
<script>
    function toggleReplyForm(commentId) {
            var form = document.getElementById('reply-form-' + commentId);
            
            if (form.style.display === 'none' || form.style.display === '') {
                form.style.display = 'block'; 
            } else {
                form.style.display = 'none'; 
            }
        }
</script>

@endsection