<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <title>@yield('title')</title>
</head>

<body>
    <div class="flex w-screen min-w-[1200px]">
        <div class="bg-gradient-to-b from-blue-950 to-blue-900 text-white h-screen min-w-[300px] max-w-[300px] shadow-xl">
            @php($user = auth()->user())
            <div class="bg-white m-1 mt-7 mb-3 rounded-lg max-w-56 min-w-56 min-h-56 mx-auto transform hover:scale-105 transition-transform duration-300">
                <img class="aspect-square object-cover rounded-lg shadow-lg" src="{{ $user->image() }}" alt="">
            </div>

            <h1 class="text-center text-xl font-semibold text-yellow-300">{{ $user->getFullname() }}</h1>
            <h1 class="text-center text-xs font-light text-gray-300 mb-2">{{ date_create()->format('l, j F, Y') }}</h1>
            <h1 class="text-center text-lg text-gray-200">{{ date_create()->format('h:i A') }}</h1>

            <ul class="flex flex-col px-4 space-y-2">
                <a href="/" class="group">
                    <div class="p-3 rounded-lg flex items-center transition-all duration-300 {{ request()->is('') ? 'bg-blue-800 translate-x-2' : 'hover:bg-blue-800 hover:translate-x-2' }}">
                        <span class="material-symbols-outlined me-3 {{ request()->is('') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            dashboard
                        </span>
                        <li class="font-medium {{ request()->is('') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            Dashboard
                        </li>
                    </div>
                </a>

                <a href="/student" class="group">
                    <div class="p-3 rounded-lg flex items-center transition-all duration-300 {{ request()->is('student') ? 'bg-blue-800 translate-x-2' : 'hover:bg-blue-800 hover:translate-x-2' }}">
                        <span class="material-symbols-outlined me-3 {{ request()->is('student') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            groups
                        </span>
                        <li class="font-medium {{ request()->is('student') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            Manage Students
                        </li>
                    </div>
                </a>

                <a href="/event/view" class="group">
                    <div class="p-3 rounded-lg flex items-center transition-all duration-300 {{ request()->is('event/view') ? 'bg-blue-800 translate-x-2' : 'hover:bg-blue-800 hover:translate-x-2' }}">
                        <span class="material-symbols-outlined me-3 {{ request()->is('event/view') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            prescriptions
                        </span>
                        <li class="font-medium {{ request()->is('event/view') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            Events
                        </li>
                    </div>
                </a>

                <a href="/attendance/class" class="group">
                    <div class="p-3 rounded-lg flex items-center transition-all duration-300 {{ request()->is('attendance/class') ? 'bg-blue-800 translate-x-2' : 'hover:bg-blue-800 hover:translate-x-2' }}">
                        <span class="material-symbols-outlined me-3 {{ request()->is('attendance/class') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            class
                        </span>
                        <li class="font-medium {{ request()->is('attendance/class') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            Class Attendance
                        </li>
                    </div>
                </a>

                <a href="/attendance" class="group">
                    <div class="p-3 rounded-lg flex items-center transition-all duration-300 {{ request()->is('attendance') ? 'bg-blue-800 translate-x-2' : 'hover:bg-blue-800 hover:translate-x-2' }}">
                        <span class="material-symbols-outlined me-3 {{ request()->is('attendance') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            list_alt
                        </span>
                        <li class="font-medium {{ request()->is('attendance') ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            Records
                        </li>
                    </div>
                </a>

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

    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    @yield('script')
</body>

</html>