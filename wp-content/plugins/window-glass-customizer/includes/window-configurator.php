<?php
/**
 * Custom Window & Glass Configurator Backend Logic & WooCommerce Integration
 * 
 * @package VlogPulse_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Helper function to retrieve or auto-create the base "Custom Window" WooCommerce product
 */
function vlogpulse_get_or_create_custom_window_product_id() {
    $product_id = get_option('vlogpulse_custom_window_product_id');

    if ($product_id && get_post_status($product_id) === 'publish') {
        return (int)$product_id;
    }

    // Look for existing by title
    $existing = get_page_by_title('Custom Architectural Glass Window', OBJECT, 'product');
    if ($existing) {
        update_option('vlogpulse_custom_window_product_id', $existing->ID);
        return (int)$existing->ID;
    }

    // Auto-create product if WooCommerce is active
    if (class_exists('WC_Product_Simple')) {
        $product = new WC_Product_Simple();
        $product->set_name('Custom Architectural Glass Window');
        $product->set_regular_price('150.00');
        $product->set_description('Custom engineered architectural glass window with tailored frame material, glazing, custom dimensions, grid style, and hardware.');
        $product->set_short_description('Fully customized architectural glass window.');
        $product->set_status('publish');
        $product->set_catalog_visibility('hidden'); // Hide from general shop loop, only sold via Studio
        $product->set_virtual(false);
        $product->set_sold_individually(false);
        $id = $product->save();

        if ($id) {
            update_option('vlogpulse_custom_window_product_id', $id);
            return (int)$id;
        }
    }

    return 0;
}

/**
 * 1. AJAX Endpoint: Add Custom Window to WooCommerce Cart
 */
function vlogpulse_ajax_add_custom_window_to_cart() {
    check_ajax_referer('vlogpulse_window_nonce', 'security');

    if (!class_exists('WooCommerce') || !WC()->cart) {
        wp_send_json_error(array('message' => __('WooCommerce is not active.', 'vlogpulse-core')));
    }

    $product_id = vlogpulse_get_or_create_custom_window_product_id();
    if (!$product_id) {
        wp_send_json_error(array('message' => __('Could not locate base window product.', 'vlogpulse-core')));
    }

    // Sanitize user inputs
    $width         = isset($_POST['width']) ? floatval($_POST['width']) : 4.0;
    $height        = isset($_POST['height']) ? floatval($_POST['height']) : 5.0;
    $area_sqft     = isset($_POST['area_sqft']) ? floatval($_POST['area_sqft']) : ($width * $height);
    $frame_name    = isset($_POST['frame_name']) ? sanitize_text_field($_POST['frame_name']) : 'Obsidian Black';
    $frame_profile = isset($_POST['frame_profile']) ? sanitize_text_field($_POST['frame_profile']) : '2.5″ Standard Architectural';
    $glass_name    = isset($_POST['glass_name']) ? sanitize_text_field($_POST['glass_name']) : 'Crystal Clear Tempered';
    $grid_name     = isset($_POST['grid_name']) ? sanitize_text_field($_POST['grid_name']) : 'Single Pane';
    $handle_name   = isset($_POST['handle_name']) ? sanitize_text_field($_POST['handle_name']) : 'No Handle (Sliding)';
    $unit_price    = isset($_POST['calculated_price']) ? floatval($_POST['calculated_price']) : 250.00;
    $quantity      = isset($_POST['quantity']) ? max(1, (int)$_POST['quantity']) : 1;
    $svg_preview   = isset($_POST['svg_preview']) ? wp_kses_post($_POST['svg_preview']) : '';

    // Build custom cart item data
    $custom_data = array(
        'vlogpulse_custom_window' => array(
            'width'            => $width,
            'height'           => $height,
            'area_sqft'        => $area_sqft,
            'frame_name'       => $frame_name,
            'frame_profile'    => $frame_profile,
            'glass_name'       => $glass_name,
            'grid_name'        => $grid_name,
            'handle_name'      => $handle_name,
            'custom_price'     => $unit_price,
            'svg_preview'      => $svg_preview,
            'unique_key'       => md5($width . $height . $frame_name . $frame_profile . $glass_name . $grid_name . $handle_name . microtime()),
        )
    );

    $cart_item_key = WC()->cart->add_to_cart($product_id, $quantity, 0, array(), $custom_data);

    if ($cart_item_key) {
        wp_send_json_success(array(
            'message'      => __('Custom window successfully added to your cart!', 'window-glass-customizer'),
            'cart_url'     => wc_get_cart_url(),
            'checkout_url' => wc_get_checkout_url(),
            'cart_count'   => WC()->cart->get_cart_contents_count(),
        ));
    } else {
        wp_send_json_error(array('message' => __('Failed to add custom window to cart. Please try again.', 'window-glass-customizer')));
    }
}
add_action('wp_ajax_vlogpulse_add_custom_window_to_cart', 'vlogpulse_ajax_add_custom_window_to_cart');
add_action('wp_ajax_nopriv_vlogpulse_add_custom_window_to_cart', 'vlogpulse_ajax_add_custom_window_to_cart');

/**
 * 2. Custom Window Visual Thumbnail in Cart & Mini-Cart Tables
 */
function luxury_window_cart_item_thumbnail($thumbnail, $cart_item, $cart_item_key) {
    if (isset($cart_item['vlogpulse_custom_window']) && !empty($cart_item['vlogpulse_custom_window']['svg_preview'])) {
        $svg = $cart_item['vlogpulse_custom_window']['svg_preview'];
        return '<div class="custom-window-cart-thumb" style="width: 70px; height: 70px; border-radius: 8px; overflow: hidden; background: radial-gradient(circle, rgba(212,175,55,0.1) 0%, rgba(7,7,9,0.95) 100%); border: 1px solid #d4af37; display: flex; align-items: center; justify-content: center; padding: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.6);">' . $svg . '</div>';
    }
    return $thumbnail;
}
add_filter('woocommerce_cart_item_thumbnail', 'luxury_window_cart_item_thumbnail', 20, 3);

/**
 * 2. Override Cart Item Price with Dynamic Calculated Price
 */
function vlogpulse_set_custom_window_cart_price($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    if (empty($cart->get_cart())) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['vlogpulse_custom_window']) && !empty($cart_item['vlogpulse_custom_window']['custom_price'])) {
            $custom_price = floatval($cart_item['vlogpulse_custom_window']['custom_price']);
            $cart_item['data']->set_price($custom_price);
        }
    }
}
add_action('woocommerce_before_calculate_totals', 'vlogpulse_set_custom_window_cart_price', 20, 1);

/**
 * 3. Display Custom Window Specs in Cart & Checkout Tables
 */
function vlogpulse_display_custom_window_cart_meta($item_data, $cart_item) {
    if (isset($cart_item['vlogpulse_custom_window'])) {
        $meta = $cart_item['vlogpulse_custom_window'];

        $item_data[] = array(
            'key'   => __('Dimensions', 'window-glass-customizer'),
            'value' => esc_html($meta['width'] . ' ft (W) × ' . $meta['height'] . ' ft (H) — ' . $meta['area_sqft'] . ' sq.ft'),
        );
        $item_data[] = array(
            'key'   => __('Frame Finish', 'window-glass-customizer'),
            'value' => esc_html($meta['frame_name']),
        );
        if (!empty($meta['frame_profile'])) {
            $item_data[] = array(
                'key'   => __('Frame Size / Profile', 'window-glass-customizer'),
                'value' => esc_html($meta['frame_profile']),
            );
        }
        $item_data[] = array(
            'key'   => __('Glass Glazing', 'window-glass-customizer'),
            'value' => esc_html($meta['glass_name']),
        );
        $item_data[] = array(
            'key'   => __('Grid Style', 'window-glass-customizer'),
            'value' => esc_html($meta['grid_name']),
        );
        $item_data[] = array(
            'key'   => __('Hardware & Lock', 'window-glass-customizer'),
            'value' => esc_html($meta['handle_name']),
        );
    }
    return $item_data;
}
add_filter('woocommerce_get_item_data', 'vlogpulse_display_custom_window_cart_meta', 10, 2);

/**
 * 4. Save Custom Window Specs to WooCommerce Order Line Item Meta (Visible in Admin Orders)
 */
function vlogpulse_save_custom_window_order_item_meta($item, $cart_item_key, $values, $order) {
    if (isset($values['vlogpulse_custom_window'])) {
        $meta = $values['vlogpulse_custom_window'];

        $item->add_meta_data(__('Custom Dimensions', 'window-glass-customizer'), $meta['width'] . ' ft (W) × ' . $meta['height'] . ' ft (H) (' . $meta['area_sqft'] . ' sq.ft)');
        $item->add_meta_data(__('Frame Finish', 'window-glass-customizer'), $meta['frame_name']);
        if (!empty($meta['frame_profile'])) {
            $item->add_meta_data(__('Frame Size / Profile', 'window-glass-customizer'), $meta['frame_profile']);
        }
        $item->add_meta_data(__('Glass Glazing', 'window-glass-customizer'), $meta['glass_name']);
        $item->add_meta_data(__('Grid Pattern', 'window-glass-customizer'), $meta['grid_name']);
        $item->add_meta_data(__('Hardware', 'window-glass-customizer'), $meta['handle_name']);
        $item->add_meta_data(__('Unit Fabricated Price', 'window-glass-customizer'), '$' . number_format($meta['custom_price'], 2));
    }
}
add_action('woocommerce_checkout_create_order_line_item', 'vlogpulse_save_custom_window_order_item_meta', 10, 4);
