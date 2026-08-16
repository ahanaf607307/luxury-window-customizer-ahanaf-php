<?php
/**
 * The Template for displaying comments
 * 
 * ফ্রেশারদের জন্য নোট:
 * - 'comments.php' ফাইলে পোস্টের সকল কমেন্ট এবং নতুন কমেন্ট সাবমিট করার ফর্ম হ্যান্ডেল করা হয়।
 * - 'comment_form()' ফাংশন দিয়ে ওয়ার্ডপ্রেসের ডিফল্ট কমেন্ট ফর্ম রেন্ডার ও কাস্টমাইজ করা যায়।
 * 
 * @package Blog_Post_Ahanaf
 */

if (post_password_required()) {
    return;
}
?>

<div id="comments" class="comments-area">

    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            💬 <?php
            $comment_count = get_comments_number();
            if ('1' === $comment_count) {
                printf(esc_html__('One comment on "%1$s"', 'blog-post-ahanaf'), '<span>' . esc_html(get_the_title()) . '</span>');
            } else {
                printf(
                    esc_html(_nx('%1$s comment', '%1$s comments', $comment_count, 'comments title', 'blog-post-ahanaf')),
                    number_format_i18n($comment_count)
                );
            }
            ?>
        </h3>

        <ul class="comment-list">
            <?php
            wp_list_comments(array(
                'style'       => 'ul',
                'short_ping'  => true,
                'avatar_size' => 44,
            ));
            ?>
        </ul>

        <?php the_comments_navigation(); ?>

    <?php endif; ?>

    <?php if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) : ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'blog-post-ahanaf'); ?></p>
    <?php endif; ?>

    <?php
    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');

    comment_form(array(
        'title_reply'          => __('Leave a Comment / Feedback', 'blog-post-ahanaf'),
        'title_reply_to'       => __('Reply to %s', 'blog-post-ahanaf'),
        'cancel_reply_link'    => __('Cancel Reply', 'blog-post-ahanaf'),
        'label_submit'         => __('Post Comment', 'blog-post-ahanaf'),
        'class_submit'         => 'btn btn-primary',
        'comment_field'        => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="5" required placeholder="' . esc_attr__('Share your thoughts on this vlog or post...', 'blog-post-ahanaf') . '"></textarea></p>',
    ));
    ?>

</div>
