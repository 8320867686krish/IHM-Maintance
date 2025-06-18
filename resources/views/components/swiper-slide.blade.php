<div class="wrapper base-template__wrapper">


    <div class="emotions-slider">


        <div class="emotions-slider__nav slider-nav">
            <div tabindex="0" class="slider-nav__item slider-nav__item_prev">
                <svg width="16" height="28" viewBox="0 0 16 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14 26L2 14L14 2" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div tabindex="0" class="slider-nav__item slider-nav__item_next">
                <svg width="16" height="28" viewBox="0 0 16 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 26L14 14L2 2" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        </div>

        <!-- Slider Content -->

        <div class="emotions-slider__slider swiper">
            <div class="emotions-slider__wrapper swiper-wrapper">
                <!-- START: Slides loop -->
                @foreach($data as $value)
                <div class="emotions-slider__slide swiper-slide">
                    <div class="emotions-slider__item emotions-slider-item">
                        <a href="{{ route($routename, ['id' => $value['id']]) }}">
                            @if($imagekey == 'ship_image')
                            <img src="{{ asset($path . '/' . $value[$imagekey]) }}" alt="{{ $value['ship_name'] ?? 'Image' }}" class="card-img-top" />
                            @else
                            <div class="text-center mt-2">
                                <img src="{{ asset($path . '/' . $value[$imagekey]) }}" alt="{{ $value['name'] ?? 'Avatar' }}" class="rounded-circle user-avatar-xxl" />
                            </div>
                            @endif

                            <div class="emotions-slider-item__content text-center">
                                <div class="emotions-slider-item__header text-center">
                                    <div class="emotions-slider-item__header-inner">
                                        <div class="emotions-slider-item__author">
                                            <div class="emotions-slider-item__author-name text-center">
                                                @if($imagekey == 'ship_image')
                                                {{ $value['ship_name'] }}
                                                @else
                                                {{ $value['name'] }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
                <!-- END: Slides loop -->

                <!-- START: Add Slide -->
                @can($permission)
                <div class="emotions-slider__slide swiper-slide add-slide">
                    <div class="emotions-slider__item emotions-slider-item">
                        <a href="{{ route($addRoute) }}">
                            <div class="text-center mt-2">
                                <div class="add-new-slide d-flex justify-content-center align-items-center rounded-circle mx-auto" style="width: 115px; height: 115px; background-color: #293042 !important;">
                                    <span style="font-size: 50px; line-height: 1; color: #fff;">+</span>
                                </div>
                            </div>

                            <div class="emotions-slider-item__content text-center">
                                <div class="emotions-slider-item__header text-center">
                                    <div class="emotions-slider-item__header-inner">
                                        <div class="emotions-slider-item__author">
                                            <div class="emotions-slider-item__author-name text-center">
                                                {{ $title }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                @endcan
                <!-- END: Add Slide -->
            </div>

        </div>

        <!-- Slider Pagination -->

        <div class="emotions-slider__pagination slider-pagination"></div>

    </div>
</div>