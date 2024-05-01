$(document).ready(function() {
    var currentPage = 1;
    var isAnimating = false;

    function showPage(pageNumber) {
        $(".page").hide();
        $("#page" + pageNumber).show();
    }

    function nextPage() {
        if (currentPage < 3 && !isAnimating) {
            isAnimating = true;
            currentPage++;
            showPage(currentPage);
            setTimeout(function() {
                isAnimating = false;
            }, 500);
        }
    }

    function prevPage() {
        if (currentPage > 1 && !isAnimating) {
            isAnimating = true;
            currentPage--;
            showPage(currentPage);
            setTimeout(function() {
                isAnimating = false;
            }, 500);
        }
    }

    $(document).on('wheel', function(e) {
        if (e.originalEvent.deltaY > 0) {
            nextPage();
        } else {
            prevPage();
        }
    });

    $("#page1").click(function() {
        nextPage();
    });

    $("#page2").click(function() {
        nextPage();
    });

    $("#page3").click(function() {
        nextPage();
    });

    $("#exploreFeatures").on("click", function() {
        window.location.href = 'features.html';
    });

    $("#joinNow").on("click", function() {
        window.location.href = 'signup.php';
    });

    showPage(currentPage);
});