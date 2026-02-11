const navLinks = document.querySelectorAll('.nav-link');

if (navLinks.length > 0) {
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });
}