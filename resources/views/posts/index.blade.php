<x-app-layout>
    <h1 class="font-bold text-xl mb-4">Liste des Posts</h1>

    <div x-data="data()">
        <!-- Onglets -->
        <div class="flex mb-4">
            <button class="px-4 py-2 text-gray-700 border-b-2" :class="{ 'border-blue-500': tab === 'following' }"
                @click="tab = 'following'">Abonnements</button>
            <button class="px-4 py-2 text-gray-700 border-b-2" :class="{ 'border-blue-500': tab === 'popular' }"
                @click="tab = 'popular'">Populaires</button>
        </div>

        <!-- Contenu des Onglets -->
        <div x-show="tab === 'following'">
            <!-- Posts des abonnements -->
            <ul class="grid sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-8">
                @foreach ($followingPosts as $post)
                    <li>
                        <x-posts-card :post="$post" />
                    </li>
                @endforeach
            </ul>
        </div>
        <div x-show="tab === 'popular'">
            <!-- Posts populaires -->
            <ul class="grid sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-8">
                @foreach ($popularPosts as $post)
                    <li>
                        <x-posts-card :post="$post" />
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <script>
        function data() {
            return {
                tab: 'following', // Onglet par défaut
            };
        }
    </script>

</x-app-layout>
