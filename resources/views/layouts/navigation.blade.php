<nav x-data="{
    open: false,
    showForm: false,
    searchText: '',
    searchResults: [],
    search() {
        if (this.searchText === '') {
            this.searchResults = [];
            return;
        }

        fetch(`/search?query=${encodeURIComponent(this.searchText)}`)
            .then(response => response.json())
            .then(data => {
                this.searchResults = data;
            });
    }
}"
    class="sticky top-0 z-50 bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Colonne gauche (vide pour équilibrage) -->
            <div class="flex-1"></div>

            <!-- Logo au centre -->
            <div class="flex-1 flex justify-center">
                <a href="{{ route('posts.index') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="block h-16 w-auto" />
                </a>
            </div>

            <!-- Colonne droite (paramètres utilisateur) -->
            <div class="flex-1 flex justify-end">
                <div class="flex justify-center">
                    <div class="relative">
                        <input type="text" x-model="searchText" @input="search()"
                            class="px-4 py-2 border rounded-full" placeholder="Recherche...">
                        <div x-show="searchText.length > 0"
                            class="absolute bg-white border border-gray-300 rounded-md shadow-lg mt-1 w-full max-h-72 overflow-y-auto">
                            <div class="p-2">
                                <h3 class="font-semibold text-gray-700 px-2">Utilisateurs</h3>
                                <template x-for="user in searchResults.users" :key="user.id">
                                    <a :href="`/profile/${user.id}`" class="block p-2 hover:bg-gray-100">
                                        <div class="flex items-center">
                                            <img :src="'/storage/' + user.avatar_path" alt="Avatar"
                                                class="w-10 h-10 mr-2 rounded-full">
                                            <span x-text="user.name"></span>
                                        </div>
                                    </a>
                                </template>

                            </div>

                            <!-- Séparateur (si nécessaire) -->
                            <hr>

                            <!-- Section Posts -->
                            <div class="p-2">
                                <h3 class="font-semibold text-gray-700 px-2">Posts</h3>
                                <template x-for="post in searchResults.posts" :key="post.id">
                                    <a :href="`/posts/${post.id}`" class="block p-2 hover:bg-gray-100 flex">
                                        <img :src="'/storage/' + post.img_path" alt="Image du post"
                                            class="w-10 h-10 mr-2 rounded-full">
                                        <span x-text="post.body.substring(0, 10) + '...'"></span>
                                    </a>
                                </template>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('posts.index')" :active="request()->routeIs('posts')">
                    {{ __('Posts') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
        <div @click="showForm = true"
            class="cursor-pointer bg-blue-500 text-white py-2 px-4 text-center mx-auto my-2 w-auto max-w-xs rounded-full">
            Ajouter un Post
        </div>

        <!-- Formulaire déroulant -->
        <div x-show="showForm" @click.away="showForm = false"
            class="absolute top-full left-0 right-0 bg-white p-4 shadow-md z-10">
            <div class="max-w-md mx-auto">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <!-- Champ optionnel pour le corps du post -->
                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700">Légende -
                            optionnel</label>
                        <textarea id="body" name="body" rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>

                    <!-- Champ obligatoire pour le téléchargement d'image -->
                    <div>
                        <label for="img_path" class="block text-sm font-medium text-gray-700">Image</label>
                        <input type="file" id="img_path" name="image"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>
                    </div>

                    <!-- Champ caché pour la date de publication -->
                    <input type="hidden" id="published_at" name="published_at" value="{{ now() }}">

                    <!-- Bouton de soumission -->
                    <div>
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Publier
                        </button>
                    </div>
                </form>
            </div>
        </div>

</nav>
<script>
    function data() {
        return {
            open: false,
            showForm: false,
            searchText: '',
            searchResults: [],
            search() {
                if (this.searchText === '') {
                    this.searchResults = [];
                    return;
                }

                fetch(`/search?query=${encodeURIComponent(this.searchText)}`)
                    .then(response => response.json())
                    .then(data => {
                        this.searchResults = data;
                    });
            }
        };
    }
</script>
