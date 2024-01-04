function togglePassword() {
    var passwordInput = document.getElementById("password");
    passwordInput.type = (passwordInput.type === "password") ? "text" : "password";
}

function submitForm(action) {
    var form = document.getElementById('loginForm');
    var formData = new FormData(form);
    formData.append('action', action);

    fetch(form.action, {
            method: form.method,
            body: formData,
        })
        .then(response => response.json())
        .catch(error => console.error('Error:', error));
}

function setSignupAction() {
    submitForm('signup');
}