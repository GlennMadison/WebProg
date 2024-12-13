@extends('layouts.app')

@section('content')
<div class="container">

    <div class="list-group my-4 shadow-sm">

        @foreach ($threads as $thread)
        <div class="list-group-item p-4  list-group-item-action" role="link" tabindex="0"
            onclick="window.location='{{ route('threads.thread.show', $thread) }}'">

            @include('profile.profileBanner', ['object' => $thread])
            <h5 class="mb-1">
                <strong id="thread-title-{{ $thread->id }}" data-full-content="{{ $thread->title }}">
                    {{ ($thread->title) }}
                </strong>
            </h5>
            <div>
                <p id="thread-body-{{ $thread->id }}" data-full-content="{{ $thread->body }}">
                    {{ Str::limit($thread->body, 250) }} 
                    @if(strlen($thread->body) > 250)
                    <a href="javascript:void(0)" id="toggle-more-{{ $thread->id }}" onclick="toggleContent({{ $thread->id }})">
                        @lang('messages.show_more')
                    </a>       
                    @endif
                </p>
                <a href="javascript:void(0)" id="translate-link-{{ $thread->id }}" onclick="translateThreadBody({{ $thread->id }})" class="text-primary">
                    @lang('messages.translate')
                </a>
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
        threadBody.innerHTML = fullContent + ' <a href="javascript:void(0)" id="toggle-more-' + threadId + '" onclick="toggleContent(' + threadId + ')">@lang('messages.show_less')</a>';
    } else {    
        threadBody.innerHTML = fullContent.substring(0, 200) + ' <a href="javascript:void(0)" id="toggle-more-' + threadId + '" onclick="toggleContent(' + threadId + ')">@lang('messages.show_more')</a>';
    }
}

async function translateThreadBody(threadId) {
    event.stopPropagation();

    const threadTitleElement = document.getElementById(`thread-title-${threadId}`);
    const threadBodyElement = document.getElementById(`thread-body-${threadId}`);
    const translateLinkElement = document.getElementById(`translate-link-${threadId}`);

    if (!translateLinkElement || !threadTitleElement || !threadBodyElement) {
        console.error('Translate link element not found.');
        return;
    }

    const originalBody = threadBodyElement.dataset.fullContent;
    const originalTitle = threadTitleElement.dataset.fullContent;
    var targetLocale = '{{ app()->getLocale() }}';  // set locale as target lang

    // naming convention, thought 'jp' was common but seems like ISO uses 'ja'
    if(targetLocale == 'jp'){
        targetLocale = 'ja';
    }
    
    console.log('Original Title:', originalTitle); // check the title being sent
    console.log('Original Text:', originalBody); // check the text being sent
    console.log('Target Locale:', targetLocale); // check target lang

    if (translateLinkElement.innerText === '{{ __('messages.translate') }}') {
        try {
            // set the API url and params
            const endpoint = '{{ config('services.azure_translator.endpoint') }}';
            const location = '{{ config('services.azure_translator.region') }}';
            const path = '/translate';
            const constructedUrl = endpoint + path;
            
            const params = {
                'api-version': '3.0',
                // 'from': 'en', // not required, uses auto detect
                'to': [targetLocale]
            };
            
            const headers = {
                'Ocp-Apim-Subscription-Key': '{{ config('services.azure_translator.key') }}',
                'Ocp-Apim-Subscription-Region': location,
                'Content-Type': 'application/json',
                'X-ClientTraceId': String(Math.floor(Math.random() * 1000000)) // untuk tracking aja buat debug & monitor
            };

            const body = [
                { 'text': originalTitle },
                { 'text': originalBody }
            ];
            
            // send POST req to azure translator API
            const response = await fetch(constructedUrl + '?' + new URLSearchParams(params), {
                method: 'POST',
                headers: headers,
                body: JSON.stringify(body)
            });

            // check if we get good response
            if (!response.ok) {
                console.error(`Error: ${response.status} - ${response.statusText}`);
                alert('Translation request failed.');
                return;
            }

            // parse response and update the thread content
            const data = await response.json();
            const translatedTitle = data[0]?.translations[0]?.text || originalTitle;
            const translatedBody = data[1]?.translations[0]?.text || originalBody;

            threadTitleElement.innerHTML = translatedTitle;
            threadBodyElement.innerHTML = translatedBody;
            translateLinkElement.innerText ='{{__('messages.show_original')}}';
        } catch (error) {
            console.error('Translation error:', error);
            alert('Failed to translate the text.');
        }
    } else {
        threadTitleElement.innerHTML = originalTitle;
        threadBodyElement.innerHTML = originalBody;
        translateLinkElement.innerText ='{{__('messages.translate')}}';
    }
}


/*
this one below works too using lectoAI, but i've hit the limit for free use, you can make
a new account and just change the key at .env
*/

// function translateThreadBody(threadId) {
//     event.stopPropagation();
//     const threadBody = document.getElementById(`thread-body-${threadId}`);
    
//     // Check if the thread body has the full content
//     const originalContent = threadBody ? threadBody.dataset.fullContent : null;

//     if (!originalContent) {
//         alert('No content available for translation.');
//         return;
//     }

//     const escapedContent = originalContent.replace(/[\r\n]+/g, ' ').replace(/["']/g, "\\$&");

//     const locale = '{{ app()->getLocale() }}'; 

//     const localeMap = {
//         'id': 'id',
//         'jp': 'ja'
//     };

//     const targetLang = localeMap[locale] || 'en';

//     console.log('Original Content:', escapedContent); // Log the escaped content
//     console.log('Target Language:', targetLang);

//     fetch('https://api.lecto.ai/v1/translate/json', {
//         method: 'POST',
//         headers: {
//             'X-API-Key': 'NK45NEB-VKS43TQ-HEWZEVV-XVCYMBK',
//             'Content-Type': 'application/json',
//             'Accept': 'application/json'
//         },
//         body: JSON.stringify({
//             to: [targetLang],
//             from: 'id',
//             protected_keys: [],
//             json: JSON.stringify({
//                 "thread": {
//                     "body": escapedContent
//                 }
//             })
//         })
//     })
//     .then(response => {
//         console.log('Response Status:', response.status);
//         return response.json();
//     })
//     .then(data => {
//         console.log('API Response:', data);
        
//         if (data.translations && data.translations.length > 0) {
//             const translatedText = JSON.parse(data.translations[0].translated[0]).thread.body;
//             threadBody.dataset.fullContent = translatedText;
//             threadBody.innerHTML = (translatedText.length > 250 
//                 ? translatedText.substring(0, 250) 
//                 : translatedText) + 
//                 (translatedText.length > 250 
//                     ? ' <a href="javascript:void(0)" id="toggle-more-' + threadId + '" onclick="toggleContent(' + threadId + ')">{{ __('messages.show_more') }}</a>'
//                     : '');
//         } else {
//             throw new Error('No translations found');
//         }
//     })
//     .catch(error => {
//         console.error('Full Translation Error:', error);
//         alert('Translation failed. Please check the console for details.');
//     });
// }

</script>