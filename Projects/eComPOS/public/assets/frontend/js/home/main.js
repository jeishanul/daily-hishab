$(document).on("click", ".product-details-plus-button", function () {
    const id = $(this).attr("data-id");
    const qty = parseInt($(`#product_details_quantity_${id}`).text()) + 1;
    $(`#product_details_quantity_${id}`).text(qty);
    addToCart(id, qty, "add");
    addToCartFetch();
});
$(document).on("click", ".product-details-minus-button", function () {
    const id = $(this).attr("data-id");
    const qty = parseInt($(`#product_details_quantity_${id}`).text());
    if (qty > 1) {
        $(`#product_details_quantity_${id}`).text(qty - 1);
        addToCart(id, qty - 1, "remove");
        addToCartFetch();
    }
});
$(document).ready(function () {
    addToCartFetch();
});

function addToCartFetch() {
    $.ajax({
        url: "/ajax-carts",
        type: "GET",
        success: function (response) {
            $(".cart-products").empty();
            $(".cart-counter").text(response.data.products_count);
            if (response.data.products.length == 0) {
                $(".cart-products").append(
                    `<div class="text-center text-danger fw-bold mt-3">No Products Found</div>`
                );
            } else {
                response.data.products.forEach(function (product, index) {
                    let isDisabled = "disabled";
                    if (product.in_stock) {
                        isDisabled = "";
                    }

                    let action = `<img src="/public/icons/trash.svg" alt="remove"
                                    class="cart-product-quantity-button product-details-remove-button" data-id="${product.id}">`;
                    if (product.qty > 1) {
                        action = `<img src="/public/icons/web-minus.svg" alt="minus"
                                    class="cart-product-quantity-button product-details-minus-button" data-id="${product.product_id}">`;
                    }

                    let price = `<div class="d-flex gap-2 align-items-end">
                                    <div class="cart-product-price">${currencySymbol(
                                        product.price
                                    )}</div>
                                </div>`;
                    if (product.promotional_price > 0) {
                        price = `<div class="d-flex gap-2 align-items-end">
                                    <div class="cart-product-old-price">${currencySymbol(
                                        product.price
                                    )}</div>
                                    <div class="cart-product-price">${currencySymbol(
                                        product.promotional_price
                                    )}</div>
                                </div>`;
                    }

                    $(
                        ".cart-products"
                    ).append(`<li class="d-flex gap-4 align-items-center cart-product-li cart-product-li-${product.id} ${isDisabled}">
                                                    <div class="d-flex gap-3 align-items-center">
                                                        <div class="cart-product-image">
                                                            <img src="${
                                                                product.thumbnail
                                                            }" alt="product">
                                                        </div>
                                                        <div>
                                                            <div class="cart-product-title">
                                                                ${product.name}
                                                            </div>
                                                            ${price}
                                                        </div>
                                                    </div>
                                                    <div class="cart-product-quantity">
                                                        ${action}
                                                        <span class="cart-product-quantity" id="product_details_quantity_${
                                                            product.product_id
                                                        }">${product.qty}</span>
                                                        <img src="/public/icons/web-plus.svg" alt="plus"
                                                            class="cart-product-quantity-button product-details-plus-button" data-id="${
                                                                product.product_id
                                                            }">
                                                    </div>
                                                </li>`);
                });
            }
        },
        error: function (xhr, status, error) {
            var response = JSON.parse(xhr.responseText);
            $(".cart-products").append(
                `<div class="text-center text-danger fw-bold mt-3">${response.message}</div>`
            );
        },
    });
}

$(document).on("click", ".product-details-remove-button", function () {
    const id = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/ajax-carts-remove",
        data: {
            id: id,
        },
        success: function (response) {
            $(".cart-product-li-" + id).remove();
            addToCartFetch();
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

$(document).ready(function () {
    $(document).on("click", ".add-to-cart-request", function () {
        var id = $(this).attr("data-id");
        addToCart(id, 1, "add");
        addToCartFetch();
    });
});

function addToCart(id, qty, type) {
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/add-product-to-cart",
        data: {
            product_id: id,
            qty: 1,
            type: type,
        },
        success: function (response) {
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
}

$(document).ready(function () {
    wishListfetch();
});
function wishListfetch() {
    $.ajax({
        url: "/ajax-wishlist",
        type: "GET",
        success: function (response) {
            $(".wishlist-counter").text(response.data.products_count);
            $(".wishlist-products").empty();
            if (response.data.products.length == 0) {
                $(".wishlist-products").append(
                    `<div class="text-center text-danger fw-bold mt-3">No Products Found</div>`
                );
            } else {
                response.data.products.forEach(function (product, index) {
                    let price = `<div class="d-flex gap-2 align-items-end">
                                    <div class="cart-product-price">${currencySymbol(
                                        product.price
                                    )}</div>
                                </div>`;
                    if (product.promotional_price > 0) {
                        price = `<div class="d-flex gap-2 align-items-end">
                                    <div class="cart-product-old-price">${currencySymbol(
                                        product.price
                                    )}</div>
                                    <div class="cart-product-price">${currencySymbol(
                                        product.promotional_price
                                    )}</div>
                                </div>`;
                    }

                    $(
                        ".wishlist-products"
                    ).append(`<li class="d-flex gap-4 align-items-center cart-product-li wishlist-product-li-${product.id}">
                                            <a href="/product-details/${
                                                product.slug
                                            }" class="d-flex gap-3 align-items-center text-decoration-none">
                                                <div class="cart-product-image">
                                                    <img src="${
                                                        product.thumbnail
                                                    }" alt="product">
                                                </div>
                                                <div>
                                                    <div class="cart-product-title" style="width:160px">
                                                        ${product.name}
                                                    </div>
                                                    ${price}
                                                </div>
                                            </a>
                                            <img src="/public/icons/trash.svg" alt="remove"
                                                    class="cart-product-quantity-button product-details-wishlist-remove-button" data-id="${
                                                        product.id
                                                    }">
                                        </li>`);
                });
            }
        },
        error: function (xhr, status, error) {
            var response = JSON.parse(xhr.responseText);
            $(".wishlist-products").append(
                `<div class="text-center text-danger fw-bold mt-3">${response.message}</div>`
            );
        },
    });
}
$(document).on("click", ".product-details-wishlist-remove-button", function () {
    const id = $(this).attr("data-id");
    $.ajax({
        type: "POST",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/ajax-wishlist-remove",
        data: {
            id: id,
        },
        success: function (response) {
            $(".wishlist-product-li-" + id).remove();
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
