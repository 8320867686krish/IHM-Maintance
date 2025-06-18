document.addEventListener("DOMContentLoaded", () => {
    const sliders = document.querySelectorAll(".emotions-slider");
    if (!sliders.length) return;

    sliders.forEach((element) => {
        const [sliderEl, prevEl, nextEl] = [
            element.querySelector(".emotions-slider__slider.swiper"),
            element.querySelector(".slider-nav__item_prev"),
            element.querySelector(".slider-nav__item_next"),
        ];

        const swiper = new Swiper(sliderEl, {
            slidesPerView: 'auto',
            spaceBetween: 40,
            speed: 600,
            navigation: {
                nextEl,
                prevEl,
                disabledClass: "disabled",
            },
            breakpoints: {
                768: {
                    spaceBetween: 25,
                },
            },
            on: {
                init() {
                    toggleNavVisibility(swiper, element);
                },
                resize() {
                    toggleNavVisibility(swiper, element);
                },
            }
        });
    });

    function toggleNavVisibility(swiper, wrapper) {
        const nav = wrapper.querySelector(".slider-nav");
        if (!nav) return;

        const isScrollable = swiper.slides.length > swiper.visibleSlides.length;
        nav.style.display = isScrollable ? 'flex' : 'none';
    }
});
