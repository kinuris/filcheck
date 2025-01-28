@extends(Auth::user()->role === 'Teacher' ? 'layouts.teacher' : 'layouts.admin')

@section('content')
<div class="w-full relative">
    <!-- @include('includes.receiver-notifier') -->
    <div class="w-full inline-block h-full bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="p-4  bg-gradient-to-r from-blue-500 to-blue-600">
            <div class="rounded-lg shadow-lg bg-white min-h-[calc(100%-4rem)] max-h-[calc(100%-1rem)] overflow-auto">
                <form action="/student/edit/{{ $student->id }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="flex h-full">
                        <div class="flex-[2] p-4 bg-gray-50">
                            <h2 class="text-xl font-semibold text-gray-700 mb-4">Profile Photo</h2>
                            <div class="aspect-square rounded-xl max-w-28 mx-auto mb-4 scale-x-[-1] overflow-hidden shadow-lg bg-black" id="vid-container">
                                <video class="object-cover h-full" id="video" autoplay></video>
                            </div>

                            <div class="hidden aspect-square rounded-xl overflow-hidden shadow-lg bg-black" id="canvas-container">
                                <canvas id="canvas"></canvas>
                            </div>

                            <div class="flex relative justify-center place-items-center aspect-square border-2 border-dashed border-blue-300 rounded-xl mb-4 bg-gray-50 hover:border-blue-500 transition-colors">
                                <img src="{{ $student->image() }}" class="object-cover aspect-square rounded-lg" name="profile" alt="Profile Preview" id="preview">
                                <p id="profile-tag" class="hidden text-gray-500">Profile Picture</p>
                                <p class="text-red-500 text-xs mt-1 absolute -bottom-4 right-3">@error('profile') {{ $message }} @enderror</p>
                            </div>

                            <div class="flex mt-4 gap-2">
                                <label class="flex-1 text-center text-white cursor-pointer bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-lg font-semibold transition-colors" for="profile">Upload</label>
                                <input class="sr-only" type="file" name="profile" id="profile" accept="image/png,image/jpg,image/jpeg">
                                <button class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-semibold px-4 py-2 rounded-lg cursor-pointer transition-colors" id="snap" type="button">Capture</button>
                            </div>
                        </div>

                        <div class="flex-[3] border-l border-gray-200 p-4">
                            <h2 class="text-xl font-semibold text-gray-700 mb-4">Basic Information</h2>

                            <div class="grid gap-4">
                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="rfid">RFID Tag</label>
                                    <input value="{{ $student->rfid }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="text" name="rfid" id="rfid" readonly>
                                    @error('rfid')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="student_number">Student Number</label>
                                    <input value="{{ $student->student_number }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('student_number') border-red-500 @enderror" type="text" name="student_number" id="student_number">
                                    @error('student_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div class="grid gap-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="firstname">First Name</label>
                                            <input value="{{ $student->first_name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-500 @enderror" type="text" name="first_name" id="firstname">
                                            @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>

                                        <div class="relative">
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="middlename">Middle Name</label>
                                            <input value="{{ $student->middle_name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="text" name="middle_name" id="middlename">
                                            @error('middle_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>

                                    <div class="relative">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="lastname">Last Name</label>
                                        <input value="{{ $student->last_name }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('last_name') border-red-500 @enderror" type="text" name="last_name" id="lastname">
                                        @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="department">Department</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="department" id="department">
                                            @php($departments = \App\Models\Department::all())
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}" {{ $student->department_id == $department->id ? 'selected' : '' }}>{{ $department->name }} ({{ $department->code }})</option>
                                            @endforeach
                                        </select>
                                        @error('department')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div class="relative">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="gender">Gender</label>
                                        <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="gender" id="gender">
                                            <option value="Male" {{ $student->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                            <option value="Female" {{ $student->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                        </select>
                                        @error('gender')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="birthdate">Birthdate</label>
                                    <input value="{{ $student->birthdate }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="date" name="birthdate" id="birthdate">
                                    @error('birthdate')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="flex-[2] border-l border-gray-200 p-4">
                            <h2 class="text-xl font-semibold text-gray-700 mb-4">Emergency Contact</h2>

                            <div class="grid gap-4">
                                <div class="flex gap-4 items-end">
                                    <div class="flex-1 relative">
                                        <label class="block text-sm font-medium text-gray-700 mb-1" for="phone">Phone Number</label>
                                        <input value="{{ $student->phone_number }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="tel" name="phone_number" id="phone">
                                        @error('phone_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                    </div>
                                    
                                </div>

                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="guardian">Parent/Guardian</label>
                                    <input value="{{ $student->guardian }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" type="text" name="guardian" id="guardian">
                                    @error('guardian')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div class="relative">
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="address">Address</label>
                                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 min-h-24" name="address" id="address">{{ $student->address }}</textarea>
                                    @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div class="pt-4 border-t border-gray-200">
                                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Level & Section</h2>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="relative">
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="year">Year Level</label>
                                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" name="year" id="year">
                                                <option {{ $student->year == 1 ? 'selected' : '' }} value="1">1st Year</option>
                                                <option {{ $student->year == 2 ? 'selected' : '' }} value="2">2nd Year</option>
                                                <option {{ $student->year == 3 ? 'selected' : '' }} value="3">3rd Year</option>
                                                <option {{ $student->year == 4 ? 'selected' : '' }} value="4">4th Year</option>
                                            </select>
                                            @error('year')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>

                                        <div class="relative">
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="section">Section</label>
                                            <input placeholder="Ex. BSCS-3A" value="{{ $student->section }}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 uppercase" type="text" name="section" id="section">
                                            @error('section')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-4 mt-4">
                                    <a href="/student" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">Cancel</a>
                                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">Save Changes</button>
                                </div>
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
@include('includes.receiver-script')
<script>
    const section = document.getElementById('section');

    section.addEventListener('keydown', (event) => {
        if (event.key === ' ') {
            event.preventDefault();
            return false;
        }

        return true;
    })
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
@endsection