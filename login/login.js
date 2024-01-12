function toggleForms() {
    var loginForm = document.getElementById("loginForm");
    var signupForm = document.getElementById("signupForm");

    if (loginForm.style.display === "none") {
        loginForm.style.display = "block";
        signupForm.style.display = "none";
    } else {
        loginForm.style.display = "none";
        signupForm.style.display = "block";
    }
}


function togglePassword() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.querySelector('.eye-icon');

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove('bx-hide');
        eyeIcon.classList.add('bx-show');
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove('bx-show');
        eyeIcon.classList.add('bx-hide');
    }
}

function toggleSignupPassword() {
    var signupPasswordInput = document.getElementById("signupPassword");
    var signupEyeIcon = document.querySelector('.signup-eye-icon');

    if (signupPasswordInput.type === "password") {
        signupPasswordInput.type = "text";
        signupEyeIcon.classList.remove('bx-hide');
        signupEyeIcon.classList.add('bx-show');
    } else {
        signupPasswordInput.type = "password";
        signupEyeIcon.classList.remove('bx-show');
        signupEyeIcon.classList.add('bx-hide');
    }
}