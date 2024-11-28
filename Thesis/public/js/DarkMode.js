document.addEventListener('DOMContentLoaded', function () {
    const currentPath = window.location.pathname;
    if (currentPath !== "/acctmanagement") {
        const darkmodeToggle = document.getElementById('darkmode-toggle');
        const darkmodeIcon = document.getElementById('darkmode-icon');
        const body = document.body;
        function updateDarkmodeIcon() {
            if (body.classList.contains('dark')) {
                darkmodeIcon.classList.remove('fa-moon');
                darkmodeIcon.classList.add('fa-sun');
            } else {
                darkmodeIcon.classList.remove('fa-sun');
                darkmodeIcon.classList.add('fa-moon');
            }
        }
        // Initialize dark mode based on localStorage
        if (localStorage.getItem('darkmode') === 'true') {
            body.classList.add('dark');
        }
        // Initialize icon state on page load
        updateDarkmodeIcon();

        darkmodeToggle.addEventListener('click', function () {
            body.classList.toggle('dark');
            updateDarkmodeIcon(); 
            // Save the current dark mode state to localStorage
            localStorage.setItem('darkmode', body.classList.contains('dark'));
            fetch('/toggle-darkmode', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ darkmode: body.classList.contains('dark') })
            });
        });
    }
});