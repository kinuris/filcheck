@extends('layouts.admin')

@section('content')
    <div class="w-full relative">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="p-6 bg-gradient-to-r from-blue-500 to-blue-600">
            <div class="rounded-xl shadow-2xl bg-white min-h-[calc(100%-4rem)] max-h-[calc(100%-1rem)] overflow-auto">
                <form class="h-full" action="/teacher/edit/{{ $teacher->id }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="flex h-full">
                        <div class="flex-[2] p-3">
                            <h2 class="text-xl font-semibold text-gray-700 mb-4">Profile Photo</h2>
                            <div class="aspect-square rounded-lg max-w-24 mx-auto mb-2 scale-x-[-1] overflow-hidden shadow bg-black"
                                id="vid-container">
                                <video class="object-cover h-full" id="video" autoplay></video>
                            </div>

                            <div class="hidden aspect-square rounded-lg overflow-hidden shadow bg-black"
                                id="canvas-container">
                                <canvas id="canvas"></canvas>
                            </div>

                            <div class="flex-1 relative">
                                <div
                                    class="flex relative justify-center place-items-center aspect-square border border-gray-300 rounded-lg mb-5 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <img src="{{ $teacher->image() }}" class="object-cover aspect-square rounded-lg"
                                        name="profile" alt="Profile Preview" id="preview">
                                    <p id="profile-tag" class="block text-sm font-medium text-gray-700 mb-1 hidden">Profile
                                        Picture</p>
                                    <p class="text-red-500 text-xs mt-1 absolute bottom-2 left-5">
                                        @error('profile')
                                            {{ $message }}
                                        @enderror
                                    </p>
                                </div>
                            </div>

                            <div class="flex mt-4 gap-2">
                                <label
                                    class="flex-1 text-center text-white cursor-pointer bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg font-semibold transition-colors"
                                    for="profile">Upload</label>
                                <input class="sr-only" type="file" name="profile" id="profile"
                                    accept="image/png,image/jpg,image/jpeg">
                                <button
                                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded-lg cursor-pointer transition-colors"
                                    id="snap" type="button">Capture</button>
                            </div>
                        </div>

                        <div class="flex-[3] border-l border-gray-400 p-4">
                            <h2 class="text-xl font-semibold text-gray-700 mb-4">Basic Information</h2>

                            <div class="grid gap-2">
                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="rfid">RFID
                                        Tag</label>
                                    <input value="{{ $teacher->rfid }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('rfid') border-red-500 @enderror"
                                        type="text" name="rfid" id="rfid" readonly>
                                    @error('rfid')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="employee_id">Employee ID</label>
                                    <input value="{{ $teacher->employee_id }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('employee_id') border-red-500 @enderror"
                                        type="text" name="employee_id" id="employee_id">
                                    @error('employee_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid gap-3.5 gap-y-2 mt-2">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative">
                                        <label class="block text-sm font-medium text-gray-700" for="firstname">First
                                            Name</label>
                                        <input value="{{ $teacher->first_name }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror"
                                            type="text" name="first_name" id="firstname">
                                        @error('first_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <label class="block text-sm font-medium text-gray-700" for="middlename">Middle
                                            Name</label>
                                        <input value="{{ $teacher->middle_name }}"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('middle_name') border-red-500 @enderror"
                                            type="text" name="middle_name" id="middlename">
                                        @error('middle_name')
                                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="lastname">Last
                                        Name</label>
                                    <input value="{{ $teacher->last_name }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror"
                                        type="text" name="last_name" id="lastname">
                                    @error('last_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex gap-4 items-end mt-1">
                                <div class="flex-1 relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">Phone
                                        Number</label>
                                    <input value="{{ $teacher->phone_number }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('phone_number') border-red-500 @enderror"
                                        type="tel" name="phone_number" id="phone">
                                    @error('phone_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex gap-4 items-start mt-2">
                                <div class="flex-1 relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1"
                                        for="gender">Gender</label>
                                    <select
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gender') border-red-500 @enderror"
                                        name="gender" id="gender">
                                        <option value="Male" {{ $teacher->gender == 'Male' ? 'selected' : '' }}>Male
                                        </option>
                                        <option value="Female" {{ $teacher->gender == 'Female' ? 'selected' : '' }}>Female
                                        </option>
                                    </select>
                                    @error('gender')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex-1 relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1"
                                        for="birthdate">Birthdate</label>
                                    <input value="{{ $teacher->birthdate }}"
                                        class="w-full px-3 py-1.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('birthdate') border-red-500 @enderror"
                                        type="date" name="birthdate" id="birthdate">
                                    @error('birthdate')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex-[3] border-l border-gray-400 p-4">
                            <h2 class="text-xl font-semibold text-gray-700 mb-4">Account</h2>

                            <div class="grid gap-2">
                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1"
                                        for="username">Username</label>
                                    <input value="{{ $teacher->username }}"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('username') border-red-500 @enderror"
                                        type="text" name="username" id="username">
                                    @error('username')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1"
                                        for="password">Password</label>
                                    <input
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                                        type="password" name="password" id="password">
                                    @error('password')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1"
                                        for="department">Department</label>
                                    <select
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('department') border-red-500 @enderror"
                                        name="department" id="department">
                                        @php($departments = \App\Models\Department::all())
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ $teacher->department_id == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }} ({{ $department->code }})</option>
                                        @endforeach
                                    </select>
                                    @error('department')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="relative mt-4">
                                    <label class="text-blue-950 font-bold mb-0" for="choices">Sections Handled:</label>
                                    <select id="choices" name="advisories[]" multiple>
                                    </select>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button
                                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors">Save</button>
                                    <a href="/teacher"
                                        class="bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded-lg transition-colors">Back</a>
                                </div>
                            </div>
                            <!-- <div class="flex justify-between place-items-center px-3">
                                <label class="font-semibold text-lg text-blue-950" for="username">USERNAME</label>
                                <input value="{{ $teacher->username }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="username" id="username">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="password">PASSWORD</label>
                                <input class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="password" name="password" id="password">
                            </div>

                            <div class="py-3"></div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="department">DEPARTMENT</label>
                                <select class="w-[195px] bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" name="department" id="department">
                                    @php($departments = \App\Models\Department::all())
                                    @foreach ($departments as $department)
                                    <option value="{{ $department->id }}" @if ($teacher->department_id == $department->id) selected @endif>{{ $department->name }} ({{ $department->code }})</option>
                                    @endforeach
                                </select>
                            </div> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        const element = document.getElementById('choices');
        new Choices(element, {
            placeholderValue: 'Select Section',
            choices: [
                <?php foreach ($sections as $section): ?> {
                    label: '{{ $section }}',
                    value: '{{ $section }}',
                    selected: <?php echo $teacher->advisories()->pluck('section')->contains($section) ? 'true' : 'false'; ?>
                },
                <?php endforeach ?>
            ],
            removeItems: true,
            removeItemButton: true,
        });
    </script>
    <script>
        const canvas = document.getElementById('canvas');
        const video = document.getElementById('video');
        const profile = document.getElementById('profile');
        const preview = document.getElementById('preview');
        const tag = document.getElementById('profile-tag');
        const snapBtn = document.getElementById('snap');

        snapBtn.addEventListener('click', async () => {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            const ctx = canvas.getContext('2d');
            ctx.scale(-1, 1);
            ctx.drawImage(video, 0, 0, -canvas.width, canvas.height);

            const dataUrl = canvas.toDataURL('image/png');
            preview.src = dataUrl;

            preview.classList.remove('hidden');
            tag.classList.add('hidden');

            const response = await fetch(dataUrl);
            const data = await response.blob();

            const file = new File([data], 'profile.png', {
                type: 'image/png'
            });

            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);

            profile.files = dataTransfer.files;
        });

        profile.addEventListener('change', (e) => {
            const file = e.target.files[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = () => {
                tag.classList.add('hidden');
                preview.classList.remove('hidden');

                preview.src = reader.result;
            }
        });

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(function(stream) {
                    const video = document.getElementById('video');

                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(error) {
                    console.error("Error accessing the camera: ", error);
                });
        } else {
            console.error("getUserMedia API not supported by this browser.");
        }
    </script>
    <script>
        const stream = new EventSource('http://localhost:8081/stream/current?stream=current');
        const rfidField = document.getElementById('rfid');

        stream.addEventListener('message', (e) => {
            rfidField.value = e.data;
        });
    </script>
    <!-- <script>
        const profile = document.getElementById('profile');
        const preview = document.getElementById('preview');
        const tag = document.getElementById('profile-tag');

        profile.addEventListener('change', (e) => {
            const file = e.target.files[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();

            reader.readAsDataURL(file);
            reader.onload = () => {
                tag.classList.add('hidden');
                preview.classList.remove('hidden');

                preview.src = reader.result;
            }
        });
    </script> -->
@endsection
