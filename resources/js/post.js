$(document).ready(function () {
    $("#first-dropdown").change(function () {
        if ($(this).val() === "a") {
            $("#emitenSaham").prop("disabled", true);
            $("#emitenSaham").val($("#emitenSaham option:first").val());
        } else {
            $("#emitenSaham").prop("disabled", false);
        }
    });
});
