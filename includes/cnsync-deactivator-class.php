<?php
/**
 * Fired during plugin deactivation
 *
 * @link       http://techexeitsolutions.com
 * @since      1.0.0
 *
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/includes
 */
/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/includes
 * @author     http://techexeitsolutions.com
 */
class Cloudnet_sync_Deactivator {

    /**
     * Short Description. (use period)
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function deactivate() {

        global $wpdb;
        $table_name = $wpdb->prefix . 'cloudnet_products';
        $sql = "DROP TABLE IF EXISTS $table_name;";
        $wpdb->query($sql);
        /* --------------- */
        $attribute_table = $wpdb->prefix . 'cloudnet_product_attribute';
        $sql2 = "DROP TABLE IF EXISTS $attribute_table;";
        $wpdb->query($sql2);
        /* --------------- */
        $product_group_table = $wpdb->prefix . 'cloudnet_product_attribute_group';
        $sql3 = "DROP TABLE IF EXISTS $product_group_table;";
        $wpdb->query($sql3);
        
        /* --------------- */
        $form_table = $wpdb->prefix . 'cloudnet_optin_form_data';
        $sql4 = "DROP TABLE IF EXISTS $form_table;";
        $wpdb->query($sql4);

        /* --------------- */
        $survey_table = $wpdb->prefix . 'cloudnet_optin_survey_data';
        $sql5 = "DROP TABLE IF EXISTS $survey_table;";
        $wpdb->query($sql5);
    }
}?>