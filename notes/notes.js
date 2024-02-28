document.addEventListener('DOMContentLoaded', function() {
    const addNoteBtn = document.getElementById('addNoteBtn');
    const modal = document.getElementById('modal');
    const closeModalBtn = document.querySelector('.close');
    const saveNoteBtn = document.getElementById('saveNoteBtn');
    const noteTitle = document.getElementById('noteTitle');
    const noteContent = document.getElementById('noteContent');
    const notesGrid = document.getElementById('notesGrid');

    // Function to open the modal
    const openModal = () => modal.style.display = 'block';

    // Function to close the modal
    const closeModal = () => modal.style.display = 'none';

    // Display modal when Add Note button is clicked
    addNoteBtn.addEventListener('click', openModal);

    // Close modal when close button is clicked
    closeModalBtn.addEventListener('click', closeModal);

    // Save note when Save button is clicked
    saveNoteBtn.addEventListener('click', function() {
        const title = noteTitle.value.trim();
        const content = noteContent.value.trim();
        if (title && content) {
            saveNoteToDatabase(title, content);
            noteTitle.value = '';
            noteContent.value = '';
            closeModal();
        }
    });

    // Function to save note to database
    function saveNoteToDatabase(title, content) {
        // Here you can perform AJAX request to save note to the database
        // For demonstration purpose, we're just displaying the note in the grid
        const noteElement = document.createElement('div');
        noteElement.classList.add('note');
        noteElement.innerHTML = `<h3>${title}</h3><p>${content}</p>`;

        // Create delete button for saved note
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.classList.add('deleteNoteBtn');
        deleteButton.addEventListener('click', function() {
            // Remove the note from the grid when delete button is clicked
            notesGrid.removeChild(noteElement);
        });

        noteElement.appendChild(deleteButton);
        notesGrid.appendChild(noteElement);
    }

    function fetchAndDisplayNotes() {
        // Perform an AJAX request to fetch notes from the server
        // For example, using the Fetch API or XMLHttpRequest
        fetch('/api/notes')
            .then(response => response.json())
            .then(data => {
                // Iterate over each note received from the server
                data.forEach(note => {
                    // Display the note by saving it to the database
                    saveNoteToDatabase(note.title, note.content);
                });
            })
            .catch(error => {
                console.error('Error fetching notes:', error);
            });
    }

    // Call the function to fetch and display notes on page load
    fetchAndDisplayNotes();
});