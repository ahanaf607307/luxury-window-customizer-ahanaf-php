<?php
/**
 * The Header for the Theme
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'wp_head()' কল করা অপরিহার্য; এটি ওয়ার্ডপ্রেসের সকল এনকিউ করা সিএসএস, জেএস এবং প্লাগিন মেটাডাটা হেড সেকশনে যুক্ত করে।
 * - 'body_class()' ট্যাগে বিভিন্ন দরকারী সিএসএস ক্লাস যুক্ত করে (যেমন: logged-in, single-post ইত্যাদি)।
 * - 'wp_nav_menu()' দিয়ে ওয়ার্ডপ্রেস ড্যাশবোর্ডের Appearance > Menus এর মেনু রেন্ডার করা হয়।
 * 
 * @package Blog_Post_Ahanaf
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">
    <div class="container">
        <div class="header-inner">
            
            <!-- Site Logo / Branding -->
            <div class="site-branding">
                <?php if (has_custom_logo()) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                        <span class="logo-icon">
                            <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="3" x2="12" y2="21"></line>
                                <line x1="3" y1="12" x2="21" y2="12"></line>
                            </svg>
                        </span>
                        <span class="logo-text">Luxury <span>Window</span></span>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Main Navigation Menu (Centered Floating Glass Pill) -->
            <nav class="main-nav" aria-label="<?php esc_attr_e('Main Navigation', 'luxury-window'); ?>">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class'     => 'nav-menu',
                        'container'      => false,
                        'depth'          => 2,
                        'fallback_cb'    => false,
                    ));
                } else {
                    $is_shop_active = function_exists('is_shop') && is_shop();
                    $shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/shop');
                    echo '<ul class="nav-menu">';
                    echo '<li class="' . (is_front_page() && !isset($_GET['is_vlog']) ? 'current-menu-item' : '') . '"><a href="' . esc_url(home_url('/')) . '">' . esc_html__('Home', 'luxury-window') . '</a></li>';
                    echo '<li class="studio-pill ' . (is_page('window-studio') ? 'current-menu-item' : '') . '"><a href="' . esc_url(home_url('/window-studio')) . '">✨ ' . esc_html__('Window Studio', 'luxury-window') . '</a></li>';
                    echo '<li class="' . ($is_shop_active ? 'current-menu-item' : '') . '"><a href="' . esc_url($shop_url) . '">' . esc_html__('Shop', 'luxury-window') . '</a></li>';
                    echo '<li class="' . (isset($_GET['is_vlog']) ? 'current-menu-item' : '') . '"><a href="' . esc_url(home_url('/?is_vlog=1')) . '">' . esc_html__('Vlogs', 'luxury-window') . '</a></li>';
                    echo '<li class="' . (is_page('about-us') ? 'current-menu-item' : '') . '"><a href="' . esc_url(home_url('/about-us')) . '">' . esc_html__('About Us', 'luxury-window') . '</a></li>';
                    echo '<li class="' . (is_page('contact-us') ? 'current-menu-item' : '') . '"><a href="' . esc_url(home_url('/contact-us')) . '">' . esc_html__('Contact Us', 'luxury-window') . '</a></li>';
                    echo '</ul>';
                }
                ?>
            </nav>

            <!-- Header Actions: Search Icon Trigger, Mini-Cart & User Profile -->
            <div class="header-actions">
                
                <!-- Quick Search Modal / Dropdown Toggle Button -->
                <button type="button" class="header-icon-btn search-toggle-btn" id="headerSearchToggle" title="<?php esc_attr_e('Search', 'luxury-window'); ?>" aria-label="<?php esc_attr_e('Open Search', 'luxury-window'); ?>">
                    <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <!-- WooCommerce Header Mini-Cart Button -->
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="header-cart-btn" title="<?php esc_attr_e('View Cart', 'luxury-window'); ?>">
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2.2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        <span class="cart-count-badge"><?php echo (WC()->cart) ? esc_html(WC()->cart->get_cart_contents_count()) : '0'; ?></span>
                    </a>
                <?php endif; ?>

                <!-- Authentication Buttons or User Dropdown -->
                <div class="auth-buttons">
                    <?php if (is_user_logged_in()) : 
                        $current_user = wp_get_current_user();
                    ?>
                        <!-- Logged In User Dropdown -->
                        <div class="user-menu-dropdown">
                            <button type="button" class="user-badge-btn" aria-haspopup="true">
                                <?php echo get_avatar($current_user->ID, 30, '', '', array('class' => 'user-avatar-img')); ?>
                                <span class="user-display-name"><?php echo esc_html($current_user->display_name); ?></span>
                                <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none">
                                    <polyline points="6 9 12 15 18 9"></polyline>
                                </svg>
                            </button>
                            <div class="dropdown-menu">
                                <?php if (current_user_can('edit_posts')) : ?>
                                    <a href="<?php echo esc_url(admin_url()); ?>" target="_blank">
                                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                                        <?php esc_html_e('WP Admin / Dashboard', 'luxury-window'); ?>
                                    </a>
                                    <a href="<?php echo esc_url(home_url('/create-post')); ?>">
                                        <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        <?php esc_html_e('Create Vlog / Post', 'luxury-window'); ?>
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo esc_url(admin_url('profile.php')); ?>">
                                    <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <?php esc_html_e('My Profile', 'luxury-window'); ?>
                                </a>
                                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="logout-link">
                                    <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    <?php esc_html_e('Sign Out', 'luxury-window'); ?>
                                </a>
                            </div>
                        </div>
                    <?php else : ?>
                        <!-- Guest User Action Buttons -->
                        <button type="button" class="btn btn-ghost header-signin-btn" data-open-modal="signin">
                            <?php esc_html_e('Sign In', 'luxury-window'); ?>
                        </button>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button type="button" class="mobile-toggle" aria-label="<?php esc_attr_e('Toggle Menu', 'luxury-window'); ?>">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>

            </div>
        </div>
    </div>

    <!-- Floating Quick Search Bar Dropdown -->
    <div id="headerSearchDropdown" class="header-search-dropdown-bar">
        <div class="container" style="max-width: 800px;">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>" class="search-dropdown-form">
                <span class="dropdown-search-icon">
                    <svg viewBox="0 0 24 24" width="20" height="20" stroke="currentColor" stroke-width="2" fill="none">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </span>
                <input type="search" id="headerSearchInput" placeholder="<?php esc_attr_e('Search products, windows, glazing, articles...', 'luxury-window'); ?>" value="<?php echo get_search_query(); ?>" name="s" autocomplete="off" />
                <button type="button" id="closeSearchDropdownBtn" class="close-search-btn" title="<?php esc_attr_e('Close Search', 'luxury-window'); ?>">✕</button>
            </form>
        </div>
    </div>
</header>
