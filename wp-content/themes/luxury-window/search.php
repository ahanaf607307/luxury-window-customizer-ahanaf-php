<?php
/**
 * The Template for displaying search results
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();
?>

<main id="primary" class="site-main">

    <!-- Search Header Banner -->
    <section class="hero-section" style="padding: 3.5rem 0 2rem;">
        <div class="container">
            <h1 class="hero-title" style="font-size: 2.3rem;">
                <?php esc_html_e('Search Results for:', 'blog-post-ahanaf'); ?> 
                <span class="gradient-text">"<?php echo esc_html(get_search_query()); ?>"</span>
            </h1>
        </div>
    </section>

    <!-- Search Results Grid -->
    <section class="posts-grid-section">
        <div class="container">
            <?php if (have_posts()) : ?>
                <div class="posts-grid">
                    <?php
                    while (have_posts()) :
                        the_post();

                        $post_id = get_the_ID();
                        $is_vlog = get_post_meta($post_id, '_ahanaf_is_vlog', true) === '1';
                        $video_url = get_post_meta($post_id, '_ahanaf_vlog_video_url', true);
                        $has_video = $is_vlog || !empty($video_url);
                        $categories = get_the_category();
                    ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                            <div class="card-thumbnail-wrap">
                                <a href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('ahanaf-card'); ?>
                                    <?php else : ?>
                                        <div style="width:100%; height:100%; min-height:200px; background:linear-gradient(135deg, #1e1b4b, #312e81); display:flex; align-items:center; justify-content:center; color:#818cf8; font-size:2.5rem;">
                                            <?php echo $has_video ? '🎥' : '📝'; ?>
                                        </div>
                                    <?php endif; ?>
                                </a>

                                <?php if ($has_video) : ?>
                                    <div class="vlog-badge">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                        <?php esc_html_e('Vlog', 'blog-post-ahanaf'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($categories)) : ?>
                                    <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="category-tag-badge">
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="card-body">
                                <div class="card-meta">
                                    <span class="card-meta-item">
                                        <svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                        <?php echo esc_html(get_the_date()); ?>
                                    </span>
                                    <span>•</span>
                                    <span class="card-meta-item">
                                        <svg viewBox="0 0 24 24" width="13" height="13" stroke="currentColor" stroke-width="2" fill="none"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                                        <?php echo esc_html(ahanaf_get_reading_time($post_id)); ?>
                                    </span>
                                </div>

                                <h3 class="card-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>

                                <div class="card-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="card-footer">
                                    <div class="card-author">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 28); ?>
                                        <span class="card-author-name"><?php the_author(); ?></span>
                                    </div>
                                    <?php ahanaf_render_like_button($post_id, true); ?>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php
                    the_posts_pagination(array(
                        'prev_text' => '&larr; Prev',
                        'next_text' => 'Next &rarr;',
                    ));
                    ?>
                </div>

            <?php else : ?>
                <div style="text-align: center; padding: 4rem 1rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">🔍</div>
                    <h3><?php esc_html_e('No results found for your search query.', 'blog-post-ahanaf'); ?></h3>
                    <p style="color: var(--color-text-muted); margin-top: 0.5rem;">
                        <?php esc_html_e('Try searching with different keywords.', 'blog-post-ahanaf'); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </section>

</main>

<?php
get_footer();
