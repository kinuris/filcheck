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
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">

    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <title>@yield('title')</title>
</head>

<body>
    <div class="flex w-screen">
        <div class="bg-gradient-to-b from-blue-950 to-blue-900 text-white h-screen min-w-[300px] max-w-[300px] shadow-xl pt-8">
            @php($user = auth()->user())
            <div class="px-6 mb-8">
                <h2 class="text-2xl font-bold text-yellow-300 mb-1">{{ $user->getFullname() }}</h2>
                <div class="flex items-center mb-4">
                    <span class="material-symbols-outlined text-sm text-yellow-300 me-1">admin_panel_settings</span>
                    <span class="text-sm font-medium text-yellow-300">Administrator</span>
                </div>
                <div class="border-t border-blue-800 pt-4">
                    <div class="flex items-center text-gray-300">
                        <span class="material-symbols-outlined text-sm me-2">calendar_today</span>
                        <span class="text-sm">{{ date_create()->format('l, j F, Y') }}</span>
                    </div>
                    <div class="flex items-center text-gray-300 mt-1">
                        <span class="material-symbols-outlined text-sm me-2">schedule</span>
                        <span class="text-sm">{{ date_create()->format('h:i A') }}</span>
                    </div>
                </div>
            </div>

            <ul class="flex flex-col px-2 space-y-1 max-h-96 overflow-auto">
                @foreach([
                ['/admin/dashboard', 'empty_dashboard', 'Dashboard'],
                ['/student', 'groups', 'Manage Students'],
                ['/curriculum', 'menu_book', 'Manage Curriculum'],
                ['/teacher', 'person', 'Manage Teachers'],
                ['/employee', 'badge', 'Faculty Attendance'],
                ['/department', 'domain', 'Departments'],
                ['/event', 'prescriptions', 'Events'],
                ] as [$url, $icon, $label])
                <a href="{{ $url }}" class="group">
                    <div class="p-2 rounded-lg flex items-center transition-all duration-300 {{ request()->is(trim($url, '/')) ? 'bg-blue-800 translate-x-2' : 'hover:bg-blue-800 hover:translate-x-2' }}">
                        <span class="material-symbols-outlined me-2 {{ request()->is(trim($url, '/')) ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            {{ $icon }}
                        </span>
                        <li class="font-medium text-sm {{ request()->is(trim($url, '/')) ? 'text-yellow-300' : 'group-hover:text-yellow-300' }}">
                            {{ $label }}
                        </li>
                    </div>
                </a>
                @endforeach

                <div class="p-2 mt-2">
                    <a href="/logout" class="block text-gray-400 font-medium hover:text-red-400 transition-colors duration-300 text-center text-sm">
                        <span class="material-symbols-outlined align-middle me-2">logout</span>
                        logout
                    </a>
                </div>
            </ul>
        </div>

        @yield('content')
    </div>

    <!-- Include Choices JavaScript (latest) -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    @yield('script')
</body>

</html>