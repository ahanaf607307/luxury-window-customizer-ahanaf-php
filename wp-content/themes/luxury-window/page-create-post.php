<?php
/**
 * Template Name: Create Post / Vlog
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();
?>

<main id="primary" class="site-main">
    <div class="container" style="max-width: 850px; margin: 3.5rem auto 6rem;">
        
        <?php if (!is_user_logged_in() || !current_user_can('edit_posts')) : ?>
            
            <!-- Access Restricted View -->
            <div class="creator-card" style="text-align: center; padding: 4rem 2rem;">
                <div style="font-size: 3.5rem; margin-bottom: 1rem;">🔒</div>
                <h1 style="font-size: 1.8rem; margin-bottom: 1rem; color: #ffffff;">
                    <?php esc_html_e('Creator Studio Access Required', 'blog-post-ahanaf'); ?>
                </h1>
                <p style="color: var(--color-text-muted); max-width: 500px; margin: 0 auto 2rem; line-height: 1.7;">
                    <?php esc_html_e('You must be logged in as an administrator or creator to publish vlogs and stories.', 'blog-post-ahanaf'); ?>
                </p>
                <a href="#" data-open-modal="signin" class="btn btn-primary">
                    ✨ <?php esc_html_e('Sign In to Continue', 'blog-post-ahanaf'); ?>
                </a>
            </div>

        <?php else : ?>

            <!-- Creator Studio Form -->
            <div class="creator-card">
                
                <div class="creator-header">
                    <div class="hero-badge" style="margin-bottom: 0.8rem;">
                        <span>👑</span>
                        <span><?php esc_html_e('Creator Dashboard', 'blog-post-ahanaf'); ?></span>
                    </div>
                    <h1 class="creator-title">
                        <?php esc_html_e('Publish New', 'blog-post-ahanaf'); ?> 
                        <span class="gold-text"><?php esc_html_e('Vlog or Story', 'blog-post-ahanaf'); ?></span>
                    </h1>
                    <p class="creator-subtitle">
                        <?php esc_html_e('Fill in the fields below to instantly publish your video vlog or written article to the community.', 'blog-post-ahanaf'); ?>
                    </p>
                </div>

                <form id="vlogpulse-create-post-form" enctype="multipart/form-data">
                    <div class="create-post-feedback"></div>

                    <!-- 1. Post Type Switcher -->
                    <div class="form-group-wrap">
                        <label class="form-label"><?php esc_html_e('Content Format', 'blog-post-ahanaf'); ?> *</label>
                        <div class="type-toggle-pills">
                            <button type="button" class="type-toggle-btn active" data-type="blog">
                                <span>📝</span> <?php esc_html_e('Standard Article / Blog', 'blog-post-ahanaf'); ?>
                            </button>
                            <button type="button" class="type-toggle-btn" data-type="vlog">
                                <span>🎥</span> <?php esc_html_e('Video Vlog', 'blog-post-ahanaf'); ?>
                            </button>
                        </div>
                        <input type="hidden" name="is_vlog" id="create-post-is-vlog" value="0" />
                    </div>

                    <!-- 2. Post Title -->
                    <div class="form-group-wrap">
                        <label for="create-post-title" class="form-label"><?php esc_html_e('Post Title', 'blog-post-ahanaf'); ?> *</label>
                        <input type="text" id="create-post-title" name="post_title" placeholder="e.g. Exploring Cinematic Lighting Techniques in 2026" required />
                    </div>

                    <!-- 3. Video URL (Hidden by default, shown for Vlogs) -->
                    <div class="form-group-wrap" id="vlog-video-url-group" style="display: none;">
                        <label for="create-post-video-url" class="form-label">
                            <?php esc_html_e('Video URL (YouTube, Vimeo, MP4)', 'blog-post-ahanaf'); ?> *
                        </label>
                        <input type="url" id="create-post-video-url" name="vlog_video_url" placeholder="https://www.youtube.com/watch?v=..." />
                        <small style="color: var(--color-text-muted); font-size: 0.82rem; margin-top: 0.4rem; display: block;">
                            <?php esc_html_e('Paste any public YouTube, Vimeo, or direct MP4 video link. It will automatically render a responsive video player.', 'blog-post-ahanaf'); ?>
                        </small>
                    </div>

                    <!-- 4. Category Selector -->
                    <div class="form-group-wrap">
                        <label for="create-post-category" class="form-label"><?php esc_html_e('Category', 'blog-post-ahanaf'); ?> *</label>
                        <select id="create-post-category" name="post_category" style="width: 100%; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--color-border); border-radius: var(--radius-sm); padding: 0.85rem 1.1rem; color: #ffffff; font-size: 0.95rem;">
                            <?php
                            $categories = get_categories(array('hide_empty' => 0));
                            foreach ($categories as $cat) {
                                echo '<option value="' . esc_attr($cat->term_id) . '" style="background: #121217; color: #fff;">' . esc_html($cat->name) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- 5. Featured Image / Thumbnail Picker -->
                    <div class="form-group-wrap">
                        <label class="form-label"><?php esc_html_e('Cover Thumbnail Image', 'blog-post-ahanaf'); ?></label>
                        
                        <div class="image-dropzone" id="create-post-dropzone" onclick="document.getElementById('create-post-thumbnail').click();">
                            <input type="file" id="create-post-thumbnail" name="thumbnail" accept="image/*" style="display: none;" />
                            
                            <div class="dropzone-prompt">
                                <div style="font-size: 2.2rem; color: var(--color-gold); margin-bottom: 0.5rem;">📁</div>
                                <p style="color: #ffffff; font-weight: 600; margin-bottom: 0.25rem;">
                                    <?php esc_html_e('Click to upload or drag & drop cover image', 'blog-post-ahanaf'); ?>
                                </p>
                                <span style="color: var(--color-text-muted); font-size: 0.82rem;">
                                    <?php esc_html_e('Supports PNG, JPG, WEBP (16:9 recommended)', 'blog-post-ahanaf'); ?>
                                </span>
                            </div>

                            <div id="create-post-thumb-preview" style="display: none; position: relative;">
                                <img id="preview-image-tag" src="#" alt="<?php esc_attr_e('Thumbnail Preview', 'blog-post-ahanaf'); ?>" style="max-height: 220px; border-radius: var(--radius-md); border: 1px solid var(--color-gold); margin: 0 auto; display: block;" />
                                <span style="display: inline-block; margin-top: 0.8rem; font-size: 0.85rem; color: var(--color-gold);">
                                    🔄 <?php esc_html_e('Click to change cover image', 'blog-post-ahanaf'); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Post Content / Story Body -->
                    <div class="form-group-wrap">
                        <label for="create-post-content" class="form-label"><?php esc_html_e('Article / Story Content', 'blog-post-ahanaf'); ?> *</label>
                        <textarea id="create-post-content" name="post_content" rows="9" placeholder="<?php esc_attr_e('Write your story, notes, gear breakdown, or insights here...', 'blog-post-ahanaf'); ?>" required></textarea>
                    </div>

                    <!-- 7. Submit Action -->
                    <div style="margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary create-post-submit-btn" style="width: 100%; padding: 1.1rem; font-size: 1.05rem;">
                            <span class="btn-text"><?php esc_html_e('Publish Post Now', 'blog-post-ahanaf'); ?> &rarr;</span>
                        </button>
                    </div>

                </form>
            </div>

        <?php endif; ?>

    </div>
</main>

<?php
get_footer();
