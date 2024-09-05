$(document).mouseup(function(e) {
    var container = $('#productList');
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide();
        $('#searchProduct').val('');
    }
});

$('#searchProduct').on("keyup", function() {
    var value = $('#searchProduct').val();
    if (value == '') {
        $('#productList').hide();
        $('#productList').html('');
    }
    $.ajax({
        url: "/product/search",
        type: 'GET',
        data: {
            search: value
        },
        dataType: 'json',
        success: function(response) {
            if (response.data.products.length) {
                $('#productList').show()
                let html = '';
                $.each(response.data.products, function(index, item) {
                    html +=
                        `<div class='product-item p-2' onclick='selecteItem("${item.id}")'>${item.name}</div>`
                });
                $('#productList').html(html)

            }
        }
    });
});

function selecteItem(id) {
    $('#productList').hide()
    $.ajax({
        url: "/product/select",
        type: 'GET',
        data: {
            id: id
        },
        dataType: 'json',
        success: function(response) {
            const product = response.data.product;
            if (product) {
                var products = $(`#productPurchaseRow_${product.id}`);
                if (products.length) {
                    var qty = Number($(`#productQty_${product.id}`).val());
                    $(`#productQty_${product.id}`).val(qty + 1);
                    countQty();
                } else {
                    $('#searchProduct').val('');
                    $('#productBarcode').append(`<tr class="productPurchaseRow" id="productPurchaseRow_${product.id}" data-id="${product.id}" data-total="0">
                        <input type="hidden" name="product_ids[]" value="${product.id}">
                        <td>${product.name}</td>
                        <td>${product.code}</td>
                        <td>
                            <input type="number" class="form-control qty" name="qtys[]"  id="productQty_${product.id}" onchange="countQty()" value="1">

                        </td>
                        <td>
                            <a onclick='deleteRow("${product.id}")'><i class="fa fa-times text-danger"></i></a>
                        </td>
                    </tr>`);
                    countQty();
                }
            }
        }
    });
}

function deleteRow(id) {
    $('#productPurchaseRow_' + id).remove();
    countQty();
}

countQty = function() {
    let totalElement = document.getElementsByClassName('productPurchaseRow')
    var totalQty = 0
    for (var i = 0; i < totalElement.length; i++) {
        var totalQty = (Number(totalQty) + Number(totalElement[i].getElementsByClassName('qty')[0].value));
    }
}