$(document).ready(function () {
    $.ajax({
        url: "/ajax-orders",
        type: "GET",
        success: function (response) {
            if (response.data.pending.length > 0) {
                response.data.pending.forEach(function (order, index) {
                    $("#pending-orders").append(`<div class="row mb-4" >
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="order-title color">Order ID :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Order Status :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Total Amount :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Delivery Address :</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title color">${order.order_id}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-status">${order.status}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title fw-bold">${order.grand_total}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title">${order.address}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`);
                });
            } else {
                $("#pending-orders")
                    .append(`<div class="alert alert-info custom-alert text-center" role="alert">
                                                    No Data Found!
                                                </div>`);
            }

            if (response.data.on_process.length > 0) {
                response.data.on_process.forEach(function (order, index) {
                    $("#on-process-orders").append(`<div class="row mb-4" >
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="order-title color">Order ID :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Order Status :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Total Amount :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Delivery Address :</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title color">${order.order_id}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-status">${order.status}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title fw-bold">${order.grand_total}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title">${order.address}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`);
                });
            } else {
                $("#on-process-orders")
                    .append(`<div class="alert alert-info custom-alert text-center" role="alert">
                                                    No Data Found!
                                                </div>`);
            }
            if (response.data.delivered.length > 0) {
                response.data.delivered.forEach(function (order, index) {
                    $("#delivered-orders").append(`<div class="row mb-4" >
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="order-title color">Order ID :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Order Status :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Total Amount :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Delivery Address :</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title color">${order.order_id}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-status">${order.status}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title fw-bold">${order.grand_total}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title">${order.address}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`);
                });
            } else {
                $("#delivered-orders")
                    .append(`<div class="alert alert-info custom-alert text-center" role="alert">
                                                    No Data Found!
                                                </div>`);
            }
            if (response.data.cancelled.length > 0) {
                response.data.cancelled.forEach(function (order, index) {
                    $("#canceled-orders").append(`<div class="row mb-4" >
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="order-title color">Order ID :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Order Status :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Total Amount :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Delivery Address :</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title color">${order.order_id}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-status">${order.status}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title fw-bold">${order.grand_total}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title">${order.address}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`);
                });
            } else {
                $("#canceled-orders")
                    .append(`<div class="alert alert-info custom-alert text-center" role="alert">
                                                    No Data Found!
                                                </div>`);
            }
            if (response.data.all.length > 0) {
                response.data.all.forEach(function (order, index) {
                    $("#all-orders").append(`<div class="row mb-4" >
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="order-title color">Order ID :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Order Status :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Total Amount :</div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="order-title">Delivery Address :</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title color">${order.order_id}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-status">${order.status}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title fw-bold">${order.grand_total}</div>
                                                        </div>
                                                        <div class="col-md-12 text-end">
                                                            <div class="order-title">${order.address}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>`);
                });
            } else {
                $("#all-orders")
                    .append(`<div class="alert alert-info custom-alert text-center" role="alert">
                                                    No Data Found!
                                                </div>`);
            }
        },
        error: function (xhr, status, error) {
            var response = JSON.parse(xhr.responseText);
            console.log(response.message);
        },
    });
});
