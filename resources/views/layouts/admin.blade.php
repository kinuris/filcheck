<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Include base CSS (optional) -->
    <!-- <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/base.min.css" /> -->

    <!-- Include Choices CSS -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>@yield('title')</title>
</head>

<body>
    <div class="flex w-screen">
        <div class="bg-gradient-to-b from-blue-950 to-blue-900 text-white h-screen min-w-[300px] max-w-[300px] shadow-xl">
            <div class="bg-white m-1 mt-7 mb-3 rounded-lg max-w-56 min-w-56 min-h-56 mx-auto transform hover:scale-105 transition-transform duration-300">
                <img class="aspect-square object-cover rounded-lg shadow-lg" src="{{ fake()->imageUrl() }}" alt="">
            </div>

            @php($user = auth()->user())
            <h1 class="text-center text-xl font-semibold text-yellow-300">{{ $user->getFullname() }}</h1>
            <h1 class="text-center text-xs font-light text-gray-300 mb-2">{{ date_create()->format('l, j F, Y') }}</h1>
            <h1 class="text-center text-lg text-gray-200">{{ date_create()->format('h:i A') }}</h1>

            <ul class="flex flex-col px-4 space-y-2">
                @foreach([
                ['/admin/dashboard', 'empty_dashboard', 'Dashboard'],
                ['/student', 'groups', 'Manage Students'],
                ['/curriculum', 'menu_book', 'Manage Curriculum'],
                ['/teacher', 'person', 'Manage Teachers'],
                ['/employee', 'badge', 'Employee Attendance'],
                ['/event', 'prescriptions', 'Events']
                ] as [$url, $icon, $label])
                <a href="{{ $url }}" class="group">
                    <div class="p-3 rounded-lg flex items-center transition-all duration-300 {{ request()->is(trim($url, '/')) ? 'bg-blue-800 translate-x-2' : 'hover:bg-blue-800 hover:translate-x-2' }}">
                        <span class="material-symbols-outlined me-3 {{ request()->is(trim($url, '/')) ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            {{ $icon }}
                        </span>
                        <li class="font-medium {{ request()->is(trim($url, '/')) ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            {{ $label }}
                        </li>
                    </div>
                </a>
                @endforeach

                <div class="p-3 mt-4">
                    <a href="/logout" class="block text-gray-400 font-medium hover:text-red-400 transition-colors duration-300 text-center">
                        <span class="material-symbols-outlined align-middle me-2">logout</span>
                        Logout
                    </a>
                </div>
            </ul>
        </div>

        @yield('content')
    </div>

    <!-- Include Choices JavaScript (latest) -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    @yield('script')
</body>

</html>