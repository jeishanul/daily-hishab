$("#promotion").on("change", function () {
    if ($(this).is(":checked")) {
        $("#starting_date").val(
            $.datepicker.formatDate("dd-mm-yy", new Date())
        );
        $("#promotion_price").show(300);
        $("#start_date").show(300);
        $("#last_date").show(300);
    } else {
        $("#promotion_price").hide(300);
        $("#start_date").hide(300);
        $("#last_date").hide(300);
    }
});
