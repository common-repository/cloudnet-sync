<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://techexeitsolutions.com
 * @since      1.0.0
 *
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/includes
 * @author     http://techexeitsolutions.com
 */
class Cloudnet_sync {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Cloudnet_sync_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if (defined('CN360_SYNC_VERSION')) {
            $this->version = CN360_SYNC_VERSION;
        } else {
            $this->version = '12.0.0';
        }
        $this->plugin_name = 'cloudnet_sync';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
      
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - cnsync_Loader. Orchestrates the hooks of the plugin.
     * - cnsync_i18n. Defines internationalization functionality.
     * - cnsync_Admin. Defines all hooks for the admin area.
     * - cnsync_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/cnsync-loader-class.php';

        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/cnsync-i18n-class.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/cnsync-admin-class.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'includes/cnsync-admin-notices.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/cnsync-public-class.php';

        $this->loader = new Cloudnet_sync_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Cloudnet_sync_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Cloudnet_sync_i18n();

        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
      
        $plugin_admin = new cnsync_Admin($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'cnsync_enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'cnsync_enqueue_scripts');
        $this->loader->add_action('admin_menu', $plugin_admin, 'cnsync_personalised_cloudnet_menu');
        $this->loader->add_action('init', $plugin_admin, 'cnsync_create_products_post_type');

        $this->loader->add_action('init', $plugin_admin, 'cnsync_create_member_ship_products_post_type');



        $this->loader->add_action('admin', $plugin_admin, 'cloudnet_add_new_product_page');
        $this->loader->add_action('wp_ajax_cnsync_api_add_option', $plugin_admin, 'cnsync_api_add_option');
        $this->loader->add_action('wp_ajax_cnsync_api_mpro_option', $plugin_admin, 'cnsync_api_mpro_option');
        // $this->loader->add_action('wp_ajax_cnsync_api_sign_up_user', $plugin_admin, 'cnsync_api_sign_up_user');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_api_add_option', $plugin_admin, 'cnsync_api_add_option');
        $this->loader->add_action('add_meta_boxes', $plugin_admin, 'cnsync_meta_box_add');
        $this->loader->add_action('wp_ajax_cnsync_get_data_from_api', $plugin_admin, 'cnsync_get_data_from_api');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_get_data_from_api', $plugin_admin, 'cnsync_get_data_from_api');
        $this->loader->add_action('wp_ajax_cnsync_delete_data', $plugin_admin, 'cnsync_delete_data');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_delete_data', $plugin_admin, 'cnsync_delete_data');
        $this->loader->add_action('wp_ajax_cnsync_delete_video_attachment', $plugin_admin, 'cnsync_delete_video_attachment');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_delete_video_attachment', $plugin_admin, 'cnsync_delete_video_attachment');
        $this->loader->add_action('wp_ajax_cnsync_delete_attachment', $plugin_admin, 'cnsync_delete_attachment');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_delete_attachment', $plugin_admin, 'cnsync_delete_attachment');
        $this->loader->add_action('restrict_manage_posts', $plugin_admin, 'cnsync_filter_post_type_by_taxonomy');
        $this->loader->add_filter('parse_query', $plugin_admin, 'cnsync_convert_id_to_term_in_query');

        // Add a post display state for special WC pages.
		$this->loader->add_filter( 'display_post_states',  $plugin_admin, 'cnsync_add_display_post_states',10,3 );
        
        //santanu
        $this->loader->add_action('parent_file', $plugin_admin, 'cloudnet_menu_highlight');        
        $this->loader->add_filter( "manage_edit-cloudnet_category_columns", $plugin_admin, 'cloudnet_category_column_header');
        $this->loader->add_filter( "manage_cloudnet_category_custom_column", $plugin_admin, 'cloudnet_category_column_content', 10, 3);

        $this->loader->add_filter( "manage_edit-cloudnet_m_s_category_columns", $plugin_admin, 'cloudnet_m_s_category_column_header');
        $this->loader->add_filter( "manage_cloudnet_m_s_category_custom_column", $plugin_admin, 'cloudnet_m_s_category_column_content', 10, 3);

        $this->loader->add_filter( "manage_edit-cloudnet_content_columns", $plugin_admin, 'cloudnet_content_column_header');
        $this->loader->add_filter( "manage_cloudnet_content_custom_column", $plugin_admin, 'cloudnet_content_column_content', 10, 3);
        
        $this->loader->add_action('edit_form_after_title', $plugin_admin, 'cnsync_disable_editors');
        $this->loader->add_filter('cloudnet_category_row_actions', $plugin_admin, 'cloudnet_category_description_link', 10, 2);
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'cnsync_enqueue_admin');
        $this->loader->add_filter( "manage_cloudnet_product_posts_columns", $plugin_admin, 'set_custom_cloudnet_product_columns');
        $this->loader->add_action( 'manage_cloudnet_product_posts_custom_column', $plugin_admin, 'manage_cloudnet_product_columns' );
        $this->loader->add_action('admin_head', $plugin_admin, 'custom_js_to_head');
        $this->loader->add_action( 'admin_post_cn_save_order', $plugin_admin, 'cn_save_order_action_hook_function' );

        /* ----------------------------New cat function for cat input---------------------------- */
        $this->loader->add_action('wp_ajax_cnsync_get_data_from_category_api', $plugin_admin, 'cnsync_get_data_from_category_api');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_get_data_from_category_api', $plugin_admin, 'cnsync_get_data_from_category_api');
        
        $this->loader->add_filter('admin', $plugin_admin, 'cnsync_cat_api_add_option');
      
        /* ----------------------------New cat function for cat input---------------------------- */
        $this->loader->add_action('save_post', $plugin_admin, 'cnsync_gall_save_post', 10, 2);
        $this->loader->add_action('post_edit_form_tag', $plugin_admin, 'cnsync_add_edit_form_multipart_encoding');
        
        /* ----------------------------------SEND VIDEO REARANGEMENT END------------------------- */
        $this->loader->add_action('wp_ajax_cnsync_update_postmeta_video_short', $plugin_admin, 'cnsync_update_postmeta_video_short');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_update_postmeta_video_short', $plugin_admin, 'cnsync_update_postmeta_video_short');

        /* ----------------------------------SEND IMAGE REARANGEMENT END------------------------- */
        $this->loader->add_action('wp_ajax_cnsync_update_postmeta_image_short', $plugin_admin, 'cnsync_update_postmeta_image_short');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_update_postmeta_image_short', $plugin_admin, 'cnsync_update_postmeta_image_short');

        /* -----------delete shortcode form data------------------------------ */
        $this->loader->add_action('wp_ajax_cnsync_delete_shortcode', $plugin_admin, 'cnsync_delete_shortcode');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_delete_shortcode', $plugin_admin, 'cnsync_delete_shortcode');

        /* -----------delete shortcode survey data------------------------------ */
        $this->loader->add_action('wp_ajax_cnsync_survey_delete_shortcode', $plugin_admin,'cnsync_survey_delete_shortcode');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_survey_delete_shortcode', $plugin_admin, 'cnsync_survey_delete_shortcode');

        /* -------------- Form shortcode function-------------- */
        add_shortcode('cn_opt_form', array($plugin_admin, 'cnsync_optin_display_shortcode'));
        $this->loader->add_action('admin_init', $plugin_admin, 'cnsync_cr_form_save');
        $this->loader->add_action('save_post', $plugin_admin, 'cn_save_post_callback');

        /* -------------- Survey Form shortcode function-------------- */
        add_shortcode('cn_opt_survey_form', array($plugin_admin, 'cnsync_optin_survey_display_shortcode'));
        $this->loader->add_action('admin_init', $plugin_admin, 'cnsync_cr_survey_save');
        $this->loader->add_action('save_post', $plugin_admin, 'cn_save_survey_post_callback');


        $this->loader->add_action('wp_ajax_cnsync_ajax_upload_file', $plugin_admin, 'cnsync_ajax_upload_file');
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new cnsync_Public($this->get_plugin_name(), $this->get_version());

        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'cnsync_enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'cnsync_enqueue_scripts');
        /* --------------------------Shortcode for display -------------- */
        add_shortcode('cloudnet_products_showcase', array($plugin_public, 'cnsync_products_showcase'));
        add_shortcode('cloudnet_product_grid_view', array($plugin_public, 'cnsync_page_display'));
		add_shortcode('cloudnet_product_single_view', array($plugin_public, 'cnsync_product_single_view'));	//added by santanu
		add_shortcode('cloudnet_category_product_1column_view', array($plugin_public, 'cnsync_product_1column_view'));	//added by santanu
		add_shortcode('cloudnet_category_product_3column_view', array($plugin_public, 'cnsync_product_3column_view'));	//added by santanu

        add_shortcode('cloudnet_m_s_category_product_1column_view', array($plugin_public, 'cnsync_m_s_product_1column_view'));	//added by ali
        add_shortcode('cloudnet_m_s_category_product_3column_view', array($plugin_public, 'cnsync_m_s_product_3column_view'));	//added by ali

        add_shortcode('cloudnet_content_1column_view', array($plugin_public, 'cloudnet_m_s_content_1column_view'));	//added by ali
        add_shortcode('cloudnet_content_2column_view', array($plugin_public, 'cloudnet_m_s_content_3column_view'));	//added by ali

        add_shortcode('cloudnet_login_page', array($plugin_public, 'cnsync_cloudnet_login_page'));	//added by ali
        add_shortcode('cloudnet_sign_up_page', array($plugin_public, 'cnsync_cloudnet_sign_up_page'));	//added by ali
        add_shortcode('cloudnet_memberships', array($plugin_public, 'cnsync_cloudnet_memberships'));	//added by ali
        add_shortcode('cloudnet_content', array($plugin_public, 'cnsync_cloudnet_content'));	//added by ali

        $this->loader->add_action('wp_ajax_cnsync_products_showcase', $plugin_public, 'cnsync_products_showcase');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_products_showcase', $plugin_public, 'cnsync_products_showcase');
        
        /* --------------------------Shortcode for display -------------- */

        $this->loader->add_filter('single_template', $plugin_public, 'cnsync_single_product', 999, 2);
        $this->loader->add_filter('template_include', $plugin_public, 'cnsync_product_categories');

        /* ----------------------------------add to cart ------------------------- */
        $this->loader->add_action('wp_ajax_cnsync_add_to_cartproduct', $plugin_public, 'cnsync_add_to_cartproduct');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_add_to_cartproduct', $plugin_public, 'cnsync_add_to_cartproduct');

        /* ----------------------------------Create User cart ------------------------- */
        $this->loader->add_action('wp_ajax_cnsync_incart_data_byip', $plugin_public, 'cnsync_incart_data_byip');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_incart_data_byip', $plugin_public, 'cnsync_incart_data_byip');
        /* ----------------------------------Delete cart item------------------------- */
        $this->loader->add_action('wp_ajax_cnsync_incart_item_remove', $plugin_public, 'cnsync_incart_item_remove');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_incart_item_remove', $plugin_public, 'cnsync_incart_item_remove');
        /* ----------------------------------Delete cart item------------------------- */
        $this->loader->add_action('wp_ajax_cnsync_sl_getfront_ip', $plugin_public, 'cnsync_sl_getfront_ip');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_sl_getfront_ip', $plugin_public, 'cnsync_sl_getfront_ip');
        /* -------------------------cloudenet_add_popcart--------------- */

        /* ----------------------------------SEND ITEM COUNT FRONT END------------------------- */
        $this->loader->add_action('wp_ajax_cnsync_get_cart_tip_count', $plugin_public, 'cnsync_get_cart_tip_count');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_get_cart_tip_count', $plugin_public, 'cnsync_get_cart_tip_count');

        /* ----------------------------------SEND ITEM COUNT FRONT END------------------------- */
        $this->loader->add_action('wp_ajax_cnsync_procedtochekout', $plugin_public, 'cnsync_procedtochekout');
        $this->loader->add_action('wp_ajax_nopriv_cnsync_procedtochekout', $plugin_public, 'cnsync_procedtochekout');

        /* -------------------------cloudenet_add_popcart--------------- */
        $this->loader->add_action('wp_footer', $plugin_public, 'cnsync_add_popcart', 100);


         /* ----------------------------------Content Post Load Ajax------------------------- */
         $this->loader->add_action('wp_ajax_cnsync_content_data_load', $plugin_public, 'cnsync_content_data_load');
         $this->loader->add_action('wp_ajax_nopriv_cnsync_content_data_load', $plugin_public, 'cnsync_content_data_load');
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Cloudnet_sync_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }
}?>