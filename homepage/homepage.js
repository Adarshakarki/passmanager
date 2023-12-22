function loadContent(file, containerId) {
    $.ajax({
        url: file,
        dataType: "html",
        success: function(data) {
            $(containerId).html(data);
        }
    });
}

// Function to toggle content based on the current file
function toggleContent(file, containerId) {
    var currentContent = $(containerId).html();

    // If the current content is from the same file, clear the container
    if (currentContent.includes(file)) {
        $(containerId).html("");
    } else {
        // Load content from the specified file
        loadContent(file, containerId);
    }
}
