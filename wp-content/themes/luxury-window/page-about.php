<?php
/**
 * Template Name: About Us (About Luxury Window)
 * 
 * The Template for displaying the About Us page for Luxury Window
 * 
 * @package Luxury_Window
 */

get_header();
?>

<main id="primary" class="site-main">
    
    <!-- Hero Showcase -->
    <section class="page-hero-section">
        <div class="container">
            <div class="hero-badge">
                <span>🏛️</span>
                <span><?php esc_html_e('The Story of Luxury Window', 'luxury-window'); ?></span>
            </div>
            <h1 class="page-hero-title">
                <?php esc_html_e('Precision Engineered', 'luxury-window'); ?> 
                <span class="gold-text"><?php esc_html_e('Glass & Window Systems', 'luxury-window'); ?></span>
            </h1>
            <p class="page-hero-desc">
                <?php esc_html_e('We craft bespoke architectural window systems, sliding glass facades, and precision aluminium frames engineered for high-end villas, luxury penthouses, and timeless architectural spaces.', 'luxury-window'); ?>
            </p>
        </div>
    </section>

    <div class="container">
        
        <!-- Mission & Values Grid -->
        <div class="about-grid">
            <div class="luxury-card">
                <div class="card-icon-wrap">🪟</div>
                <h3 style="margin-bottom: 0.8rem; font-size: 1.3rem;"><?php esc_html_e('Live Custom Configurator', 'luxury-window'); ?></h3>
                <p style="color: var(--color-text-muted); line-height: 1.7;">
                    <?php esc_html_e('Our proprietary Window Studio empowers architects and homeowners to custom-build windows with real-time visual 3D previews, exact dimensional controls, and live cost calculation.', 'luxury-window'); ?>
                </p>
            </div>

            <div class="luxury-card">
                <div class="card-icon-wrap">🛡️</div>
                <h3 style="margin-bottom: 0.8rem; font-size: 1.3rem;"><?php esc_html_e('Acoustic & Thermal Shields', 'luxury-window'); ?></h3>
                <p style="color: var(--color-text-muted); line-height: 1.7;">
                    <?php esc_html_e('Engineered with Low-E thermal coatings, argon-filled double glazing, and multi-chamber aluminium profiles to block 99% of outside noise and extreme solar heat.', 'luxury-window'); ?>
                </p>
            </div>

            <div class="luxury-card">
                <div class="card-icon-wrap">💎</div>
                <h3 style="margin-bottom: 0.8rem; font-size: 1.3rem;"><?php esc_html_e('Mastercrafted Finishes', 'luxury-window'); ?></h3>
                <p style="color: var(--color-text-muted); line-height: 1.7;">
                    <?php esc_html_e('From aerospace anodized champagne gold and stealth obsidian black to architectural bronze, every frame is treated for 30+ years of weather resistance.', 'luxury-window'); ?>
                </p>
            </div>
        </div>

        <!-- Stats Counter Bar -->
        <div class="stats-bar-grid">
            <div class="stat-item">
                <h3>15K+</h3>
                <p><?php esc_html_e('Sq.Ft Glazing Installed', 'luxury-window'); ?></p>
            </div>
            <div class="stat-item">
                <h3>500+</h3>
                <p><?php esc_html_e('Luxury Estates Transformed', 'luxury-window'); ?></p>
            </div>
            <div class="stat-item">
                <h3>25+</h3>
                <p><?php esc_html_e('Years Frame Warranty', 'luxury-window'); ?></p>
            </div>
            <div class="stat-item">
                <h3>100%</h3>
                <p><?php esc_html_e('Precision Engineered', 'luxury-window'); ?></p>
            </div>
        </div>

        <!-- Founder & Architectural Showcase -->
        <div class="luxury-card" style="margin-bottom: 5rem; display: flex; flex-wrap: wrap; gap: 2.5rem; align-items: center;">
            <div style="flex: 0 0 140px; text-align: center;">
                <div style="width: 130px; height: 130px; border-radius: 50%; border: 3px solid var(--color-gold); overflow: hidden; margin: 0 auto; box-shadow: 0 0 25px rgba(212,175,55,0.3);">
                    <?php echo get_avatar(1, 130); ?>
                </div>
            </div>
            <div style="flex: 1; min-width: 280px;">
                <span class="single-category-tag"><?php esc_html_e('Architectural Glazing Specialist & Founder', 'luxury-window'); ?></span>
                <h2 style="font-size: 1.8rem; margin-bottom: 0.6rem;"><?php esc_html_e('Ahanaf Mubasshir', 'luxury-window'); ?></h2>
                <p style="color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.2rem;">
                    <?php esc_html_e('Pioneering modern architectural glass systems and digital studio customization tools, transforming the way architects and luxury homeowners design custom fenestration.', 'luxury-window'); ?>
                </p>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="<?php echo esc_url(home_url('/window-studio')); ?>" class="btn btn-primary">
                        ✨ <?php esc_html_e('Launch Window Studio', 'luxury-window'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="btn btn-ghost">
                        <?php esc_html_e('Consult Our Specialists', 'luxury-window'); ?> &rarr;
                    </a>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
get_footer();

