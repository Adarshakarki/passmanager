// Function to toggle the form's visibility
function toggleForm() {
    const overlay = document.getElementById('overlay');
    const addForm = document.getElementById('addForm');

    overlay.style.display = overlay.style.display === 'none' ? 'block' : 'none';
    addForm.style.display = addForm.style.display === 'none' ? 'block' : 'none';
}

// Function to toggle the saved data overlay's visibility
function toggleSavedDataOverlay() {
    const savedDataOverlay = document.getElementById('savedDataOverlay');
    savedDataOverlay.style.display = savedDataOverlay.style.display === 'none' ? 'block' : 'none';

    // Close the add form overlay when opening the saved data overlay
    const overlay = document.getElementById('overlay');
    overlay.style.display = 'none';
}

// Function to display a popup for a stored entry
function displayEntryPopup(entry, index) {
    const popupContainer = document.createElement('div');
    popupContainer.className = 'popup-container';

    const popupContent = document.createElement('div');
    popupContent.className = 'popup-content';
    popupContent.innerHTML = `
        <p><strong>Title:</strong> ${entry.title}</p>
        <p><strong>Website:</strong> ${entry.website}</p>
        <p><strong>Email:</strong> ${entry.email}</p>
        <p><strong>Password:</strong> ${entry.password}</p>
        <p><strong>Categories:</strong> ${entry.categories}</p>
        <button class="close-button" onclick="closeEntryPopup()">&#10006;</button>
        <button class="edit-icon" onclick="editEntry(${index})">✎ Edit</button>
        <button class="delete-icon" onclick="deleteEntryAndPopup(${index})">🗑 Delete</button>
    `;

    popupContainer.appendChild(popupContent);
    document.body.appendChild(popupContainer);
}

// Function to close the saved file popup
function closeEntryPopup() {
    const popupContainers = document.querySelectorAll('.popup-container');
    popupContainers.forEach(popup => document.body.removeChild(popup));
}

// Function to delete a stored entry and close the corresponding popup
function deleteEntryAndPopup(index) {
    const storedData = JSON.parse(localStorage.getItem('storedData')) || [];

    // Check if the index is valid
    if (index >= 0 && index < storedData.length) {
        // Remove the entry at the specified index
        storedData.splice(index, 1);

        // Save the updated array back to local storage
        localStorage.setItem('storedData', JSON.stringify(storedData));

        // Display the updated stored data on the page
        displayStoredData();

        // Close the corresponding popup
        closeEntryPopup();
    }
}

// Function to display stored data on the page
function displayStoredData() {
    const storedData = JSON.parse(localStorage.getItem('storedData')) || [];

    // Clear existing buttons
    const existingButtons = document.querySelectorAll('.entry-button');
    existingButtons.forEach(button => document.body.removeChild(button));

    // Display the data in the main content area with buttons
    storedData.forEach((entry, index) => {
        createEntryButton(entry, index);
    });
}

// Function to create a button for a stored entry in the main content area
function createEntryButton(entry, index) {
    const button = document.createElement('button');
    button.textContent = `${entry.title} - ${entry.email || 'N/A'}`;
    button.className = 'entry-button';
    button.onclick = function() {
        displayEntryPopup(entry, index);
    };

    document.body.appendChild(button);
}

// Function to handle form submission
function handleFormSubmit(event) {
    // Prevent the default form submission
    event.preventDefault();

    // Retrieve form values
    const titleElement = document.getElementById('title');
    const websiteElement = document.getElementById('website');
    const emailElement = document.getElementById('email');
    const passwordElement = document.getElementById('password');
    const categoriesElement = document.getElementById('categories');

    // Check if form elements exist before accessing their values
    if (!titleElement || !websiteElement || !emailElement || !passwordElement || !categoriesElement) {
        console.error('One or more form elements are not defined.');
        return;
    }

    // Create an object with the form values
    const entry = {
        title: titleElement.value,
        website: websiteElement.value,
        email: emailElement.value,
        password: passwordElement.value,
        categories: categoriesElement.value,
    };

    // Retrieve existing stored data or initialize an empty array
    let storedData = JSON.parse(localStorage.getItem('storedData')) || [];

    // Add the new entry to the array
    storedData.push(entry);

    // Save the updated array back to local storage
    localStorage.setItem('storedData', JSON.stringify(storedData));

    // Clear existing buttons and display the updated stored data on the page
    displayStoredData();

    // Close the form
    toggleForm();
}

// Attach event listener to form submission
document.getElementById('addForm').addEventListener('submit', handleFormSubmit);

// Optionally, display any existing stored data on page load
displayStoredData();