<x-app-layout>
    <div class="flex w-full">
        <x-avatar class="h-20 w-20" :user="$user" />
        <div class="ml-4 flex flex-col">
            <div class="text-gray-800 font-bold">{{ $user->name }}</div>
            <div class="text-gray-700 text-sm">{{ $user->email }}</div>
            <div class="text-gray-500 text-xs">
                Membre depuis {{ $user->created_at->diffForHumans() }}
            </div>
        </div>
    </div>
    @if (auth()->user() &&
            !auth()->user()->following->contains('followed_user_id', $user->id))
        <form action="{{ route('users.follow', $user) }}" method="POST">
            @csrf
            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>

            </button>
        </form>
    @else
        <form action="{{ route('users.unfollow', $user) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>

            </button>
        </form>
    @endif


    <div class="mt-8">
        <h2 class="font-bold text-xl mb-4">Posts</h2>
        <ul class="grid sm:grid-cols-2 gap-8">
            @forelse ($posts as $post)
                <li>
                    <x-posts-card :post="$post" />
                </li>
            @empty
                <div class="text-gray-700">Aucun post</div>
            @endforelse
        </ul>
    </div>

    <div class="mt-8">
        <h2 class="font-bold text-xl mb-4">Commentaires</h2>

        <div class="flex-col space-y-4">
            @forelse ($comments as $comment)
                <div class="flex bg-white rounded-md shadow p-4 space-x-4">
                    <div class="flex justify-start items-start h-full">
                        <x-avatar class="h-10 w-10" :user="$comment->user" />
                    </div>
                    <div class="flex flex-col justify-center w-full space-y-4">
                        <div class="flex justify-between">
                            <div class="flex space-x-4 items-center justify-center">
                                <div class="flex flex-col justify-center">
                                    <div class="text-gray-700">{{ $comment->user->name }}</div>
                                    <div class="text-gray-500 text-sm">
                                        {{ $comment->created_at->diffForHumans() }}
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
            @endforelse
        </div>
        <x-modal name="confirm-comment-deletion" focusable>
            <form method="post"
                onsubmit="event.target.action= '/posts/{{ $post->id ?? 1 }}/comments/' + window.selected"
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
