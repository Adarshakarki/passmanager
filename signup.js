function togglePassword() {
    var passwordInput = document.getElementById("password");
    var eyeIcon = document.getElementById("eyeIcon");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeIcon.src = "eye-slash.svg"; // Change the eye icon to eye-slash.svg
    } else {
        passwordInput.type = "password";
        eyeIcon.src = "eye.svg"; // Change the eye icon back to eye.svg
    }
}