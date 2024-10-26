// Save this as navbar-script.js
document.addEventListener('DOMContentLoaded', function() {
    // Update copyright year
    document.getElementById('current-year').textContent = new Date().getFullYear();

    // Mobile menu toggle
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const navList = document.querySelector('.nav-list');
    let isMenuOpen = false;

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent event from bubbling up
            isMenuOpen = !isMenuOpen;
            navList.classList.toggle('active');
            // Update button text based on menu state
            mobileMenuBtn.textContent = isMenuOpen ? '×' : '☰';
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (isMenuOpen && !event.target.closest('.nav-list')) {
            navList.classList.remove('active');
            mobileMenuBtn.textContent = '☰';
            isMenuOpen = false;
        }
    });

    // Prevent menu from closing when clicking inside it
    navList.addEventListener('click', function(event) {
        event.stopPropagation();
    });

    // Highlight current page in navigation
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPage) {
            link.style.color = '#9ca3af';
        }
    });
});