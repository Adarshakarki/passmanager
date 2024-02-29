document.addEventListener("DOMContentLoaded", function() {
    const openPopupButton = document.getElementById('openPopup');
    const closePopupButton = document.getElementById('closePopup');
    const popup = document.getElementById('popup');
    const overlay = document.getElementById('overlay');

    openPopupButton.addEventListener('click', function() {
        popup.style.display = 'block';
        overlay.style.display = 'block';
    });

    closePopupButton.addEventListener('click', function() {
        popup.style.display = 'none';
        overlay.style.display = 'none';
    });
});