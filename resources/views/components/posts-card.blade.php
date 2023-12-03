<div>
    <a class="flex flex-col h-full space-y-4 bg-white rounded-md shadow-md p-5 w-full hover:shadow-lg hover:scale-105 transition"
        href="{{ route('posts.show', $post) }}">

        <!-- Ajout de l'avatar et du nom de l'utilisateur -->
        <div class="flex items-center space-x-3">
            <img src="{{ asset('/storage/' . $post->user->avatar_path) }}" alt="Avatar" class="rounded-full w-8 h-8">
            <span class="font-semibold">{{ $post->user->name }}</span>
        </div>

        <img class="text-gray-700" src="{{ asset('/storage/' . $post->img_path) }}">
        <div class="uppercase font-bold text-gray-800">
            {{ $post->title }}
        </div>
        <div class="flex-grow text-gray-700 text-sm text-justify">
            {{ Str::limit($post->body, 120) }}
        </div>
        <div class="text-xs text-gray-500">
            {{ $post->published_at }}
        </div>
        <div class="flex items-center space-x-2">
            <x-heroicon-o-heart class="h-5 w-5 text-red-500" />
            <div class="text-sm text-gray-500">{{ $post->likes_count }}</div>
        </div>
        <div class="flex items-center space-x-2">
            <x-heroicon-o-chat-bubble-bottom-center-text class="h-5 w-5 text-gray-500" />
            <div class="text-sm text-gray-500">{{ $post->comments_count }}</div>
        </div>
    </a>
</div>
