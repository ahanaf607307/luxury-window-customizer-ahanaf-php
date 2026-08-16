<?php
/**
 * Theme Functions and Definitions
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'functions.php' হলো একটি ওয়ার্ডপ্রেস থিমের মেইন ইঞ্জিন।
 * - এখানে থিমের বিভিন্ন ফিচার, স্ক্রিপ্ট (CSS/JS) এবং কাস্টম ফাংশন লোড করা হয়।
 * - 'wp_enqueue_scripts' হুক দিয়ে নিরাপদভাবে CSS এবং JS ফাইল ইনজেক্ট করতে হয়।
 * - 'wp_localize_script' দিয়ে পিএইচপি থেকে জাভাস্ক্রিপ্টে AJAX URL এবং Security Nonce পাস করা হয়।
 * 
 * @package Blog_Post_Ahanaf
 */

if (!defined('ABSPATH')) {
    exit;
}

// ১. থিমের সেটআপ ও প্রেজেন্টেশন মডিউল লোড করা
require_once get_template_directory() . '/inc/theme-setup.php';

/**
 * CSS এবং JS স্ক্রিপ্ট এনকিউ (Enqueue) করা - শুধুমাত্র প্রেজেন্টেশন ও UI
 */
function ahanaf_theme_scripts() {
    // গুগল ফন্টস (Google Fonts: Inter & Outfit)
    wp_enqueue_style(
        'ahanaf-google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap',
        array(),
        null
    );

    // মেইন সিএসএস ফাইল
    wp_enqueue_style(
        'ahanaf-main-style',
        get_template_directory_uri() . '/assets/css/main.css',
        array(),
        '1.0.0'
    );

    // থিমের মূল style.css ফাইল
    wp_enqueue_style(
        'ahanaf-theme-style',
        get_stylesheet_uri(),
        array('ahanaf-main-style'),
        '1.0.0'
    );

    // ফ্রন্টএন্ড UI ও মেনু স্ক্রিপ্ট (মডাল ওপেন/ক্লোজ ও মোবাইল মেনু)
    wp_enqueue_script(
        'ahanaf-main-script',
        get_template_directory_uri() . '/assets/js/main.js',
        array(),
        '1.0.0',
        true
    );

    // থ্রেডেড কমেন্ট স্ক্রিপ্ট (ডিফল্ট ওয়ার্ডপ্রেস কমেন্ট রিপ্লাইয়ের জন্য)
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'ahanaf_theme_scripts');

/**
 * সেফ ফলব্যাক হেল্পার ফাংশন (Core Plugin ডিঅ্যাক্টিভ থাকলেও যেন থিমে Fatal Error না হয়)
 */
if (!function_exists('ahanaf_render_like_button')) {
    function ahanaf_render_like_button($post_id = null, $show_text = true) {
        // যদি Core Plugin এক্টিভ না থাকে, সাইলেন্টলি ফলব্যাক হবে
        return;
    }
}

if (!function_exists('ahanaf_get_vlog_player_html')) {
    function ahanaf_get_vlog_player_html($post_id = null) {
        // যদি Core Plugin এক্টিভ না থাকে, ফলব্যাক হিসেবে খালি স্ট্রিং রিটার্ন করবে
        return '';
    }
}

/**
 * উইজেট ও সাইডবার রেজিস্টার করা (ঐচ্ছিক)
 */
function ahanaf_widgets_init() {
    register_sidebar(array(
        'name'          => __('Sidebar Area', 'blog-post-ahanaf'),
        'id'            => 'sidebar-1',
        'description'   => __('Add widgets here to appear in your sidebar.', 'blog-post-ahanaf'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'ahanaf_widgets_init');

/**
 * WooCommerce AJAX Cart Fragments Refresh (লাইভ কার্ট কাউন্ট আপডেট)
 */
function ahanaf_woocommerce_cart_fragments($fragments) {
    if (class_exists('WooCommerce') && WC()->cart) {
        ob_start();
        ?>
        <span class="cart-count-badge"><?php echo esc_html(WC()->cart->get_cart_contents_count()); ?></span>
        <?php
        $fragments['span.cart-count-badge'] = ob_get_clean();
    }
    return $fragments;
}
add_filter('woocommerce_add_to_cart_fragments', 'ahanaf_woocommerce_cart_fragments');

/**
 * লোকাল ডেভেলপমেন্টে WordPress.org থেকে প্লাগিন/থিম লোড ও ডাউনলোডের cURL অপ্টিমাইজেশন
 */
add_filter('http_request_args', function ($args, $url) {
    $args['sslverify'] = false;
    
    // প্লাগিন/থিম জিপ ফাইল ডাউনলোডের সময় পর্যাপ্ত সময় (৩০০ সেকেন্ড) দেওয়া যাতে cURL Error 28 না হয়
    if (!empty($args['stream']) || strpos($url, '.zip') !== false || strpos($url, 'downloads.wordpress.org') !== false) {
        $args['timeout'] = 300;
    } else {
        $args['timeout'] = 15;
    }
    
    return $args;
}, 10, 2);

// উইন্ডোজ লোকালহোস্টে IPv6 রেজোলিউশন জনিত স্লোনেস ও হ্যাং বন্ধ করতে IPv4 ফোর্স করা
add_action('http_api_curl', function ($handle) {
    if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
        curl_setopt($handle, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    }
});

