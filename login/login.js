function toggleForms() {
    var loginForm = document.querySelector('form[action="login.php"]');
    var signupForm = document.querySelector('form[action="signup.php"]');

    if (loginForm.style.display === 'none') {
        loginForm.style.display = 'block';
        signupForm.style.display = 'none';
    } else {
        loginForm.style.display = 'none';
        signupForm.style.display = 'block';
    }
}

function togglePassword() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.querySelector('.password-container .ph-eye');

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.classList.remove('ph-eye-slash');
        eyeIcon.classList.add('ph-eye');
    } else {
        passwordInput.type = "password";
        eyeIcon.classList.remove('ph-eye');
        eyeIcon.classList.add('ph-eye-slash');
    }
}

function toggleSignupPassword() {
    var signupPasswordInput = document.getElementById("signupPassword");
    var signupEyeIcon = document.querySelector('#signupForm .password-container .ph-eye');

    if (signupPasswordInput.type === "password") {
        signupPasswordInput.type = "text";
        signupEyeIcon.classList.remove('ph-eye-slash');
        signupEyeIcon.classList.add('ph-eye');
    } else {
        signupPasswordInput.type = "password";
        signupEyeIcon.classList.remove('ph-eye');
        signupEyeIcon.classList.add('ph-eye-slash');
    }
}