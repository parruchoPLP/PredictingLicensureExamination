<!-- resources/views/components/clock.blade.php -->
<div id="clock" class="flex items-center space-x-4 py-3 px-4 font-arial rounded-xl bg-white dark:bg-slate-900 shadow-lg transition-transform transform hover:scale-105 cursor-pointer fixed top-4 right-56 z-20">
    <p id="time" class="font-semibold text-slate-900 dark:text-slate-200 text-2xl"></p>
</div>

<script>
    function updateTime() {
        const now = new Date();
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('time').textContent = `${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateTime, 1000);
    updateTime();
</script>
