<?php
/**
 * Plugin Name: Video.js Shortcode
 * Plugin URI: https://github.com/byetimmy/video.js
 * Description: This plugin allows to use Video.js HTML5 player in a shortcode.
 * Version: 1.0.0
 * Author: Bob Barber
 * Author URI: https://github.com/byetimmy
 * License: MIT
 */

//Load our video-js scripts and styles
function scriptsandstyles_videojs() {
    // Register and enqueue the video.js script for this plugin:
    wp_register_script( 'video-js-script', plugins_url( '/video.min.js', __FILE__ ) );
    wp_enqueue_script( 'video-js-script' );
	
     // Register and enqueue the video.js stylesheet for this plugin:
    wp_register_style( 'video-js-style', plugins_url( '/video-js.min.css', __FILE__ ) );
    wp_enqueue_style( 'video-js-style' );
	
}
add_action( 'wp_enqueue_scripts', 'scriptsandstyles_videojs' );


//Configure our video-js script
function config_videojs($content) {
	$content .= '<script>';
	$content .= 'if (window.videojs) videojs.options.flash.swf="' . plugins_url( '/video-js.swf', __FILE__ ) . '";';
	$content .= '</script>';
	return $content;
}
add_action('the_content', 'config_videojs');


// [video_js width="640" height="480"]
function video_js_func( $atts ) {
	//TODO - Add tracks for captions, subtitles, and chapters
    $a = shortcode_atts( array(
		'id' => rand(),
        'width' => '640',
        'height' => '480',
		'loop' => 'false',
		'controls' => 'true',
		'autoplay' => 'false',
		'preload' => 'auto',
		'poster' => '',
		'mp4' => '',
		'webm' => '',
		'ogg' => '',
		'skin' => 'vjs-default-skin'
    ), $atts );


	$controls = ($a['controls'] == 'true' ? ' controls ' : '');
	$autoplay = ($a['autoplay'] == 'true' ? ' autoplay ' : '');
	$loop = ($a['loop'] == 'true' ? ' loop ' : '');

	$ret  = '<video ';
	$ret .= '  id="' . esc_attr($a['id']) . '" class="video-js ' . esc_attr($a['skin']) . ' " ';
	$ret .= '  ' . $controls . $autoplay . $loop . ' preload="' . esc_attr($a['preload']) . '" ';
	$ret .= '  width="' . esc_attr($a['width']) . '" height="' . esc_attr($a['height']) . '" ';
	$ret .= ($a['poster'] == '' ? '' : '  poster="' . esc_attr($a['poster']) . '" ');
	$ret .= 'style="height: ' . esc_attr($a['height']) . 'px; width: ' . esc_attr($a['width']) . 'px; "';
	$ret .= '>';
	
	$ret .= ($a['mp4'] == '' ? '' : ' <source src="' . esc_attr($a['mp4']) . '" type="video/mp4" />');
	$ret .= ($a['webm'] == '' ? '' : ' <source src="' . esc_attr($a['webm']) . '" type="video/webm" />');
	$ret .= ($a['ogg'] == '' ? '' : ' <source src="' . esc_attr($a['ogg']) . '" type="video/ogg" />');
	
	//TODO - Hook up existing i18n strings with this 
	$ret .= ' <p class="vjs-no-js">' . 'To view this video please enable JavaScript, and consider upgrading to a web browser that supports HTML5 video. More info: http://videojs.com/html5-video-support/ ' . '</p>';
	$ret .= '</video>';
	
	return $ret;
}
add_shortcode('video-js', 'video_js_func');
