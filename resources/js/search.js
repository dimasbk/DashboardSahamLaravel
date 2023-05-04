$("#searchBar").on("keydown", function (event) {
    if (event.keyCode === 13) {
        event.preventDefault();
        const query = $(this).val().trim();
        if (query !== "") {
            $.ajax({
                url: "/search/data",
                method: "GET",
                success: function (response) {
                    if (response.includes(query)) {
                        window.location.href = "/emiten/" + query;
                    } else {
                        alert("Data Tidak Ditemukan");
                    }
                },
                error: function (error) {
                    console.error(error);
                },
            });
        }
    }
});
