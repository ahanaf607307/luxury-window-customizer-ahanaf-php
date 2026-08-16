<?php
/**
 * Frontend Post & Vlog Submission AJAX Handler
 * 
 * @package VlogPulse_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * AJAX handler for submitting posts / vlogs from the frontend creator form
 */
function vlogpulse_handle_frontend_post_submission() {
    // 1. Check Nonce
    check_ajax_referer('vlogpulse_post_nonce', 'security');

    // 2. Permission Check
    if (!is_user_logged_in() || !current_user_can('edit_posts')) {
        wp_send_json_error(array(
            'message' => __('You do not have permission to publish posts.', 'vlogpulse-core')
        ));
    }

    // 3. Extract & Sanitize Data
    $title    = isset($_POST['post_title']) ? sanitize_text_field(trim($_POST['post_title'])) : '';
    $content  = isset($_POST['post_content']) ? wp_kses_post(trim($_POST['post_content'])) : '';
    $category = isset($_POST['post_category']) ? (int)$_POST['post_category'] : 0;
    $is_vlog  = isset($_POST['is_vlog']) && $_POST['is_vlog'] === '1' ? '1' : '0';
    $video_url = isset($_POST['vlog_video_url']) ? esc_url_raw(trim($_POST['vlog_video_url'])) : '';

    if (empty($title)) {
        wp_send_json_error(array('message' => __('Please provide a post title.', 'vlogpulse-core')));
    }

    if (empty($content)) {
        wp_send_json_error(array('message' => __('Please write your post content or description.', 'vlogpulse-core')));
    }

    if ($is_vlog === '1' && empty($video_url)) {
        wp_send_json_error(array('message' => __('Please provide a video URL for this vlog.', 'vlogpulse-core')));
    }

    // 4. Create Post
    $current_user_id = get_current_user_id();
    $post_data = array(
        'post_title'    => $title,
        'post_content'  => $content,
        'post_status'   => 'publish',
        'post_author'   => $current_user_id,
        'post_type'     => 'post',
    );

    if ($category > 0) {
        $post_data['post_category'] = array($category);
    }

    $post_id = wp_insert_post($post_data);

    if (is_wp_error($post_id) || !$post_id) {
        wp_send_json_error(array('message' => __('Failed to publish post. Please try again.', 'vlogpulse-core')));
    }

    // 5. Save Vlog Meta
    update_post_meta($post_id, '_ahanaf_is_vlog', $is_vlog);
    if (!empty($video_url)) {
        update_post_meta($post_id, '_ahanaf_vlog_video_url', $video_url);
    }

    // 6. Handle Featured Image Upload
    if (!empty($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';

        $attachment_id = media_handle_upload('thumbnail', $post_id);

        if (!is_wp_error($attachment_id)) {
            set_post_thumbnail($post_id, $attachment_id);
        }
    }

    // 7. Return Success
    wp_send_json_success(array(
        'message'  => $is_vlog === '1' ? __('Vlog published successfully!', 'vlogpulse-core') : __('Blog post published successfully!', 'vlogpulse-core'),
        'redirect' => get_permalink($post_id)
    ));
}
add_action('wp_ajax_vlogpulse_submit_post', 'vlogpulse_handle_frontend_post_submission');
