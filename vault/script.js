updateDisplayedEntries();

function openPopup() {
    document.getElementById('popup').style.display = 'flex';
}

function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('title').value = '';
    document.getElementById('website').value = '';
    document.getElementById('email').value = '';
    document.getElementById('password').value = '';
    document.getElementById('category').value = '';
}

function customTogglePasswordVisibility() {
    var passwordInput = document.getElementById("password");
    var toggleButton = document.getElementById("togglePassword");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleButton.innerHTML = '<i class="bx bx-hide"></i>';
    } else {
        passwordInput.type = "password";
        toggleButton.innerHTML = '<i class="bx bx-show"></i>';
    }
}

function togglePasswordVisibility() {
    var passwordInput = document.getElementById("editPassword");
    var toggleButton = document.getElementById("toggleEditPasswordButton");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        toggleButton.innerHTML = '<i class="bx bx-hide"></i>'; // Boxicon "eye-slash" icon for hide
    } else {
        passwordInput.type = "password";
        toggleButton.innerHTML = '<i class="bx bx-show"></i>'; // Boxicon "eye" icon for show
    }
}

function saveVaultEntry() {
    var title = document.getElementById('title').value;
    var website = document.getElementById('website').value;
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;
    var categoryElement = document.getElementById('category');
    var category = categoryElement.options[categoryElement.selectedIndex].text;
    var entryId = Date.now();
    var entry = {
        id: entryId,
        title: title,
        website: website,
        email: email,
        password: password,
        category: category
    };

    var existingEntries = JSON.parse(localStorage.getItem('vaultEntries')) || [];
    var existingEntryIndex = existingEntries.findIndex(existingEntry => existingEntry.title === title);
    if (existingEntryIndex !== -1) {
        existingEntries[existingEntryIndex] = entry;
    } else {
        existingEntries.push(entry);
    }
    localStorage.setItem('vaultEntries', JSON.stringify(existingEntries));
    updateDisplayedEntries();
    closePopup();
}

function updateDisplayedEntries() {
    var existingEntries = JSON.parse(localStorage.getItem('vaultEntries')) || [];
    var vaultEntriesContainer = document.getElementById('vaultEntries');
    vaultEntriesContainer.innerHTML = '';
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
    var overlay = document.createElement('div');
    overlay.classList.add('overlay');
    document.body.appendChild(overlay);
    var entryPopup = document.createElement('div');
    entryPopup.classList.add('entry-popup');
    entryPopup.setAttribute('data-entry-id', entryId);
    var categories = ['Website', 'Personal', 'Work', 'Application', 'Game'];
    var categoryOptions = categories.map(cat => `<option value="${cat}" ${cat === category ? 'selected' : ''}>${cat}</option>`).join('');
    entryPopup.innerHTML = `
        <div class="entry-container">
            <div class="entry-header">
            <p><strong>Title:</strong> <input type="text" id="editTitle" value="${title}" /><br />
            </div>
            <div class="entry-details">
                <p><strong>Website:</strong> <input type="text" id="editWebsite" value="${website}" /></p>
                <p><strong>Email:</strong> <input type="text" id="editEmail" value="${email}" /></p>
                <p>
                <strong>Password:</strong>
                <div class="password-container">
                    <input type="password" id="editPassword" value="${password}" />
                    <button type="button" id="toggleEditPasswordButton" onclick="togglePasswordVisibility()" class="toggle-password-icon">
                        <i class="bx bx-show"></i> <!-- Initial icon, you can customize it -->
                    </button>
                </div>
            </p>         
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
    document.body.appendChild(entryPopup);
    var editCategoryDropdown = document.getElementById('editCategory');
    editCategoryDropdown.value = category;
    editCategoryDropdown.addEventListener('change', function() {
        category = editCategoryDropdown.value;
    });
    window.closeEntryPopup = function(id) {
        var entryOverlay = document.querySelector(`.overlay[data-entry-id="${id}"]`);
        var entryPopup = document.querySelector(`.entry-popup[data-entry-id="${id}"]`);

        document.body.removeChild(entryOverlay);
        document.body.removeChild(entryPopup);

        window.closeEntryPopup = null;
    };
    overlay.setAttribute('data-entry-id', entryId);
    entryPopup.setAttribute('data-entry-id', entryId);
}

function saveEditedEntry(entryId) {
    var editedTitle = document.getElementById('editTitle').value;
    var editedWebsite = document.getElementById('editWebsite').value;
    var editedEmail = document.getElementById('editEmail').value;
    var editedPassword = document.getElementById('editPassword').value;
    var editedCategory = document.getElementById('editCategory').value;
    var existingEntries = JSON.parse(localStorage.getItem('vaultEntries')) || [];
    var entryIndex = existingEntries.findIndex(entry => entry.id === entryId);

    if (entryIndex !== -1) {
        existingEntries[entryIndex] = {
            id: entryId,
            title: editedTitle,
            website: editedWebsite,
            email: editedEmail,
            password: editedPassword,
            category: editedCategory
        };
        localStorage.setItem('vaultEntries', JSON.stringify(existingEntries));
        updateDisplayedEntry(entryId, editedTitle, editedEmail);
    }
    closeEntryPopup(entryId);
}

function updateDisplayedEntry(entryId, editedTitle, editedEmail) {
    var entryContainer = document.querySelector(`.entry-container[data-entry-id="${entryId}"]`);
    if (entryContainer) {
        var entryButton = entryContainer.querySelector('button');
        entryButton.innerHTML = `<strong>${editedTitle}</strong><br>${editedEmail}`;
    }
}

function closeEntryPopup(id) {
    var entryOverlay = document.querySelector(`.overlay[data-entry-id="${id}"]`);
    var entryPopup = document.querySelector(`.entry-popup[data-entry-id="${id}"]`);

    if (entryOverlay && entryPopup) {
        document.body.removeChild(entryOverlay);
        document.body.removeChild(entryPopup);
    }
    window.closeEntryPopup = null;
}

function deleteEntry(entryId) {
    var entryContainer = document.querySelector(`.entry-container[data-entry-id="${entryId}"]`);
    var entryOverlay = document.querySelector(`.overlay[data-entry-id="${entryId}"]`);
    var entryPopup = document.querySelector(`.entry-popup[data-entry-id="${entryId}"]`);

    if (entryContainer && entryOverlay && entryPopup) {
        entryContainer.remove();
        document.body.removeChild(entryOverlay);
        document.body.removeChild(entryPopup);
    }
    var existingEntries = JSON.parse(localStorage.getItem('vaultEntries')) || [];
    var updatedEntries = existingEntries.filter(entry => entry.id !== entryId);
    localStorage.setItem('vaultEntries', JSON.stringify(updatedEntries));
}