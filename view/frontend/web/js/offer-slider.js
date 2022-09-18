define([
    'jquery',
    'domReady!'
], function ($) {
    'use strict';
    let sliderContainer = $('#offers-container__slider');
    let sliderDelay = sliderContainer.data('sliding-delay');
    let sliderItemCount = sliderContainer.data('item-count');

    window.setInterval(function() {
        let newItemDisplay = sliderContainer.data('item-displayed') + 1;
        sliderContainer.data('item-displayed', newItemDisplay);
        if (newItemDisplay % sliderItemCount === 0) {
            sliderContainer.data('item-displayed', 0);
        }
        sliderContainer.css('transform', 'translateX(-' + (sliderContainer.data('item-displayed') * 100) + 'vw)');
        console.log(sliderDelay * 1000);
    },  sliderDelay * 1000);
});
