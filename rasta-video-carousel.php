<?php
/**
 * Plugin Name: Rasta Video Carousel
 * Description: Production-ready Elementor video carousel (coverflow + lazy load)
 * Version: 1.0.0
 * Author: Adelola Kayode Samson
 * Author URI: https://github.com/xarmzon
 */

if (!defined('ABSPATH')) exit;

function mvc_register_widget($widgets_manager) {
    require_once(__DIR__ . '/widget.php');
    $widgets_manager->register(new \MVC_Video_Carousel());
}
add_action('elementor/widgets/register', 'mvc_register_widget');

function mvc_enqueue_assets() {

    wp_enqueue_script('swiper');

    wp_enqueue_style(
        'mvc-style',
        plugins_url('assets/css/style.css', __FILE__)
    );

    wp_enqueue_script(
        'mvc-script',
        plugins_url('assets/js/script.js', __FILE__),
        ['jquery', 'swiper'],
        '2.0.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'mvc_enqueue_assets');
