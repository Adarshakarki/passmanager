document.addEventListener('DOMContentLoaded', function() {
    const notesContainer = document.getElementById('notes-container');
    const addNoteForm = document.getElementById('add-note-form');
    const addNoteButton = document.getElementById('add-note-button');
    const addNoteModal = document.getElementById('add-note-modal');

    // Display add note modal when the add note button is clicked
    addNoteButton.addEventListener('click', function() {
        addNoteModal.style.display = 'block';
    });

    // Close the add note modal when the close button is clicked
    addNoteModal.querySelector('.close').addEventListener('click', function() {
        addNoteModal.style.display = 'none';
    });

    addNoteForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const title = document.getElementById('note-title').value;
        const content = document.getElementById('note-content').value;
        if (title.trim() === '' || content.trim() === '') {
            alert('Please enter a title and content for the note.');
            return;
        }
        addNoteModal.style.display = 'none';
        addNote(title, content);
    });

    function addNote(title, content) {
        fetch('notes.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ title, content })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to add note.');
                }
                return response.json();
            })
            .then(() => {
                fetchNotes();
                addNoteForm.reset();
            })
            .catch(error => console.error('Error adding note:', error));
    }

    function fetchNotes() {
        fetch('notes.php')
            .then(response => response.json())
            .then(notes => {
                notesContainer.innerHTML = '';
                notes.forEach(note => {
                    const noteElement = createNoteElement(note);
                    notesContainer.appendChild(noteElement);
                });
            })
            .catch(error => console.error('Error fetching notes:', error));
    }

    function createNoteElement(note) {
        const noteElement = document.createElement('div');
        noteElement.classList.add('note');
        noteElement.innerHTML = `
            <h3>${note.title}</h3>
            <p>${note.content}</p>
            <button class="delete-button" data-note-id="${note.id}">Delete</button>
        `;
        noteElement.querySelector('.delete-button').addEventListener('click', function() {
            const id = this.getAttribute('data-note-id');
            deleteNote(id);
        });
        return noteElement;
    }

    function deleteNote(id) {
        fetch('notes.php', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to delete note.');
                }
                return response.json();
            })
            .then(() => {
                fetchNotes();
            })
            .catch(error => console.error('Error deleting note:', error));
    }

    // Close the add note modal when the user clicks outside of it
    window.addEventListener('click', function(event) {
        if (event.target === addNoteModal) {
            addNoteModal.style.display = 'none';
        }
    });

    // Fetch notes on page load
    fetchNotes();
});