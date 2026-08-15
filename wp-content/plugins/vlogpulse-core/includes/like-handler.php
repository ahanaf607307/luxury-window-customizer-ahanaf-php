<?php
/**
 * Interactive AJAX Post Like / Unlike System
 * 
 * ফ্রেশারদের জন্য নোট:
 * - ইউজার যখন লাইক বাটনে ক্লিক করে, ব্রাউজার থেকে জাভাস্ক্রিপ্ট AJAX কল পাঠায়।
 * - 'wp_postmeta' টেবিলে আমরা পোস্টের মোট লাইক সংখ্যা এবং কোন কোন ইউজার লাইক দিয়েছে তার তালিকা সংরক্ষণ করি।
 * - 'wp_usermeta' টেবিলে ইউজার কোন কোন পোস্টে লাইক দিয়েছে তাও ট্র্যাক করা হয়।
 * 
 * @package VlogPulse_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * পোস্টের মোট লাইক সংখ্যা পাওয়ার হেল্পার ফাংশন
 */
if (!function_exists('ahanaf_get_post_likes')) {
    function ahanaf_get_post_likes($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        $likes = get_post_meta($post_id, '_ahanaf_like_count', true);
        return !empty($likes) ? (int)$likes : 0;
    }
}

/**
 * বর্তমান ইউজার এই পোস্টে লাইক দিয়েছে কিনা তা চেক করার ফাংশন
 */
if (!function_exists('ahanaf_user_has_liked')) {
    function ahanaf_user_has_liked($post_id = null, $user_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }
        if (!$user_id) {
            $user_id = get_current_user_id();
        }
        if (!$user_id) {
            return false;
        }

        $liked_users = get_post_meta($post_id, '_ahanaf_liked_users', true);
        if (!is_array($liked_users)) {
            return false;
        }

        return in_array($user_id, $liked_users);
    }
}

/**
 * লাইক বাটন রেন্ডার করার হেল্পার ফাংশন (কার্ড এবং সিঙ্গেল পেজে ব্যবহারের জন্য)
 */
if (!function_exists('ahanaf_render_like_button')) {
    function ahanaf_render_like_button($post_id = null, $show_text = true) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }

        $like_count = ahanaf_get_post_likes($post_id);
        $has_liked = ahanaf_user_has_liked($post_id);
        $is_logged_in = is_user_logged_in();
        $active_class = $has_liked ? 'is-liked' : '';
        ?>
        <button type="button" 
                class="ahanaf-like-btn <?php echo esc_attr($active_class); ?>" 
                data-post-id="<?php echo esc_attr($post_id); ?>"
                data-logged-in="<?php echo $is_logged_in ? '1' : '0'; ?>"
                title="<?php echo $has_liked ? esc_attr__('Unlike this vlog', 'vlogpulse-core') : esc_attr__('Like this vlog', 'vlogpulse-core'); ?>"
                aria-label="<?php echo esc_attr__('Like or unlike post', 'vlogpulse-core'); ?>">
            <span class="ahanaf-like-icon">
                <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="<?php echo $has_liked ? 'currentColor' : 'none'; ?>" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                </svg>
            </span>
            <span class="ahanaf-like-count"><?php echo esc_html($like_count); ?></span>
            <?php if ($show_text) : ?>
                <span class="ahanaf-like-label"><?php echo $has_liked ? esc_html__('Liked', 'vlogpulse-core') : esc_html__('Like', 'vlogpulse-core'); ?></span>
            <?php endif; ?>
        </button>
        <?php
    }
}

/**
 * AJAX লাইক / আনলাইক হ্যান্ডলার
 */
function ahanaf_handle_ajax_like() {
    // ১. ননস ভেরিফিকেশন
    check_ajax_referer('ahanaf_like_nonce', 'security');

    // ২. ইউজার লগইন চেক করা (লাইক দেওয়ার জন্য লগইন আবশ্যক)
    if (!is_user_logged_in()) {
        wp_send_json_error(array(
            'require_login' => true,
            'message'       => __('Please log in to like this post.', 'vlogpulse-core')
        ));
    }

    $post_id = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;
    if (!$post_id || get_post_status($post_id) !== 'publish') {
        wp_send_json_error(array('message' => __('Invalid post ID!', 'vlogpulse-core')));
    }

    $user_id = get_current_user_id();

    // পোস্টের বর্তমান লাইকারদের লিস্ট আনা
    $liked_users = get_post_meta($post_id, '_ahanaf_liked_users', true);
    if (!is_array($liked_users)) {
        $liked_users = array();
    }

    $like_count = (int)get_post_meta($post_id, '_ahanaf_like_count', true);
    $liked = false;

    // টগল লজিক: ইউজার অলরেডি লাইক দিয়ে থাকলে আনলাইক করবে, না থাকলে লাইক যোগ করবে
    if (in_array($user_id, $liked_users)) {
        // আনলাইক করা
        $liked_users = array_diff($liked_users, array($user_id));
        $like_count = max(0, $like_count - 1);
        $liked = false;
        $message = __('Post unliked', 'vlogpulse-core');
    } else {
        // লাইক দেওয়া
        $liked_users[] = $user_id;
        $like_count = $like_count + 1;
        $liked = true;
        $message = __('Post liked!', 'vlogpulse-core');
    }

    // মেটাডাটা আপডেট করা
    update_post_meta($post_id, '_ahanaf_liked_users', array_values($liked_users));
    update_post_meta($post_id, '_ahanaf_like_count', $like_count);

    wp_send_json_success(array(
        'liked'      => $liked,
        'count'      => $like_count,
        'message'    => $message,
        'post_id'    => $post_id
    ));
}
add_action('wp_ajax_ahanaf_toggle_like', 'ahanaf_handle_ajax_like');
add_action('wp_ajax_nopriv_ahanaf_toggle_like', 'ahanaf_handle_ajax_like');
