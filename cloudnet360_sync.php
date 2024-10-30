<?php
/* ------------------------------------------------------------------------------
 * The plugin bootstrap file
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin  CloudNet360,India.
 * ******************************************************************************
 * @link              https://www.cloudnet360.com/
 * @since             1.0.0
 * @package           cloudnet360_sync
 * ******************************************************************************
 * @wordpress-plugin
 * Plugin Name:       CloudNet360
 * Plugin URI:        https://www.cloudnet360.com/
 * Description:       Instant sales automation with any theme and the proven strength of the CloudNet360 small business sales automation platform. Easy to install, “copy / paste” simple to use anywhere on your site, and more powerful than anything else available today. </b>
 * Version:           3.2.0
 * Author:            GARY JEZORSKI 
 * Author URI:        https://www.gary-jezorski.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cloudnet360
 * Domain Path:       /languages
 * ******************************************************************************
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 */
define('CN360_SYNC_VERSION', '1.0.0');
define('CN360_SYNC__MINIMUM_WP_VERSION', '4.0');
define('CN360_SYNC__PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CN360_SYNC__PLUGIN_URL', plugin_dir_url(__FILE__));
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/cnsync-activator-class.php
 */
if (!function_exists('activate_cloudnet_sync')) {
    function activate_cloudnet_sync()
    {
        require_once(CN360_SYNC__PLUGIN_DIR . 'includes/cnsync-activator-class.php');
        Cloudnet_sync_Activator::activate();
    }
}
/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/cnsync-deactivator-class.php
 */
if (!function_exists('deactivate_cloudnet_sync')) {
    function deactivate_cloudnet_sync()
    {
        require_once(CN360_SYNC__PLUGIN_DIR . 'includes/cnsync-deactivator-class.php');
        Cloudnet_sync_Deactivator::deactivate();
    }
}
register_activation_hook(__FILE__, 'activate_cloudnet_sync');
register_deactivation_hook(__FILE__, 'deactivate_cloudnet_sync');
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once(CN360_SYNC__PLUGIN_DIR . 'includes/cnsync-class.php');

require_once(CN360_SYNC__PLUGIN_DIR . 'includes/cnsync-list-custom-taxonomy-widget.php');

include(CN360_SYNC__PLUGIN_DIR . 'includes/advanced-custom-fields/acf.php');
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
/* * Add wp List table support */
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}
if (!function_exists('run_cloudnet_sync')) {
    function run_cloudnet_sync()
    {
        $plugin = new Cloudnet_sync();
        $plugin->run();
        add_filter('post_updated_messages', 'codex_book_updated_messages');
        /**
         * Book update messages.
         *
         * See /wp-admin/edit-form-advanced.php
         *
         * @param array $messages Existing post update messages.
         *
         * @return array Amended post update messages with new CPT update messages.
         */
        function codex_book_updated_messages($messages)
        {
            $post = get_post();
            $post_type = get_post_type($post);
            $post_type_object = get_post_type_object($post_type);

            $messages['cloudnet_product'] = array(
                0 => '', // Unused. Messages start at index 1.
                1 => __('Product has been updated successfully.', 'CN360_SYNC'),
                2 => __('Custom field has been updated successfully.', 'CN360_SYNC'),
                3 => __('Custom field has been deleted successfully.', 'CN360_SYNC'),
                4 => __('Product has been updated successfully.', 'CN360_SYNC'),
                /* translators: %s: date and time of the revision */
                5 => isset($_GET['revision']) ? sprintf(__('Book restored to revision from %s', 'CN360_SYNC'), wp_post_revision_title((int) $_GET['revision'], false)) : false,
                6 => __('Product has been published.', 'CN360_SYNC'),
                7 => __('Product has been saved.', 'CN360_SYNC'),
                8 => __('Product has been submitted.', 'CN360_SYNC'),
                9 => sprintf(
                    __('Product scheduled for: <strong>%1$s</strong>.', 'CN360_SYNC'),
                    // translators: Publish box date format, see http://php.net/date
                    date_i18n(__('M j, Y @ G:i', 'CN360_SYNC'), strtotime($post->post_date))
                ),
                10 => __('Product draft has been updated successfully.', 'CN360_SYNC')
            );
            if ($post_type_object->publicly_queryable && 'cloudnet_product' === $post_type) {
                $permalink = get_permalink($post->ID);

                $view_link = sprintf(' <a href="%s">%s</a>', esc_url($permalink), __('View product', 'CN360_SYNC'));
                $messages[$post_type][1] .= $view_link;
                $messages[$post_type][6] .= $view_link;
                $messages[$post_type][9] .= $view_link;

                $preview_permalink = add_query_arg('preview', 'true', $permalink);
                $preview_link = sprintf(' <a target="_blank" href="%s">%s</a>', esc_url($preview_permalink), __('Preview product', 'CN360_SYNC'));
                $messages[$post_type][8] .= $preview_link;
                $messages[$post_type][10] .= $preview_link;
            }
            return $messages;
        }
    }
    run_cloudnet_sync();
}
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6384aaf22b227',
        'title' => 'Content',
        'fields' => array(
            array(
                'key' => 'field_6384aaf22c1b7',
                'label' => 'File',
                'name' => 'file',
                'aria-label' => '',
                'type' => 'file',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'return_format' => 'array',
                'library' => 'all',
                'min_size' => '',
                'max_size' => '',
                'mime_types' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'cloudnet_m_s_content',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    
    acf_add_local_field_group(array(
        'key' => 'group_63849638cde46',
        'title' => 'Membership Level',
        'fields' => array(
            array(
                'key' => 'field_63849639028ea',
                'label' => 'Choose Package',
                'name' => 'choose_package',
                'aria-label' => '',
                'type' => 'radio',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array(
                    'Non Premium' => 'Non Premium',
                    'Premium' => 'Premium',
                ),
                'default_value' => '',
                'return_format' => 'value',
                'allow_null' => 0,
                'other_choice' => 0,
                'layout' => 'vertical',
                'save_other_choice' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'cloudnet_m_s_content',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

    acf_add_local_field_group(array(
        'key' => 'group_63849d97384d7',
        'title' => 'Category Content',
        'fields' => array(
            array(
                'key' => 'field_63849e4ee8033',
                'label' => 'Release Date',
                'name' => 'release_date',
                'aria-label' => '',
                'type' => 'date_picker',
                'instructions' => 'Override standard release schedule with a set release date - all members will get content on this date',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'display_format' => 'Y-m-d',
                'return_format' => 'Y-m-d',
                'first_day' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'cloudnet_content',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));
    
endif;		

// used for tracking error messages
function cnsync_errors(){
    static $wp_error; // Will hold global variable safely
    return isset($wp_error) ? $wp_error : ($wp_error = new WP_Error(null, null, null));
}

function cnsync_show_error_messages() {
	if($codes = cnsync_errors()->get_error_codes()) {
		echo '<div class="cnsync_errors">';
		    // Loop error codes and display errors
		   foreach($codes as $code){
		        $message = cnsync_errors()->get_error_message($code);
		        echo '<span class="error"><strong>' . __('Error') . '</strong>: ' . $message . '</span><br/>';
		    }
		echo '</div>';
	}	
}

function cnsync_register_css() {
    wp_register_style('cnsync-form-css', plugin_dir_url( __FILE__ ) . '/public/css/forms.css');
}
function cnsync_print_css() {
    global $cnsync_load_css;
 
    // this variable is set to TRUE if the short code is used on a page/post
    if ( ! $cnsync_load_css )
        return; // this means that neither short code is present, so we get out of here
 
    wp_print_styles('cnsync-form-css');
}

add_action('init', 'cnsync_register_css');
add_action('wp_footer','cnsync_print_css');

