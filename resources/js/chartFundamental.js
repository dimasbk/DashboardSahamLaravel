var button1 = document.getElementById("oneWeek");
var button2 = document.getElementById("oneMonth");
var button3 = document.getElementById("oneYear");
var button4 = document.getElementById("threeYear");

window.onload = function () {
    button1.click();
};

function chart(data) {
    //console.log(data);
    var dividen = [];
    var performance = [];
    var valuation = [];

    performance.push([
        "Tahun",
        "Return on Asset",
        "Return on Equity",
        "Gross Profit Margin",
        "Net Profit Margin",
    ]);

    valuation.push([
        "Tahun",
        "Price to Book Value",
        "Earnings to Equity Ratio",
        "Equity to Asset Ratio",
        "Price to Earnings Ratio",
    ]);

    dividen.push(["Tahun", "Dividend Payout Ratio", "Dividend Yield"]);

    var fundamental = data["fundamentalEmiten"];
    fundamental.forEach(function (row) {
        performance.push([
            row.tahun,
            Number(row.annualized_roa),
            Number(row.annualized_roe),
            Number(row.gpm),
            Number(row.npm),
        ]);
        dividen.push([
            row.tahun,
            Number(row.dividen_payout_ratio),
            Number(row.dividen_yield),
        ]);
        valuation.push([
            row.tahun,
            Number(row.pbv),
            Number(row.eer),
            Number(row.ear),
            Number(row.annualized_per),
        ]);
    });
    //console.log(chartData);
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var performanceTable =
            google.visualization.arrayToDataTable(performance);
        var dividenTable = google.visualization.arrayToDataTable(dividen);
        var valuationTable = google.visualization.arrayToDataTable(valuation);

        var ticker = $("#ticker").text();
        var options = {
            title: "Dividend (%)",
            hAxis: { title: "Year", titleTextStyle: { color: "#333" } },
            vAxis: { minValue: 0 },
            seriesType: "line",
            series: { 2: { type: "bars" } },
        };

        var options1 = {
            title: "Performance (%)",
            hAxis: { title: "Year", titleTextStyle: { color: "#333" } },
            vAxis: { minValue: 0 },
            seriesType: "line",
            series: { 2: { type: "bars" } },
        };

        var options2 = {
            title: "Valuation (%)",
            hAxis: { title: "Year", titleTextStyle: { color: "#333" } },
            vAxis: { minValue: 0 },
            seriesType: "line",
            //series: { 2: { type: "bars" } },
        };
        var chart2 = new google.visualization.ComboChart(
            document.getElementById("chart_div2")
        );
        chart2.draw(valuationTable, options2);

        var chart1 = new google.visualization.ComboChart(
            document.getElementById("chart_div1")
        );
        chart1.draw(performanceTable, options1);

        var chart = new google.visualization.ComboChart(
            document.getElementById("chart_div")
        );
        chart.draw(dividenTable, options);
    }
}
button1.addEventListener("click", function () {
    // Make the AJAX call
    var start = $("#start").val();
    var end = $("#end").val();
    var emiten = $("#emiten").val();
    $.ajax({
        type: "GET",
        url: "/emiten/fundamental/chart/get",
        headers: {
            Accept: "application/json",
        },
        data: {
            _token: $("input[name='_token']").val(),
            ticker: emiten,
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
