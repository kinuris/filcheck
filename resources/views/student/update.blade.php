@extends('layouts.teacher')

@section('content')
<div class="w-full">
    <div class="w-full inline-block h-full bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="p-4 mb-16 bg-blue-400 h-[calc(100%-8rem)] max-h-[calc(100vh-8rem)]">
            <div class="flex w-full mb-3 justify-between">
                <h1 class="text-2xl font-extrabold text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]">STUDENT</h1>
            </div>
            <div class="rounded-lg shadow-lg bg-[#ADE3FE] min-h-[calc(100%-4rem)] max-h-[calc(100%-4rem)] overflow-scroll">
                <form action="/student/edit/{{ $student->id }}" enctype="multipart/form-data" method="POST">
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
                                <img src="{{ $student->image() }}" class="object-cover aspect-square rounded-lg" name="profile" alt="Profile Preview" id="preview">
                                <p id="profile-tag" class="hidden">Profile Picture</p>
                                <p class="text-red-500 text-xs mt-1 absolute bottom-2 left-5">@error('profile') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex mt-2">
                                <label class="text-white cursor-pointer bg-blue-800 p-3 rounded-lg font-bold" for="profile">UPLOAD</label>
                                <input class="sr-only" type="file" name="profile" id="profile" accept="image/png,image/jpg,image/jpeg">
                                <button class="bg-gray-400 text-white font-bold p-3 rounded-lg cursor-pointer ml-2" id="snap" type="button">SNAP</button>
                            </div>
                        </div>

                        <div class="flex-[3] border-l border-gray-400 h-full">
                            <h1 class="text-center mt-3 text-blue-950 text-xl font-semibold mb-4">BASIC INFO</h1>

                            <div class="flex flex-col px-3 relative">
                                <label class="font-semibold text-lg text-blue-950" for="rfid">RFID TAG</label>
                                <input value="{{ $student->rfid }}" class="bg-[#c3e8f8] border-black border rounded-lg px-2 py-1" type="text" name="rfid" id="rfid" readonly>
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('rfid') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-lg text-blue-950" for="student_number">STUDENT NUMBER</label>
                                <input value="{{ $student->student_number }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1 @error('student_number') border-red-500 @enderror" type="text" name="student_number" id="student_number">
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('student_number') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-lg text-blue-950" for="firstname">FIRST NAME</label>
                                <input value="{{ $student->first_name }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1 @error('first_name') border-red-500 @enderror" type="text" name="first_name" id="firstname">
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('first_name') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-lg text-blue-950" for="middlename">MIDDLE NAME</label>
                                <input value="{{ $student->middle_name }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1 @error('middle_name') border-red-500 @enderror" type="text" name="middle_name" id="middlename">
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('middle_name') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-lg text-blue-950" for="lastname">LAST NAME</label>
                                <input value="{{ $student->last_name }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1 @error('last_name') border-red-500 @enderror" type="text" name="last_name" id="lastname">
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('last_name') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-lg text-blue-950" for="department">DEPARTMENT</label>
                                <select class="w-[195px] bg-[#ADE3FE] border-black border rounded-lg px-2 py-1 @error('department') border-red-500 @enderror" name="department" id="department">
                                    @php($departments = \App\Models\Department::all())
                                    @foreach($departments as $department)
                                    <option value="{{ $department->id }}" {{ $student->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }} ({{ $department->code }})</option>
                                    @endforeach
                                </select>
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-5">@error('department') {{ $message }} @enderror</p>
                            </div>
                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-lg text-blue-950" for="gender">GENDER</label>
                                <select class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-2 @error('gender') border-red-500 @enderror" name="gender" id="gender">
                                    <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-5">@error('gender') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex flex-col px-3 my-3  relative">
                                <label class="font-semibold text-lg text-blue-950" for="birthdate">BIRTHDATE</label>
                                <input value="{{ $student->birthdate }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1 @error('birthdate') border-red-500 @enderror" type="date" name="birthdate" id="birthdate">
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-5 right-3">@error('birthdate') {{ $message }} @enderror</p>
                            </div>
                        </div>

                        <div class="flex-[3] border-l border-gray-400 flex flex-col">
                            <h1 class="text-center mt-3 text-blue-950 text-xl font-semibold mb-4">IN CASE OF EMERGENCY</h1>

                            <div class="flex">
                                <div class="flex flex-col px-3 relative flex-1">
                                    <label class="font-semibold text-lg text-blue-950" for="phone">PHONE NUMBER</label>
                                    <input value="{{ $student->phone_number }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1 @error('phone_number') border-red-500 @enderror" type="tel" name="phone_number" id="phone">
                                    <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('phone_number') {{ $message }} @enderror</p>
                                </div>
                                <div class="flex flex-col relative place-items-center justify-center mr-3">
                                    <label for="sms_activated" title="SMS delivery for this student">SMS</label>
                                    <input {{ $student->activatedSms() ? 'checked' : '' }} class="w-5 h-5" type="checkbox" name="sms_activated" id="sms_activated">
                                </div>
                            </div>

                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-sm text-blue-950" for="guardian">PARENT /<br>GUARDIANS</label>
                                <input value="{{ $student->guardian }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1 @error('guardian') border-red-500 @enderror" type="tel" name="guardian" id="guardian">
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('guardian') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-lg text-blue-950" for="address">ADDRESS</label>
                                <textarea class="bg-[#ADE3FE] border-black border rounded-lg min-h-28 max-h-28 px-2 py-1 @error('address') border-red-500 @enderror" name="address" id="address">{{ $student->address }}</textarea>
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('address') {{ $message }} @enderror</p>
                            </div>

                            <div class="border-b border-gray-400 my-4"></div>
                            <h1 class="text-center text-blue-950 text-xl font-semibold">LEVEL & SECTION</h1>
                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-sm text-blue-950" for="year">Year</label>
                                <select value="{{ old('year') }}" class="bg-[#ADE3FE] border-black border rounded-lg p-2 @error('year') border-red-500 @enderror" type="number" name="year" id="year">
                                    <option value="1">1st</option>
                                    <option value="2">2nd</option>
                                    <option value="3">3rd</option>
                                    <option value="4">4th</option>
                                </select>
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('year') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex flex-col px-3 mt-2 relative">
                                <label class="font-semibold text-sm text-blue-950" for="section">Section</label>
                                <input value="{{ old('section') }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1 @error('section') border-red-500 @enderror" type="text" name="section" id="section">
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('section') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex-1 text-gray-400"></div>

                            <div class="flex justify-between px-3 w-full mb-3">
                                <button class="bg-green-300 px-5 rounded-lg border-black border">SAVE</button>
                                <a href="/student" class="bg-red-300 px-5 rounded-lg border-black border">BACK</a>
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
<script>
    const stream = new EventSource('http://localhost:8081/stream/current?stream=current');
    const rfidField = document.getElementById('rfid');

    stream.addEventListener('message', (e) => {
        rfidField.value = e.data;
    });
</script>
@endsection