<?php
/*
Plugin Name: Custom Footer Widget
Description: Add a custom footer widget with settings page.
Version: 1.0
Author: Pradeep Prajapati
Author URI: https://pradeepprajapat.netlify.app/
*/

if (!defined('ABSPATH')) {
    exit;
}

// Define plugin URL and PATH
define('CFW_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CFW_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Include required files
require_once CFW_PLUGIN_PATH . 'includes/settings-page.php';
require_once CFW_PLUGIN_PATH . 'includes/custom-widget.php';

// Enqueue scripts and styles
function cfw_enqueue_scripts() {
    wp_enqueue_style('cfw-style', CFW_PLUGIN_URL . 'css/style.css');
    wp_enqueue_script('cfw-script', CFW_PLUGIN_URL . 'js/script.js', array('jquery'), false, true);
    wp_enqueue_media();
    wp_enqueue_script('wp-color-picker');
    wp_enqueue_style('wp-color-picker');
}
add_action('admin_enqueue_scripts', 'cfw_enqueue_scripts');
add_action('wp_enqueue_scripts', 'cfw_enqueue_scripts');

// Register widget
function cfw_register_widget() {
    register_widget('Custom_Footer_Widget');
}
add_action('widgets_init', 'cfw_register_widget');

// Activation hook
function cfw_activate() {
    if (!get_option('cfw_settings')) {
        update_option('cfw_settings', array());
    }
}
register_activation_hook(__FILE__, 'cfw_activate');

// Deactivation hook
function cfw_deactivate() {
    delete_option('cfw_settings');
}
register_deactivation_hook(__FILE__, 'cfw_deactivate');
