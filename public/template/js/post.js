$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
  });
  $("#first-dropdown").change(function () {
    if ($(this).val() === "a") {
      $("#emitenSaham").prop("disabled", true);
      $("#emitenSaham").val($("#emitenSaham option:first").val());
    } else {
      $("#emitenSaham").prop("disabled", false);
    }
  });

  $("#post-form").submit(function (event) {
    event.preventDefault(); // prevent default form submission
    if (validateForm()) {
      var formData = new FormData(this);
      var title = $("#post-title").val();
      var content = $("#post-content").val();
      var image = $("#post-image").val();
      var emiten = $("#emitenSaham").val();
      var tag = $('input[name="gender"]:checked').val();

      // create FormData object from form data
      $.ajax({
        url: "/post/add", // URL to submit the form data
        type: "POST",
        data: formData,
        contentType: false, // necessary for file uploads
        processData: false, // necessary for file uploads
        beforeSend: function () {
          // Show loading spinner or disable submit button
          $("#submit-button").prop("disabled", true);
          $("#submit-button").hide();
          $("#loading-spinner").show();
        },
        success: function (response) {
          console.log(response);
          $("#loading-spinner").hide();
          $("#submit-button").prop("disabled", false);

          // Handle successful response
        },
        error: function (xhr, status, error) {
          // Hide loading spinner or enable submit button
          $("#loading-spinner").hide();
          $("#submit-button").prop("disabled", false);

          // Handle error
          alert("Error submitting post: " + error);
        },
        complete: function () {
          //location.reload();
          //alert(JSON.stringify(formData));
        },
      });
    }
  });

  function validateForm() {
    var title = $("#post-title").val();
    var content = $("#post-content").val();
    var image = $("#post-image").val();
    var tag = $('input[name="gender"]:checked').val();
    var errorMessage = "";

    // Validate title
    if (title.trim() === "") {
      $("#post-title").addClass("is-invalid");
      $("#title-invalid-feedback").text("Title is required.");
      errorMessage += "Title is required.\n";
    } else {
      $("#post-title").removeClass("is-invalid");
      $("#title-invalid-feedback").text("");
    }

    // Validate content
    if (content.trim() === "") {
      $("#post-content").addClass("is-invalid");
      $("#content-invalid-feedback").text("Content is required.");
      errorMessage += "Content is required.\n";
    } else {
      $("#post-content").removeClass("is-invalid");
      $("#content-invalid-feedback").text("");
    }

    if (tag) {
      $("#tag-invalid-feedback").text("Content is required.");
      errorMessage += "Content is required.\n";
    } else {
      $("#tag-invalid-feedback").text("");
    }

    // Validate image (optional)
    if (image && !/\.(jpg|jpeg|png)$/i.test(image)) {
      $("#post-image").addClass("is-invalid");
      $("#image-invalid-feedback").text(
        "Invalid image file type. Please upload a JPG or PNG file."
      );
      errorMessage +=
        "Invalid image file type. Please upload a JPG or PNG file.\n";
    } else {
      $("#post-image").removeClass("is-invalid");
      $("#image-invalid-feedback").text("");
    }

    // Display error message if validation fails
    if (errorMessage !== "") {
      return false;
    }

    // Validation passed
    return true;
  }
});
