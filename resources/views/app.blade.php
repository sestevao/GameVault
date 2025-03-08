<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/images/icons/favicon.ico" id="favicon">
    <title>@yield('title', 'Game Vault')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ url('css/custom.css') }}">
</head>

<body class="bg-gray-900 text-white">
    <header class="bg-gray-800 p-4 shadow-lg">
        <nav class="flex justify-between items-center container mx-auto">
            <div class="flex items-center gap-3">
                <img src="{{ url('images/icons/favicon.png') }}" alt="Game Dashboard" class="w-16 h-16 rounded-full border-2 border-gray-700 p-1">
                <div class="flex flex-col items-center px-2">
                    <h1 class="text-2xl font-bold tracking-widest flex items-center justify-center gap-2 bg-clip-text text-transparent bg-gradient-to-r from-purple-light via-purple-light to-green-mid">
                        LEVELUP
                        <img src="{{ url('images/icons/ps-controller.png') }}" alt="Game Dashboard" class="w-10 h-10">
                        LIBRARY
                    </h1>

                    <p class="text-sm text-gray-400">Organize and manage your physical games</p>
                </div>
            </div>
            <ul class="flex gap-6 text-lg">
                <li><a href="/" class="hover:text-blue-400">Home</a></li>
                <li><a href="/games" class="hover:text-blue-400">Games</a></li>
                <li><a href="/notes" class="hover:text-blue-400">Notes</a></li>
            </ul>
        </nav>
    </header>

    <div class="flex min-h-screen">
        <aside class="w-1/5 bg-gray-800 p-6 space-y-6 shadow-lg">
            @foreach ($groupedConsoles as $ownerId => $consolesByOwner)
                @php $owner = $owners->find($ownerId); @endphp
                @if ($owner)
                <div class="group">
                    <h3 class="font-bold text-xl text-white p-4 rounded-lg bg-gray-700 mb-2">
                        <span class="bg-opacity-50 p-2 rounded">{{ $owner->name }}</span>
                    </h3>
                    <ul class="space-y-2">
                        @foreach ($consolesByOwner as $console)
                            <li class="flex items-center gap-4 p-3 rounded-lg cursor-pointer hover:bg-gray-600 transition-all duration-300">
                                <img src="{{ url('images/icons/' . $console->slug . '.png') }}" alt="{{ $console->name }}" class="w-12 h-12 rounded-full border-2 border-gray-600 hover:border-gray-400 p-2">
                                <span class="text-white font-medium">{{ $console->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            @endforeach
        </aside>

        <div id="notification" class="hidden fixed top-4 left-1/2 transform -translate-x-1/2 p-4 max-w-sm w-full rounded-lg text-white">
            <p id="notification-message" class="text-center"></p>
        </div>

        <main class="flex-1 p-6 bg-cover bg-center relative" >
            <div class="absolute inset-0 bg-black opacity-50"></div>

            <div class="relative z-10">
                <div class="bg-gray-700 p-4 rounded-lg flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <img src="/images/avatar/avatar1.png" alt="Profile" class="w-16 h-16 rounded-full">
                        <div>
                            <h2 class="text-2xl font-bold">Dark King</h2>
                            <p class="text-sm text-gray-300">Total Games: {{$games->count()}}</p>
                        </div>
                    </div>
                    <form class="flex gap-4">
                        <input type="text" placeholder="Search by Title..." class="bg-gray-800 text-white px-4 py-2 rounded-lg">
                        <button class="bg-blue-600 px-4 py-2 rounded-lg hover:bg-blue-500">Search</button>
                    </form>

                    <button id="open-modal" class="px-4 py-2 bg-green-500 hover:bg-green-500 rounded-lg shadow-md flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5" cx="12" cy="12" r="10"></path>
                        </svg>
                        Game
                    </button>
                </div>

                <div class="mt-6 bg-gray-800 p-6 rounded-lg">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($games as $game)
                            <div class="bg-gray-700 rounded-lg shadow-lg overflow-hidden group relative">
                                <!-- Game cover image -->
                                <img src="{{ $game->cover_url }}" alt="{{ $game->title }}" class="w-full h-48 object-cover">

                                <!-- Edit and Remove Icons -->
                                <div class="absolute top-2 right-2 flex space-x-2 z-10">
                                    <button class="edit-game-btn border-2 border-blue-500 p-1 rounded-full text-blue-500 hover:text-blue-300 hover:border-blue-300" data-game-id="{{ $game->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232a3 3 0 114.242 4.242l-8.485 8.486H6v-4.242l8.485-8.485z" />
                                        </svg>
                                    </button>

                                    <button class="remove-game-btn border-2 border-red-500 p-1 rounded-full text-red-500 hover:text-red-300 hover:border-red-300" data-game-id="{{ $game->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="p-4">
                                    <h2 class="text-xl font-semibold truncate">{{ $game->title }}</h2>

                                    <!-- Game platform -->
                                    <img src="{{ url('images/icons/' . $game->console->slug . '.png') }}" alt="{{ $game->console->name }}" class="w-10 h-10 rounded-full border border-gray-600 p-1">

                                    <!-- Game genre -->
                                    <p class="text-sm text-gray-400 mt-2">
                                        <span class="text-gray-200">{{ $game->genre->name }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </main>
    </div>

    <footer class="bg-gray-800 text-center p-4">
        &copy; {{ date('Y') }} Game Dashboard
    </footer>

    <div id="game-modal" class="hidden fixed inset-0 bg-gray-900 bg-opacity-60 flex items-center justify-center z-40">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg max-w-md max-h-[90vh] overflow-y-auto w-full text-white">
            <form id="add-game-form" action="/store" method="post" class="text-gray-200 p-6 " enctype="multipart/form-data">
                @csrf

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-2xl font-semibold">Add a New Game</h2>
                    <button id="close-modal" class="text-gray-400 hover:text-white hover:border-gray-200 transition border-2 border-gray-600 rounded-full p-1 shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-sm font-medium">Game Title</label>
                    <input type="text" id="title" name="title" class="mt-1 block w-full text-gray-800 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm" />
                    @error('title') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="console_id" class="block text-sm font-medium ">Platform</label>
                    <select id="console_id" name="console_id" class="mt-1 text-gray-800 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                        <option value="">Select a Platform</option>
                        @foreach($groupedConsoles as $ownerId => $consoles)
                        @php
                        $owner = $owners->find($ownerId);
                        @endphp
                        @if ($owner)
                        <optgroup label="{{ $owner->name }}">
                            @foreach($consoles as $console)
                            <option value="{{ $console->id }}">{{ $console->name }}</option>
                            @endforeach
                        </optgroup>
                        @endif
                        @endforeach
                    </select>
                    @error('console_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4 flex items-center justify-center gap-2">
                    <div class="flex-1">
                        <label for="genre_id" class="block text-sm font-medium ">Genre</label>
                        <select id="genre_id" name="genre_id" class="mt-1 text-gray-800 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">
                            <option value="">Select a Genre</option>
                            @foreach($genres as $genre)
                            <option value="{{ $genre->id }}">{{ $genre->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="button" id="add-new-genre-btn" class="mt-6 text-sm border-2 rounded-full hover:border-blue-800 border-blue-600 text-blue-600 hover:text-blue-800 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"></path>
                        </svg>
                    </button>

                    @error('genre_id') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="game-cover" class="block text-sm font-medium ">Game Cover</label>
                    <input type="file" id="game-cover" name="cover" accept="image/jpeg, image/png, image/jpg, image/gif, image/svg+xml" class="mt-1 block w-full px-4 py-2 bg-gray-700 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 hover:border-gray-600 transition duration-300 ease-in-out sm:text-sm" />
                    <img id="game-cover-preview" src="" alt="Game Cover Preview" class="mt-2 hidden w-32 h-32 object-cover rounded-md border border-gray-300" />
                    @error('cover') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="game-additional-cover" class="block text-sm font-medium ">Additional Covers</label>
                    <input type="file" id="game-additional-cover" name="additional-cover" class="mt-1 block w-full px-4 py-2 bg-gray-700 border border-gray-500 rounded-md shadow-sm focus:outline-none focus:ring-gray-500 focus:border-gray-500 hover:border-gray-600 transition duration-300 ease-in-out sm:text-sm" />
                    <img id="game-additional-cover-preview" src="" alt="Game Additional Cover Preview" class="mt-2 hidden w-32 h-32 object-cover rounded-md border border-gray-300" />
                    @error('additional-cover') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium ">Game Notes</label>
                    <textarea id="notes" name="notes" class="mt-1 block text-gray-800 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm"></textarea>
                    @error('notes') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4 flex items-center space-x-3">
                    <input type="checkbox" id="is_psn" name="is_psn" class="h-5 w-5 text-gray-800  border-gray-300 rounded focus:ring-green-500 transition duration-300 ease-in-out" />
                    <label for="is_psn" class="text-sm font-medium px-2">PSN</label>
                </div>

                <div class="flex justify-end gap-4 mt-6 border-t border-gray-600 pt-4">
                    <button type="button" id="close-modal" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg">Save Game</button>
                </div>
            </form>
        </div>
    </div>

    <div id="add-genre-modal" class="hidden fixed inset-0 flex z-50 items-center justify-center bg-gray-500 bg-opacity-50">
        <div class="bg-gray-800 p-6 rounded-lg w-1/3">
            <h2 class="text-lg font-semibold mb-4">Add New Genre</h2>
            <form id="new-genre-form" action="genres/store" method="POST">
                @csrf
                <label for="new-genre-name" class="block text-sm font-medium text-gray-200">Genre Name</label>
                <input type="text" id="new-genre-name" name="name" class="mt-1 block w-full text-gray-800 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm">

                <div class="mt-4 flex justify-end">
                    <button type="button" id="close-modal-btn" class="text-gray-200 hover:text-gray-800">Cancel</button>
                    <button type="submit" class="ml-3 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600">Add Genre</button>
                </div>
            </form>
        </div>
    </div>
</body>

<script src="{{ url('js/app.js') }}" defer></script>



</html>
