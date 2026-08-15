<?php
/**
 * The Main Template File (Homepage & Post List)
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'index.php' হলো ওয়ার্ডপ্রেস থিমের প্রাইমারি টেমপ্লেট যা হোমপেজে বা পোস্ট লিস্ট প্রদর্শনে কাজ করে।
 * - 'The Loop' (have_posts() & the_post()) এর মাধ্যমে ডাটাবেজ থেকে পোস্টগুলো একে একে ফেচ করে ডিসপ্লে করা হয়।
 * - 'get_header()' এবং 'get_footer()' দিয়ে হেডার ও ফুটার ইনক্লুড করা হয়।
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();

// ভ্লগ ফিল্টারিং হ্যান্ডলিং (URL এ ?is_vlog=1 থাকলে শুধু ভ্লগ পোস্ট দেখাবে)
$filter_vlog = isset($_GET['is_vlog']) && $_GET['is_vlog'] == '1';
?>

<main id="primary" class="site-main">

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-badge">
                <span>👑</span>
                <span><?php esc_html_e('Discover Inspiring Stories & Visual Vlogs', 'blog-post-ahanaf'); ?></span>
            </div>

            <h1 class="hero-title">
                <?php esc_html_e('Crafting Ideas into', 'blog-post-ahanaf'); ?> 
                <span class="gold-text"><?php esc_html_e('Dynamic Vlogs & Blogs', 'blog-post-ahanaf'); ?></span>
            </h1>

            <p class="hero-subtitle">
                <?php esc_html_e('Join our vibrant community. Watch exclusive vlogs, read insightful tech articles, and like your favorite posts in real-time!', 'blog-post-ahanaf'); ?>
            </p>

            <!-- Category / Filter Pills -->
            <div class="category-filter-bar">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="category-pill <?php echo (!$filter_vlog && !is_category()) ? 'active' : ''; ?>">
                    <?php esc_html_e('🔥 All Posts', 'blog-post-ahanaf'); ?>
                </a>
                <a href="<?php echo esc_url(add_query_arg('is_vlog', '1', home_url('/'))); ?>" class="category-pill <?php echo $filter_vlog ? 'active' : ''; ?>">
                    <?php esc_html_e('🎥 Only Vlogs', 'blog-post-ahanaf'); ?>
                </a>
                <?php
                $categories = get_categories(array('number' => 6));
                foreach ($categories as $cat) :
                ?>
                    <a href="<?php echo esc_url(get_category_link($cat->term_id)); ?>" class="category-pill">
                        #<?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Post Grid Section -->
    <section class="posts-grid-section">
        <div class="container">

            <div class="section-header">
                <h2 class="section-title">
                    <?php 
                    if ($filter_vlog) {
                        esc_html_e('🎬 Featured Video Vlogs', 'blog-post-ahanaf');
                    } else {
                        esc_html_e('📰 Latest Stories & Vlogs', 'blog-post-ahanaf');
                    }
                    ?>
                </h2>
            </div>

            <?php
            // যদি ভ্লগ ফিল্টার এক্টিভ থাকে তবে কাস্টম মেটাক্যোয়ারি দিয়ে পোস্ট কুয়েরি চালানো
            if ($filter_vlog) {
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $vlog_query = new WP_Query(array(
                    'post_type'      => 'post',
                    'posts_per_page' => 9,
                    'paged'          => $paged,
                    'meta_query'     => array(
                        array(
                            'key'     => '_ahanaf_is_vlog',
                            'value'   => '1',
                            'compare' => '='
                        )
                    )
                ));
            } else {
                $vlog_query = $wp_query;
            }

            if ($vlog_query->have_posts()) :
            ?>
                <div class="posts-grid">
                    <?php
                    while ($vlog_query->have_posts()) :
                        $vlog_query->the_post();

                        $post_id = get_the_ID();
                        $is_vlog = get_post_meta($post_id, '_ahanaf_is_vlog', true) === '1';
                        $video_url = get_post_meta($post_id, '_ahanaf_vlog_video_url', true);
                        $has_video = $is_vlog || !empty($video_url);
                        $categories = get_the_category();
                    ?>
                        <!-- Post Card Component -->
                        <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                            
                            <!-- Thumbnail Area -->
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

                                <!-- Vlog Badge -->
                                <?php if ($has_video) : ?>
                                    <div class="vlog-badge">
                                        <svg viewBox="0 0 24 24" width="12" height="12" fill="currentColor"><polygon points="5 3 19 12 5 21 5 3"></polygon></svg>
                                        <?php esc_html_e('Vlog', 'blog-post-ahanaf'); ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Category Badge -->
                                <?php if (!empty($categories)) : ?>
                                    <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="category-tag-badge">
                                        <?php echo esc_html($categories[0]->name); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Card Content Body -->
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
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <div class="card-excerpt">
                                    <?php the_excerpt(); ?>
                                </div>

                                <!-- Card Footer: Author & AJAX Like Button -->
                                <div class="card-footer">
                                    <div class="card-author">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 28); ?>
                                        <span class="card-author-name"><?php the_author(); ?></span>
                                    </div>

                                    <!-- Interactive Like Button -->
                                    <?php ahanaf_render_like_button($post_id, true); ?>
                                </div>

                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="pagination">
                    <?php
                    echo paginate_links(array(
                        'total'     => $vlog_query->max_num_pages,
                        'prev_text' => '&larr; Prev',
                        'next_text' => 'Next &rarr;',
                    ));
                    ?>
                </div>

            <?php 
            else : 
            ?>
                <div style="text-align: center; padding: 4rem 1rem;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">📭</div>
                    <h3><?php esc_html_e('No posts found!', 'blog-post-ahanaf'); ?></h3>
                    <p style="color: var(--color-text-muted); margin-top: 0.5rem;">
                        <?php esc_html_e('Get started by logging into WP Admin and creating your first Blog or Video Vlog.', 'blog-post-ahanaf'); ?>
                    </p>
                </div>
            <?php 
            endif;

            if ($filter_vlog) {
                wp_reset_postdata();
            }
            ?>

        </div>
    </section>

</main>

<?php
get_footer();
