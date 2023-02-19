var emitenSaham = $("#id_saham_hidden").val();
var $select = $("#id_saham").selectize();
var selectize = $select[0].selectize;
selectize.setValue(emitenSaham, false);

var jenisSaham = $("#id_jenis_saham_hidden").val();
var $select = $("#id_jenis_saham").selectize();
var selectize = $select[0].selectize;
selectize.setValue(emitenSaham, false);
