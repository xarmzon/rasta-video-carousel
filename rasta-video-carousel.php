<?php
/**
 * Plugin Name: Rasta 3D Video Carousel
 * Description: A custom 3D Coverflow video carousel widget for Elementor.
 * Plugin URI:  https://github.com/xarmzon
 * Version:     1.0.0
 * Author:      Adelola Kayode Samson
 * Author URI:  https://github.com/xarmzon
 * Text Domain: rasta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function rasta_register_video_carousel_widget( $widgets_manager ) {
	require_once( __DIR__ . '/widget.php' );
	$widgets_manager->register( new \Rasta_Video_Carousel_Widget() );
}
add_action( 'elementor/widgets/register', 'rasta_register_video_carousel_widget' );

function rasta_video_carousel_scripts() {
    // wp_enqueue ensures the files are forced to load on the live page
	wp_enqueue_style( 'rasta-carousel-style', plugins_url( 'assets/css/style.css', __FILE__ ) );
	wp_enqueue_script( 'rasta-carousel-script', plugins_url( 'assets/js/script.js', __FILE__ ), [ 'jquery', 'swiper' ], '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'rasta_video_carousel_scripts' );