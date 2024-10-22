@extends('layouts.admin')

@section('content')
<div class="w-full">
    <div class="w-full inline-block h-full bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="p-4 mb-16 bg-blue-400 h-[calc(100%-8rem)]">
            <div class="flex w-full mb-3 justify-between">
                <h1 class="text-2xl font-extrabold text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]">TEACHER</h1>
            </div>
            <div class="rounded-lg shadow-lg bg-[#ADE3FE] h-[calc(100%-4rem)]">
                <form class="h-full" action="/teacher/create" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="flex h-full">
                        <div class="flex-[2] p-3">
                            <div class="aspect-square rounded-lg max-w-24 mx-auto mb-2 scale-x-[-1] overflow-hidden shadow bg-black" id="vid-container">
                                <video class="object-cover h-full" id="video" autoplay></video>
                            </div>

                            <div class="hidden aspect-square rounded-lg overflow-hidden shadow bg-black" id="canvas-container">
                                <canvas id="canvas"></canvas>
                            </div>

                            <div class="flex relative justify-center place-items-center aspect-square border-2 border-dashed border-slate-400 rounded-lg mb-5 bg-gray-50">
                                <img class="hidden object-cover aspect-square" name="profile" alt="Profile Preview" id="preview">
                                <p id="profile-tag">Profile Picture</p>
                                <p class="text-red-500 text-xs mt-1 absolute bottom-2 left-5">@error('profile') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex mt-2">
                                <label class="text-white cursor-pointer bg-blue-800 p-3 rounded-lg font-bold" for="profile">UPLOAD</label>
                                <input class="sr-only" type="file" name="profile" id="profile" accept="image/png,image/jpg,image/jpeg">
                                <button class="bg-gray-400 text-white font-bold p-3 rounded-lg cursor-pointer ml-2" id="snap" type="button">SNAP</button>
                            </div>
                        </div>

                        <div class="flex-[3] border-l border-gray-400">
                            <h1 class="text-center mt-3 text-blue-950 text-xl font-semibold mb-4">BASIC INFO</h1>
                            <div class="flex justify-between place-items-center px-3">
                                <label class="font-semibold text-lg text-blue-950" for="firstname">FIRST NAME</label>
                                <input value="{{ old('first_name') }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="first_name" id="firstname">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="middlename">MIDDLE NAME</label>
                                <input value="{{ old('middle_name') }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="middle_name" id="middlename">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="lastname">LAST NAME</label>
                                <input value="{{ old('last_name') }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="last_name" id="lastname">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-6">
                                <label class="font-semibold text-lg text-blue-950" for="phone">PHONE NUMBER</label>
                                <input value="{{ old('phone_number') }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="tel" name="phone_number" id="phone">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="gender">GENDER</label>
                                <select class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-2" name="gender" id="gender">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="birthdate">BIRTHDATE</label>
                                <input value="{{ old('birthdate') }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="date" name="birthdate" id="birthdate">
                            </div>
                        </div>
                        <div class="flex-[3] border-l border-gray-400 flex flex-col">
                            <h1 class="text-center mt-3 text-blue-950 text-xl font-semibold mb-4">ACCOUNT</h1>
                            <div class="flex justify-between place-items-center px-3">
                                <label class="font-semibold text-lg text-blue-950" for="username">USERNAME</label>
                                <input value="{{ old('username') }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="username" id="username">
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
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }} ({{ $department->code }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex-1"></div>

                            <div class="flex justify-between px-3 w-full mb-3">
                                <button class="bg-green-300 px-5 rounded-lg border-black border">SAVE</button>
                                <a href="/teacher" class="bg-red-300 px-5 rounded-lg border-black border">BACK</a>
                            </div>
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
@endsection