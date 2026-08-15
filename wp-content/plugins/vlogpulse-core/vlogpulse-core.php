<?php
/**
 * Plugin Name:       VlogPulse Core
 * Plugin URI:        https://github.com/ahanafmubasshir/vlogpulse-core
 * Description:       Core companion plugin for VlogPulse / Blog Post theme providing Custom Meta Boxes, Interactive AJAX Likes, and Authentication Logic.
 * Version:           1.0.0
 * Author:            Ahanaf Mubasshir
 * Author URI:        https://github.com/ahanafmubasshir
 * License:           GPL-2.0+
 * Text Domain:       vlogpulse-core
 * Domain Path:       /languages
 *
 * @package           VlogPulse_Core
 */

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

// 1. Define Plugin Constants
define('VLOGPULSE_CORE_VERSION', '1.0.0');
define('VLOGPULSE_CORE_DIR', plugin_dir_path(__FILE__));
define('VLOGPULSE_CORE_URL', plugin_dir_url(__FILE__));

// 2. Load Core Feature Modules
require_once VLOGPULSE_CORE_DIR . 'includes/meta-boxes.php';
require_once VLOGPULSE_CORE_DIR . 'includes/like-handler.php';
require_once VLOGPULSE_CORE_DIR . 'includes/auth-handler.php';
require_once VLOGPULSE_CORE_DIR . 'includes/post-submission.php';

/**
 * Enqueue Core Frontend Scripts & Localized AJAX Data
 */
function vlogpulse_core_enqueue_scripts() {
    // AJAX Authentication Script
    wp_enqueue_script(
        'vlogpulse-auth-script',
        VLOGPULSE_CORE_URL . 'assets/js/auth.js',
        array(),
        VLOGPULSE_CORE_VERSION,
        true
    );

    // AJAX Like / Unlike Script
    wp_enqueue_script(
        'vlogpulse-likes-script',
        VLOGPULSE_CORE_URL . 'assets/js/likes.js',
        array(),
        VLOGPULSE_CORE_VERSION,
        true
    );

    // Frontend Post / Vlog Submission Script
    wp_enqueue_script(
        'vlogpulse-post-submission-script',
        VLOGPULSE_CORE_URL . 'assets/js/post-submission.js',
        array(),
        VLOGPULSE_CORE_VERSION,
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
            'login_required' => __('Please sign in first to like or comment!', 'vlogpulse-core'),
            'loading'        => __('Processing...', 'vlogpulse-core'),
            'error'          => __('Something went wrong, please try again.', 'vlogpulse-core'),
        )
    );

    wp_localize_script('vlogpulse-auth-script', 'ahanaf_data', $localize_data);
    wp_localize_script('vlogpulse-likes-script', 'ahanaf_data', $localize_data);
    wp_localize_script('vlogpulse-post-submission-script', 'vlogpulse_core_data', $localize_data);
}
add_action('wp_enqueue_scripts', 'vlogpulse_core_enqueue_scripts');

/**
 * Load Plugin Textdomain for Translations
 */
function vlogpulse_core_load_textdomain() {
    load_plugin_textdomain('vlogpulse-core', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'vlogpulse_core_load_textdomain');
