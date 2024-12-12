@extends('layouts.app')

@section('content')
<div class="container">

    <div class="list-group my-4 shadow-sm">

        @foreach ($threads as $thread)
        <div class="list-group-item p-4  list-group-item-action" role="link" tabindex="0"
            onclick="window.location='{{ route('threads.thread.show', $thread) }}'">

            @include('profile.profileBanner', ['object' => $thread])
            <h5 class="mb-1">
                <strong>{{ $thread->title }}</strong>
            </h5>
            <div>
                <p id="thread-body-{{ $thread->id }}" data-full-content="{{ $thread->body }}">
                    {{ Str::limit($thread->body, 250) }} 
                    @if(strlen($thread->body) > 250)
                    <a href="javascript:void(0)" id="toggle-more-{{ $thread->id }}" onclick="toggleContent({{ $thread->id }})">
                        {{ __('messages.show_more') }}
                    </a>       
                    @endif
                </p>
            </div>
            @if($thread->threads_image)
            <img class="rounded img-fluid my-2" src="{{ $thread->threads_image }}" alt="Thread Image"
                style="max-width: 20vw; height: auto;">
            @endif

            <div class="d-flex align-items-center my-2">
                <form action="{{ route('vote', ['type' => 'thread', 'id' => $thread->id]) }}" method="POST">
                    @csrf
                    @if(Auth::check())
                    <button type="submit" name="vote_type" value="upvote" class="btn btn-primary p-2 ">
                        <i class="bi bi-caret-up-fill"></i>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-primary p-2 " id="show-more">
                        <i class="bi bi-caret-up-fill"></i>
                    </a>
                    @endif
                </form>

                <p class="mx-2 mb-0 ">{{ $thread->upvoteCount() - $thread->downvoteCount() }}</p>

                <form action="{{ route('vote', ['type' => 'thread', 'id' => $thread->id]) }}" method="POST">
                    @csrf
                    @if(Auth::check())
                    <button type="submit" name="vote_type" value="downvote" class="btn btn-primary p-2">
                        <i class="bi bi-caret-down-fill"></i>
                    </button>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-primary p-2">
                        <i class="bi bi-caret-down-fill"></i>
                    </a>
                    @endif
                </form>
            </div>
        </div>
        @endforeach

    </div>

    <div class="mt-4 d-flex">
        <div class="ms-auto">
            {{ $threads->links() }}
        </div>
    </div>
</div>
@endsection

<script>
function toggleContent(threadId) {
    event.stopPropagation();
    const threadBody = document.getElementById(`thread-body-${threadId}`);
    const toggleLink = document.getElementById(`toggle-more-${threadId}`);
    const fullContent = threadBody.dataset.fullContent;
    
    if (toggleLink.innerText === '{{ __('messages.show_more') }}') {
        threadBody.innerHTML = fullContent + ' <a href="javascript:void(0)" id="toggle-more-' + threadId + '" onclick="toggleContent(' + threadId + ')">{{ __('messages.show_less') }}</a>';
    } else {    
        threadBody.innerHTML = fullContent.substring(0, 200) + ' <a href="javascript:void(0)" id="toggle-more-' + threadId + '" onclick="toggleContent(' + threadId + ')">{{ __('messages.show_more') }}</a>';
    }
}
</script>