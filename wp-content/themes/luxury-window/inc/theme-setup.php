<?php
/**
 * Theme Setup & Core Features
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'after_setup_theme' হুকের মাধ্যমে আমরা ওয়ার্ডপ্রেসের ডিফল্ট ফিচারগুলো (যেমন: থাম্বনেইল, টাইটেল ট্যাগ, নেভিগেশন মেনু) সক্রিয় করি।
 * - 'wp_head' ও 'wp_footer' এর মাধ্যমে ওয়ার্ডপ্রেস স্বয়ংক্রিয়ভাবে স্ক্রিপ্ট এবং মেটাডাটা হ্যান্ডেল করে।
 * 
 * @package Blog_Post_Ahanaf
 */

if (!defined('ABSPATH')) {
    exit; // সরাসরি ফাইল অ্যাক্সেস বন্ধ করা হলো (Security Best Practice)
}

function ahanaf_theme_setup() {
    // ১. টেক্সট ডোমেইন লোড করা (ট্রান্সলেশন এবং আন্তর্জাতিকীকরণের জন্য)
    load_theme_textdomain('blog-post-ahanaf', get_template_directory() . '/languages');

    // ২. ওয়ার্ডপ্রেস স্বয়ংক্রিয়ভাবে <title> ট্যাগ জেনারেট করবে
    add_theme_support('title-tag');

    // ৩. পোস্টে ফিচারড ইমেজ (Featured Image / Thumbnail) সাপোর্ট এনাবল করা
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(1200, 675, true); // ১৬:৯ অ্যাসপেক্ট রেশিওতে ক্রপ
    add_image_size('ahanaf-card', 600, 360, true);
    add_image_size('ahanaf-hero', 1400, 700, true);

    // ৪. কাস্টম লোগো সাপোর্ট
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // ৫. আধুনিক HTML5 মার্কআপ সাপোর্ট
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script'
    ));

    // ৬. নেভিগেশন মেনু রেজিস্ট্রেশন (Primary Header & Footer Menu)
    register_nav_menus(array(
        'primary' => __('Primary Navigation Menu', 'blog-post-ahanaf'),
        'footer'  => __('Footer Navigation Menu', 'blog-post-ahanaf'),
    ));

    // ৭. রেসপনসিভ এমবেড সাপোর্ট (ইউটিউব/ভিমিও ভিডিও স্বয়ংক্রিয়ভাবে রেসপন্সিভ হবে)
    add_theme_support('responsive-embeds');

    // ৮. WooCommerce ই-কমার্স সাপোর্ট ও প্রোডাক্ট গ্যালারি ফিচার এনাবল করা
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'ahanaf_theme_setup');

/**
 * এক্সার্পট (Excerpt) এর দৈর্ঘ্য নিয়ন্ত্রণ করা
 */
function ahanaf_custom_excerpt_length($length) {
    return 24; // কার্ডে ২৪টি শব্দ পর্যন্ত শো করবে
}
add_filter('excerpt_length', 'ahanaf_custom_excerpt_length', 999);

/**
 * এক্সার্পটের শেষে [...] এর বদলে সুন্দর '...' দেখানো
 */
function ahanaf_custom_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'ahanaf_custom_excerpt_more');

/**
 * আনুমানিক পড়ার সময় গণনা করার হেল্পার ফাংশন (Reading Time)
 */
function ahanaf_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // গড়ে মানুষ প্রতি মিনিটে ২০০ শব্দ পড়ে
    return max(1, $reading_time) . ' min read';
}
