$(document).ready(function () {
    // Your jQuery code goes here
    $("#form").submit(function (event) {
        event.preventDefault(); // Prevent form submission

        // Get input values
        var trend = $("#trend").val().toLowerCase();
        var fundamentalSelect = $("#fundamental").val();
        var comparisonSelect = $("#comparison").val();
        var percentage = $("#percentage").val();
        var start = $("#startDate").val();
        var end = $("#endDate").val();
        alert(start + " " + end);

        if (fundamentalSelect == "Debt to Equity Ratio") {
            var fundamental = "der";
        } else if (fundamentalSelect == "Loan to Deposit Ratio") {
            var fundamental = "loan_to_depo_ratio";
        }

        if (comparisonSelect == "Less than") {
            var comparison = "<";
        } else if (comparisonSelect == "More than") {
            var comparison = ">";
        }

        // Log the values (replace with your desired logic)
        $.ajax({
            type: "GET",
            url: "/search/technical",
            headers: {
                Accept: "application/json",
            },
            data: {
                _token: $("input[name='_token']").val(),
                param: fundamental,
                comparison: comparison,
                num: percentage,
                trend: trend,
                start: start,
                end: end,
            },
            success: function (data) {
                console.log(data);
                if (!data) {
                    alert("Data tidak ditemukan");
                } else {
                    var tableBody = document
                        .getElementById("tableData")
                        .getElementsByTagName("tbody")[0];

                    for (var i = 0; i < data.length; i++) {
                        var row = tableBody.insertRow();
                        var num = row.insertCell();
                        var tickerCell = row.insertCell();
                        var trendCell = row.insertCell();
                        var changeCell = row.insertCell();
                        var derCell = row.insertCell();
                        var ldrCell = row.insertCell();

                        let change = parseInt(data[i]["change"]).toFixed(2);

                        num.innerHTML = i + 1;
                        tickerCell.innerHTML = data[i].ticker;
                        trendCell.innerHTML = data[i].trend;
                        changeCell.innerHTML = change + "%";
                        derCell.innerHTML = data[i]["der"] + "%";
                        ldrCell.innerHTML = data[i]["ldr"] + "%";
                    }
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
});
