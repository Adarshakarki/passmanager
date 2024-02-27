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