<script>
    const rsStream = new EventSource('http://localhost:8081/stream/current?stream=current');
    const noReceiverNotifier = document.getElementById('no-receiver-notifier');

    rsStream.addEventListener('error', () => {
        noReceiverNotifier.classList.remove('hidden');
    });

    rsStream.addEventListener('open', () => {
        noReceiverNotifier.classList.add('hidden');
    });
</script>