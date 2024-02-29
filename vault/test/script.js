function openPopup() {
    document.getElementById('password-popup').style.display = 'block';
}

function closePopup() {
    document.getElementById('password-popup').style.display = 'none';
}

function togglePasswordVisibility(element) {
    var passwordInput = element.parentElement.querySelector('#password');
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}

document.getElementById('add-password-form').addEventListener('submit', function(e) {
    e.preventDefault();

    // Get form values
    var title = document.getElementById('title').value;
    var website = document.getElementById('website').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Add password item to table
    var table = document.getElementById('password-table').getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.rows.length);
    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    var cell3 = newRow.insertCell(2);
    var cell4 = newRow.insertCell(3);
    cell1.innerHTML = title;
    cell2.innerHTML = website;
    cell3.innerHTML = email;
    cell4.innerHTML = password;

    // Close the popup
    closePopup();

    // Clear form fields
    document.getElementById('title').value = '';
    document.getElementById('website').value = '';
    document.getElementById('email').value = '';
    document.getElementById('password').value = '';
});