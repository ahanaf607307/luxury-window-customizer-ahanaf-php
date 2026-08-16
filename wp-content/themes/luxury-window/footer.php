<?php
/**
 * The Footer for the Theme
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'wp_footer()' কল করা অপরিহার্য; এটি ওয়ার্ডপ্রেসের সকল জাভাস্ক্রিপ্ট ফাইল এবং অ্যাডমিন বার লোড করে।
 * - সাইন ইন এবং সাইন আপ এর পপআপ মডাল এখানে একবার রেন্ডার করা হয়েছে যাতে পুরো সাইটের যেকোনো পেজ থেকে এক্সেস করা যায়।
 * 
 * @package Blog_Post_Ahanaf
 */
?>

<footer class="site-footer">
    <div class="container">
        <div class="footer-top-grid">
            
            <!-- Column 1: Brand & About -->
            <div class="footer-brand">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
                    <span class="logo-icon">
                        <svg viewBox="0 0 24 24" width="22" height="22" stroke="currentColor" stroke-width="2.2" fill="none">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="12" y1="3" x2="12" y2="21"></line>
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                        </svg>
                    </span>
                    <span class="logo-text">Luxury <span>Window</span></span>
                </a>
                <p>
                    <?php esc_html_e('Engineered luxury architectural glass, bespoke sliding windows, and high-performance acoustic glazing tailored for modern residences and commercial projects.', 'luxury-window'); ?>
                </p>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="footer-col">
                <h4 class="footer-widget-title"><?php esc_html_e('Explore', 'blog-post-ahanaf'); ?></h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'blog-post-ahanaf'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/window-studio')); ?>" style="color: var(--color-gold);">✨ <?php esc_html_e('Custom Window Studio', 'blog-post-ahanaf'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/?is_vlog=1')); ?>"><?php esc_html_e('Featured Vlogs', 'blog-post-ahanaf'); ?></a></li>
                    <li><a href="<?php echo function_exists('wc_get_page_permalink') ? esc_url(wc_get_page_permalink('shop')) : esc_url(home_url('/shop')); ?>"><?php esc_html_e('Shop & Merch', 'blog-post-ahanaf'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/about-us')); ?>"><?php esc_html_e('About Us', 'blog-post-ahanaf'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact-us')); ?>"><?php esc_html_e('Contact Us', 'blog-post-ahanaf'); ?></a></li>
                    <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>"><?php esc_html_e('Privacy Policy', 'blog-post-ahanaf'); ?></a></li>
                </ul>
            </div>

            <!-- Column 3: Membership & Categories -->
            <div class="footer-col">
                <h4 class="footer-widget-title"><?php esc_html_e('Categories', 'blog-post-ahanaf'); ?></h4>
                <ul class="footer-links">
                    <?php
                    $categories = get_categories(array('number' => 5));
                    foreach ($categories as $category) {
                        echo '<li><a href="' . esc_url(get_category_link($category->term_id)) . '">' . esc_html($category->name) . ' (' . esc_html($category->count) . ')</a></li>';
                    }
                    ?>
                    <?php if (!is_user_logged_in()) : ?>
                        <li style="margin-top: 0.5rem;"><a href="#" data-open-modal="signin" style="color: var(--color-gold);">✨ <?php esc_html_e('Member Sign In', 'blog-post-ahanaf'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>

        </div>

        <!-- Footer Bottom Copyright -->
        <div class="footer-bottom">
            <p>
                &copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. <?php esc_html_e('Crafted with ❤️ for creators and storytellers.', 'blog-post-ahanaf'); ?>
            </p>
        </div>
    </div>
</footer>

<!-- =========================================================================
     Authentication Modal (Sign In / Sign Up Popups)
     ========================================================================= -->
<?php if (!is_user_logged_in()) : ?>
<div id="ahanaf-auth-modal" class="ahanaf-modal" role="dialog" aria-modal="true">
    <div class="modal-card">
        
        <!-- Close Button -->
        <button type="button" class="modal-close-btn" aria-label="<?php esc_attr_e('Close Modal', 'blog-post-ahanaf'); ?>">
            <svg viewBox="0 0 24 24" width="18" height="18" stroke="currentColor" stroke-width="2" fill="none"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>

        <!-- Modal Tabs -->
        <div class="modal-tabs">
            <button type="button" class="modal-tab-btn active" data-tab="signin">
                <?php esc_html_e('Sign In', 'blog-post-ahanaf'); ?>
            </button>
            <button type="button" class="modal-tab-btn" data-tab="signup">
                <?php esc_html_e('Sign Up', 'blog-post-ahanaf'); ?>
            </button>
        </div>

        <div class="modal-content-body">
            
            <!-- 1. Sign In Form -->
            <div id="ahanaf-signin-form-wrap">
                <form id="ahanaf-ajax-signin-form">
                    <div class="auth-feedback-msg"></div>

                    <div class="auth-form-group">
                        <label for="signin-username"><?php esc_html_e('Username or Email', 'blog-post-ahanaf'); ?> *</label>
                        <input type="text" id="signin-username" name="log" placeholder="your_username" required autocomplete="username" />
                    </div>

                    <div class="auth-form-group">
                        <label for="signin-password"><?php esc_html_e('Password', 'blog-post-ahanaf'); ?> *</label>
                        <input type="password" id="signin-password" name="pwd" placeholder="••••••••" required autocomplete="current-password" />
                    </div>

                    <div class="auth-form-group" style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.5rem;">
                        <input type="checkbox" id="signin-remember" name="rememberme" value="true" style="width: auto; cursor: pointer;" />
                        <label for="signin-remember" style="margin-bottom: 0; cursor: pointer; font-size: 0.85rem; font-weight: normal; color: var(--color-text-muted);">
                            <?php esc_html_e('Remember me', 'blog-post-ahanaf'); ?>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary auth-submit-btn">
                        <?php esc_html_e('Sign In Now', 'blog-post-ahanaf'); ?>
                    </button>
                </form>
            </div>

            <!-- 2. Sign Up Form -->
            <div id="ahanaf-signup-form-wrap" style="display: none;">
                <form id="ahanaf-ajax-signup-form">
                    <div class="auth-feedback-msg"></div>

                    <div class="auth-form-group">
                        <label for="signup-fullname"><?php esc_html_e('Full Name', 'blog-post-ahanaf'); ?></label>
                        <input type="text" id="signup-fullname" name="fullname" placeholder="Ahanaf Mubasshir" />
                    </div>

                    <div class="auth-form-group">
                        <label for="signup-username"><?php esc_html_e('Username', 'blog-post-ahanaf'); ?> *</label>
                        <input type="text" id="signup-username" name="username" placeholder="ahanaf99" required autocomplete="username" />
                    </div>

                    <div class="auth-form-group">
                        <label for="signup-email"><?php esc_html_e('Email Address', 'blog-post-ahanaf'); ?> *</label>
                        <input type="email" id="signup-email" name="email" placeholder="hello@example.com" required autocomplete="email" />
                    </div>

                    <div class="auth-form-group">
                        <label for="signup-password"><?php esc_html_e('Password (Min 6 chars)', 'blog-post-ahanaf'); ?> *</label>
                        <input type="password" id="signup-password" name="password" placeholder="••••••••" required autocomplete="new-password" minlength="6" />
                    </div>

                    <button type="submit" class="btn btn-primary auth-submit-btn">
                        <?php esc_html_e('Create Account', 'blog-post-ahanaf'); ?>
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
<?php endif; ?>

<!-- Global Toast Container -->
<div class="toast-container"></div>

<?php wp_footer(); ?>
</body>
</html>
