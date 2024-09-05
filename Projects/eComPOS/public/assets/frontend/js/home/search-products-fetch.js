$(document).ready(function () {
    $("#search-btn").click(function () {
        var search = $("#search").val();
        if (search == "") {
            window.location.href = "/";
        } else {
            window.location.href = "/view-all-products/search/" + search;
        }
    });
});
