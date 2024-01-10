function togglePassword() {
    var passwordInput = document.getElementById("password");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
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
        .then(data => handleResponse(data))
        .catch(error => console.error('Error:', error));
}

function setSignupAction() {
    submitForm('signup');
}