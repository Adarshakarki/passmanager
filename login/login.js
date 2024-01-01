function togglePassword() {
    var passwordInput = document.getElementById("password");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}

// New functions for notifications
function handleResponse(response) {
    var notification = document.getElementById('notification');
    notification.textContent = response.message;
    notification.className = 'notification';

    // Add error class for error messages
    if (response.status === 'error') {
        notification.classList.add('error');
    }

    // Show notification
    notification.style.display = 'block';

    // Hide notification after a certain time (e.g., 3 seconds)
    setTimeout(function() {
        notification.style.display = 'none';
        notification.classList.remove('error');
    }, 3000);
}

function submitForm(action) {
    var form = document.getElementById('loginForm');
    var formData = new FormData(form);
    formData.append('action', action);

    // Use fetch API to submit the form asynchronously
    fetch(form.action, {
            method: form.method,
            body: formData,
        })
        .then(response => response.json())
        .then(data => handleResponse(data))
        .catch(error => console.error('Error:', error));
}

// Function to set signup action and submit the form
function setSignupAction() {
    submitForm('signup');
}