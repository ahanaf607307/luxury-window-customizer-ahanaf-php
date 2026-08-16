<?php
/**
 * Template Name: About Us (আমাদের সম্পর্কে)
 * 
 * The Template for displaying the About Us page
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
                <span>👑</span>
                <span><?php esc_html_e('The Story of VlogPulse', 'blog-post-ahanaf'); ?></span>
            </div>
            <h1 class="page-hero-title">
                <?php esc_html_e('Empowering Storytellers &', 'blog-post-ahanaf'); ?> 
                <span class="gold-text"><?php esc_html_e('Visual Creators', 'blog-post-ahanaf'); ?></span>
            </h1>
            <p class="page-hero-desc">
                <?php esc_html_e('We craft high-quality cinematic video vlogs and in-depth tech articles to inspire, educate, and connect creative minds across the globe.', 'blog-post-ahanaf'); ?>
            </p>
        </div>
    </section>

    <div class="container">
        
        <!-- Mission & Values Grid -->
        <div class="about-grid">
            <div class="luxury-card">
                <div class="card-icon-wrap">🎥</div>
                <h3 style="margin-bottom: 0.8rem; font-size: 1.3rem;"><?php esc_html_e('Cinematic Storytelling', 'blog-post-ahanaf'); ?></h3>
                <p style="color: var(--color-text-muted); line-height: 1.7;">
                    <?php esc_html_e('We produce engaging visual vlogs capturing breathtaking travels, tech innovations, and lifestyle journeys with crystal clear presentation.', 'blog-post-ahanaf'); ?>
                </p>
            </div>

            <div class="luxury-card">
                <div class="card-icon-wrap">⚡</div>
                <h3 style="margin-bottom: 0.8rem; font-size: 1.3rem;"><?php esc_html_e('Interactive Engagement', 'blog-post-ahanaf'); ?></h3>
                <p style="color: var(--color-text-muted); line-height: 1.7;">
                    <?php esc_html_e('Experience real-time instant liking, seamless membership authentication, and direct discussion forums with creators.', 'blog-post-ahanaf'); ?>
                </p>
            </div>

            <div class="luxury-card">
                <div class="card-icon-wrap">💎</div>
                <h3 style="margin-bottom: 0.8rem; font-size: 1.3rem;"><?php esc_html_e('Premium Quality First', 'blog-post-ahanaf'); ?></h3>
                <p style="color: var(--color-text-muted); line-height: 1.7;">
                    <?php esc_html_e('Every vlog, article, and resource on VlogPulse is curated with luxury aesthetics, ultra-fast performance, and user convenience in mind.', 'blog-post-ahanaf'); ?>
                </p>
            </div>
        </div>

        <!-- Stats Counter Bar -->
        <div class="stats-bar-grid">
            <div class="stat-item">
                <h3>50K+</h3>
                <p><?php esc_html_e('Community Members', 'blog-post-ahanaf'); ?></p>
            </div>
            <div class="stat-item">
                <h3>250+</h3>
                <p><?php esc_html_e('High-Quality Vlogs', 'blog-post-ahanaf'); ?></p>
            </div>
            <div class="stat-item">
                <h3>1.2M</h3>
                <p><?php esc_html_e('Total Video Views', 'blog-post-ahanaf'); ?></p>
            </div>
            <div class="stat-item">
                <h3>100%</h3>
                <p><?php esc_html_e('Creator Owned & Loved', 'blog-post-ahanaf'); ?></p>
            </div>
        </div>

        <!-- Creator Showcase -->
        <div class="luxury-card" style="margin-bottom: 5rem; display: flex; flex-wrap: wrap; gap: 2.5rem; align-items: center;">
            <div style="flex: 0 0 140px; text-align: center;">
                <div style="width: 130px; height: 130px; border-radius: 50%; border: 3px solid var(--color-gold); overflow: hidden; margin: 0 auto; box-shadow: 0 0 25px rgba(212,175,55,0.3);">
                    <?php echo get_avatar(1, 130); ?>
                </div>
            </div>
            <div style="flex: 1; min-width: 280px;">
                <span class="single-category-tag"><?php esc_html_e('Lead Creator & Founder', 'blog-post-ahanaf'); ?></span>
                <h2 style="font-size: 1.8rem; margin-bottom: 0.6rem;"><?php esc_html_e('Ahanaf Mubasshir', 'blog-post-ahanaf'); ?></h2>
                <p style="color: var(--color-text-muted); line-height: 1.7; margin-bottom: 1.2rem;">
                    <?php esc_html_e('Tech enthusiast, visual storyteller, and full-stack WordPress developer passionate about delivering world-class web experiences and insightful visual content.', 'blog-post-ahanaf'); ?>
                </p>
                <a href="<?php echo esc_url(home_url('/contact-us')); ?>" class="btn btn-primary">
                    <?php esc_html_e('Get In Touch', 'blog-post-ahanaf'); ?> &rarr;
                </a>
            </div>
        </div>

    </div>
</main>

<?php
get_footer();
