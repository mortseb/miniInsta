<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<style>
    @font-face {
        font-family: 'relieve';
        src: url('/fonts/Relieve.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
</style>

<body class="font-sans text-gray-900 antialiased bg-[url('../images/background.jpg')] bg-no-repeat bg-cover bg-center">
    <div class="  min-h-screen flex flex-col justify-center items-center dark:bg-gray-900">
        <!-- Logo et Boutons pour la Racine -->
        @if (request()->is('/'))
            <div class="pb-20 flex flex-col items-center text-center fond bg-white bg-opacity-70 p-6">
                <a href="{{ url('/') }}" class="">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-48 h-48 filter drop-shadow-lg">
                </a>
                <h1 class="mb-4 text-9xl  text-gray-800 dark:text-white" style="font-family: 'relieve', sans-serif;">
                    Connectez-vous <br> Inspirez le Monde
                </h1>

                <div class="space-y-4 space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow transition duration-300">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow transition duration-300">Log
                                in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow transition duration-300">Register</a>
                            @endif
                        @endauth
                    @endif
                </div>
            @else
                <!-- Autres Pages -->
                <nav class="absolute top-0 left-0 right-0 flex justify-between items-center py-2 px-4 w-full">
                    <a href="{{ url('/') }}" class="top-4 left-4">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                            class="w-20 h-20 filter drop-shadow-lg">
                    </a>
                    <div class="space-y-4 space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow transition duration-300">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow transition duration-300">Log
                                    in</a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow transition duration-300">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </nav>

                <!-- Contenu Principal -->
                <main class="fondform flex flex-col items-center justify-center w-full">
                    {{ $slot }}
                </main>
        @endif

        <style>
            .btn {
                @apply bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 shadow-md;
            }

            .fond {
                width: 70%;
                height: 100%;
                background-color: rgba(255, 255, 255, 0.4);
                backdrop-filter: blur(3px) brightness(1.11) grayscale(10%);
                border-radius: 5%;
                border: 0.3rem solid;


            }

            .fondform {
                width: 280px;
                height: 300px;
                background-color: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(3px) brightness(1.11) grayscale(100%);
                border-radius: 10%;
            }
        </style>
    </div>
</body>

</html>
