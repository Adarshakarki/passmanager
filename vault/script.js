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

    var entry = {
        title: title,
        website: website,
        email: email,
        password: password,
        category: category
    };

    fetch('save_entry.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(entry)
        })
        .then(response => {
            if (response.ok) {
                // Entry saved successfully, add it to the popup
                addEntryToPopup(entry);
                closePopup(); // Close the popup after saving
            } else {
                // Failed to save entry, handle error
                console.error('Failed to save entry');
            }
        })
        .catch(error => {
            console.error('Error saving entry:', error);
        });
}

function addEntryToPopup(entry) {
    var entryButton = document.createElement('button');
    entryButton.classList.add('entry-button');
    entryButton.textContent = entry.title + ' - ' + entry.email;

    // Create a div to hold the entry data
    var entryData = document.createElement('div');
    entryData.classList.add('entry-data');
    entryData.style.display = 'none'; // Hide the entry data initially

    // Add data elements to the entryData div
    var websitePara = document.createElement('p');
    websitePara.textContent = 'Website: ' + entry.website;
    entryData.appendChild(websitePara);

    var passwordPara = document.createElement('p');
    passwordPara.textContent = 'Password: ' + entry.password;
    entryData.appendChild(passwordPara);

    var categoryPara = document.createElement('p');
    categoryPara.textContent = 'Category: ' + entry.category;
    entryData.appendChild(categoryPara);

    // Append the entryData div to the entryButton
    entryButton.appendChild(entryData);

    // Toggle visibility of entry data when the button is clicked
    entryButton.addEventListener('click', function() {
        if (entryData.style.display === 'none') {
            entryData.style.display = 'block';
        } else {
            entryData.style.display = 'none';
        }
    });

    document.getElementById('popup').appendChild(entryButton);
}