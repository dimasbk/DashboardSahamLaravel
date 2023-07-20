var button1 = document.getElementById("oneWeek");
var button2 = document.getElementById("oneMonth");
var button3 = document.getElementById("oneYear");
var button4 = document.getElementById("threeYear");

window.onload = function () {
    button1.click();
};

function chart(data) {
    //console.log(data);
    let chartData = [];
    //let low = Number(row.low);
    //console.log(low);
    var area = [];
    area.push(["Date", "Low", "Open", "Close", "High"]);
    data.forEach(function (row) {
        area.push([
            row.date,
            Number(row.low),
            Number(row.open),
            Number(row.close),
            Number(row.high),
        ]);
        chartData.push([
            row.date,
            Number(row.low),
            Number(row.open),
            Number(row.close),
            Number(row.high),
        ]);
    });
    //console.log(chartData);
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(area);
        var dataTable = google.visualization.arrayToDataTable(chartData, true);

        var ticker = $("#ticker").text();
        var options = {
            legend: "none",
            title: "Candlestick Chart",
            bar: { groupWidth: "100%" },
            candlestick: {
                fallingColor: { strokeWidth: 0, fill: "#a52714" }, // red
                risingColor: { strokeWidth: 0, fill: "#0f9d58" }, // green
            },
        };

        var options1 = {
            title: "Area Chart",
            hAxis: { title: "Year", titleTextStyle: { color: "#333" } },
            vAxis: { minValue: 0 },
        };

        var chart1 = new google.visualization.AreaChart(
            document.getElementById("chart_div1")
        );
        chart1.draw(data, options1);
        var chart = new google.visualization.CandlestickChart(
            document.getElementById("chart_div")
        );

        chart.draw(dataTable, options);
    }
}
button1.addEventListener("click", function () {
    // Make the AJAX call
    var start = $("#start").val();
    var end = $("#end").val();
    var emiten = $("#emiten").val();
    $.ajax({
        type: "GET",
        url: "/emiten/technical/chart/get",
        headers: {
            Accept: "application/json",
        },
        data: {
            _token: $("input[name='_token']").val(),
            start: start,
            end: end,
            emiten: emiten,
        },
        beforeSend: function () {
            $("#loader").removeClass("display-none");
        },
        success: function (data) {
            console.log(data);
            chart(data);
            $("#chart_div").removeClass("display-none");
        },
        complete: function () {
            $("#loader").addClass("display-none");
        },
        error: function (error) {
            // Handle the error
        },
    });
});
