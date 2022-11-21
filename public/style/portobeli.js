function validasibeli(){
    var id_saham = document.forms.formbeli.id_saham.value;
    if (what.selectedIndex == -1) {
        alert("Please enter your course.");
        what.focus();
        return false;
    }
}