<?php
/**
 * The Template for displaying all WooCommerce Pages (Shop, Single Product, Archive)
 * 
 * @package Blog_Post_Ahanaf
 */

get_header();
?>

<main id="primary" class="site-main woocommerce-main-wrapper">
    <div class="container" style="padding-top: 3.5rem; padding-bottom: 5.5rem;">
        <?php woocommerce_content(); ?>
    </div>
</main>

<?php
get_footer();
