<div id="clock" class="flex items-center font-medium text-slate-700 dark:text-slate-300 text-md font-arial transition-transform border border-slate-300 rounded-full p-2 transform hover:scale-105 cursor-pointer">
    <p id="dateTime"></p> 
</div>

<script>
    function updateTime() {
        const now = new Date();
        
        // Get the current time
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        
        // Get the current date in m/d/y format
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
        const day = String(now.getDate()).padStart(2, '0');
        const year = now.getFullYear();
        const formattedDate = `${month}/${day}/${year}`;
        
        // Combine date, dot symbol, and time
        document.getElementById('dateTime').textContent = `${formattedDate} • ${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateTime, 1000);
    updateTime();
</script>
