<?php
/**
 * Frontend AJAX Authentication Handlers (Sign In & Sign Up)
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'wp_ajax_nopriv_{action}' হুকটি ব্যবহৃত হয় যারা লগইন করা নেই (Guest Users) তাদের জন্য।
 * - 'wp_ajax_{action}' হুকটি ব্যবহৃত হয় যারা ইতোমধ্যে লগইন করা তাদের জন্য।
 * - 'check_ajax_referer()' ননস ভেরিফাই করে যা স্প্যাম বা আনঅথোরাইজড রিকোয়েস্ট ঠেকায়।
 * - 'wp_send_json_success()' এবং 'wp_send_json_error()' রেসপন্স হিসেবে JSON ডাটা ফ্রন্টএন্ডে রিটার্ন করে।
 * 
 * @package VlogPulse_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * ১. AJAX ইউজার রেজিস্ট্রেশন (Sign Up) হ্যান্ডলার
 */
function ahanaf_handle_ajax_register() {
    // সিকিউরিটি ননস চেক করা
    check_ajax_referer('ahanaf_auth_nonce', 'security');

    $username = isset($_POST['username']) ? sanitize_user(trim($_POST['username'])) : '';
    $email    = isset($_POST['email']) ? sanitize_email(trim($_POST['email'])) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $fullname = isset($_POST['fullname']) ? sanitize_text_field(trim($_POST['fullname'])) : '';

    // প্রাথমিক ভ্যালিডেশন
    if (empty($username) || empty($email) || empty($password)) {
        wp_send_json_error(array(
            'message' => __('Please fill in all required fields.', 'vlogpulse-core')
        ));
    }

    if (!is_email($email)) {
        wp_send_json_error(array(
            'message' => __('Please provide a valid email address.', 'vlogpulse-core')
        ));
    }

    if (username_exists($username)) {
        wp_send_json_error(array(
            'message' => __('This username is already taken. Please choose another.', 'vlogpulse-core')
        ));
    }

    if (email_exists($email)) {
        wp_send_json_error(array(
            'message' => __('An account with this email already exists.', 'vlogpulse-core')
        ));
    }

    if (strlen($password) < 6) {
        wp_send_json_error(array(
            'message' => __('Password must be at least 6 characters.', 'vlogpulse-core')
        ));
    }

    // ওয়ার্ডপ্রেসে নতুন ইউজার তৈরি করা
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        wp_send_json_error(array(
            'message' => $user_id->get_error_message()
        ));
    }

    // ফুলনেম থাকলে আপডেট করা
    if (!empty($fullname)) {
        wp_update_user(array(
            'ID'           => $user_id,
            'display_name' => $fullname
        ));
    }

    // রেজিস্ট্রেশনের সাথে সাথে স্বয়ংক্রিয়ভাবে লগইন করিয়ে দেওয়া (Seamless UX)
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id, true);

    wp_send_json_success(array(
        'message'  => __('Registration successful! Logging in...', 'vlogpulse-core'),
        'redirect' => home_url()
    ));
}
add_action('wp_ajax_nopriv_ahanaf_ajax_register', 'ahanaf_handle_ajax_register');

/**
 * ২. AJAX ইউজার লগইন (Sign In) হ্যান্ডলার
 */
function ahanaf_handle_ajax_login() {
    // সিকিউরিটি ননস চেক করা
    check_ajax_referer('ahanaf_auth_nonce', 'security');

    $credentials = array(
        'user_login'    => isset($_POST['log']) ? sanitize_text_field(trim($_POST['log'])) : '',
        'user_password' => isset($_POST['pwd']) ? $_POST['pwd'] : '',
        'remember'      => isset($_POST['rememberme']) && $_POST['rememberme'] === 'true',
    );

    if (empty($credentials['user_login']) || empty($credentials['user_password'])) {
        wp_send_json_error(array(
            'message' => __('Both username and password are required.', 'vlogpulse-core')
        ));
    }

    // ওয়ার্ডপ্রেসের 'wp_signon()' ফাংশন দিয়ে ক্রেডেনশিয়াল পরীক্ষা ও লগইন
    $user_signon = wp_signon($credentials, is_ssl());

    if (is_wp_error($user_signon)) {
        wp_send_json_error(array(
            'message' => __('Invalid username or password!', 'vlogpulse-core')
        ));
    }

    wp_send_json_success(array(
        'message'  => __('Login successful! Reloading...', 'vlogpulse-core'),
        'redirect' => isset($_POST['redirect_to']) && !empty($_POST['redirect_to']) ? esc_url_raw($_POST['redirect_to']) : home_url()
    ));
}
add_action('wp_ajax_nopriv_ahanaf_ajax_login', 'ahanaf_handle_ajax_login');
add_action('wp_ajax_ahanaf_ajax_login', 'ahanaf_handle_ajax_login');
