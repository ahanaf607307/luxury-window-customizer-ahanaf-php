<?php
/**
 * Custom Meta Boxes for Vlog Video Support
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'add_meta_box()' ফাংশন দিয়ে ওয়ার্ডপ্রেসের পোস্ট এডিটরে কাস্টম ইনপুট বক্স যোগ করা হয়।
 * - 'save_post' অ্যাকশন হুক দিয়ে ফর্ম সেভ হওয়ার সময় ইনপুট নেওয়া ডাটা ডাটাবেজের 'wp_postmeta' টেবিলে সেভ করা হয়।
 * - Security: সবসময় 'Nonce' ভেরিফাই করতে হবে এবং ডাটা 'sanitize' করে সেভ করতে হবে।
 * 
 * @package VlogPulse_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * পোস্ট এডিটরে মেটাবক্স রেজিস্টার করা
 */
function ahanaf_register_vlog_metabox() {
    add_meta_box(
        'ahanaf_vlog_settings',                                // মেটাবক্স আইডি
        __('🎥 Vlog Video Settings (ভ্লগ ভিডিও সেটিংস)', 'vlogpulse-core'), // মেটাবক্স টাইটেল
        'ahanaf_render_vlog_metabox',                          // কলব্যাক ফাংশন যা এইচটিএমএল রেন্ডার করবে
        'post',                                                // কোন পোস্ট টাইপে দেখাবে (এখানে standard 'post')
        'normal',                                              // পজিশন (normal / side / advanced)
        'high'                                                 // প্রায়োরিটি (high / default / low)
    );
}
add_action('add_meta_boxes', 'ahanaf_register_vlog_metabox');

/**
 * অ্যাডমিন প্যানেলে ইনপুট ফিল্ড প্রদর্শন করা
 */
function ahanaf_render_vlog_metabox($post) {
    // সিকিউরিটি ননস ফিল্ড তৈরি করা
    wp_nonce_field('ahanaf_save_vlog_meta', 'ahanaf_vlog_nonce');

    // ডাটাবেজ থেকে পূর্বে সেভ করা ভিডিও ইউআরএল ও ভিডিও টাইপ আনা
    $video_url = get_post_meta($post->ID, '_ahanaf_vlog_video_url', true);
    $is_vlog = get_post_meta($post->ID, '_ahanaf_is_vlog', true);
    ?>
    <div style="padding: 12px 0;">
        <p style="margin-bottom: 12px;">
            <label style="font-weight: 600; cursor: pointer;">
                <input type="checkbox" name="ahanaf_is_vlog" value="1" <?php checked($is_vlog, '1'); ?> />
                <?php esc_html_e('Mark this post as a Video Vlog (এই পোস্টটি কি একটি ভিডিও ভ্লগ?)', 'vlogpulse-core'); ?>
            </label>
        </p>

        <div style="margin-bottom: 8px;">
            <label for="ahanaf_vlog_video_url" style="display:block; font-weight: 600; margin-bottom: 6px;">
                <?php esc_html_e('Video URL (YouTube, Vimeo, or direct MP4 link):', 'vlogpulse-core'); ?>
            </label>
            <input type="url" 
                   id="ahanaf_vlog_video_url" 
                   name="ahanaf_vlog_video_url" 
                   value="<?php echo esc_attr($video_url); ?>" 
                   placeholder="https://www.youtube.com/watch?v=xxxx or https://vimeo.com/xxxx" 
                   style="width: 100%; max-width: 650px; padding: 8px; border-radius: 4px;" />
            <p class="description" style="color: #666; margin-top: 5px;">
                <?php esc_html_e('YouTube, Vimeo লিংক অথবা সরাসরি MP4 ফাইলের লিংক দিন। এটি পোস্ট ডিটেইলস পেজের শীর্ষে প্লেয়ার হিসেবে প্রদর্শিত হবে।', 'vlogpulse-core'); ?>
            </p>
        </div>
    </div>
    <?php
}

/**
 * পোস্ট সেভ হওয়ার সময় ডাটা ডাটাবেজে সংরক্ষণ করা
 */
function ahanaf_save_vlog_meta($post_id) {
    // ১. ননস ভেরিফিকেশন (Cross-Site Request Forgery প্রতিরোধ)
    if (!isset($_POST['ahanaf_vlog_nonce']) || !wp_verify_nonce($_POST['ahanaf_vlog_nonce'], 'ahanaf_save_vlog_meta')) {
        return;
    }

    // ২. অটো-সেভ হলে সেভ প্রসেস বন্ধ রাখা
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // ৩. ইউজারের পারমিশন চেক করা
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // ৪. ইজ ভ্লগ চেকবক্স আপডেট
    if (isset($_POST['ahanaf_is_vlog'])) {
        update_post_meta($post_id, '_ahanaf_is_vlog', '1');
    } else {
        delete_post_meta($post_id, '_ahanaf_is_vlog');
    }

    // ৫. ভিডিও ইউআরএল স্যানিটাইজ এবং সেভ করা
    if (isset($_POST['ahanaf_vlog_video_url'])) {
        $clean_url = esc_url_raw(trim($_POST['ahanaf_vlog_video_url']));
        if (!empty($clean_url)) {
            update_post_meta($post_id, '_ahanaf_vlog_video_url', $clean_url);
            // যদি ইউআরএল দেওয়া থাকে তাহলে স্বয়ংক্রিয়ভাবে is_vlog অন করে দেওয়া হবে
            update_post_meta($post_id, '_ahanaf_is_vlog', '1');
        } else {
            delete_post_meta($post_id, '_ahanaf_vlog_video_url');
        }
    }
}
add_action('save_post', 'ahanaf_save_vlog_meta');

/**
 * ফ্রন্টএন্ডের জন্য ভিডিও এম্বেড HTML জেনারেট করার ফাংশন
 */
if (!function_exists('ahanaf_get_vlog_player_html')) {
    function ahanaf_get_vlog_player_html($post_id = null) {
        if (!$post_id) {
            $post_id = get_the_ID();
        }

        $video_url = get_post_meta($post_id, '_ahanaf_vlog_video_url', true);
        if (empty($video_url)) {
            return '';
        }

        // ওয়ার্ডপ্রেসের ইনবিল্ট oEmbed দিয়ে স্বয়ংক্রিয়ভাবে ইউটিউব/ভিমিও আইফ্রেম তৈরি
        $embed_html = wp_oembed_get($video_url);

        if ($embed_html) {
            return '<div class="ahanaf-video-responsive">' . $embed_html . '</div>';
        }

        // যদি ডিরেক্ট MP4 ফাইল হয় তবে HTML5 ভিডিও প্লেয়ার
        if (preg_match('/\.(mp4|webm|ogg)$/i', $video_url)) {
            return '<div class="ahanaf-video-responsive">
                <video controls playsinline class="ahanaf-html5-video">
                    <source src="' . esc_url($video_url) . '" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>';
        }

        return '';
    }
}
