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
        <div class="bg-blue-950 text-white h-screen min-w-[max(20%,300px)]">
            <div class="bg-white m-1 mt-7 mb-3 rounded-lg max-w-56 min-w-56 min-h-56 mx-auto">
                <img class="aspect-square object-cover rounded-lg shadow-lg shadown-black" src="{{ fake()->imageUrl() }}" alt="">
            </div>

            @php($user = auth()->user())
            <h1 class="text-center text-xl font-thin text-yellow-300">{{ $user->getFullname() }}</h1>
            <h1 class="text-center text-xs font-thin mb-2">{{ date_create()->format('l, j F, Y') }}</h1>
            <h1 class="text-center text-lg">{{ date_create()->format('h:i A') }}</h1>

            <ul class="flex flex-col p-4">
                <a href="/" class="font-extrabold hover:text-gray-300">
                    <div class="p-3 hover:bg-blue-300 hover:shadow-lg rounded-lg mb-1 flex">
                        <span class="material-symbols-outlined me-3">
                            empty_dashboard
                        </span>
                        <li>
                            Dashboard
                        </li>
                    </div>
                </a>

                <a href="/student" class="font-extrabold hover:text-gray-300">
                    <div class="p-3 hover:bg-blue-300 hover:shadow-lg rounded-lg mb-1 flex">
                        <span class="material-symbols-outlined me-3">
                            groups
                        </span>
                        <li>
                            Manage Students
                        </li>
                    </div>
                </a>

                <a href="/curriculum" class="font-extrabold hover:text-gray-300">
                    <div class="p-3 hover:bg-blue-300 hover:shadow-lg rounded-lg mb-1 flex">
                        <span class="material-symbols-outlined me-3">
                            menu_book
                        </span>
                        <li>
                            Manage Curriculum
                        </li>
                    </div>
                </a>

                <a href="/teacher" class="font-extrabold hover:text-gray-300">
                    <div class="p-3 hover:bg-blue-300 hover:shadow-lg rounded-lg mb-1 flex">
                        <span class="material-symbols-outlined me-3">
                            person
                        </span>
                        <li>
                            Manage Teachers
                        </li>
                    </div>
                </a>

                <a href="/employee" class="font-extrabold hover:text-gray-300">
                    <div class="p-3 hover:bg-blue-300 hover:shadow-lg rounded-lg mb-1 flex">
                        <span class="material-symbols-outlined me-3">
                            badge
                        </span>
                        <li>
                            Employee Attendance
                        </li>
                    </div>
                </a>

                <a href="/event" class="font-extrabold hover:text-gray-300">
                    <div class="p-3 hover:bg-blue-300 hover:shadow-lg rounded-lg mb-1 flex">
                        <span class="material-symbols-outlined me-3">
                            prescriptions
                        </span>
                        <li>
                            Events
                        </li>
                    </div>
                </a>

                <!-- <a href="/attendance" class="font-extrabold hover:text-gray-300">
                    <div class="p-3 hover:bg-blue-300 hover:shadow-lg rounded-lg mb-1 flex">
                        <span class="material-symbols-outlined me-3">
                            ballot
                        </span>
                        <li>
                            Records
                        </li>
                    </div>
                </a> -->
                <div class="p-3 hover:bg-blue-300 hover:shadow-lg rounded-lg mb-1">
                    <a href="/logout" class="text-gray-400 font-thin hover:text-black">Logout</a>
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