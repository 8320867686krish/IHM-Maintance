document.addEventListener("DOMContentLoaded", () => {
    const sliders = document.querySelectorAll(".emotions-slider");
    if (!sliders.length) return;

    sliders.forEach((element) => {
        const [slider, prevEl, nextEl] = [
         //   element.querySelector(".swiper"),
          //  element.querySelector(".slider-nav__item_prev"),
//element.querySelector(".slider-nav__item_next"),
        ];

        const slidesCount = slider.querySelectorAll(".swiper-slide").length;

        new Swiper(slider, {
            slidesPerView: 'auto',
            spaceBetween: 40,
            speed: 600,
            navigation:true,
            breakpoints: {
                768: {
                    spaceBetween: 25,
                },
            },
        });

    });
});
