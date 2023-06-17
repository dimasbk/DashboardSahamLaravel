$(document).ready(function () {
    $("#input").DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        columnDefs: [{ width: "20%", targets: 0 }],
        fixedColumns: true,
    });

    $("#output").DataTable({
        scrollY: "300px",
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        columnDefs: [{ width: "20%", targets: 0 }],
        fixedColumns: true,
    });
    $('[data-toggle="tooltip"]').tooltip();
});
