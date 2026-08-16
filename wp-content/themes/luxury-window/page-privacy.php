<?php
/**
 * Template Name: Privacy Policy (গোপনীয়তা নীতি)
 * 
 * The Template for displaying the Privacy Policy page
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <!-- Hero Showcase -->
    <section class="page-hero-section">
        <div class="container">
            <div class="hero-badge">
                <span>🛡️</span>
                <span><?php esc_html_e('Your Privacy Matters', 'blog-post-ahanaf'); ?></span>
            </div>
            <h1 class="page-hero-title">
                <?php esc_html_e('Privacy &', 'blog-post-ahanaf'); ?> 
                <span class="gold-text"><?php esc_html_e('Security Policy', 'blog-post-ahanaf'); ?></span>
            </h1>
            <p class="page-hero-desc">
                <?php esc_html_e('Last updated: August 2026. Learn how VlogPulse protects your data and respects your privacy.', 'blog-post-ahanaf'); ?>
            </p>
        </div>
    </section>

    <div class="container privacy-container">
        
        <div class="privacy-card">
            <h2>
                <span>📌</span>
                <span><?php esc_html_e('1. Information We Collect', 'blog-post-ahanaf'); ?></span>
            </h2>
            <p>
                <?php esc_html_e('When you create an account, leave comments, or like posts on VlogPulse, we collect the basic information you provide: your username, email address, display name, and avatar preference.', 'blog-post-ahanaf'); ?>
            </p>
            <p>
                <?php esc_html_e('We do not sell, rent, or share your personal data with third-party advertisers. All passwords are encrypted with industry-standard cryptographic hashing.', 'blog-post-ahanaf'); ?>
            </p>
        </div>

        <div class="privacy-card">
            <h2>
                <span>🍪</span>
                <span><?php esc_html_e('2. Cookies & Session Storage', 'blog-post-ahanaf'); ?></span>
            </h2>
            <p>
                <?php esc_html_e('We use lightweight essential cookies to keep you signed in seamlessly and remember your post likes. No intrusive third-party cross-site trackers are used.', 'blog-post-ahanaf'); ?>
            </p>
            <ul>
                <li><strong>Authentication Cookies:</strong> Keep your session active across tabs.</li>
                <li><strong>Preference Cookies:</strong> Remember your theme and video volume settings.</li>
            </ul>
        </div>

        <div class="privacy-card">
            <h2>
                <span>🎥</span>
                <span><?php esc_html_e('3. Video Content & Embedded Media', 'blog-post-ahanaf'); ?></span>
            </h2>
            <p>
                <?php esc_html_e('Articles and vlogs on this site may include embedded content (e.g. YouTube, Vimeo videos). Embedded content from other websites behaves in the exact same way as if the visitor has visited the other website.', 'blog-post-ahanaf'); ?>
            </p>
        </div>

        <div class="privacy-card">
            <h2>
                <span>⚖️</span>
                <span><?php esc_html_e('4. Your Data Rights', 'blog-post-ahanaf'); ?></span>
            </h2>
            <p>
                <?php esc_html_e('If you have an account on this site, you can request an exported file of the personal data we hold about you, or request that we erase any personal data we hold about you by contacting us.', 'blog-post-ahanaf'); ?>
            </p>
            <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="btn btn-ghost" style="margin-top: 0.5rem;">
                <?php esc_html_e('Contact Data Protection Team', 'blog-post-ahanaf'); ?> &rarr;
            </a>
        </div>

    </div>
</main>

<?php
get_footer();
