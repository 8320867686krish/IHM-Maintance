document.addEventListener("DOMContentLoaded", () => {
    const sliders = document.querySelectorAll(".emotions-slider");
    if (!sliders.length) return;

    sliders.forEach((element) => {
        const [slider, prevEl, nextEl] = [
            element.querySelector(".swiper"),
            element.querySelector(".slider-nav__item_prev"),
            element.querySelector(".slider-nav__item_next"),
        ];

        const slidesCount = slider.querySelectorAll(".swiper-slide").length;
console.log(slidesCount);
if(slidesCount <= 3){
    return false;
}
        new Swiper(slider, {
            slidesPerView: 4, // Adjust dynamically
            spaceBetween: 40, // Reduce space for 2 slides
            speed: 600,
            navigation: {
                nextEl,
                prevEl,
                disabledClass: "disabled",
            },
            breakpoints: {
                768: {
                    spaceBetween: 40, // Adjust space on larger screens
                },
            },
        });
    });
});
