$(document).ready(function () {
    $(document).on("click", ".wishlist-add-request", function () {
        var id = $(this).attr("data-id");
        $.ajax({
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/add-product-to-wishlist",
            data: {
                product_id: id,
            },
            success: function (response) {
                wishListfetch();
                Toast.fire({
                    icon: "success",
                    title: response.message,
                });
            },
            error: function (xhr, status, error) {
                var response = JSON.parse(xhr.responseText);
                Toast.fire({
                    icon: "error",
                    title: response.message,
                });
            },
        });
    });
});
