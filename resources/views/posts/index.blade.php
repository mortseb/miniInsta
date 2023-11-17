<x-guest-layout>
    <h1 class="font-bold text-xl mb-4">Liste des Posts</h1>
    <ul class="grid sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-8">
        @foreach ($posts as $post)
            <li>
                <x-posts-card :post="$post" />
            </li>
        @endforeach
    </ul>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</x-guest-layout>
