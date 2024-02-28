const addButton = document.getElementById('addButton');
const popupOverlay = document.getElementById('popupOverlay');
const popupContent = document.getElementById('popupContent');
const closePopup = document.getElementById('closePopup');

addButton.addEventListener('click', () => {
    popupOverlay.style.display = 'block';
    popupContent.style.display = 'flex';
});

closePopup.addEventListener('click', () => {
    popupOverlay.style.display = 'none';
    popupContent.style.display = 'none';
});

document.getElementById('togglePassword').addEventListener('click', function() {
    var passwordField = document.getElementById('passwd');
    var toggleButton = document.getElementById('togglePassword');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleButton.innerHTML = '<i class=\'bx bx-hide\'></i>'; // Change the icon to a hide icon
    } else {
        passwordField.type = 'password';
        toggleButton.innerHTML = '<i class=\'bx bx-show\'></i>'; // Change the icon back to a show icon
    }
});

// Function to fetch data from the database and display in table
function fetchDataAndDisplayTable() {
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("savedDataContainer").innerHTML = xhr.responseText;
        }
    };
    xhr.open("GET", "vault.php", true);
    xhr.send();
}

// Fetch data when the page loads
window.onload = function() {
    fetchDataAndDisplayTable(); // Initial fetch and display of data
    // Attach event listener to the form for AJAX form submission
    document.getElementById("vaultForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        // Collect form data
        var formData = new FormData(this);

        // Send form data to vault.php using AJAX
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Request was successful, do something if needed
                    console.log("Form submitted successfully");
                    fetchDataAndDisplayTable(); // Update table after successful submission
                } else {
                    // Request failed
                    console.error("Form submission failed");
                }
            }
        };
        xhr.open("POST", "vault.php", true);
        xhr.send(formData);
    });
};