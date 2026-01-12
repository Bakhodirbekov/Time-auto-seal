import '../css/app.css';

// Sidebar toggle function
window.toggleSidebar = function() {
    const sidebar = document.querySelector('aside');
    if (sidebar) {
        sidebar.classList.toggle('hidden');
    }
}
