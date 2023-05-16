$(document).ready(function () {
    $("#link1").addClass("active");
    $("#page1").show();
    $("#link1").on("click", function () {
        $(this).addClass("active");
        $("#link2").removeClass("active");
        $("#page1").show();
        $("#page2").hide();
    });
    $("#link2").on("click", function () {
        $(this).addClass("active");
        $("#link1").removeClass("active");
        $("#page2").show();
        $("#page1").hide();
    });

    const followButtonsContainer = $(".follow-buttons-container");

    // Add a click event listener to the container element using event delegation
    followButtonsContainer.on("click", ".follow-button", (event) => {
        // Get a reference to the button element that was clicked
        const followButton = $(event.target);

        // Get the user ID from the data-user-id attribute
        const userId = followButton.data("user-id");

        // Send an Ajax request to the server to follow the user
        $.ajax({
            url: "/follow",
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: "application/json",
            data: JSON.stringify({ userId }),
            success: function (response) {
                console.log(response);
                followButton.text("Following");
                followButton.prop("disabled", true);
                window.location.reload(true);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("AJAX request failed:");
                console.log("jqXHR:", jqXHR);
                console.log("textStatus:", textStatus);
                console.log("errorThrown:", errorThrown);
            },
        });
    });
});
