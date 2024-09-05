$(document).ready(function () {
    $.ajax({
        url: "/ajax-product-details/" + $("#slug").val(),
        type: "GET",
        success: function (response) {
            const product = response.data.product;

            if (product.more_images.length > 0) {
                let html = "";
                $.each(product.more_images, function (index, item) {
                    html += `<div class="product-details-item">
                    <img src="${item}" alt="product" class="product-details-image">
                    </div>`;
                });
                $("#product-details-image-swiper").html(html);
            }

            $(".product-details-checkout-button").attr("data-id", product.id);
            $(".product-details-wishlist").attr("data-id", product.id);
            $(".product-details-minus-button").attr("data-id", product.id);
            $(".product-details-quantity").attr(
                "id",
                `product_details_quantity_${product.id}`
            );
            $(".product-details-plus-button").attr("data-id", product.id);
            $(".product-details-title").text(product.name);
            $(".product-details-image-main").attr("src", product.thumbnail);
            $(".product-details-description").html(product.product_details);
            $(".product-details-in-stock").text(
                product.in_stock ? "In Stock" : "Out of Stock"
            );
            $(".product-details-add-to-cart-section").addClass(
                product.in_stock ? "" : "disabled"
            );
            if (product.promotional_price > 0) {
                $(".product-details-old-price").show();
                $(".product-details-old-price").text(
                    currencySymbol(product.price)
                );
                $(".product-details-price").text(
                    currencySymbol(product.promotional_price)
                );
            } else {
                $(".product-details-old-price").hide();
                $(".product-details-price").text(currencySymbol(product.price));
            }
        },
        error: function (xhr, status, error) {
            var response = JSON.parse(xhr.responseText);
            window.location.href = "/";
        },
    });
});
