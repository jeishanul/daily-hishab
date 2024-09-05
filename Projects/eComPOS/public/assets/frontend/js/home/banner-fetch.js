$.ajax({
    url: "/ajax-banners",
    type: "GET",
    success: function (response) {
        response.data.banners.forEach(function (banner, index) {
            $(".swiper-wrapper").append(`<div class="swiper-slide">
                                    <a href="${banner.url}" class="banner-link">
                                        <img src="${banner.image}" class="w-100" alt="banner">
                                    </a>
                                </div>`);
        });
        sliderInit();
    },
    error: function (xhr, status, error) {
        var response = JSON.parse(xhr.responseText);
        console.log(response.message);
    },
});
function sliderInit() {
    const swiper = new Swiper(".mainBanner", {
        spaceBetween: 30,
        centeredSlides: true,
        direction: "horizontal",
        loop: true,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
        },

        // If we need pagination
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
}
