function togglePassword() {
    var passwordInput = document.getElementById('password');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
}

// Add this function to handle form submission
function handleFormSubmission(event) {
    event.preventDefault(); // Prevent the default form submission

    var formData = new FormData(document.getElementById('loginForm'));

    fetch('your_php_script.php', {
            method: 'POST',
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alert(data.message);
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Attach the handleFormSubmission function to the form's submit event
document.getElementById('loginForm').addEventListener('submit', handleFormSubmission);