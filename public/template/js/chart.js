var button1 = document.getElementById("oneWeek");
var button2 = document.getElementById("oneMonth");
var button3 = document.getElementById("oneYear");
var button4 = document.getElementById("threeYear");

window.onload = function () {
  button1.click();
};

function chart(data, title) {
  console.log(data);
  let chartData = [];
  data.forEach(function (row) {
    chartData.push([row.date, row.low, row.open, row.close, row.high]);
  });
  console.log(chartData);
  google.charts.load("current", { packages: ["corechart"] });
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable(chartData, true);

    var ticker = $("#ticker").text();
    var options = {
      legend: "none",
      title: "(" + ticker + ") " + title,
      bar: { groupWidth: "100%" },
      candlestick: {
        fallingColor: { strokeWidth: 0, fill: "#a52714" }, // red
        risingColor: { strokeWidth: 0, fill: "#0f9d58" }, // green
      },
    };

    var chart = new google.visualization.CandlestickChart(
      document.getElementById("chart_div")
    );

    chart.draw(data, options);
  }
}
button1.addEventListener("click", function () {
  // Make the AJAX call
  var x = document.getElementById("ticker").innerHTML;
  $.ajax({
    type: "GET",
    url: "/chart/oneWeek/" + x,
    headers: {
      Accept: "application/json",
    },
    success: function (data) {
      let title = "Satu Minggu";
      chart(data, title);
    },
    error: function (error) {
      // Handle the error
    },
  });
});

button2.addEventListener("click", function () {
  // Make the AJAX call
  var x = document.getElementById("ticker").innerHTML;
  $.ajax({
    type: "GET",
    url: "/chart/oneMonth/" + x,
    headers: {
      Accept: "application/json",
    },
    success: function (data) {
      let title = "Satu Bulan";
      chart(data, title);
    },
    error: function (error) {
      // Handle the error
    },
  });
});

button3.addEventListener("click", function () {
  // Make the AJAX call
  var x = document.getElementById("ticker").innerHTML;
  $.ajax({
    type: "GET",
    url: "/chart/oneYear/" + x,
    headers: {
      Accept: "application/json",
    },
    success: function (data) {
      let title = "Satu Tahun";
      chart(data, title);
    },
    error: function (error) {
      // Handle the error
    },
  });
});

button4.addEventListener("click", function () {
  // Make the AJAX call
  var x = document.getElementById("ticker").innerHTML;
  $.ajax({
    type: "GET",
    url: "/chart/threeYear/" + x,
    headers: {
      Accept: "application/json",
    },
    success: function (data) {
      let title = "Tiga Tahun";
      chart(data, title);
    },
    error: function (error) {
      // Handle the error
    },
  });
});
