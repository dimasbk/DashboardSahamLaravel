$("select").selectize({
  sortField: "text",
});
$(document).ready(function () {
  $("#portofolioJual").DataTable();
  $("#submit-button").click(function () {
    var emitenSaham = $("#emitenSaham").val();
    var jenisSaham = $("#jenisSaham").val();
    var volume = $("#volume").val();
    var tanggalBeli = $("#tanggalBeli").val();
    var hargaBeli = $("#hargaBeli").val();
    var feeBeli = $("#feeBeli").val();

    $(".invalid-feedback").empty();

    if (!emitenSaham) {
      $("#emitenSaham").addClass("is-invalid");
      $("#emitenSaham + .invalid-feedback").text("Mohon pilih Emiten Saham");
    }
    if (!jenisSaham) {
      $("#jenisSaham").addClass("is-invalid");
      $("#jenisSaham + .invalid-feedback").text("Mohon pilih Jenis Saham");
    }
    if (!volume) {
      $("#volume").addClass("is-invalid");
      $("#volume + .invalid-feedback").text("Volume tidak boleh kosong!");
    }
    if (!tanggalBeli) {
      $("#tanggalBeli").addClass("is-invalid");
      $("#tanggalBeli + .invalid-feedback").text(
        "Tanggal Beli tidak boleh kosong!"
      );
    }
    if (!hargaBeli) {
      $("#hargaBeli").addClass("is-invalid");
      $("#hargaBeli + .invalid-feedback").text(
        "Harga Beli tidak boleh kosong!"
      );
    }
    if (!feeBeli) {
      $("#feeBeli").addClass("is-invalid");
      $("#feeBeli + .invalid-feedback").text("Fee Beli tidak boleh kosong!");
    }

    if (
      !emitenSaham ||
      !jenisSaham ||
      !volume ||
      !tanggalBeli ||
      !hargaBeli ||
      !feeBeli
    ) {
      return;
    }

    $.ajax({
      type: "POST",
      url: "/portofoliobeli/addbeli",
      data: {
        _token: $("input[name='_token']").val(),
        emitenSaham: emitenSaham,
        jenisSaham: jenisSaham,
        volume: volume,
        tanggalBeli: tanggalBeli,
        hargaBeli: hargaBeli,
        feeBeli: feeBeli,
      },
      success: function (response) {
        console.log("response");
        location.reload();
      },
      error: function (error) {
        console.log("gagal");
      },
    });
  });
});

$("#clear-form").click(function () {
  $("#formBeli")[0].reset();
  $("#emitenSaham + .invalid-feedback").text("");
  $("#emitenSaham").removeClass("is-invalid");

  $("#jenisSaham + .invalid-feedback").text("");
  $("#jenisSaham").removeClass("is-invalid");

  $("#volume + .invalid-feedback").text("");
  $("#volume").removeClass("is-invalid");

  $("#tanggalBeli + .invalid-feedback").text("");
  $("#tanggalBeli").removeClass("is-invalid");

  $("#hargaBeli + .invalid-feedback").text("");
  $("#hargaBeli").removeClass("is-invalid");

  $("#feeBeli + .invalid-feedback").text("");
  $("#feeBeli").removeClass("is-invalid");
});

$("#emitenSaham").change(function () {
  $(this).addClass("form-control:valid");
  $("#emitenSaham + .invalid-feedback").text("");
  $(this).removeClass("is-invalid");
});

$("#jenisSaham").change(function () {
  $(this).addClass("form-control:valid");
  $("#jenisSaham + .invalid-feedback").text("");
  $(this).removeClass("is-invalid");
});
$("#volume").on("input", function () {
  this.value = this.value.replace(/[^0-9]/g, "");
  $(this).addClass("form-control:valid");
  $("#volume + .invalid-feedback").text("");
  $(this).removeClass("is-invalid");
});

$("#tanggalBeli").on("input", function () {
  $(this).addClass("form-control:valid");
  $("#tanggalBeli + .invalid-feedback").text("");
  $(this).removeClass("is-invalid");
});

$("#hargaBeli").on("input", function () {
  this.value = this.value.replace(/[^0-9]/g, "");
  $(this).addClass("form-control:valid");
  $("#volhargaBeliume + .invalid-feedback").text("");
  $(this).removeClass("is-invalid");
});

$("#feeBeli").on("input", function () {
  this.value = this.value.replace(/[^0-9]/g, "");
  $(this).addClass("form-control:valid");
  $("#feeBeli + .invalid-feedback").text("");
  $(this).removeClass("is-invalid");
});
