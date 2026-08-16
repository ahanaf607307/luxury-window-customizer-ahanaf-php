<?php
/**
 * Plugin Name:       LuxePane Core
 * Plugin URI:        https://github.com/ahanaf607307/vlogpulse-theme-plugin-ahanaf-php
 * Description:       Core architectural glass & window configurator engine, dynamic pricing formula, custom post types, and WooCommerce line-item integrations for LuxePane.
 * Version:           1.0.0
 * Author:            Ahanaf Mubasshir
 * Author URI:        https://github.com/ahanaf607307
 * License:           GPL-2.0+
 * Text Domain:       luxepane-core
 * Domain Path:       /languages
 *
 * @package           LuxePane_Core
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// 1. Define Plugin Constants
define('LUXEPANE_CORE_VERSION', '1.0.0');
define('LUXEPANE_CORE_DIR', plugin_dir_path(__FILE__));
define('LUXEPANE_CORE_URL', plugin_dir_url(__FILE__));

// 2. Load Core Feature Modules
require_once LUXEPANE_CORE_DIR . 'includes/meta-boxes.php';
require_once LUXEPANE_CORE_DIR . 'includes/like-handler.php';
require_once LUXEPANE_CORE_DIR . 'includes/auth-handler.php';
require_once LUXEPANE_CORE_DIR . 'includes/post-submission.php';
require_once LUXEPANE_CORE_DIR . 'includes/window-configurator.php';

/**
 * Enqueue Core Frontend Scripts & Localized AJAX Data
 */
function luxepane_core_enqueue_scripts() {
    // AJAX Authentication Script
    wp_enqueue_script(
        'luxepane-auth-script',
        LUXEPANE_CORE_URL . 'assets/js/auth.js',
        array(),
        LUXEPANE_CORE_VERSION,
        true
    );

    // AJAX Like / Unlike Script
    wp_enqueue_script(
        'luxepane-likes-script',
        LUXEPANE_CORE_URL . 'assets/js/likes.js',
        array(),
        LUXEPANE_CORE_VERSION,
        true
    );

    // Frontend Post / Vlog Submission Script
    wp_enqueue_script(
        'luxepane-post-submission-script',
        LUXEPANE_CORE_URL . 'assets/js/post-submission.js',
        array(),
        LUXEPANE_CORE_VERSION,
        true
    );

    // Live Custom Window & Glass Configurator Script
    wp_enqueue_script(
        'luxepane-window-configurator-script',
        LUXEPANE_CORE_URL . 'assets/js/window-configurator.js',
        array(),
        LUXEPANE_CORE_VERSION,
        true
    );

    // Localize Data for AJAX requests (Nonces, URL, User status, Translation strings)
    $localize_data = array(
        'ajax_url'     => admin_url('admin-ajax.php'),
        'auth_nonce'   => wp_create_nonce('ahanaf_auth_nonce'),
        'like_nonce'   => wp_create_nonce('ahanaf_like_nonce'),
        'post_nonce'   => wp_create_nonce('vlogpulse_post_nonce'),
        'is_logged_in' => is_user_logged_in() ? 1 : 0,
        'current_user' => is_user_logged_in() ? wp_get_current_user()->display_name : '',
        'strings'      => array(
            'login_required' => __('Please sign in first to like or comment!', 'luxepane-core'),
            'loading'        => __('Processing...', 'luxepane-core'),
            'error'          => __('Something went wrong, please try again.', 'luxepane-core'),
        )
    );

    $window_localize_data = array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('vlogpulse_window_nonce'),
        'cart_url' => function_exists('wc_get_cart_url') ? wc_get_cart_url() : home_url('/cart/'),
    );

    wp_localize_script('luxepane-auth-script', 'ahanaf_data', $localize_data);
    wp_localize_script('luxepane-likes-script', 'ahanaf_data', $localize_data);
    wp_localize_script('luxepane-post-submission-script', 'vlogpulse_core_data', $localize_data);
    wp_localize_script('luxepane-window-configurator-script', 'vlogpulse_window_data', $window_localize_data);
}
add_action('wp_enqueue_scripts', 'luxepane_core_enqueue_scripts');

/**
 * Load Plugin Textdomain for Translations
 */
function luxepane_core_load_textdomain() {
    load_plugin_textdomain('luxepane-core', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'luxepane_core_load_textdomain');
