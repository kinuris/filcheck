@extends('layouts.teacher')

@section('content')
<div class="w-full">
    <div class="w-full inline-block h-full bg-white">
        <div class="h-16 p-4">
            <img src="{{ asset('assets/filcheck.svg') }}" alt="Logo">
        </div>
        <div class="p-4 mb-16 bg-blue-400 h-[calc(100%-8rem)]">
            <div class="flex w-full mb-3 justify-between">
                <h1 class="text-2xl font-extrabold text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]">STUDENT</h1>
            </div>
            <div class="rounded-lg shadow-lg bg-[#ADE3FE] h-[calc(100%-4rem)]">
                <form class="h-full" action="/student/edit/{{ $student->id }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    <div class="flex h-full">
                        <div class="flex-[2] p-3">
                            <div class="flex justify-center place-items-center aspect-square border-2 border-dashed border-slate-400 rounded-lg mb-5 bg-gray-50">
                                <img src="{{ $student->image() }}" class="rounded-lg object-cover aspect-square" alt="Profile Preview" id="preview">
                                <p class="hidden" id="profile-tag">Profile Picture</p>
                            </div>

                            <div class="flex">
                                <label class="text-white cursor-pointer bg-blue-800 p-3 rounded-lg font-bold" for="profile">UPLOAD</label>
                                <input class="sr-only" type="file" name="profile" id="profile" accept="image/png,image/jpg,image/jpeg">
                            </div>
                        </div>
                        <div class="flex-[3] border-l border-gray-400">
                            <h1 class="text-center mt-3 text-blue-950 text-xl font-semibold mb-4">BASIC INFO</h1>
                            <div class="flex justify-between place-items-center px-3">
                                <label class="font-semibold text-lg text-blue-950" for="rfid">RFID TAG</label>
                                <input value="{{ $student->rfid }}" class="bg-[#c3e8f8] border-black border rounded-lg px-2 py-1" readonly type="text" name="rfid" id="rfid">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="student_number">STUDENT NUMBER</label>
                                <input value="{{ $student->student_number }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="student_number" id="student_number">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="firstname">FIRST NAME</label>
                                <input value="{{ $student->first_name }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="first_name" id="firstname">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="middlename">MIDDLE NAME</label>
                                <input value="{{ $student->middle_name }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="middle_name" id="middlename">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="lastname">LAST NAME</label>
                                <input value="{{ $student->last_name }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="last_name" id="lastname">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="department">DEPARTMENT</label>
                                <select class="w-[195px] bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" name="department" id="department">
                                    @php($departments = \App\Models\Department::all())
                                    @foreach($departments as $department)
                                    <option {{ $student->department_id == $department->id ? 'selected' : '' }} value="{{ $department->id }}">{{ $department->name }} ({{ $department->code }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="gender">GENDER</label>
                                <select class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-2" name="gender" id="gender">
                                    <option {{ $student->gender == 'Male' ? 'selected' : '' }} value="Male">Male</option>
                                    <option {{ $student->gender == 'Female' ? 'selected' : '' }} value="Female">Female</option>
                                </select>
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="birthdate">BIRTHDATE</label>
                                <input value="{{ $student->birthdate }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="date" name="birthdate" id="birthdate">
                            </div>
                        </div>
                        <div class="flex-[3] border-l border-gray-400 flex flex-col">
                            <h1 class="text-center mt-3 text-blue-950 text-xl font-semibold mb-4">IN CASE OF EMERGENCY</h1>

                            <div class="flex justify-between place-items-center px-3">
                                <label class="font-semibold text-lg text-blue-950" for="phone">PHONE NUMBER</label>
                                <input value="{{ $student->phone_number }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="tel" name="phone_number" id="phone">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-sm text-blue-950" for="guardian">PARENT /<br>GUARDIANS</label>
                                <input value="{{ $student->guardian }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="tel" name="guardian" id="guardian">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="address">ADDRESS</label>
                                <textarea class="bg-[#ADE3FE] border-black border rounded-lg min-h-28 max-h-28 px-2 py-1" name="address" id="address">{{ $student->address }}</textarea>
                            </div>

                            <!-- <div class="flex justify-between place-items-center px-3">
                                <label class="font-semibold text-lg text-blue-950" for="username">USERNAME</label>
                                <input value="{{ old('username') }}" class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="text" name="username" id="username">
                            </div>

                            <div class="flex justify-between place-items-center px-3 mt-2">
                                <label class="font-semibold text-lg text-blue-950" for="password">PASSWORD</label>
                                <input class="bg-[#ADE3FE] border-black border rounded-lg px-2 py-1" type="password" name="password" id="password">
                            </div> -->

                            <div class="flex-1"></div>

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
</script>
@endsection