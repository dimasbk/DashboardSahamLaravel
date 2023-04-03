var emitenSaham = $("#id_saham_hidden").val();
var $select1 = $("#id_saham").selectize();
var selectize = $select1[0].selectize;
selectize.setValue(emitenSaham, false);

var jenisSaham = $("#id_jenis_saham_hidden").val();
var $select2 = $("#id_jenis_saham").selectize();
var selectize = $select2[0].selectize;
selectize.setValue(jenisSaham, false);

var sekuritas = $("#id_sekuritas").val();
var $select3 = $("#sekuritas").selectize();
var selectize = $select3[0].selectize;
selectize.setValue(sekuritas, false);
