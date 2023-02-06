var button1 = document.getElementById("oneWeek");
var button2 = document.getElementById("oneMonth");
var button3 = document.getElementById("oneYear");
var button4 = document.getElementById("threeYear");
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

        var options = {
          legend: "none",
        };

        var chart = new google.visualization.CandlestickChart(
          document.getElementById("chart_div")
        );

        chart.draw(data, options);
      }
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

        var options = {
          legend: "none",
        };

        var chart = new google.visualization.CandlestickChart(
          document.getElementById("chart_div")
        );

        chart.draw(data, options);
      }
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

        var options = {
          legend: "none",
        };

        var chart = new google.visualization.CandlestickChart(
          document.getElementById("chart_div")
        );

        chart.draw(data, options);
      }
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

        var options = {
          legend: "none",
        };

        var chart = new google.visualization.CandlestickChart(
          document.getElementById("chart_div")
        );

        chart.draw(data, options);
      }
    },
    error: function (error) {
      // Handle the error
    },
  });
});
