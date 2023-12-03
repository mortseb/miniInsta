<x-app-layout>

    <div class="mb-4 text-xs text-gray-500">
        {{ $posts->published_at }}
    </div>

    <div class="flex items-center justify-center">
        <img src="{{ asset('storage/' . $posts->img_path) }}" alt="illustration du post"
            class="rounded shadow aspect-auto object-cover object-center" />
    </div>

    <div class="mt-4">{!! \nl2br($posts->body) !!}</div>

    <a class="flex mt-8 hover:-translate-y-1 transition
    " href="{{ route('profile.show', $posts->user) }}">
        <x-avatar class="h-20 w-20" :user="$posts->user" />
        <div class="ml-4 flex flex-col justify-center">
            <div class="text-gray-700">{{ $posts->user->name }}</div>
            <div class="text-gray-500">{{ $posts->user->email }}</div>
        </div>
    </a>
    <div class="mt-4">
        @if (auth()->user() &&
                !auth()->user()->likes->contains('posts_id', $posts->id))
            <form action="{{ route('posts.like', $posts) }}" method="POST">
                @csrf
                <button type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>

                </button>
            </form>
        @else
            <form action="{{ route('posts.unlike', $posts) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path
                            d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                    </svg>

                </button>
            </form>
        @endif



    </div>

    <div class="mt-8 flex items-center justify-center">
        <a href="{{ route('posts.index') }}" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow">
            Retour à la liste des posts
        </a>
    </div>

    <div class="mt-8">
        <h2 class="font-bold text-xl mb-4">Commentaires</h2>

        <div class="flex-col space-y-4">
            @forelse ($posts->comments as $comment)
                <div class="flex bg-white rounded-md shadow p-4 space-x-4">
                    <a class="flex justify-start items-start h-full" href="{{ route('profile.show', $comment->user) }}">
                        <x-avatar class="h-10 w-10" :user="$comment->user" />
                    </a>
                    <div class="flex flex-col justify-center w-full space-y-4">
                        <div class="flex justify-between">
                            <div class="flex space-x-4 items-center justify-center">
                                <div class="flex flex-col justify-center">
                                    <a class="text-gray-700" href="{{ route('profile.show', $comment->user) }}">
                                        {{ $comment->user->name }}
                                    </a>
                                    <div class="text-gray-500 text-sm">
                                        {{ $comment->created_at }}
                                    </div>
                                </div>
                            </div>
                            <div class="flex justify-center">
                                @can('delete', $comment)
                                    <button x-data="{ id: {{ $comment->id }} }"
                                        x-on:click.prevent="window.selected = id; $dispatch('open-modal', 'confirm-comment-deletion');"
                                        type="submit" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow">
                                        <x-heroicon-o-trash class="h-5 w-5" />
                                    </button>
                                @endcan
                            </div>
                        </div>
                        <div class="flex flex-col justify-center w-full text-gray-700">
                            <p class="border bg-gray-100 rounded-md p-4">
                                {{ $comment->body }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="flex bg-white rounded-md shadow p-4 space-x-4">
                    Aucun commentaire pour l'instant
                </div>
            @endforelse @auth
            <form action="{{ route('posts.comments.add', $posts) }}" method="POST"
                class="flex bg-white rounded-md shadow p-4">
                @csrf
                <div class="flex justify-start items-start h-full mr-4">
                    <x-avatar class="h-10 w-10" :user="auth()->user()" />
                </div>
                <div class="flex flex-col justify-center w-full">
                    <div class="text-gray-700">{{ auth()->user()->name }}</div>
                    <div class="text-gray-500 text-sm">{{ auth()->user()->email }}</div>
                    <div class="text-gray-700">
                        <textarea name="body" id="body" rows="4" placeholder="Votre commentaire"
                            class="w-full rounded-md shadow-sm border-gray-300 bg-gray-100 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mt-4"></textarea>
                    </div>
                    <div class="text-gray-700 mt-2 flex justify-end">
                        <button type="submit" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow">
                            Ajouter un commentaire
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="flex bg-white rounded-md shadow p-4 text-gray-700 justify-between items-center">
                <span> Vous devez être connecté pour ajouter un commentaire </span>
                <a href="{{ route('login') }}" class="font-bold bg-white text-gray-700 px-4 py-2 rounded shadow-md">Se
                    connecter</a>
            </div>
        @endauth
    </div>
    <x-modal name="confirm-comment-deletion" focusable>
        <form method="post"
            onsubmit="event.target.action= '/posts/{{ $posts->id }}/comments/' + window.selected"
            class="p-6">
            @csrf @method('DELETE')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Êtes-vous sûr de vouloir supprimer ce commentaire ?
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Cette action est irréversible. Toutes les données seront supprimées.
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    Annuler
                </x-secondary-button>

                <x-danger-button class="ml-3" type="submit">
                    Supprimer
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</div>
</x-app-layout>
