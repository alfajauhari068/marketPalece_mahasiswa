document.addEventListener('DOMContentLoaded', function () {
    const themeToggle = document.getElementById('themeToggle');
    const shell = document.body;
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebarPanel = document.querySelector('.dashboard-sidebar-panel');

    function setTheme(theme) {
        if (theme === 'dark') {
            shell.classList.add('dark');
            themeToggle.innerHTML = '<i class="bi bi-sun"></i>';
            localStorage.setItem('dashboardTheme', 'dark');
        } else {
            shell.classList.remove('dark');
            themeToggle.innerHTML = '<i class="bi bi-moon"></i>';
            localStorage.setItem('dashboardTheme', 'light');
        }
    }

    const savedTheme = localStorage.getItem('dashboardTheme');
    setTheme(savedTheme === 'dark' ? 'dark' : 'light');

    if (themeToggle) {
        themeToggle.addEventListener('click', function () {
            const isDark = shell.classList.contains('dark');
            setTheme(isDark ? 'light' : 'dark');
        });
    }

    if (sidebarToggle && sidebarPanel) {
        sidebarToggle.addEventListener('click', function () {
            shell.classList.toggle('sidebar-open');
        });
    }
});
