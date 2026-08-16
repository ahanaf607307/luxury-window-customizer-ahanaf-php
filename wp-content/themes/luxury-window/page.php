<?php
/**
 * The Template for displaying all static pages
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();

while (have_posts()) :
    the_post();
?>

<main id="primary" class="site-main">
    <div class="container" style="max-width: 860px; margin: 3.5rem auto 5rem;">
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            
            <header class="page-header" style="margin-bottom: 2.5rem; text-align: center;">
                <h1 class="page-title" style="font-size: clamp(2rem, 4vw, 3rem); font-weight: 800;"><?php the_title(); ?></h1>
            </header>

            <?php if (has_post_thumbnail()) : ?>
                <div class="single-media-wrapper" style="margin-bottom: 2.5rem;">
                    <?php the_post_thumbnail('ahanaf-hero'); ?>
                </div>
            <?php endif; ?>

            <div class="single-content">
                <?php
                the_content();

                wp_link_pages(array(
                    'before' => '<div class="page-links">' . esc_html__('Pages:', 'blog-post-ahanaf'),
                    'after'  => '</div>',
                ));
                ?>
            </div>

            <?php
            if (comments_open() || get_comments_number()) :
                comments_template();
            endif;
            ?>

        </article>
    </div>
</main>

<?php
endwhile;

get_footer();
