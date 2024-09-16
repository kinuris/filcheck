<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>

<body>
    <form action="/login" method="POST">
        @csrf
        <div class="inline-block w-screen h-screen">
            <div class="my-16 bg-[#528CAC]/90 h-[calc(100%-8rem)] flex justify-center place-items-center relative">
                <div class="bg-white py-8 rounded-lg shadow-lg shadow-grey-500 max-w-[700px] min-w-[350px] px-16">
                    <img class="h-16" src="{{ asset('assets/filcheck.svg') }}" alt="">
                    <h1 class="text-center text-2xl">User Authentication</h1>

                    <div class="flex flex-col mt-7">
                        <label class="text-sm" for="username">Username</label>
                        <input class="border-2 border-black rounded-lg px-3 py-1" type="text" name="username" id="username">
                    </div>

                    <div class="flex flex-col mt-3">
                        <label class="text-sm" for="password">Password</label>
                        <input class="border-2 border-black rounded-lg px-3 py-1" type="password" name="password" id="password">
                    </div>

                    <div class="flex flex-col place-items-center">
                        <button type="submit" class="mt-5 bg-yellow-300 border-2 border-black text-black font-bold py-1 px-4 rounded-lg">
                            Login
                        </button>

                        <a class="underline mt-3 font-bold" href="/rfid">ATTENDANCE MONITOR</a>
                    </div>
                </div>
                <img class="top-0 absolute -z-[1] h-full" src="{{ asset('assets/bg.png') }}" alt="Background">
            </div>
        </div>
    </form>
</body>

</html>