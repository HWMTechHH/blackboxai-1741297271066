<?php
/**
 * Plugin Name: WP Play.Ht Reader
 * Description: A plugin to read WordPress articles aloud using Play.Ht API.
 * Version: 1.0
 * Author: Your Name
 */

// Enqueue scripts and styles
function playht_enqueue_scripts() {
    wp_enqueue_script('playht-js', plugin_dir_url(__FILE__) . 'assets/js/playht.js', array('jquery'), null, true);
    wp_enqueue_style('playht-css', plugin_dir_url(__FILE__) . 'assets/css/playht.css');
}
add_action('wp_enqueue_scripts', 'playht_enqueue_scripts');

// Add player to the beginning of the article
function playht_add_player($content) {
    if (is_single()) {
        $player_html = '<div id="playht-player"></div>';
        $content = $player_html . $content;
    }
    return $content;
}
add_filter('the_content', 'playht_add_player');
