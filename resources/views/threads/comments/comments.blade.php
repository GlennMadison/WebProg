<ul class="list-group bg-light border-0 shadow-sm">
    @foreach ($comments as $comment)

    <li class="list-group-item border-0 bg-light ms-2 ">
        @include('profile.profileBanner', ['object' => $comment])

        <p class="my-3">{{ $comment->body }}</p>
        @include('threads.vote.vote', ['object' => $comment, 'type' => 'comment'])
        
        @if ($comment->childComments->isNotEmpty())
        <ul class="list-group">
            <div class="border-left">

                @include('threads.comments.comments', ['comments' => $comment->childComments])
            </div>
        </ul>
        @endif

    </li>
    @endforeach
    
</ul>
