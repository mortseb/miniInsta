<x-guest-layout>
    <h1 class="font-bold text-xl mb-4">{{ $posts->title }}</h1>
    <div class="mb-4 text-xs text-gray-500">
        {{ $posts->published_at }}
    </div>
    <div>
        {!! \nl2br($posts->body) !!}
    </div>
</x-guest-layout>
