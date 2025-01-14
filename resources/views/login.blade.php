<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Login</title>
</head>

<body>
    <div id="setupClassNodeModal" class="hidden fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-80">
        <div class="flex items-center justify-center min-h-screen w-full">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
                <div class="flex justify-between items-center pb-3">
                    <h2 class="text-xl font-semibold">Setup Class Node</h2>
                    <button id="closeModal" class="text-black">&times;</button>
                </div>
                <form action="{{ route('class-node.setup') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="roomName" class="block text-sm font-medium text-gray-700">Room Name</label>
                        <input type="text" name="room_name" id="roomName" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('room_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded-lg">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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

                        <a class="underline mt-5 font-bold" href="/rfid">ATTENDANCE MONITOR</a>
                        <button type="button" onclick="openModal()" class="underline mt-1 font-bold">SETUP CLASS NODE</button>
                    </div>
                </div>
                <img class="top-0 absolute -z-[1] h-full" src="{{ asset('assets/bg.png') }}" alt="Background">
            </div>
        </div>
    </form>
    <script>
        function openModal() {
            document.getElementById('setupClassNodeModal').classList.remove('hidden');
            document.getElementById('setupClassNodeModal').classList.add('flex');
            document.getElementById('closeModal').addEventListener('click', function() {
                document.getElementById('setupClassNodeModal').classList.add('hidden');
                document.getElementById('setupClassNodeModal').classList.remove('flex');
            });

        }

        <?php if (session('openModal') === 1): ?>
            openModal();
        <?php endif ?>
    </script>
</body>

</html>