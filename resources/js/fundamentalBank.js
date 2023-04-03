$(document).ready(function () {
  $("#fundamental").DataTable({
    scrollY: "300px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    columnDefs: [{ width: "20%", targets: 0 }],
    fixedColumns: true,
  });
  $("#submit-button").click(function () {
    var aset = $("#aset").val();
    var simpanan = $("#simpanan").val();
    var pinjaman = $("#pinjaman").val();
    var saldo_laba = $("#saldo-laba").val();
    var ekuitas = $("#ekuitas").val();
    var jumlah_saham_beredar = $("#jumlah-saham-beredar").val();
    var pendapatan = $("#pendapatan").val();
    var laba_kotor = $("#laba-kotor").val();
    var laba_bersih = $("#laba-bersih").val();
    var harga_saham = $("#harga-saham").val();
    var operating_cash_flow = $("#operating-cash-flow").val();
    var investing_cash_flow = $("#investing-cash-flow").val();
    var total_dividen = $("#total-dividen").val();
    var stock_split = $("#stock-split").val();
    var eps = $("#eps").val();
    var tahun = $("#tahun").val();
    var emiten = $("#emiten").val();

    if (!aset) {
      $("#aset").addClass("is-invalid");
      $("#aset + .invalid-feedback").text("Aset Tidak Boleh Kosong");
    }
    if (!simpanan) {
      $("#simpanan").addClass("is-invalid");
      $("#simpanan + .invalid-feedback").text("Simpanan Tidak Boleh Kosong");
    }
    if (!pinjaman) {
      $("#pinjaman").addClass("is-invalid");
      $("#pinjaman + .invalid-feedback").text("Pinjaman Tidak Boleh Kosong");
    }
    if (!saldo_laba) {
      $("#saldo-laba").addClass("is-invalid");
      $("#saldo-laba + .invalid-feedback").text(
        "Saldo Laba Tidak Boleh Kosong"
      );
    }
    if (!ekuitas) {
      $("#ekuitas").addClass("is-invalid");
      $("#ekuitas + .invalid-feedback").text("Ekuitas Tidak Boleh Kosong");
    }
    if (!jumlah_saham_beredar) {
      $("#jumlah-saham-beredar").addClass("is-invalid");
      $("#jumlah-saham-beredar + .invalid-feedback").text(
        "Jumlah Saham Beredar Tidak Boleh Kosong"
      );
    }
    if (!pendapatan) {
      $("#pendapatan").addClass("is-invalid");
      $("#pendapatan + .invalid-feedback").text(
        "Pendapatan Tidak Boleh Kosong"
      );
    }
    if (!laba_kotor) {
      $("#laba-kotor").addClass("is-invalid");
      $("#laba-kotor + .invalid-feedback").text(
        "Laba Kotor Tidak Boleh Kosong"
      );
    }
    if (!laba_bersih) {
      $("#laba-bersih").addClass("is-invalid");
      $("#laba-bersih + .invalid-feedback").text(
        "Laba Bersih Tidak Boleh Kosong"
      );
    }
    if (!harga_saham) {
      $("#harga-saham").addClass("is-invalid");
      $("#harga-saham + .invalid-feedback").text(
        "Harga Saham Tidak Boleh Kosong"
      );
    }
    if (!operating_cash_flow) {
      $("#operating-cash-flow").addClass("is-invalid");
      $("#operating-cash-flow + .invalid-feedback").text(
        "Operating Cash Flow Tidak Boleh Kosong"
      );
    }
    if (!investing_cash_flow) {
      $("#investing-cash-flow").addClass("is-invalid");
      $("#investing-cash-flow + .invalid-feedback").text(
        "Investing Cash Flow Tidak Boleh Kosong"
      );
    }
    if (!total_dividen) {
      $("#total-dividen").addClass("is-invalid");
      $("#total-dividen + .invalid-feedback").text(
        "Total Dividen Tidak Boleh Kosong"
      );
    }
    if (!stock_split) {
      $("#stock-split").addClass("is-invalid");
      $("#stock-split + .invalid-feedback").text(
        "Stock Split Tidak Boleh Kosong"
      );
    }
    if (!eps) {
      $("#eps").addClass("is-invalid");
      $("#eps + .invalid-feedback").text("EPS Tidak Boleh Kosong");
    }
    if (!tahun) {
      $("#tahun").addClass("is-invalid");
      $("#tahun + .invalid-feedback").text("Tahun Tidak Boleh Kosong");
    }

    $.ajax({
      type: "POST",
      url: "/fundamental/input/add",
      data: {
        _token: $("input[name='_token']").val(),
        aset: aset,
        simpanan: simpanan,
        pinjaman: pinjaman,
        saldo_laba: saldo_laba,
        ekuitas: ekuitas,
        jumlah_saham_beredar: jumlah_saham_beredar,
        pendapatan: pendapatan,
        laba_kotor: laba_kotor,
        laba_bersih: laba_bersih,
        harga_saham: harga_saham,
        operating_cash_flow: operating_cash_flow,
        investing_cash_flow: investing_cash_flow,
        total_dividen: total_dividen,
        stock_split: stock_split,
        eps: eps,
        tahun: tahun,
        emiten: emiten,
      },
      success: function (response) {
        console.log(response);
        location.reload();
      },
      error: function (error) {
        console.log(error);
      },
    });
  });

  $("#clear-form").click(function () {
    $("#formFundamental")[0].reset();
    $("#aset + .invalid-feedback").text("");
    $("#aset").removeClass("is-invalid");

    $("#simpanan + .invalid-feedback").text("");
    $("#simpanan").removeClass("is-invalid");

    $("#pinjaman + .invalid-feedback").text("");
    $("#pinjaman").removeClass("is-invalid");

    $("#saldo-laba + .invalid-feedback").text("");
    $("#saldo-laba").removeClass("is-invalid");

    $("#ekuitas + .invalid-feedback").text("");
    $("#ekuitas").removeClass("is-invalid");

    $("#jumlah-saham-beredar + .invalid-feedback").text("");
    $("#jumlah-saham-beredar").removeClass("is-invalid");

    $("#pendapatan + .invalid-feedback").text("");
    $("#pendapatan").removeClass("is-invalid");

    $("#laba-kotor + .invalid-feedback").text("");
    $("#laba-kotor").removeClass("is-invalid");

    $("#laba-bersih + .invalid-feedback").text("");
    $("#laba-bersih").removeClass("is-invalid");

    $("#harga-saham + .invalid-feedback").text("");
    $("#harga-saham").removeClass("is-invalid");

    $("#operating-cash-flow + .invalid-feedback").text("");
    $("#operating-cash-flow").removeClass("is-invalid");

    $("#investing-cash-flow + .invalid-feedback").text("");
    $("#investing-cash-flow").removeClass("is-invalid");

    $("#total-dividen + .invalid-feedback").text("");
    $("#total-dividen").removeClass("is-invalid");

    $("#stock-split + .invalid-feedback").text("");
    $("#stock-split").removeClass("is-invalid");

    $("#eps + .invalid-feedback").text("");
    $("#eps").removeClass("is-invalid");

    $("#tahun + .invalid-feedback").text("");
    $("#tahun").removeClass("is-invalid");
  });

  $("#aset").change(function () {
    $(this).addClass("form-control:valid");
    $("#aset + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#simpanan").change(function () {
    $(this).addClass("form-control:valid");
    $("#simpanan + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#pinjaman").change(function () {
    $(this).addClass("form-control:valid");
    $("#pinjaman + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#saldo-laba").change(function () {
    $(this).addClass("form-control:valid");
    $("#saldo-laba + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#ekuitas").change(function () {
    $(this).addClass("form-control:valid");
    $("#ekuitas + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#jumlah-saham-beredar").change(function () {
    $(this).addClass("form-control:valid");
    $("#jumlah-saham-beredar + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#pendapatan").change(function () {
    $(this).addClass("form-control:valid");
    $("#pendapatan + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#laba-kotor").change(function () {
    $(this).addClass("form-control:valid");
    $("#laba-kotor + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#laba-bersih").change(function () {
    $(this).addClass("form-control:valid");
    $("#laba-bersih + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#harga-saham").change(function () {
    $(this).addClass("form-control:valid");
    $("#harga-saham + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#operating-cash-flow").change(function () {
    $(this).addClass("form-control:valid");
    $("#operating-cash-flow + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#investing-cash-flow").change(function () {
    $(this).addClass("form-control:valid");
    $("#investing-cash-flow + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#total-dividen").change(function () {
    $(this).addClass("form-control:valid");
    $("#total-dividen + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#stock-split").change(function () {
    $(this).addClass("form-control:valid");
    $("#stock-split + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#eps").change(function () {
    $(this).addClass("form-control:valid");
    $("#eps + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });

  $("#tahun").change(function () {
    $(this).addClass("form-control:valid");
    $("#tahun + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });
});
