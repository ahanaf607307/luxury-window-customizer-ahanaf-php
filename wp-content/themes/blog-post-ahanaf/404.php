<?php
/**
 * The Template for displaying 404 pages (Not Found)
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container" style="max-width: 600px; margin: 6rem auto 8rem; text-align: center;">
        <div class="gold-text" style="font-size: 5.5rem; font-weight: 800; line-height: 1; margin-bottom: 1rem;">
            404
        </div>
        <h1 style="font-size: 1.8rem; margin-bottom: 1rem; color: #ffffff;">
            <?php esc_html_e('Oops! Page Not Found', 'blog-post-ahanaf'); ?>
        </h1>
        <p style="color: var(--color-text-muted); margin-bottom: 2rem;">
            <?php esc_html_e('The vlog or story you are looking for might have been removed, had its name changed, or is temporarily unavailable.', 'blog-post-ahanaf'); ?>
        </p>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">
            &larr; <?php esc_html_e('Back to Homepage', 'blog-post-ahanaf'); ?>
        </a>
    </div>
</main>

<?php
get_footer();
