<?php
/**
 * Template Name: User Dashboard (কাস্টমার ড্যাশবোর্ড)
 * 
 * Comprehensive Luxury Window Customer Dashboard:
 * - Overview stats (Orders count, Total spent, Liked blogs/vlogs)
 * - My Orders & Custom Window Architectural Projects
 * - My Liked Vlogs & Blog Articles
 * - Profile & Account Details
 * 
 * @package Luxury_Window
 */

get_header();

// 1. Ensure user is logged in
if (!is_user_logged_in()) {
    ?>
    <main id="primary" class="site-main luxury-dashboard-page">
        <div class="container" style="max-width: 800px; margin: 5rem auto 7rem; text-align: center;">
            <div class="dashboard-auth-gate glass-card" style="padding: 3.5rem 2rem; border-radius: 16px; background: rgba(18, 18, 22, 0.75); border: 1px solid rgba(212, 175, 55, 0.25); backdrop-filter: blur(16px); box-shadow: 0 16px 40px rgba(0,0,0,0.6);">
                <div style="font-size: 3rem; margin-bottom: 1rem;">🔒</div>
                <h2 style="font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 0.8rem;">
                    <?php esc_html_e('Member Access Required', 'luxury-window'); ?>
                </h2>
                <p style="color: #94a3b8; font-size: 1.05rem; max-width: 500px; margin: 0 auto 2rem; line-height: 1.6;">
                    <?php esc_html_e('Please sign in or create an account to view your custom window orders, liked architectural vlogs, and account settings.', 'luxury-window'); ?>
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <button type="button" class="btn btn-primary" data-open-modal="signin" style="padding: 0.8rem 2rem; font-weight: 700;">
                        <?php esc_html_e('Sign In to Dashboard', 'luxury-window'); ?>
                    </button>
                    <button type="button" class="btn btn-outline" data-open-modal="signup" style="padding: 0.8rem 2rem; font-weight: 600;">
                        <?php esc_html_e('Create Free Account', 'luxury-window'); ?>
                    </button>
                </div>
            </div>
        </div>
    </main>
    <?php
    get_footer();
    return;
}

$current_user = wp_get_current_user();
$user_id = $current_user->ID;

// 2. Fetch Customer WooCommerce Orders
$customer_orders = array();
$total_spent = 0;
$total_custom_windows = 0;

if (class_exists('WooCommerce')) {
    $customer_orders = wc_get_orders(array(
        'customer_id' => $user_id,
        'limit'       => -1,
        'orderby'     => 'date',
        'order'       => 'DESC',
    ));

    foreach ($customer_orders as $ord) {
        $total_spent += floatval($ord->get_total());
        foreach ($ord->get_items() as $item) {
            if ($item->get_meta('Custom Dimensions') || $item->get_meta('Frame Finish')) {
                $total_custom_windows += $item->get_quantity();
            }
        }
    }
}

// 3. Fetch User Liked Posts & Vlogs
$liked_posts_query = new WP_Query(array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => -1,
    'meta_query'     => array(
        array(
            'key'     => '_ahanaf_liked_users',
            'value'   => sprintf(':"%s";', $user_id),
            'compare' => 'LIKE',
        ),
    ),
));

// Fallback lookup if serialized array format differs
$liked_posts = array();
if ($liked_posts_query->have_posts()) {
    $liked_posts = $liked_posts_query->posts;
} else {
    // Secondary search: retrieve recent posts and filter by ahanaf_user_has_liked
    $all_posts = get_posts(array('posts_per_page' => 100, 'post_status' => 'publish'));
    foreach ($all_posts as $p) {
        if (function_exists('ahanaf_user_has_liked') && ahanaf_user_has_liked($p->ID, $user_id)) {
            $liked_posts[] = $p;
        }
    }
}
$liked_count = count($liked_posts);
?>

<main id="primary" class="site-main luxury-dashboard-page">
    <div class="container" style="max-width: 1240px; margin: 3rem auto 6rem; padding: 0 1.25rem;">
        
        <!-- DASHBOARD HEADER / PROFILE BANNER -->
        <div class="dashboard-user-header glass-card" style="display: flex; justify-content: space-between; align-items: center; padding: 2rem 2.5rem; border-radius: 16px; background: radial-gradient(circle at top right, rgba(212,175,55,0.12), rgba(12,12,15,0.95)); border: 1px solid rgba(212,175,55,0.25); box-shadow: 0 12px 36px rgba(0,0,0,0.5); margin-bottom: 2.5rem; flex-wrap: wrap; gap: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1.4rem;">
                <div class="dashboard-avatar-wrap" style="position: relative;">
                    <?php echo get_avatar($user_id, 80, '', '', array('class' => 'dashboard-avatar-img', 'style' => 'border-radius: 50%; border: 2.5px solid var(--color-gold); box-shadow: 0 0 18px rgba(212,175,55,0.3);')); ?>
                    <span style="position: absolute; bottom: 2px; right: 2px; width: 14px; height: 14px; background: #10b981; border: 2px solid #000; border-radius: 50%;"></span>
                </div>
                <div>
                    <div style="display: flex; align-items: center; gap: 0.6rem; margin-bottom: 0.2rem;">
                        <h1 style="font-size: 1.8rem; font-weight: 800; color: #fff; margin: 0;">
                            <?php echo esc_html($current_user->display_name); ?>
                        </h1>
                        <span class="user-tier-badge" style="font-size: 0.72rem; font-weight: 700; background: linear-gradient(135deg, #d4af37, #fef08a); color: #09090b; padding: 0.2rem 0.55rem; border-radius: 20px; text-transform: uppercase;">
                            <?php esc_html_e('VIP Client', 'luxury-window'); ?>
                        </span>
                    </div>
                    <p style="color: #94a3b8; font-size: 0.92rem; margin: 0;">
                        <span>✉️ <?php echo esc_html($current_user->user_email); ?></span> &nbsp;•&nbsp; 
                        <span>🗓️ <?php printf(esc_html__('Member since %s', 'luxury-window'), esc_html(date_i18n('M Y', strtotime($current_user->user_registered)))); ?></span>
                    </p>
                </div>
            </div>

            <div style="display: flex; gap: 0.8rem; align-items: center;">
                <a href="<?php echo esc_url(home_url('/window-studio')); ?>" class="btn btn-primary" style="font-size: 0.88rem; font-weight: 700; padding: 0.65rem 1.4rem;">
                    ✨ <?php esc_html_e('Custom Studio', 'luxury-window'); ?>
                </a>
                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="btn btn-outline" style="font-size: 0.88rem; padding: 0.65rem 1.2rem; border-color: rgba(239, 68, 68, 0.4); color: #f87171;">
                    🚪 <?php esc_html_e('Sign Out', 'luxury-window'); ?>
                </a>
            </div>
        </div>

        <!-- STATS OVERVIEW CARDS (4 Pillars) -->
        <div class="dashboard-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.25rem; margin-bottom: 2.5rem;">
            
            <!-- Stat 1: Total Orders -->
            <div class="stat-card glass-card" style="padding: 1.5rem; border-radius: 12px; background: rgba(20,20,26,0.6); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 1.2rem;">
                <div class="stat-icon-wrap" style="width: 52px; height: 52px; border-radius: 12px; background: rgba(56,189,248,0.12); color: #38bdf8; display: flex; align-items: center; justify-content: center; font-size: 1.6rem;">
                    📦
                </div>
                <div>
                    <span style="font-size: 0.82rem; color: #94a3b8; text-transform: uppercase; font-weight: 600;"><?php esc_html_e('Total Orders', 'luxury-window'); ?></span>
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0.2rem 0 0;"><?php echo count($customer_orders); ?></h3>
                </div>
            </div>

            <!-- Stat 2: Custom Windows Engineered -->
            <div class="stat-card glass-card" style="padding: 1.5rem; border-radius: 12px; background: rgba(20,20,26,0.6); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 1.2rem;">
                <div class="stat-icon-wrap" style="width: 52px; height: 52px; border-radius: 12px; background: rgba(212,175,55,0.12); color: #d4af37; display: flex; align-items: center; justify-content: center; font-size: 1.6rem;">
                    🪟
                </div>
                <div>
                    <span style="font-size: 0.82rem; color: #94a3b8; text-transform: uppercase; font-weight: 600;"><?php esc_html_e('Custom Windows', 'luxury-window'); ?></span>
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0.2rem 0 0;"><?php echo $total_custom_windows; ?></h3>
                </div>
            </div>

            <!-- Stat 3: Liked Blogs & Vlogs -->
            <div class="stat-card glass-card" style="padding: 1.5rem; border-radius: 12px; background: rgba(20,20,26,0.6); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 1.2rem;">
                <div class="stat-icon-wrap" style="width: 52px; height: 52px; border-radius: 12px; background: rgba(244,63,94,0.12); color: #f43f5e; display: flex; align-items: center; justify-content: center; font-size: 1.6rem;">
                    ❤️
                </div>
                <div>
                    <span style="font-size: 0.82rem; color: #94a3b8; text-transform: uppercase; font-weight: 600;"><?php esc_html_e('Liked Posts & Vlogs', 'luxury-window'); ?></span>
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0.2rem 0 0;"><?php echo $liked_count; ?></h3>
                </div>
            </div>

            <!-- Stat 4: Total Spent -->
            <div class="stat-card glass-card" style="padding: 1.5rem; border-radius: 12px; background: rgba(20,20,26,0.6); border: 1px solid rgba(255,255,255,0.08); display: flex; align-items: center; gap: 1.2rem;">
                <div class="stat-icon-wrap" style="width: 52px; height: 52px; border-radius: 12px; background: rgba(16,185,129,0.12); color: #10b981; display: flex; align-items: center; justify-content: center; font-size: 1.6rem;">
                    💳
                </div>
                <div>
                    <span style="font-size: 0.82rem; color: #94a3b8; text-transform: uppercase; font-weight: 600;"><?php esc_html_e('Total Invested', 'luxury-window'); ?></span>
                    <h3 style="font-size: 1.6rem; font-weight: 800; color: #fff; margin: 0.2rem 0 0;">$<?php echo number_format($total_spent, 2); ?></h3>
                </div>
            </div>

        </div>

        <!-- MAIN DASHBOARD CONTENT TABS -->
        <div class="dashboard-main-tabs-wrap">
            
            <!-- Tab Navigation Buttons -->
            <div class="dashboard-tab-nav" style="display: flex; gap: 0.75rem; border-bottom: 2px solid rgba(255,255,255,0.08); padding-bottom: 0.8rem; margin-bottom: 2rem; flex-wrap: wrap;">
                <button type="button" class="dash-tab-btn active" data-tab="orders" style="background: transparent; border: none; font-size: 1.05rem; font-weight: 700; color: #fff; padding: 0.6rem 1.4rem; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📦</span>
                    <span><?php esc_html_e('My Orders & Custom Projects', 'luxury-window'); ?></span>
                    <span style="font-size: 0.75rem; background: var(--color-gold); color: #000; padding: 0.15rem 0.5rem; border-radius: 12px; font-weight: 800;"><?php echo count($customer_orders); ?></span>
                </button>

                <button type="button" class="dash-tab-btn" data-tab="likes" style="background: transparent; border: none; font-size: 1.05rem; font-weight: 700; color: #94a3b8; padding: 0.6rem 1.4rem; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                    <span>❤️</span>
                    <span><?php esc_html_e('Liked Vlogs & Blogs', 'luxury-window'); ?></span>
                    <span style="font-size: 0.75rem; background: rgba(244,63,94,0.2); color: #f43f5e; padding: 0.15rem 0.5rem; border-radius: 12px; font-weight: 800;"><?php echo $liked_count; ?></span>
                </button>

                <button type="button" class="dash-tab-btn" data-tab="account" style="background: transparent; border: none; font-size: 1.05rem; font-weight: 700; color: #94a3b8; padding: 0.6rem 1.4rem; border-radius: 8px; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
                    <span>⚙️</span>
                    <span><?php esc_html_e('Account & Profile Details', 'luxury-window'); ?></span>
                </button>
            </div>

            <!-- TAB 1: ORDERS & CUSTOM WINDOW PROJECTS -->
            <div id="dash-tab-orders" class="dash-tab-content active-content">
                <?php if (!empty($customer_orders)) : ?>
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <?php foreach ($customer_orders as $order) : 
                            $order_id = $order->get_id();
                            $status = $order->get_status();
                            $date_created = $order->get_date_created() ? $order->get_date_created()->date_i18n('F j, Y, g:i a') : '';
                            $total = $order->get_formatted_order_total();
                            $items = $order->get_items();
                        ?>
                            <div class="order-card glass-card" style="padding: 1.75rem; border-radius: 14px; background: rgba(18,18,24,0.7); border: 1px solid rgba(255,255,255,0.08);">
                                <!-- Order Header -->
                                <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem;">
                                    <div>
                                        <div style="display: flex; align-items: center; gap: 0.8rem; margin-bottom: 0.3rem;">
                                            <h3 style="font-size: 1.2rem; font-weight: 800; color: #fff; margin: 0;">
                                                <?php printf(esc_html__('Order #%s', 'luxury-window'), esc_html($order->get_order_number())); ?>
                                            </h3>
                                            <span class="order-status-badge status-<?php echo esc_attr($status); ?>" style="font-size: 0.75rem; font-weight: 700; padding: 0.25rem 0.75rem; border-radius: 20px; text-transform: uppercase; background: <?php echo ($status === 'completed') ? 'rgba(16,185,129,0.15)' : 'rgba(212,175,55,0.15)'; ?>; color: <?php echo ($status === 'completed') ? '#10b981' : 'var(--color-gold)'; ?>; border: 1px solid currentColor;">
                                                <?php echo esc_html(wc_get_order_status_name($status)); ?>
                                            </span>
                                        </div>
                                        <p style="color: #94a3b8; font-size: 0.85rem; margin: 0;">
                                            <span>📅 <?php echo esc_html($date_created); ?></span> &nbsp;•&nbsp; 
                                            <span>💳 <?php echo esc_html($order->get_payment_method_title()); ?></span>
                                        </p>
                                    </div>
                                    <div style="text-align: right;">
                                        <span style="font-size: 0.8rem; color: #94a3b8; text-transform: uppercase;"><?php esc_html_e('Order Total', 'luxury-window'); ?></span>
                                        <div style="font-size: 1.4rem; font-weight: 800; color: var(--color-gold);"><?php echo wp_kses_post($total); ?></div>
                                    </div>
                                </div>

                                <!-- Order Line Items -->
                                <div class="order-items-list" style="display: flex; flex-direction: column; gap: 1rem;">
                                    <?php foreach ($items as $item_id => $item) : 
                                        $product = $item->get_product();
                                        $custom_dims    = $item->get_meta('Custom Dimensions') ?: $item->get_meta(__('Custom Dimensions', 'window-glass-customizer'));
                                        $frame_finish   = $item->get_meta('Frame Finish') ?: $item->get_meta(__('Frame Finish', 'window-glass-customizer'));
                                        $frame_profile  = $item->get_meta('Frame Size / Profile') ?: $item->get_meta(__('Frame Size / Profile', 'window-glass-customizer'));
                                        $glass_glazing  = $item->get_meta('Glass Glazing') ?: $item->get_meta(__('Glass Glazing', 'window-glass-customizer'));
                                        $grid_pattern   = $item->get_meta('Grid Pattern') ?: $item->get_meta(__('Grid Pattern', 'window-glass-customizer'));
                                        $hardware       = $item->get_meta('Hardware') ?: $item->get_meta(__('Hardware', 'window-glass-customizer'));
                                    ?>
                                        <div class="order-item-row" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(0,0,0,0.3); border-radius: 10px; border: 1px solid rgba(255,255,255,0.04); flex-wrap: wrap; gap: 1rem;">
                                            <div style="display: flex; align-items: center; gap: 1rem;">
                                                <div style="width: 52px; height: 52px; border-radius: 8px; overflow: hidden; background: radial-gradient(circle, rgba(212,175,55,0.1) 0%, rgba(7,7,9,0.95) 100%); border: 1px solid var(--color-gold); display: flex; align-items: center; justify-content: center; font-size: 1.5rem;">
                                                    🪟
                                                </div>
                                                <div>
                                                    <h4 style="font-size: 1rem; font-weight: 700; color: #fff; margin: 0 0 0.3rem;">
                                                        <?php echo esc_html($item->get_name()); ?> <span style="color: var(--color-gold); font-size: 0.88rem;">× <?php echo esc_html($item->get_quantity()); ?></span>
                                                    </h4>
                                                    
                                                    <!-- Custom Window Specs Pill Cloud -->
                                                    <?php if ($custom_dims || $frame_finish || $glass_glazing) : ?>
                                                        <div style="display: flex; flex-wrap: wrap; gap: 0.4rem; margin-top: 0.4rem;">
                                                            <?php if ($custom_dims) : ?>
                                                                <span style="font-size: 0.75rem; background: rgba(56,189,248,0.12); color: #38bdf8; padding: 0.15rem 0.5rem; border-radius: 4px; border: 1px solid rgba(56,189,248,0.3);">📐 <?php echo esc_html($custom_dims); ?></span>
                                                            <?php endif; ?>
                                                            <?php if ($frame_finish) : ?>
                                                                <span style="font-size: 0.75rem; background: rgba(212,175,55,0.12); color: var(--color-gold); padding: 0.15rem 0.5rem; border-radius: 4px; border: 1px solid rgba(212,175,55,0.3);">🎨 <?php echo esc_html($frame_finish); ?></span>
                                                            <?php endif; ?>
                                                            <?php if ($frame_profile) : ?>
                                                                <span style="font-size: 0.75rem; background: rgba(168,85,247,0.12); color: #c084fc; padding: 0.15rem 0.5rem; border-radius: 4px; border: 1px solid rgba(168,85,247,0.3);">📏 <?php echo esc_html($frame_profile); ?></span>
                                                            <?php endif; ?>
                                                            <?php if ($glass_glazing) : ?>
                                                                <span style="font-size: 0.75rem; background: rgba(16,185,129,0.12); color: #34d399; padding: 0.15rem 0.5rem; border-radius: 4px; border: 1px solid rgba(16,185,129,0.3);">💎 <?php echo esc_html($glass_glazing); ?></span>
                                                            <?php endif; ?>
                                                            <?php if ($grid_pattern) : ?>
                                                                <span style="font-size: 0.75rem; background: rgba(255,255,255,0.08); color: #e2e8f0; padding: 0.15rem 0.5rem; border-radius: 4px;">🏛️ <?php echo esc_html($grid_pattern); ?></span>
                                                            <?php endif; ?>
                                                            <?php if ($hardware) : ?>
                                                                <span style="font-size: 0.75rem; background: rgba(255,255,255,0.08); color: #e2e8f0; padding: 0.15rem 0.5rem; border-radius: 4px;">🚪 <?php echo esc_html($hardware); ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div style="font-size: 1.1rem; font-weight: 700; color: #fff;">
                                                $<?php echo number_format($order->get_line_total($item, true), 2); ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Action Footer -->
                                <div style="display: flex; justify-content: flex-end; gap: 0.8rem; margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.05);">
                                    <a href="<?php echo esc_url($order->get_view_order_url()); ?>" class="btn btn-outline" style="font-size: 0.82rem; padding: 0.45rem 1rem;">
                                        📄 <?php esc_html_e('View Order Details / Receipt', 'luxury-window'); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <!-- Empty Orders State -->
                    <div class="empty-state-box glass-card" style="padding: 3.5rem 2rem; border-radius: 14px; text-align: center; background: rgba(18,18,24,0.6); border: 1px dashed rgba(212,175,55,0.3);">
                        <div style="font-size: 3rem; margin-bottom: 0.8rem;">📦</div>
                        <h3 style="font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem;">
                            <?php esc_html_e('No Architectural Orders Yet', 'luxury-window'); ?>
                        </h3>
                        <p style="color: #94a3b8; font-size: 0.95rem; max-width: 460px; margin: 0 auto 1.5rem;">
                            <?php esc_html_e('Design your first bespoke architectural glass window or browse our curated catalog to get started.', 'luxury-window'); ?>
                        </p>
                        <a href="<?php echo esc_url(home_url('/window-studio')); ?>" class="btn btn-primary" style="padding: 0.75rem 1.8rem; font-weight: 700;">
                            ✨ <?php esc_html_e('Launch Window Studio Configurator', 'luxury-window'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- TAB 2: LIKED BLOGS & VLOGS -->
            <div id="dash-tab-likes" class="dash-tab-content" style="display: none;">
                <?php if (!empty($liked_posts)) : ?>
                    <div class="liked-posts-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem;">
                        <?php foreach ($liked_posts as $post) : setup_postdata($post); 
                            $post_id = $post->ID;
                            $thumb = get_the_post_thumbnail_url($post_id, 'medium_large') ?: get_template_directory_uri() . '/assets/images/default-thumbnail.jpg';
                            $likes = function_exists('ahanaf_get_post_likes') ? ahanaf_get_post_likes($post_id) : 0;
                            $categories = get_the_category($post_id);
                            $cat_name = !empty($categories) ? $categories[0]->name : 'Glazing Insight';
                        ?>
                            <article class="liked-card glass-card" style="border-radius: 12px; overflow: hidden; background: rgba(18,18,24,0.75); border: 1px solid rgba(255,255,255,0.08); transition: transform 0.25s ease, border-color 0.25s ease; display: flex; flex-direction: column;">
                                <div style="position: relative; height: 180px; overflow: hidden;">
                                    <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title($post_id)); ?>" style="width: 100%; height: 100%; object-fit: cover;" />
                                    <span style="position: absolute; top: 10px; left: 10px; background: rgba(0,0,0,0.75); backdrop-filter: blur(8px); color: var(--color-gold); font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 4px; border: 1px solid var(--color-gold);">
                                        <?php echo esc_html($cat_name); ?>
                                    </span>
                                    <span style="position: absolute; top: 10px; right: 10px; background: rgba(244,63,94,0.9); color: #fff; font-size: 0.75rem; font-weight: 700; padding: 0.2rem 0.55rem; border-radius: 20px; display: flex; align-items: center; gap: 0.3rem;">
                                        ❤️ <?php echo esc_html($likes); ?>
                                    </span>
                                </div>
                                
                                <div style="padding: 1.25rem; display: flex; flex-direction: column; flex-grow: 1; justify-content: space-between;">
                                    <div>
                                        <h4 style="font-size: 1.1rem; font-weight: 700; color: #fff; line-height: 1.4; margin: 0 0 0.6rem;">
                                            <a href="<?php echo esc_url(get_permalink($post_id)); ?>" style="color: inherit; text-decoration: none;">
                                                <?php echo esc_html(get_the_title($post_id)); ?>
                                            </a>
                                        </h4>
                                        <p style="color: #94a3b8; font-size: 0.88rem; line-height: 1.5; margin: 0 0 1rem;">
                                            <?php echo esc_html(wp_trim_words(get_the_excerpt($post_id), 14, '...')); ?>
                                        </p>
                                    </div>
                                    
                                    <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 0.8rem;">
                                        <span style="font-size: 0.8rem; color: #64748b;">🗓️ <?php echo esc_html(get_the_date('M j, Y', $post_id)); ?></span>
                                        <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="btn btn-outline" style="font-size: 0.78rem; padding: 0.35rem 0.8rem;">
                                            <?php esc_html_e('Read / Watch', 'luxury-window'); ?> →
                                        </a>
                                    </div>
                                </div>
                            </article>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </div>
                <?php else : ?>
                    <!-- Empty Liked State -->
                    <div class="empty-state-box glass-card" style="padding: 3.5rem 2rem; border-radius: 14px; text-align: center; background: rgba(18,18,24,0.6); border: 1px dashed rgba(244,63,94,0.3);">
                        <div style="font-size: 3rem; margin-bottom: 0.8rem;">❤️</div>
                        <h3 style="font-size: 1.4rem; font-weight: 700; color: #fff; margin-bottom: 0.5rem;">
                            <?php esc_html_e('No Liked Posts or Vlogs Yet', 'luxury-window'); ?>
                        </h3>
                        <p style="color: #94a3b8; font-size: 0.95rem; max-width: 460px; margin: 0 auto 1.5rem;">
                            <?php esc_html_e('Explore our architectural glass showcases, thermal engineering vlogs, and hit the heart icon on any post you love.', 'luxury-window'); ?>
                        </p>
                        <a href="<?php echo esc_url(home_url('/?is_vlog=1')); ?>" class="btn btn-primary" style="padding: 0.75rem 1.8rem; font-weight: 700;">
                            🎬 <?php esc_html_e('Explore Luxury Vlogs & Insights', 'luxury-window'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- TAB 3: ACCOUNT & PROFILE DETAILS -->
            <div id="dash-tab-account" class="dash-tab-content" style="display: none;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
                    
                    <!-- Profile Information Card -->
                    <div class="glass-card" style="padding: 2rem; border-radius: 14px; background: rgba(18,18,24,0.7); border: 1px solid rgba(255,255,255,0.08);">
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 1.2rem; border-bottom: 2px solid var(--color-gold); padding-bottom: 0.6rem;">
                            👤 <?php esc_html_e('Personal Information', 'luxury-window'); ?>
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                            <div>
                                <span style="font-size: 0.82rem; color: #94a3b8; text-transform: uppercase;"><?php esc_html_e('Full Display Name', 'luxury-window'); ?></span>
                                <p style="font-size: 1.05rem; font-weight: 700; color: #fff; margin: 0.1rem 0 0;"><?php echo esc_html($current_user->display_name); ?></p>
                            </div>
                            <div>
                                <span style="font-size: 0.82rem; color: #94a3b8; text-transform: uppercase;"><?php esc_html_e('Account Username', 'luxury-window'); ?></span>
                                <p style="font-size: 1.05rem; font-weight: 700; color: #fff; margin: 0.1rem 0 0;">@<?php echo esc_html($current_user->user_login); ?></p>
                            </div>
                            <div>
                                <span style="font-size: 0.82rem; color: #94a3b8; text-transform: uppercase;"><?php esc_html_e('Primary Email Address', 'luxury-window'); ?></span>
                                <p style="font-size: 1.05rem; font-weight: 700; color: #fff; margin: 0.1rem 0 0;"><?php echo esc_html($current_user->user_email); ?></p>
                            </div>
                            <div>
                                <span style="font-size: 0.82rem; color: #94a3b8; text-transform: uppercase;"><?php esc_html_e('Client Membership Role', 'luxury-window'); ?></span>
                                <p style="font-size: 1.05rem; font-weight: 700; color: var(--color-gold); margin: 0.1rem 0 0; text-transform: capitalize;"><?php echo esc_html(implode(', ', $current_user->roles)); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Concierge & Architectural Assistance Card -->
                    <div class="glass-card" style="padding: 2rem; border-radius: 14px; background: rgba(18,18,24,0.7); border: 1px solid rgba(255,255,255,0.08);">
                        <h3 style="font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 1.2rem; border-bottom: 2px solid #38bdf8; padding-bottom: 0.6rem;">
                            🏛️ <?php esc_html_e('Architectural Concierge Desk', 'luxury-window'); ?>
                        </h3>
                        <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem;">
                            <?php esc_html_e('Need custom structural calculations, onsite architectural glazing measurements, or crane installation logistics for your estate?', 'luxury-window'); ?>
                        </p>
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="btn btn-primary" style="text-align: center; font-weight: 700;">
                                💬 <?php esc_html_e('Request Private Consultation', 'luxury-window'); ?>
                            </a>
                            <a href="tel:+18005898794" class="btn btn-outline" style="text-align: center;">
                                📞 +1 (800) 589-8794
                            </a>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const tabBtns = document.querySelectorAll('.dash-tab-btn');
    const tabContents = document.querySelectorAll('.dash-tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.getAttribute('data-tab');

            tabBtns.forEach(b => {
                b.classList.remove('active');
                b.style.color = '#94a3b8';
            });
            tabContents.forEach(c => {
                c.style.display = 'none';
                c.classList.remove('active-content');
            });

            this.classList.add('active');
            this.style.color = '#fff';

            const activeContent = document.getElementById('dash-tab-' + target);
            if (activeContent) {
                activeContent.style.display = (target === 'account' || target === 'orders' || target === 'likes') ? 'block' : 'block';
                activeContent.classList.add('active-content');
            }
        });
    });
});
</script>

<?php
get_footer();
