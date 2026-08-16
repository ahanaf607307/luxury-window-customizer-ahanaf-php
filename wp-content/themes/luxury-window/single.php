<?php
/**
 * The Template for displaying all single posts (Vlogs & Blogs)
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'single.php' ফাইলে একক পোস্টের বিস্তারিত কনটেন্ট, ভিডিও প্লেয়ার এবং লাইক বাটন প্রদর্শিত হয়।
 * - 'the_content()' ফাংশন পোস্টের মূল কনটেন্ট রেন্ডার করে।
 * - 'comments_template()' দিয়ে কমেন্ট সেকশন লোড করা হয়।
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();

while (have_posts()) :
    the_post();

    $post_id    = get_the_ID();
    $is_vlog    = get_post_meta($post_id, '_ahanaf_is_vlog', true) === '1';
    $video_url  = get_post_meta($post_id, '_ahanaf_vlog_video_url', true);
    $categories = get_the_category();
    $video_html = ahanaf_get_vlog_player_html($post_id);
?>

<main id="primary" class="site-main">
    <article id="post-<?php the_ID(); ?>" <?php post_class('single-post-container'); ?>>

        <!-- Single Post Header -->
        <header class="single-header">
            <?php if (!empty($categories)) : ?>
                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="single-category-tag">
                    #<?php echo esc_html($categories[0]->name); ?>
                </a>
            <?php endif; ?>

            <h1 class="single-title"><?php the_title(); ?></h1>

            <div class="single-meta-bar">
                <div class="single-meta-author">
                    <?php echo get_avatar(get_the_author_meta('ID'), 36); ?>
                    <span><?php the_author_posts_link(); ?></span>
                </div>
                <span>•</span>
                <div>
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none" style="vertical-align: middle; margin-right: 4px;"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                    <?php echo esc_html(get_the_date('M j, Y')); ?>
                </div>
                <span>•</span>
                <div>
                    <svg viewBox="0 0 24 24" width="14" height="14" stroke="currentColor" stroke-width="2" fill="none" style="vertical-align: middle; margin-right: 4px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <?php echo esc_html(ahanaf_get_reading_time($post_id)); ?>
                </div>
            </div>
        </header>

        <!-- Media Display: Vlog Video Player or Featured Image -->
        <?php if (!empty($video_html)) : ?>
            <!-- Video Player Showcase -->
            <div class="single-media-wrapper">
                <?php echo $video_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            </div>
        <?php elseif (has_post_thumbnail()) : ?>
            <!-- Featured Image -->
            <div class="single-media-wrapper single-featured-image">
                <?php the_post_thumbnail('ahanaf-hero'); ?>
            </div>
        <?php endif; ?>

        <!-- Post Content Body -->
        <div class="single-content">
            <?php
            the_content();

            wp_link_pages(array(
                'before' => '<div class="page-links">' . esc_html__('Pages:', 'blog-post-ahanaf'),
                'after'  => '</div>',
            ));
            ?>
        </div>

        <!-- Interactive Engagement Action Bar (Like & Share) -->
        <div class="single-actions-bar">
            <div>
                <!-- Big AJAX Like Button -->
                <?php ahanaf_render_like_button($post_id, true); ?>
            </div>

            <!-- Share Buttons -->
            <div style="display: flex; align-items: center; gap: 0.8rem;">
                <span style="font-size: 0.88rem; color: var(--color-text-muted); font-weight: 500;">
                    <?php esc_html_e('Share:', 'blog-post-ahanaf'); ?>
                </span>
                <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_permalink()); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn btn-ghost" 
                   style="padding: 0.4rem 0.8rem; font-size: 0.85rem;"
                   title="<?php esc_attr_e('Share on Twitter/X', 'blog-post-ahanaf'); ?>">
                    𝕏 Post
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" 
                   target="_blank" 
                   rel="noopener noreferrer" 
                   class="btn btn-ghost" 
                   style="padding: 0.4rem 0.8rem; font-size: 0.85rem;"
                   title="<?php esc_attr_e('Share on Facebook', 'blog-post-ahanaf'); ?>">
                    f Share
                </a>
            </div>
        </div>

        <!-- Author Bio Box -->
        <div class="author-bio-card">
            <div class="author-bio-avatar">
                <?php echo get_avatar(get_the_author_meta('ID'), 72); ?>
            </div>
            <div class="author-bio-info">
                <h3><?php the_author(); ?></h3>
                <p>
                    <?php 
                    $author_desc = get_the_author_meta('description');
                    echo !empty($author_desc) ? esc_html($author_desc) : esc_html__('Author & Content Creator exploring interesting stories and sharing insights.', 'blog-post-ahanaf');
                    ?>
                </p>
            </div>
        </div>

        <!-- Comments Area -->
        <?php
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        ?>

    </article>
</main>

<?php
endwhile;

get_footer();
