@extends(Auth::user()->role === 'Teacher' ? 'layouts.teacher' : 'layouts.admin')

@php
    $courseCodes = [
        "2yrMT",
        "2yrSBM",
        "ABAS",
        "ABChrE",
        "ABComm",
        "AB CSc",
        "ABEng",
        "ABEHCD",
        "ABGenS",
        "ABIntS",
        "ABMCom",
        "ABPsyc",
        "AB Sc",
        "ABTheo",
        "ABMath",
        "ABPolS",
        "AssAcc",
        "AssAgB",
        "AssAgC",
        "AssAgT",
        "AssAMT",
        "AssAES",
        "AssAP",
        "AssAS",
        "AssAD",
        "AsArch",
        "AA",
        "AA(cl)",
        "AA(Ph)",
        "AsAvEE",
        "AsAvET",
        "AsAvT",
        "AsAvTe",
        "AsBA",
        "AsBDP",
        "AsBMgt",
        "AsCET",
        "AsCoAr",
        "ACS",
        "AsCDP",
        "AsCEd",
        "AsCEng",
        "AsCoSc",
        "AsCoSe",
        "AsCoSt",
        "AsCoTe",
        "AsCrim",
        "ACA",
        "A.D.M.",
        "AsEET",
        "AFArts",
        "AFTech",
        "AFoTec",
        "AsFore",
        "A.G.E.",
        "A.H.T.",
        "AsHRM",
        "AsIChe",
        "AsITec",
        "ALibS",
        "A.M.E.",
        "A.M.T.",
        "AMsCom",
        "AMechE",
        "AMET",
        "AMedS",
        "AMusic",
        "APT",
        "APulT",
        "AREE",
        "A.R.T.",
        "ARelEd",
        "ARespT",
        "AssSci",
        "A.SecA",
        "ASecS",
        "AsTT",
        "AJS",
        "BAAnth",
        "BABrCo",
        "BABA",
        "BACDEd",
        "BAComm",
        "BACoAt",
        "BACoRe",
        "BACDPs",
        "BACT",
        "BACoop",
        "BADevC",
        "BADevS",
        "BAEco",
        "BAEd",
        "BAEng",
        "BAFAC",
        "BAHist",
        "BAHum",
        "BAIsS",
        "BAJour",
        "BALegM",
        "BALing",
        "BALitE",
        "BALitP",
        "BAME",
        "BAMsCo",
        "BAMath",
        "BAOrCo",
        "BAPhAr",
        "BAPhil",
        "BAPil",
        "BAPoSc",
        "BAPsyc",
        "BAPubA",
        "BAPubR",
        "BARelS",
        "BASocS",
        "BASoc",
        "BASpCo",
        "BAThAr",
        "BATheo",
        "BATour",
        "BA",
        "BAdv",
        "BAppDS",
        "BAppSc",
        "BBF",
        "BAB",
        "BBsMgt",
        "BBE",
        "BBTE",
        "BCDPM",
        "BCM",
        "BCS",
        "BCT",
        "BCoop",
        "BEd",
        "BEntMg",
        "BFishT",
        "BHBT",
        "BIndT",
        "BInfoT",
        "BITM",
        "BMLS",
        "BOA",
        "BPE",
        "BAPW",
        "BPolEc",
        "BRB",
        "BTHELE",
        "BTheo",
        "BTrnsM",
        "BBA",
        "BAgT",
        "BAgFT",
        "AB",
        "ABCEd",
        "ABArts",
        "ABPhil",
        "ABPsyc",
        "ABTheo",
        "BBA",
        "BBM",
        "BACMin",
        "BECCD",
        "BECE",
        "BEdHE",
        "BEEd",
        "BEngg",
        "ABFArt",
        "BFoT",
        "BHTech",
        "BIntD",
        "BKEd",
        "BLArch",
        "LLB",
        "BLISc",
        "BLibSc",
        "BMComm",
        "BMusic",
        "BMuPia",
        "BPhilo",
        "BPhyEd",
        "BARELI",
        "BS",
        "BSEEd",
        "BSE",
        "BSHTE",
        "BSIntD",
        "BSTLEd",
        "BSPsyc",
        "BSEd",
        "BSecA",
        "BSpecE",
        "BSpoSc",
        "BTTHE",
        "BTTE",
        "BTeceD",
        "BTTE",
        "BTech",
        "BTHM",
        "BComSc",
        "BSAgD",
        "BSAgEx",
        "BSAgEE",
        "BSAgro",
        "BSAqua",
        "BSBCA",
        "BSCheT",
        "BSCPsy",
        "BSCDPM",
        "BSCoEd",
        "BSCSec",
        "BSEco",
        "BSETec",
        "BSESE",
        "BSHAE",
        "BSA",
        "BSAE",
        "BSAeE",
        "BSAgrB",
        "BSAAdm",
        "BSABM",
        "BSAgAD",
        "BSAChe",
        "BSAgE",
        "BSAgEd",
        "BSAgrE",
        "BSAgEx",
        "BSAgrH",
        "BSAgHE",
        "BSAgT",
        "BSAgri",
        "BSAgrF",
        "BSAgFE",
        "BSAME",
        "BSAMT",
        "BSAirT",
        "BSABA",
        "BSAMA",
        "BSAH",
        "BSASc",
        "BSAnT",
        "BSAB",
        "BSAC",
        "BSAEco",
        "BSAMat",
        "BSApP",
        "BSApSt",
        "BSArch",
        "BSAMT",
        "BSATCE",
        "BSAEE",
        "BSAvET",
        "BSAvT",
        "BSAviT",
        "BSBFin",
        "BSBS",
        "BSBioc",
        "BSBioS",
        "BSBio",
        "BSBot",
        "BSBCom",
        "BSBA",
        "BSBAA",
        "BSBCA",
        "BSBDP",
        "BSBE",
        "BSBEd",
        "BSBM",
        "BSBT",
        "BSCerE",
        "BSChE",
        "BSChem",
        "BSCDE",
        "BSChrE",
        "BSCE",
        "BSCT",
        "BSC",
        "BSCoE",
        "BSCoE",
        "BSCD",
        "BSCH",
        "BSCN",
        "BSCAM",
        "BSCIC",
        "BSCDP",
        "BSCEd",
        "BSCEng",
        "BSClim",
        "BSComm",
        "BSCrim",
        "BSCS",
        "BSCSc",
        "BSEd",
        "BSEcE",
        "BSFT",
        "BSGeo",
        "BSHist",
        "BSJour",
        "BSLibS",
        "BSMath",
        "BSMetE",
        "BSMTech",
        "BSPhys",
        "BSPhyT",
        "BSSE",
        "BSSoc",
        "BSSW",
        "BSTour",
        "BSVetM",
        "BSZoo"
    ];
@endphp

@section('content')
<div class="w-full relative">
    <!-- @include('includes.receiver-notifier') -->
    <div class="w-full inline-block h-full bg-white">
        <div class="h-16 p-4">
            <img class="h-10" src="{{ asset('assets/filcheck.png') }}" alt="Logo">
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

                        <div class="flex-[3] border-l border-gray-200 p-4">
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
                                    <div class="grid grid-cols-10 gap-4">
                                        <div class="col-span-3 relative">
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="year">Year Level</label>
                                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('year') border-red-500 @enderror" name="year" id="year">
                                                <option value="1" {{ $student->year == '1' ? 'selected' : '' }}>1st</option>
                                                <option value="2" {{ $student->year == '2' ? 'selected' : '' }}>2nd</option>
                                                <option value="3" {{ $student->year == '3' ? 'selected' : '' }}>3rd</option>
                                                <option value="4" {{ $student->year == '4' ? 'selected' : '' }}>4th</option>
                                            </select>
                                            @error('year')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>

                                        @php([$sectCode, $sectLetter] = $student->getCodeAndSection())

                                        <div class="col-span-2 relative">
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="section_letter">Section</label>
                                            <select class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('section_letter') border-red-500 @enderror" name="section_letter" id="section_letter">
                                                <option value="A" {{ $sectLetter == 'A' ? 'selected' : '' }}>A</option>
                                                <option value="B" {{ $sectLetter == 'B' ? 'selected' : '' }}>B</option>
                                                <option value="C" {{ $sectLetter == 'C' ? 'selected' : '' }}>C</option>
                                                <option value="D" {{ $sectLetter == 'D' ? 'selected' : '' }}>D</option>
                                                <option value="E" {{ $sectLetter == 'E' ? 'selected' : '' }}>E</option>
                                            </select>
                                            @error('section_letter')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                                        </div>
                                        <div class="col-span-5 relative">
                                            <label class="block text-sm font-medium text-gray-700 mb-1" for="section">Course Code</label>
                                            <div class="relative">
                                                <input type="text" id="course-search" placeholder="Search course code..." class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" autocomplete="false">
                                                <div id="course-dropdown" class="absolute z-[100] w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden" style="position: absolute; left: 0; right: 0; bottom: 120%;"
                                                    @foreach($courseCodes as $code)
                                                    <option value="{{ $code }}" {{ old('section') == $code ? 'selected' : '' }}>{{ $code }}</option>
                                                    @endforeach
                                                    <!-- Course options will be populated here -->
                                                </div>
                                            </div>
                                            @error('section')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
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
    // Get the dropdown elements
    const courseSearch = document.getElementById('course-search');
    const courseDropdown = document.getElementById('course-dropdown');
    let selectedCourse = '';

    // Create hidden input field for the actual value
    const courseInput = document.createElement('input');
    courseInput.type = 'hidden';
    courseInput.name = 'section';
    courseInput.value = "{{ $sectCode }}";
    courseSearch.parentNode.appendChild(courseInput);

    // Set initial value
    if (courseInput.value) {
        courseSearch.value = courseInput.value;
        selectedCourse = courseInput.value;
    }

    // Handle showing the dropdown
    courseSearch.addEventListener('focus', () => {
        courseDropdown.classList.remove('hidden');
        filterCourses();
    });

    // Handle hiding dropdown when clicking outside
    document.addEventListener('click', (e) => {
        if (!courseSearch.contains(e.target) && !courseDropdown.contains(e.target)) {
            courseDropdown.classList.add('hidden');
        }
    });

    // Handle filtering courses as user types
    courseSearch.addEventListener('input', filterCourses);

    function filterCourses() {
        const searchTerm = courseSearch.value.toUpperCase();
        const options = courseDropdown.querySelectorAll('option');
        let hasMatch = false;

        // Clear dropdown first
        courseDropdown.innerHTML = '';

        // Filter and add matching courses
        @foreach($courseCodes as $code) {
            const code = "{{ $code }}";
            if (code.toUpperCase().includes(searchTerm)) {
                hasMatch = true;
                const option = document.createElement('div');
                option.className = 'px-3 py-2 cursor-pointer hover:bg-gray-100';
                option.textContent = code;
                if (code === selectedCourse) {
                    option.classList.add('bg-blue-50');
                }
                option.addEventListener('click', () => {
                    courseSearch.value = code;
                    courseInput.value = code;
                    selectedCourse = code;
                    courseDropdown.classList.add('hidden');
                });
                courseDropdown.appendChild(option);
            }
        }
        @endforeach

        // Show or hide dropdown based on results
        if (!hasMatch) {
            const noMatch = document.createElement('div');
            noMatch.className = 'px-3 py-2 text-gray-500 italic';
            noMatch.textContent = 'No matching courses found';
            courseDropdown.appendChild(noMatch);
        }
    }

    // Initial population of dropdown
    filterCourses();
</script>

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