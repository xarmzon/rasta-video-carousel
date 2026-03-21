<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Rasta_Video_Carousel_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rasta_video_carousel';
	}

	public function get_title() {
		return esc_html__( 'Rasta Video Carousel', 'rasta' );
	}

	public function get_icon() {
		return 'eicon-media-carousel';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_script_depends() {
		return [ 'rasta-carousel-script', 'swiper' ];
	}

	public function get_style_depends() {
        // e-swiper forces Elementor's native Swiper CSS to load
		return [ 'rasta-carousel-style', 'e-swiper' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Video Slides', 'rasta' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'video_title',
			[
				'label' => esc_html__( 'Title', 'rasta' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Video Title', 'rasta' ),
			]
		);

		$repeater->add_control(
			'video_url',
			[
				'label' => esc_html__( 'Video Link (YouTube/Vimeo)', 'rasta' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://youtube.com/...', 'rasta' ),
				'default' => [
					'url' => '',
				],
			]
		);

		$repeater->add_control(
			'cover_image',
			[
				'label' => esc_html__( 'Custom Cover Image (Optional Fallback)', 'rasta' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'slides',
			[
				'label' => esc_html__( 'Carousel Items', 'rasta' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[ 'video_title' => esc_html__( 'Slide 1', 'rasta' ) ],
					[ 'video_title' => esc_html__( 'Slide 2', 'rasta' ) ],
					[ 'video_title' => esc_html__( 'Slide 3', 'rasta' ) ],
				],
				'title_field' => '{{{ video_title }}}',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		if ( empty( $settings['slides'] ) ) return;
		?>
		<div class="rasta-carousel-wrapper">
			<div class="swiper rasta-main-swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $settings['slides'] as $slide ) : 
                        $video_url = !empty($slide['video_url']['url']) ? $slide['video_url']['url'] : '';
                        $iframe_src = '';
                        $thumb_url = '';

                        // 1. Check for YouTube (Standard, Short, or Embed)
                        if ( preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|shorts/)|youtu\.be/)([^"&?/\s]{11})%i', $video_url, $match) ) {
                            $yt_id = $match[1];
                            $thumb_url = "https://img.youtube.com/vi/{$yt_id}/maxresdefault.jpg";
                            $iframe_src = "https://www.youtube.com/embed/{$yt_id}?autoplay=1&rel=0&showinfo=0";
                        } 
                        // 2. Check for Vimeo
                        elseif ( preg_match('/(?:vimeo\.com\/|player\.vimeo\.com\/video\/)([0-9]+)/i', $video_url, $match) ) {
                            $vimeo_id = $match[1];
                            $thumb_url = !empty($slide['cover_image']['url']) ? $slide['cover_image']['url'] : \Elementor\Utils::get_placeholder_image_src();
                            $iframe_src = "https://player.vimeo.com/video/{$vimeo_id}?autoplay=1";
                        } 
                        // 3. Fallback (Direct MP4 or Other)
                        else {
                            $thumb_url = !empty($slide['cover_image']['url']) ? $slide['cover_image']['url'] : \Elementor\Utils::get_placeholder_image_src();
                            $iframe_src = $video_url; 
                        }
                    ?>
						<div class="swiper-slide">
                            <div class="rasta-video-card lazy-video-facade" data-iframe="<?php echo esc_url($iframe_src); ?>">
                                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $slide['video_title'] ); ?>" loading="lazy">
                                <div class="play-btn"><i class="eicon-play"></i></div>
                            </div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="swiper rasta-thumb-swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $settings['slides'] as $slide ) : 
                        $video_url = !empty($slide['video_url']['url']) ? $slide['video_url']['url'] : '';
                        $thumb_url = '';

                        if ( preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=|shorts/)|youtu\.be/)([^"&?/\s]{11})%i', $video_url, $match) ) {
                            $thumb_url = "https://img.youtube.com/vi/{$match[1]}/maxresdefault.jpg";
                        } else {
                            $thumb_url = !empty($slide['cover_image']['url']) ? $slide['cover_image']['url'] : \Elementor\Utils::get_placeholder_image_src();
                        }
                    ?>
						<div class="swiper-slide">
							<img src="<?php echo esc_url( $thumb_url ); ?>" alt="Thumb" loading="lazy">
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<?php
	}
}