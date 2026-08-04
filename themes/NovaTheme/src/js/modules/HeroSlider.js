import Swiper from 'swiper';

import {Navigation, Pagination, Autoplay} from 'swiper/modules';


import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';

/*
|--------------------------------------------------------------------------
| SWIPER INITIALIZATION
|--------------------------------------------------------------------------
*/
export const initHeroSlider = () => {
    const sliderElem = document.querySelector('.js-hero-slider');

    if (sliderElem) {
        new Swiper(sliderElem, {

            modules: [Navigation, Pagination, Autoplay],
            loop: true,
            speed: 800,
            autoplay: {
                delay: 5000,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    }
};