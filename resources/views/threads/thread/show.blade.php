@extends('layouts.app')


@section('content')
<div class="container ">
    <div class="card my-4 p-2 border-0 bg-light shadow-sm">
        <div class="card-body">

            @include('profile.profileBanner', ['object' => $thread])
            <div class="mt-3">
                <h1 class="card-title">{{ $thread->title }}</h1>
                <p>{{ $thread->body }}</p>
                @if($thread->threads_image)
                <img class="rounded img-fluid my-2" src="{{ $thread->threads_image }}" alt="Thread Image" style="max-width: 20vw; height: auto;">
                @endif
            </div>

            @include('threads.vote.vote', ['object' => $thread, 'type' => 'thread'])
            
        </div>
    </div>


    @include('threads.comments.comments' , ['comments' => $thread -> comments])


</div>


@endsection