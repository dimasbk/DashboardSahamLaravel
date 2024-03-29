$("#getToken").on("click", function () {
    var id = $("#id").val();
    var duration = $("#duration").val();
    var price = $("#price").val();
    ajax(id, duration, price);
});

function ajax(id, duration, price) {
    $.ajax({
        type: "GET",
        url: "/getPaymentToken",
        data: {
            _token: $("input[name='_token']").val(),
            duration: duration,
            id: id,
            price: price,
        },
        success: function (response) {
            console.log(response);
            //alert(response);
            $("#getToken").prop("disabled", true);
            window.snap.pay(response["snapToken"], {
                onSuccess: function (result) {
                    /* You may add your own implementation here */
                    window.location.href =
                        "/subscribe/update/" + response["subscribeID"];
                    console.log(result);
                },
                onPending: function (result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                },
                onError: function (result) {
                    /* You may add your own implementation here */
                    window.location.href =
                        "/subscribe/delete/" + response["subscribeID"];
                    console.log(result);
                },
                onClose: function () {
                    /* You may add your own implementation here */
                    $("#getToken").prop("disabled", false);
                    window.location.href =
                        "/subscribe/delete/" + response["subscribeID"];
                },
            });
        },
        error: function (error) {
            console.log(error);
        },
    });
}
