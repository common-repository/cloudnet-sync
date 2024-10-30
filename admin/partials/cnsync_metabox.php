<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       www.vll.com
 * @since      1.0.0
 *
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/admin/partials
 */
?>
<section>
    <div class="container-fluid">

        <div class="wrap col-sm-12">
            <div class="welcome-panel">
                <div class="welcome-panel-content">
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="text-box-row">
                                <label>Price <?php echo get_option('cloudnet_store_currencysymbol'); ?></label>
                                <?php $price = get_post_meta($post_id, '_price', true); ?>
                                <input type="text" name="price" disabled id="price" class="form-control" value="<?php if (!empty($price)) echo $price; ?>"/>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="welcome-panel">
        <div class="welcome-panel-content">
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="text-box-row">
                        <div class="col-sm-3"><label>Short Description</label></div>   
                        <?php
                        $content = get_post_meta($post_id, '_shortdesc', true);
                        $editor_id = 'cncustompost';
                        //wp_editor($content, $editor_id);
                        echo nl2br($content);
                        ?>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>