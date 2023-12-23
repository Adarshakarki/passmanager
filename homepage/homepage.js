function loadContent(file, containerId) {
    $.ajax({
        url: file,
        dataType: "html",
        success: function(data) {
            $(containerId).html(data);
        }
    });
}

function toggleContent(file, containerId) {
    var currentContent = $(containerId).html();

    if (currentContent.includes(file)) {
        $(containerId).html("");
    } else {
        loadContent(file, containerId);
    }
}

$(document).on("click", ".open-popup-btn", function() {
    $("#popup").show();
});

$(document).on("click", ".close-popup-btn", function() {
    $("#popup").hide();
});