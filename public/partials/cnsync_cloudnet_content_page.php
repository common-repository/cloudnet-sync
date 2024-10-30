<?php

/**
 * Provide a public  area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://techexeitsolutions.com/
 * @since      1.0.0
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/public/partials
 */ 

 $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
 $posts = get_posts(
     array(
         'posts_per_page' => 6,
         'post_type' => 'cloudnet_m_s_content',
         'order' => 'ASC',
         'orderby' => 'meta_value_num',
         'paged' => $paged
     )
 );
?>
<style>
    .album {
        min-height: 100vh;

    }

    .album-ul {
        display: flex;
        overflow: auto;
    }

    .album-ul li {
        list-style: none;
        padding: 8px 20px;
        margin: 5px;
        letter-spacing: 1px;
        cursor: pointer;
    }

    .album-ul li.active {
        background-color: white;
        color: black;
    }

    .container2 {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
    }

    .container2 .box {
        position: relative;
        width: 350px;
        height: 500px;
        margin: 5px;
        background-color: white;
    }

    .container2 .box .badge,
    .container2 .box .date {
        position: absolute;
        text-align: center;
        font-weight: 600;
        color: white;
        top: 15px;
    }

    .container2 .box .badge {
        left: 10px;
        width: 100px;
        padding: 10px;
        background-color: #ff4343;
    }

    .container2 .box .date {
        right: 10px;
        background-color: grey;
        padding: 10px;
    }

    .container2 .box .thumbnail {
        width: 100%;
        height: 50%;
        background-color: grey;
    }

    .container2 .box .content {
        padding: 20px;
    }

    .container2 .box .content h1 {
        font-size: 24px;
        color: #333;
    }

    .container2 .box .content p {
        font-size: 15px;
        color: #b0b0b6;
    }
</style>
<main>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <ul class="album-ul">
                    <li class="list active" data-filter="all">All</li>
                    <?php
                    $terms = get_terms([
                        'taxonomy' => 'cloudnet_content',
                        'hide_empty' => false,
                    ]);
                    foreach ($terms as $term) :
                        if ($term->parent == 0) :
                    ?>
                            <li class="list" data-filter="<?= $term->term_id ?>"><?= $term->name ?></li>
                        <?php else : ?>
                            <li class="list" data-filter="<?= $term->term_id ?>"> -- <?= $term->name ?></li>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </ul>

                <div class="container2">
                    <?php

                    foreach ($posts as $value) :
                        $fimg = '';
                        $post_id = $value->ID;
                        $categories = get_the_terms($value->ID, 'cloudnet_content');
                        $date = '';
                        foreach ((!empty($categories) ? $categories : []) as $category) {

                            $date_string = get_field('release_date', $category);
                            $date = $date_string;
                        }

                        if (!has_post_thumbnail($post_id)) {
                            $fimg = CN360_SYNC__PLUGIN_URL . 'admin/images/img_found.jpg';
                        } else {
                            $fimg = wp_get_attachment_url(get_post_thumbnail_id($value->ID));
                        }
                        $post_type = get_post_type($post_id);
                        $taxonomies = get_object_taxonomies($post_type);
                        $taxonomy_names = wp_get_object_terms($post_id, $taxonomies, array("fields" => "ids"));

                        $name_ids = count($taxonomy_names) > 0 ? implode(" ", $taxonomy_names) : '';

                        $taxonomy_names = wp_get_object_terms($post_id, $taxonomies, array("fields" => "names"));

                        $name_tex = count($taxonomy_names) > 0 ? implode(", ", $taxonomy_names) : '';

                        $prod_short_desc = get_post_field('post_content', $post_id);

                        $prod_short_desc = get_the_content(null, false, $post_id);
                    ?>

                        <!-- Box Start -->
                        <div class="box <?= $name_ids ?>">
                            <div class="date"><?= date("d-m-Y", strtotime($value->post_modified)) ?></div>
                            <div class="badge"><?= $name_tex ?></div>
                            <a href="<?= $value->guid ?>"><img class="thumbnail" src="<?= $fimg ?>"></img></a>
                            <div class="content">
                                <h1><?= $value->post_title ?></h1>
                                <div style="line-height: 1.6; margin-top: 0.625rem;">
                                    <p><?= (strlen($prod_short_desc) > 50 ? htmlspecialchars(substr($prod_short_desc, 250)) . '....' : htmlspecialchars($prod_short_desc)) ?></p>
                                    <?php if ($date <= date('Y-m-d')) : ?>
                                        <a class="article__author" href="<?= $value->guid ?>">Details</a>
                                    <?php else : ?>
                                        <a class="article__author" href="<?= $value->guid ?>">Not Release content</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                    
                </div>
               <div style="  display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;">
               <div class="text-center loading" style="display: none;">
                        <img src="<?php echo CN360_SYNC__PLUGIN_URL; ?>public/images/loading.gif">
                    </div>
               </div>
                <div class="btn__wrapper">
                    <a href="javascript:void(0)" class="btn btn-primary" id="load-more" onclick="load_more_content();">Load more</a>
                </div>
            </div>
        </div>
    </div>


</main>

<script>
    /* filter js */
    jQuery(document).ready(function() {
        jQuery('.list').click(function() {
            const value = jQuery(this).attr('data-filter');
            if (value == 'all') {
                jQuery('.box').show('1000');
            } else {
                jQuery('.box').not('.' + value).hide('1000');
                jQuery('.box').filter('.' + value).show('1000');
            }
        })

        jQuery('.list').click(function() {
            jQuery(this).addClass('active').siblings().removeClass('active');
        });

       
    });
</script>