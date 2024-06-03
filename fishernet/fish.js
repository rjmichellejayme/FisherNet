function toggleNav() {
  var nav = document.getElementById("navMenu");
  if (nav.style.display === "block") {
    nav.style.display = "none";
  } else {
    nav.style.display = "block";
  }
}

function validateForm() {
  var username = document.getElementById("username").value;
  var password = document.getElementById("password").value;
  var email = document.getElementById("email").value;

  if (username.trim() == "") {
    alert("Please enter a username.");
    return false;
  }

  if (password.trim() == "") {
    alert("Please enter a password.");
    return false;
  }

  if (email.trim() == "") {
    alert("Please enter an email.");
    return false;
  }

  return true;
}

document.addEventListener("DOMContentLoaded", function () {
  var menuButton = document.getElementById("menuButton");
  if (menuButton) {
    menuButton.addEventListener("click", toggleNav);
  }

  var registerForm = document.getElementById("registerForm");
  if (registerForm) {
    registerForm.addEventListener("submit", validateForm);
  }
});
