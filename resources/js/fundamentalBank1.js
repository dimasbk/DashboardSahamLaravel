$(document).ready(function () {
  $("#fundamental").DataTable({
    scrollY: "300px",
    scrollX: true,
    scrollCollapse: true,
    paging: false,
    columnDefs: [{ width: "20%", targets: 0 }],
    fixedColumns: true,
  });
  $('[data-toggle="tooltip"]').tooltip();

  $("#submit-button").click(function () {
    var aset = $("#aset").val();
    var simpanan = $("#simpanan").val();
    var pinjaman = $("#pinjaman").val();
    var hutang_obligasi = $("#hutang_obligasi").val();
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
    var eps = laba_bersih / (jumlah_saham_beredar * stock_split);
    $("#eps").val(eps);
    var emiten = $("#emiten").val();
    var tahun = $("#tahun").val();
    if (!aset) {
      aset = 0;
    }
    if (!hutang_obligasi) {
      hutang_obligasi = 0;
    }
    if (!simpanan) {
      simpanan = 0;
    }
    if (!pinjaman) {
      pinjaman = 0;
    }
    if (!saldo_laba) {
      saldo_laba = 0;
    }
    if (!ekuitas) {
      ekuitas = 0;
    }
    if (!jumlah_saham_beredar) {
      jumlah_saham_beredar = 0;
    }
    if (!pendapatan) {
      pendapatan = 0;
    }
    if (!laba_kotor) {
      laba_kotor = 0;
    }
    if (!laba_bersih) {
      laba_bersih = 0;
    }
    if (!harga_saham) {
      harga_saham = 0;
    }
    if (!operating_cash_flow) {
      operating_cash_flow = 0;
    }
    if (!investing_cash_flow) {
      investing_cash_flow = 0;
    }
    if (!total_dividen) {
      total_dividen = 0;
    }
    if (!stock_split) {
      stock_split = 0;
    }
    if (!eps) {
      eps = 0;
    }
    if (!tahun) {
      $("#tahun").addClass("is-invalid");
      $("#tahun + .invalid-feedback").text("Tahun Tidak Boleh Kosong");
    } else {
      $.ajax({
        type: "POST",
        url: "/fundamental/input/bank/add",
        data: {
          _token: $("input[name='_token']").val(),
          aset: aset,
          hutang_obligasi: hutang_obligasi,
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
    }
  });

  $("#clear-form").click(function () {
    $("#formFundamental")[0].reset();

    $("#tahun + .invalid-feedback").text("");
    $("#tahun").removeClass("is-invalid");
  });

  $("#tahun").change(function () {
    $(this).addClass("form-control:valid");
    $("#tahun + .invalid-feedback").text("");
    $(this).removeClass("is-invalid");
  });
});
