jQuery(window).on("elementor/frontend/init", function () {
  elementorFrontend.hooks.addAction(
    "frontend/element_ready/rasta_video_carousel.default",
    function ($scope) {
      var $mainSwiper = $scope.find(".rasta-main-swiper");
      var $thumbSwiper = $scope.find(".rasta-thumb-swiper");

      if (!$mainSwiper.length || !$thumbSwiper.length) return;

      // 1. Initialize Elementor's Async Swiper
      const asyncSwiper = elementorFrontend.utils.swiper;

      new asyncSwiper($thumbSwiper, {
        spaceBetween: 15,
        slidesPerView: 5,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
          320: { slidesPerView: 3 },
          768: { slidesPerView: 5 },
        },
      }).then(function (thumbSwiperInstance) {
        // Initialize main slider ONLY after thumbnails are ready
        new asyncSwiper($mainSwiper, {
          effect: "coverflow",
          grabCursor: true,
          centeredSlides: true,
          slidesPerView: "auto",
          initialSlide: 1,
          coverflowEffect: {
            rotate: 30,
            stretch: 0,
            depth: 150,
            modifier: 1,
            slideShadows: true,
          },
          thumbs: {
            swiper: thumbSwiperInstance,
          },
        });
      });

      // 2. Lazy Load Iframe on Play Button Click
      $scope.find(".lazy-video-facade .play-btn").on("click", function (e) {
        e.preventDefault();
        var $card = jQuery(this).closest(".lazy-video-facade");
        var iframeSrc = $card.data("iframe");

        // Create the iframe HTML
        var iframeHtml =
          '<iframe width="100%" height="100%" src="' +
          iframeSrc +
          '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="position:absolute; top:0; left:0; width:100%; height:100%; border-radius: 12px; z-index: 10;"></iframe>';

        // Inject iframe and hide the image & play button
        $card.append(iframeHtml);
        $card.find("img, .play-btn").fadeOut(300);
      });
    },
  );
});