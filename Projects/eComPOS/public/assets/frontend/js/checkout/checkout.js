$.ajax({
    url: "/ajax-carts",
    type: "GET",
    success: function (response) {
        let total = 0;

        response.data.products.forEach(function (product, index) {
            if (product.in_stock) {
                total += product.subtotal;
                $("#add-to-cart-product")
                    .append(`<tr class="productSaleRow" data-id="${product.id}">
                                        <td>
                                            <div class="add-to-cart-product">
                                                <img src="${
                                                    product.thumbnail
                                                }" alt="product">
                                                <span>${product.name}</span>
                                            </div>
                                        </td>
                                        <td class="productPrice" data-price="${
                                            product.price
                                        }">${currencySymbol(product.price)}</td>
                                        <td>
                                            <div class="add-to-cart-product-quantity">
                                                <div class="productQty">${
                                                    product.qty
                                                }</div>
                                            </div>
                                        </td>
                                        <td>${currencySymbol(
                                            product.subtotal
                                        )}</td>
                                    </tr>`);
            }
        });

        let totalElement = document.getElementsByClassName("productSaleRow");
        if (totalElement.length == 0) {
            window.location = "/";
        }

        $("#subtotal").text(currencySymbol(total));
        $("#total").text(currencySymbol(total)).attr("data-total", total);
    },
    error: function (xhr, status, error) {
        var response = JSON.parse(xhr.responseText);
        console.log(response.message);
    },
});

$(".apply-btn").click(function (e) {
    e.preventDefault();
    const coupon = $("#coupon").val();
    const total = $("#total").attr("data-total");
    $.ajax({
        url: "/coupon-validate",
        type: "POST",
        data: {
            coupon_id: $("#coupon_id").val(),
            price: total,
            coupon: coupon,
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            const discount = response.data.discount;
            $("#coupon_id").val(response.data.id);
            $("#couponDiscount").text(currencySymbol(discount));
            $("#total")
                .text(currencySymbol(total - discount))
                .attr("data-total", total - discount);
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

$(".checkout-input").keyup(function () {
    let coupon = $(this).val();
    if (coupon.length > 0) {
        $(".apply-btn").removeClass("d-none");
        $(".remove-btn").addClass("d-none");
    } else {
        $(".apply-btn").addClass("d-none");
        $(".remove-btn").removeClass("d-none");
    }
});

$(".apply-btn").click(function () {
    $(".checkout-input").val("");
    $(".apply-btn").addClass("d-none");
    $(".remove-btn").removeClass("d-none");
});

$(".address-btn").click(function () {
    $.ajax({
        url: "/ajax-profile-update",
        type: "POST",
        data: {
            name: $("#name").val(),
            phone: $("#phone_number").val(),
            email: $("#email").val(),
            country: $("#country").val(),
            city: $("#city").val(),
            zip_code: $("#zip_code").val(),
            address: $("#address").val(),
        },
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
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
});

$(document).on("click", ".checkout-btn", function () {
    const totalGrand = $("#total").attr("data-total");
    const customer_id = $("#customer_id").val();
    const coupon_id = $("#coupon_id").val();
    const payment_method = "Cash";
    const type = "Order";

    let totalElement = document.getElementsByClassName("productSaleRow");
    let qtyArray = [];
    let ProductIdArray = [];
    let ProductPriceArray = [];

    for (var i = 0; i < totalElement.length; i++) {
        var productQty =
            totalElement[i].getElementsByClassName("productQty")[0].innerHTML;
        var productPrice = totalElement[i]
            .getElementsByClassName("productPrice")[0]
            .getAttribute("data-price");
        var productId = totalElement[i].getAttribute("data-id");
        qtyArray.push(Number(productQty));
        ProductIdArray.push(Number(productId));
        ProductPriceArray.push(Number(productPrice));
    }

    $.ajax({
        url: "/sale/pos",
        type: "GET",
        data: {
            type: type,
            paid_amount: totalGrand,
            qty: qtyArray,
            price: ProductPriceArray,
            product_ids: ProductIdArray,
            customer_id: customer_id,
            coupon_id: coupon_id,
            payment_method: payment_method,
        },
        success: function (response) {
            Toast.fire({
                icon: "success",
                title: response.message,
            });
            window.location = "/profile?type=order";
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
