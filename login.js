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