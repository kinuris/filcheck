<script>
    const stream = new EventSource('http://localhost:8081/stream/current?stream=current');

    const profile = document.getElementById('profile');
    const studentId = document.getElementById('student_id');

    stream.addEventListener('message', async function(e) {
        const rfid = e.data;

        const [studentResponse, logResponse] = await Promise.all([
            fetch('/student/get/' + rfid),
            fetch('/event/node/attendance/log', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    rfid,
                    event_id: '{{ $event->id }}',
                }),
            }),
        ]);

        if (studentResponse.status !== 200) {
            studentId.classList.remove('text-green-500');
            studentId.classList.remove('text-red-500');
            studentId.classList.add('text-red-500');
            studentId.innerHTML = "(RFID NOT FOUND)";
            profile.src = "{{ asset('assets/placeholder.png') }}";

            return;
        }

        const {
            student
        } = await studentResponse.json();
        const log = await logResponse.json();

        profile.src = student.image;

        studentId.classList.remove('text-red-500');

        if (log.type === 'ENTER') {
            studentId.classList.add('text-green-500');
            const logTime = new Date(log.time.date).toLocaleString();
            studentId.innerHTML = `${student.first_name} ${student.last_name} ENTERED at ${logTime}`;
        } else {
            const logTime = new Date(log.time.date).toLocaleString();
            studentId.classList.add('text-red-500');
            studentId.innerHTML = `${student.first_name} ${student.last_name} EXITED at ${logTime}`;
        }
    });
</script>