<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Login - FilCheck</title>
</head>

<body class="bg-gray-100">
    <!-- Modal remains mostly the same but with improved styling -->
    <div id="setupClassNodeModal" class="hidden fixed z-10 inset-0 overflow-y-auto bg-black bg-opacity-80">
        <div class="flex items-center justify-center min-h-screen w-full p-4">
            <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full transform transition-all">
                <div class="flex justify-between items-center pb-4">
                    <h2 class="text-2xl font-bold text-gray-800">Setup Class Node</h2>
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
                </div>
                <form action="{{ route('class-node.setup') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="roomName" class="block text-sm font-semibold text-gray-700 mb-2">Room Name</label>
                        <input type="text" name="room_name" id="roomName" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        @error('room_name')
                            <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition-colors">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <form action="/login" method="POST">
        @csrf
        <div class="min-h-screen relative">
            <div class="absolute inset-0">
                <img class="w-full h-full object-cover" src="{{ asset('assets/bg.png') }}" alt="Background">
                <div class="absolute inset-0 bg-gradient-to-r from-blue-900/30 to-blue-800/40"></div>
            </div>

            <div class="relative min-h-screen flex items-center justify-center px-4">
                <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-2xl w-full max-w-md">
                    <div class="flex justify-center mb-6">
                        <img class="h-20" src="{{ asset('assets/filcheck.png') }}" alt="FilCheck Logo">
                    </div>
                    <h1 class="text-center text-3xl font-bold text-gray-800 mb-8">Welcome</h1>

                    <div class="space-y-6">
                        <div>
                            <label class="text-sm font-medium text-gray-700" for="username">Username</label>
                            <input class="mt-2 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                   type="text" name="username" id="username" placeholder="Enter your username">
                        </div>

                        <div>
                            <label class="text-sm font-medium text-gray-700" for="password">Password</label>
                            <input class="mt-2 w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" 
                                   type="password" name="password" id="password" placeholder="Enter your password">
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors">
                            Sign In
                        </button>

                        <div class="flex flex-col items-center space-y-3 pt-4">
                            <a class="text-blue-600 hover:text-blue-800 font-semibold transition-colors" href="/rfid">ATTENDANCE MONITOR</a>
                            <button type="button" onclick="openModal()" class="text-blue-600 hover:text-blue-800 font-semibold transition-colors">SETUP CLASS NODE</button>
                        </div>
                    </div>
                </div>
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