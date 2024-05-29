// Function to toggle the navigation menu on smaller screens
function toggleNav() {
    var nav = document.getElementById('navMenu');
    if (nav.style.display === 'block') {
        nav.style.display = 'none';
    } else {
        nav.style.display = 'block';
    }
}

// Function to validate the registration form
function validateForm() {
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var email = document.getElementById('email').value;

    // Simple validation checks
    if (username.trim() == '') {
        alert('Please enter a username.');
        return false;
    }

    if (password.trim() == '') {
        alert('Please enter a password.');
        return false;
    }

    if (email.trim() == '') {
        alert('Please enter an email.');
        return false;
    }

    // Additional validation checks can be added here

    return true; // Form will submit if all validations pass
}

// Add event listeners for menu toggling and form validation
document.addEventListener('DOMContentLoaded', function () {
    var menuButton = document.getElementById('menuButton');
    if (menuButton) {
        menuButton.addEventListener('click', toggleNav);
    }

    var registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', validateForm);
    }
});
