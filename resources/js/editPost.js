$("#first-dropdown").change(function () {
    if ($(this).val() === "a") {
        $("#emitenSaham").prop("disabled", true);
        $("#emitenSaham").val($("#emitenSaham option:first").val());
    } else {
        $("#emitenSaham").prop("disabled", false);
    }
});

const tx = document.getElementsByTagName("textarea");
for (let i = 0; i < tx.length; i++) {
    tx[i].setAttribute(
        "style",
        "height:" + tx[i].scrollHeight + "px;overflow-y:hidden;"
    );
    tx[i].addEventListener("input", OnInput, false);
}

function OnInput() {
    this.style.height = 0;
    this.style.height = this.scrollHeight + "px";
}

var emitenSaham = $("#id_saham_hidden").val();
if (emitenSaham == null) {
    $("#first-dropdown").val("a");
} else {
    $("#first-dropdown").val("b");
    $("#emitenSaham").val(emitenSaham);
}
