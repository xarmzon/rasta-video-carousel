jQuery(window).on('elementor/frontend/init', function () {

    elementorFrontend.hooks.addAction(
        'frontend/element_ready/rasta_video_carousel.default',
        function ($scope) {

            const swiperEl = $scope.find('.mvc-swiper')[0];
            if (!swiperEl) return;

            new Swiper(swiperEl, {
                effect: 'coverflow',
                grabCursor: true,
                centeredSlides: true,
                loop: true,
                slidesPerView: 'auto',
                coverflowEffect: {
                    rotate: 0,
                    depth: 200,
                    modifier: 1.5,
                    slideShadows: false
                }
            });

            $scope.find('.mvc-video').on('click', function () {
                const videoUrl = $(this).data('video');
                const iframe = `<iframe src="${videoUrl}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>`;
                $(this).html(iframe);
            });

        }
    );

});
