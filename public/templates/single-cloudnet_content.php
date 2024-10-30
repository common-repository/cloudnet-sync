<?php

/**
 * Template Name: Cloudnet Content
 */
get_header();
?>
<style>
    .cn360-btn {
        margin: 50px;
        text-align: center;
        padding-bottom: 50px !important;
    }

    .cn360-mybtn {
        border-radius: 3px;
        text-decoration: none;
        font-family: sans-serif;
        font-size: 20px;
        padding: 10px 20px;
        background-color: #00ad25;
        color: #fff;
        transition-delay: .2s;
        transition: .3s;
        font-variant-caps: all-small-caps;
        box-shadow: 4px 3px 11px 0 #00ad25;
    }

    .cn360-mybtn:hover {
        background-color: #009420;
        box-shadow: 4px 3px 11px 0 #005a13;
    }
</style>
<?php
$cnsync_cloudnet_content_page = plugin_dir_path(__FILE__) . '../partials/cnsync_cloudnet_content_page.php';
$content_data = plugin_dir_path(__FILE__) . '/partials/content_data.php';
$restrict_content = plugin_dir_path(__FILE__) . '/partials/restrict_content.php';
$logout = plugin_dir_path(__FILE__) . '/partials/logout.php';
$not_release = plugin_dir_path(__FILE__) . '/partials/not_release.php';
$choose_package = get_field('choose_package');

$categories = get_the_terms(get_the_ID(), 'cloudnet_content');
$date = '';

foreach ((!empty($categories) ? $categories : []) as $category) {

    $date_string = get_field('release_date', $category);
    $date = $date_string;
}
if (date('Y-m-d') >= $date) {
    if (is_user_logged_in()) {
        if (wp_get_current_user()->roles[0] != 'administrator') {
            if ($choose_package == 'Premium') {

                $id = wp_get_current_user()->ID;

                $get_user_meta = get_post_meta($post->ID, '_membership_meta_key', false);

                $memebership_level = get_user_meta($id, 'memebership', true);

                $encproductrowid = get_user_meta($id, 'encproductrowid', true);


                $cloudnet_products = $wpdb->prefix . 'cloudnet_products';


                $cloudnet_products_query = $wpdb->get_row("select product_no FROM " . $cloudnet_products . " WHERE product_link_id = '" . $encproductrowid . "'");

                $postmeta = $wpdb->prefix . 'postmeta';


                $postmeta_query = $wpdb->get_row("SELECT post_id FROM " . $postmeta . " WHERE meta_key = '_product_no' and meta_value = " . $cloudnet_products_query->product_no . "");


                if (isset($memebership_level)) {
                    if ($memebership_level == 1) {

                        if (in_array($postmeta_query->post_id, $get_user_meta[0])) {
                            require  $content_data;
                        } else {
                            require  $restrict_content;
                        }
                    } else {
                        require  $restrict_content;
                    }
                }
            } else {
                require  $content_data;
            }
        } else {
            require  $content_data;
        }
    } else {
        if ($choose_package == 'Premium') {
            require  $restrict_content;
        } else {
            require  $content_data;
        }
    }
} else {
    require  $not_release;
}


require $cnsync_cloudnet_content_page;

?>

<?php get_footer(); ?>