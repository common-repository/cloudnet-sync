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
 */ ?>
<style>
    .toolbar {
        display: block;
        padding: 10px 0;
        border-top: 1px solid #eaeaea;
        border-bottom: 1px solid #eaeaea;
        margin-bottom: 20px;
    }

    .grid-list {
        float: left;
        margin: 0 20px 0 0;
    }

    .grid-list a {
        display: inline-block;
        width: 34px;
        height: 34px;
        line-height: 34px;
        color: #999;
        border: 1px solid #eaeaea;
        text-align: center;
    }

    .grid-list a.active {
        border-color: #fe5252;
    }

    .ordering {
        float: left;
    }

    .ordering .orderby {
        width: auto;
        min-width: 166px;
    }

    .ordering .theme-select {
        font-size: 13px;
        color: #999;
    }



    input,
    textarea,
    button {
        height: 25px;
        margin: 0;
        padding: 10px;
        font-family: Raleway, sans-serif;
        font-weight: normal;
        font-size: 12pt;
        outline: none;
        border-radius: 0;
        background: none;
        border: 1px solid #282B33;
    }

    button,
    select {
        height: 45px;
        padding: 0 15px;
        cursor: pointer;
    }

    button {
        background: none;
        border: 1px solid black;
        margin: 25px 0;
    }

    button:hover {
        background-color: #282B33;
        color: white;
    }


    .tools {
        overflow: auto;
        zoom: 1;
    }

    .search-area {
        float: left;
        width: 60%;
    }

    .settings {
        display: none;
        float: right;
        width: 40%;
        text-align: right;
    }

    #view {
        display: none;
        width: auto;
        height: 47px;
    }

    #searchbutton {
        width: 60px;
        height: 47px;
    }

    input#search {
        width: 30%;
        width: calc(100% - 90px);
        padding: 10px;
        border: 1px solid #282B33;
    }

    @media screen and (max-width:400px) {
        .search-area {
            width: 100%;
        }
    }

    .products {
        width: 100%;
        font-family: Raleway;
    }

    .product {
        display: inline-block;
        width: calc(24% - 13px);
        margin: 10px 10px 30px 10px;
        vertical-align: top;
    }

    .product img {
        display: block;
        margin: 0 auto;
        width: auto;
        height: 200px;
        max-width: calc(100% - 20px);
        box-shadow: 0px 0px 7px 0px rgba(0, 0, 0, 0.8);
        border-radius: 2px;
    }

    .product-content {
        text-align: center;
    }

    .product h3 {
        font-size: 20px;
        font-weight: 600;
        margin: 10px 0 0 0;
    }

    .product h3 small {
        display: block;
        font-size: 16px;
        font-weight: 400;
        font-style: italic;
        margin: 7px 0 0 0;
    }

    .product .product-text {
        margin: 7px 0 0 0;
        color: #777;
    }

    .product .price {
        font-family: sans-serif;
        font-size: 16px;
        font-weight: 700;
    }

    .product .genre {
        font-size: 14px;
    }


    @media screen and (max-width:1150px) {
        .product {
            width: calc(33% - 23px);
        }
    }

    @media screen and (max-width:700px) {
        .product {
            width: calc(50% - 43px);
        }
    }

    @media screen and (max-width:400px) {
        .product {
            width: 100%;
        }
    }

    /* TABLE VIEW */

    @media screen and (min-width:401px) {
        .settings {
            display: block;
        }

        #view {
            display: inline;
        }

        .products-table .product {
            display: block;
            width: auto;
            margin: 10px 10px 30px 10px;
        }

        .products-table .product .product-img {
            display: inline-block;
            margin: 0;
            width: 120px;
            height: 120px;
            vertical-align: middle;
        }

        .products-table .product img {
            width: auto;
            height: 120px;
            max-width: 120px;
        }

        .products-table .product-content {
            text-align: left;
            display: inline-block;
            margin-left: 20px;
            vertical-align: middle;
        }

        .products-table .product h3 {
            margin: 0;
        }
    }
</style>
<div class="" style="display: flex; padding:3%;">
    <div style="flex:1;padding-right: 30px;padding-left: 0;">
        <?php if (is_active_sidebar('memberships_sidebar')) { ?>
            <ul id="sidebar">
                <?php dynamic_sidebar('memberships_sidebar'); ?>
            </ul>
        <?php } ?>
    </div>
    <div style="flex: 3;padding-left: 30px;
    padding-right: 0;
    border-left-width: 1px;
    border-right-width: 0;">

        <div style="margin: 0;
    padding: 0;
    border: 0;
    outline: 0;
    font-size: 100%;
    font: inherit;
    vertical-align: baseline;
    font-family: inherit;
    font-size: 100%;
    font-style: inherit;
    font-weight: inherit;">
            <div class="products products-table">
                <article style="display: block;">
                    <div class="toolbar clr">
                        <nav class="grid-list"><a href="#" id="oceanwp-grid" title="Grid view" class="grid-btn"><i class=" icon-grid" aria-hidden="true" role="img"></i></a><a href="#" id="oceanwp-list" title="List view" class="list-btn active"><i class=" icon-list" aria-hidden="true" role="img"></i></a></nav>
                        <form class="ordering" method="get">
                            <select name="orderby" class="orderby" style="opacity: 0; position: absolute; height: 34px; font-size: 13px; appearance: menulist-button; width: 228px;">
                                <option value="menu_order" <?php if (@$_GET['orderby'] == 'menu_order') : ?> selected <?php endif; ?>>Default sorting</option>
                                <option value="date" <?php if (@$_GET['orderby'] == 'date') : ?> selected <?php endif; ?>>Sort by latest</option>
                                <option value="price" <?php if (@$_GET['orderby'] == 'price') : ?> selected <?php endif; ?>>Sort by price: low to high</option>
                                <option value="price-desc" <?php if (@$_GET['orderby'] == 'price-desc') : ?> selected <?php endif; ?>>Sort by price: high to low</option>
                            </select><span class="theme-select orderby" style="display: inline-block;">
                                <span class="theme-selectInner" style="display: inline-block;">
                                    Default sorting
                                </span>
                            </span>
                            <input type="hidden" name="paged" value="1">
                        </form>
                    </div>
                    <?php

                    foreach ($posts as $value) {
                        $fimg = '';
                        $post_id = $value->ID;
                        $image_path = get_post_meta($post_id, '_imagepath', true);

                        $gallery_img = get_post_meta($post_id, 'cloudnet_attachment_gallery_key', true);
                        $_shotred_series = get_post_meta($post_id, '_shotred_series', true);

                        $rst = $_shotred_series;
                        if (empty($gallery_img)) {
                            $fimg = CN360_SYNC__PLUGIN_URL . 'admin/images/img_found.jpg';
                        } else {
                            $fimg = wp_get_attachment_url($gallery_img[0]);
                        }


                        $img_id = '';
                        if (!empty($rst) && $rst[0] != '') {
                            $img_id = $rst;
                        } else {
                            if (!empty($gallery_img)) {
                                $img_id = $gallery_img;
                            }
                        }
                        $prod_short_desc = get_post_meta($post_id, '_shortdesc', true);
                    ?>
                        <div class="product">
                            <div class="product-img">
                                <img src="<?= $fimg; ?>">
                            </div>
                            <div class="product-content">
                                <h3>
                                    <?= $value->post_title ?>
                                </h3>
                                <p class="product-text price">Price <?= get_option('cloudnet_store_currencysymbol') ?> <?= (!empty(get_post_meta($post_id, '_price', true)) ? get_post_meta($post_id, '_price', true) : '0.00') ?></p>
                                <p class="product-text genre"><?= (strlen($prod_short_desc) > 150 ? substr($prod_short_desc, 150) . '....' : $prod_short_desc) ?></p>
                                <a class="button" href="<?= $value->guid ?>">Details</a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </article>
            </div>

        </div>
        <?php

        echo paginate_links(array(
            'current' => $paged,
            'total' =>  1
        ));
        ?>
    </div>

</div>
<script>
    jQuery(document).ready(function() {
        jQuery('.orderby').change(function() {
            url = "?orderby=" + encodeURIComponent(jQuery(this).val());
            location.href = url;
        });
    });
</script>