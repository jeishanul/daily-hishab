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
