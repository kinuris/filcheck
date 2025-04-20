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

            <ul class="flex flex-col px-4 space-y-1 overflow-auto"> {{-- Increased px --}}
                @foreach([
                ['/admin/dashboard', 'empty_dashboard', 'Dashboard'],
                ['/student', 'groups', 'Manage Students'],
                ['/curriculum', 'menu_book', 'Manage Curriculum'],
                ['/teacher', 'person', 'Manage Teachers'],
                ['/employee', 'badge', 'Faculty Attendance'],
                ['/department', 'domain', 'Departments'],
                ['/event', 'prescriptions', 'Events'],
                ] as [$url, $icon, $label])
                @php($isActive = request()->is(ltrim($url, '/')) || request()->is(ltrim($url, '/').'/*')) {{-- Check for sub-routes too --}}
                <a href="{{ $url }}" class="group block"> {{-- Added block --}}
                    <div class="px-4 py-2.5 rounded-lg flex items-center transition-all duration-200 {{ $isActive ? 'bg-blue-700 shadow-inner' : 'hover:bg-blue-800 hover:translate-x-1' }}"> {{-- Adjusted padding, active style --}}
                        <span class="material-symbols-outlined me-3 text-lg {{ $isActive ? 'text-yellow-300' : 'text-blue-300 group-hover:text-yellow-300' }}"> {{-- Adjusted margin, size, colors --}}
                            {{ $icon }}
                        </span>
                        <li class="font-semibold text-sm {{ $isActive ? 'text-white' : 'text-blue-100 group-hover:text-white' }}"> {{-- Adjusted font-weight, colors --}}
                            {{ $label }}
                        </li>
                    </div>
                </a>
                @endforeach

                {{-- Logout Button --}}
                <div class="pt-4 mt-4 border-t border-blue-800 px-4">
                    <a href="/logout" class="group block">
                         <div class="px-4 py-2.5 rounded-lg flex items-center transition-all duration-200 hover:bg-red-800 hover:bg-opacity-50">
                            <span class="material-symbols-outlined me-3 text-lg text-red-300 group-hover:text-red-200">logout</span>
                            <li class="font-semibold text-sm text-red-200 group-hover:text-red-100">
                                Logout
                            </li>
                        </div>
                    </a>
                </div>
            </ul>
        </div>

        {{-- Main Content Area --}}
        <main class="flex-1 h-screen overflow-y-auto bg-gray-100"> {{-- Added main tag, bg color --}}
            @yield('content')
        </main>
    </div>

    <!-- Include Choices JavaScript (latest) -->
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>

    @yield('script')
</body>

</html>