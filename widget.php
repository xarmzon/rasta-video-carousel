<?php
if (!defined('ABSPATH')) exit;

class MVC_Video_Carousel extends \Elementor\Widget_Base {

    public function get_name() { return 'rasta_video_carousel'; }
    public function get_title() { return 'Rasta Video Carousel'; }
    public function get_icon() { return 'eicon-slider-video'; }
    public function get_categories() { return ['general']; }

    protected function register_controls() {

        $this->start_controls_section('content_section', [
            'label' => 'Videos',
        ]);

        $repeater = new \Elementor\Repeater();

        $repeater->add_control('video_url', [
            'label' => 'Video URL',
            'type' => \Elementor\Controls_Manager::TEXT,
            'placeholder' => 'https://youtube.com/watch?v=xxxx',
        ]);

        $this->add_control('videos', [
            'label' => 'Video List',
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'title_field' => '{{{ video_url }}}',
        ]);

        $this->end_controls_section();
    }

    private function get_youtube_id($url) {

    if (empty($url)) return '';

    // Normalize URL
    $url = trim($url);

    // Handle youtu.be links
    if (preg_match('/youtu\.be\/([a-zA-Z0-9_-]{11})/', $url, $match)) {
        return $match[1];
    }

    // Handle shorts
    if (preg_match('/youtube\.com\/shorts\/([a-zA-Z0-9_-]{11})/', $url, $match)) {
        return $match[1];
    }

    // Handle embed
    if (preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]{11})/', $url, $match)) {
        return $match[1];
    }

    // Handle standard watch?v=
    $query = parse_url($url, PHP_URL_QUERY);

    if ($query) {
        parse_str($query, $params);
        if (!empty($params['v'])) {
            return $params['v'];
        }
    }

    return '';
}

    protected function render() {

        $settings = $this->get_settings_for_display();
        if (empty($settings['videos'])) return;

        $id = 'rasta-swiper-' . $this->get_id();

        echo '<div class="mvc-swiper swiper" id="' . esc_attr($id) . '">';
        echo '<div class="swiper-wrapper">';

        foreach ($settings['videos'] as $video) {

            $video_id = $this->get_youtube_id($video['video_url']);
            $thumbnail = $video_id 
                ? "https://img.youtube.com/vi/$video_id/hqdefault.jpg" 
                : "";

            $embed_url = $video_id
                ? "https://www.youtube.com/embed/$video_id?autoplay=1"
                : esc_url($video['video_url']);

            echo '<div class="swiper-slide">';
            echo '<div class="mvc-video" data-video="' . esc_attr($embed_url) . '">';

            if ($thumbnail) {
                echo '<img src="' . esc_url($thumbnail) . '" class="mvc-thumb" />';
            }

            echo '<div class="mvc-play-btn">▶</div>';

            echo '</div>';
            echo '</div>';
        }

        echo '</div></div>';
    }
}
