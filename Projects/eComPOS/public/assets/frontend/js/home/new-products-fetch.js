$.ajax({
    url: "/ajax-new-products",
    type: "GET",
    success: function (response) {
        response.data.products.forEach(function (product, index) {
            let isDisabled = "disabled";
            if (product.in_stock) {
                isDisabled = "";
            }

            let price = `<div class="d-flex gap-2 align-items-end">
                                    <div class="product-price">
                                        ${currencySymbol(product.price)}
                                    </div>
                                </div>`;
            if (product.promotional_price > 0) {
                price = `<div class="d-flex gap-2 align-items-end">
                                    <div class="product-old-price">
                                        ${currencySymbol(product.price)}
                                    </div>
                                    <div class="product-price">
                                        ${currencySymbol(
                                            product.promotional_price
                                        )}
                                    </div>
                                </div>`;
            }
            $("#new-products").append(`
                <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 my-3 ${isDisabled}">
                    <div class="card custom-card">
                        <div class="card-body position-relative">
                        <div class="new-label position-absolute wishlist-add-request" data-id="${
                            product.id
                        }">
                            <img src="/public/icons/heart.svg" alt="wishlist">
                        </div>
                            <a href="/product-details/${
                                product.slug
                            }" class="product-image">
                                <img src="${
                                    product.thumbnail
                                }" alt="${product.name}">
                            </a>
                            <div class="product-details mt-2">
                                <a href="/product-details/${
                                    product.slug
                                }" class="product-title-link">
                                    <div class="product-title">
                                        ${product.name}
                                    </div>
                                </a>

                                <div class="d-flex justify-content-between align-items-center my-2">
                                    <div class="product-rating-container gap-1">
                                        <img src="/public/icons/star.svg" alt="stars" class="product-rating-image">
                                        <span class="product-rating">${
                                            product.rating
                                        }</span>
                                        <span class="product-rating-count">(${
                                            product.rating_count
                                        })</span>
                                    </div>
                                    <span class="product-in-stock">${
                                        product.in_stock
                                            ? "In Stock"
                                            : "Out of Stock"
                                    }</span>
                                </div>
                                ${price}
                            </div>
                            <div class="d-flex justify-content-between align-items-center gap-3 mt-3">
                                <div class="add-to-cart-button add-to-cart-request" data-id="${
                                    product.id
                                }">
                                    <img src="/public/icons/web-shopping-cart.svg" alt="shopping-cart" class="add-to-cart-image">
                                    <div class="add-to-cart-text">Add To Cart</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>`);
        });
    },
    error: function (xhr, status, error) {
        var response = JSON.parse(xhr.responseText);
        console.log(response.message);
    },
});
