function openPopup() {
    document.getElementById('popup').style.display = 'flex';
}

function closePopup() {
    // Hide the popup
    document.getElementById('popup').style.display = 'none';

    // Clear the form fields
    document.getElementById('title').value = '';
    document.getElementById('website').value = '';
    document.getElementById('email').value = '';
    document.getElementById('password').value = '';
    document.getElementById('category').value = '';
}

function togglePassword() {
    var passwordInput = document.getElementById("password");
    var togglePassword = document.getElementById("togglePassword");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        togglePassword.textContent = "Hide";
    } else {
        passwordInput.type = "password";
        togglePassword.textContent = "Show";
    }
}

function saveVaultEntry() {
    // Get form values
    var title = document.getElementById('title').value;
    var website = document.getElementById('website').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    // Get the selected category value
    var categoryElement = document.getElementById('category');
    var category = categoryElement.options[categoryElement.selectedIndex].text;

    // Create a new entry object with a unique identifier
    var entryId = Date.now();
    var entry = {
        id: entryId,
        title: title,
        website: website,
        email: email,
        password: password,
        category: category
    };

    // Retrieve existing entries from local storage or initialize an empty array
    var existingEntries = JSON.parse(localStorage.getItem('vaultEntries')) || [];

    // Add the new entry to the array
    existingEntries.push(entry);

    // Save the updated entries array back to local storage
    localStorage.setItem('vaultEntries', JSON.stringify(existingEntries));

    // Update the displayed entries (create a function to update the UI)
    updateDisplayedEntries();

    // Close the popup and clear the form
    closePopup();
}

// Function to update the displayed entries in the UI
function updateDisplayedEntries() {
    // Retrieve existing entries from local storage
    var existingEntries = JSON.parse(localStorage.getItem('vaultEntries')) || [];

    // Clear the existing entries in the UI
    var vaultEntriesContainer = document.getElementById('vaultEntries');
    vaultEntriesContainer.innerHTML = '';

    // Loop through the entries and recreate the UI
    existingEntries.forEach(function(entry) {
        var entryContainer = document.createElement('div');
        entryContainer.classList.add('entry-container');
        entryContainer.setAttribute('data-entry-id', entry.id);

        var entryButton = document.createElement('button');
        entryButton.innerHTML = `<strong>${entry.title}</strong><br>${entry.email}`;

        entryButton.addEventListener('click', function() {
            openEntryPopup(entry.title, entry.website, entry.email, entry.password, entry.category, entry.id);
        });

        entryContainer.appendChild(entryButton);
        vaultEntriesContainer.appendChild(entryContainer);
    });
}

function openEntryPopup(title, website, email, password, category, entryId) {
    // Create a new dark overlay
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);

    // Create a new popup for the entry
    var entryPopup = document.createElement('div');
    entryPopup.classList.add('entry-popup');
    entryPopup.setAttribute('data-entry-id', entryId); // Set data-entry-id attribute to identify the entry

    // Define categories (replace this with your actual category options)
    var categories = ['Website', 'Personal', 'Work', 'Application', 'Game'];

    // Generate category options for the dropdown
    var categoryOptions = categories.map(cat => `<option value="${cat}" ${cat === category ? 'selected' : ''}>${cat}</option>`).join('');

    // Populate entry popup with editable text fields and buttons
    entryPopup.innerHTML = `
        <div class="entry-container">
            <div class="entry-header">
            <input type="text" id="editTitle" value="${title}" /><br />
            </div>
            <div class="entry-details">
                <p><strong>Website:</strong> <input type="text" id="editWebsite" value="${website}" /></p>
                <p><strong>Email:</strong> <input type="text" id="editEmail" value="${email}" /></p>
                <p><strong>Password:</strong> <input type="text" id="editPassword" value="${password}" /></p>
                <p><strong>Category:</strong>
                    <select id="editCategory">
                        ${categoryOptions}
                    </select>
                </p>
            </div>
            <div class="entry-footer">
                <button class="edit-button" onclick="saveEditedEntry(${entryId})">Save</button>
                <button class="delete-button" onclick="deleteEntry(${entryId})">Delete</button>
                <button class="close-button" onclick="closeEntryPopup(${entryId})">X</button>
            </div>
        </div>
    `;
    // Append entry popup to the body
    document.body.appendChild(entryPopup);

    // Set initial values for the dropdown and update on changes
    var editCategoryDropdown = document.getElementById('editCategory');
    editCategoryDropdown.value = category;

    // Event listener to update dropdown value when changed
    editCategoryDropdown.addEventListener('change', function() {
        category = editCategoryDropdown.value;
    });

    // Function to close the popup and overlay
    window.closeEntryPopup = function(id) {
        var entryOverlay = document.querySelector(`.overlay[data-entry-id="${id}"]`);
        var entryPopup = document.querySelector(`.entry-popup[data-entry-id="${id}"]`);

        document.body.removeChild(entryOverlay);
        document.body.removeChild(entryPopup);

        window.closeEntryPopup = null;
    };

    // Set data-entry-id attribute to identify the entry
    overlay.setAttribute('data-entry-id', entryId);
    entryPopup.setAttribute('data-entry-id', entryId);
}

function saveEditedEntry(entryId) {
    // Get edited values from text fields and dropdown
    var editedTitle = document.getElementById('editTitle').value;
    var editedWebsite = document.getElementById('editWebsite').value;
    var editedEmail = document.getElementById('editEmail').value;
    var editedPassword = document.getElementById('editPassword').value;
    var editedCategory = document.getElementById('editCategory').value;

    // Retrieve existing entries from local storage or initialize an empty array
    var existingEntries = JSON.parse(localStorage.getItem('vaultEntries')) || [];

    // Find the index of the entry to be edited
    var entryIndex = existingEntries.findIndex(entry => entry.id === entryId);

    if (entryIndex !== -1) {
        // Update the entry with the edited values
        existingEntries[entryIndex] = {
            id: entryId,
            title: editedTitle,
            website: editedWebsite,
            email: editedEmail,
            password: editedPassword,
            category: editedCategory
        };

        // Save the updated entries array back to local storage
        localStorage.setItem('vaultEntries', JSON.stringify(existingEntries));

        // Update the displayed entry in the vaultEntries section
        updateDisplayedEntry(entryId, editedTitle, editedEmail);
    }

    // Close the popup after saving edits
    closeEntryPopup(entryId);
}

function updateDisplayedEntry(entryId, editedTitle, editedEmail) {
    // Find the entry container in the DOM using its data-entry-id attribute
    var entryContainer = document.querySelector(`.entry-container[data-entry-id="${entryId}"]`);

    if (entryContainer) {
        // Update the button's inner HTML with the edited title and email
        var entryButton = entryContainer.querySelector('button');
        entryButton.innerHTML = `<strong>${editedTitle}</strong><br>${editedEmail}`;
    }
}

function closeEntryPopup(id) {
    // Remove the entry popup with the specified entryId
    var entryOverlay = document.querySelector(`.overlay[data-entry-id="${id}"]`);
    var entryPopup = document.querySelector(`.entry-popup[data-entry-id="${id}"]`);

    if (entryOverlay && entryPopup) {
        document.body.removeChild(entryOverlay);
        document.body.removeChild(entryPopup);
    }

    // Remove the closeEntryPopup function
    window.closeEntryPopup = null;
}

function deleteEntry(entryId) {
    // Remove the entry button and corresponding popup
    var entryContainer = document.querySelector(`.entry-container[data-entry-id="${entryId}"]`);
    var entryOverlay = document.querySelector(`.overlay[data-entry-id="${entryId}"]`);
    var entryPopup = document.querySelector(`.entry-popup[data-entry-id="${entryId}"]`);

    if (entryContainer && entryOverlay && entryPopup) {
        entryContainer.remove();
        document.body.removeChild(entryOverlay);
        document.body.removeChild(entryPopup);
    }

    // Remove the entry from local storage
    var existingEntries = JSON.parse(localStorage.getItem('vaultEntries')) || [];
    var updatedEntries = existingEntries.filter(entry => entry.id !== entryId);
    localStorage.setItem('vaultEntries', JSON.stringify(updatedEntries));
}