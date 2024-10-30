<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://techexeitsolutions.com
 * @since      1.0.0
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/admin
 * @author     http://techexeitsolutions.com
 */
class cnsync_Admin extends ExtraRun
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->init();
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    public function cnsync_personalised_cloudnet_menu()
    {

        add_menu_page('Cloud Net', 'CloudNet360', 'manage_options', 'cloud_net', array($this, 'cnsync_page_function'), 'dashicons-cloud'); //dashicons-update
        add_submenu_page('cloud_net', 'CloudNet360 Dashboard', 'Dashboard', 'edit_posts', 'cloud_net');
        add_submenu_page('cloud_net', 'CloudNet360 Categories', 'Categories', 'manage_options', 'edit-tags.php?taxonomy=cloudnet_category&post_type=cloudnet_product', NULL);
        add_submenu_page('cloud_net', 'CloudNet360 Products', 'Products', 'manage_options', 'edit.php?post_type=cloudnet_product', NULL); //My Product
        add_submenu_page('cloud_net', 'CloudNet360 Opt-In Forms', 'Opt-In Forms', 'edit_posts', 'form', array($this, 'cnsync_cloudnet_optin_display'));
        add_submenu_page('cloud_net', 'CloudNet360 Surveys Action Forms', 'Action Surveys', 'edit_posts', 'survey', array($this, 'cnsync_cloudnet_survey_display'));
        add_submenu_page(null, 'Cloud Net Form', 'Cloud Net Shortcoder', 'edit_posts', 'cloudnet_shortcoder', array($this, 'cnsync_cr_form'));
        add_submenu_page(null, 'Cloud Net Survey Form', 'Cloud Net Survey Shortcoder', 'edit_posts', 'cloudnet_survey_shortcoder', array($this, 'cnsync_cr_survey_form'));
        add_submenu_page('cloud_net', 'CloudNet360 API Settings', 'API Settings', 'edit_posts', 'api_settings', array($this, 'cnsync_subpage_function_api_settings'));


        //MemberShip
        if (!empty(get_option('mpro')) || get_option('mpro') == 1) {
            add_menu_page('Cloud Net', 'MemberShip', 'manage_options', 'member_ship', array($this, 'cnsync_page_function'), 'dashicons-editor-code');
            add_submenu_page('member_ship', 'CloudNet360 Dashboard', 'Dashboard', 'edit_posts', 'member_ship');
            add_submenu_page('member_ship', 'CloudNet360 Products', 'Membership Products', 'manage_options', 'edit.php?post_type=cloudnet_m_s_product', NULL); //My Product
            add_submenu_page('member_ship', 'CloudNet360 Categories', 'Membership Category', 'manage_options', 'edit-tags.php?taxonomy=cloudnet_m_s_category&post_type=cloudnet_m_s_product', NULL);

            // content
            add_submenu_page('member_ship', 'CloudNet360 Content Category', 'Membership Content Category', 'manage_options', 'edit-tags.php?taxonomy=cloudnet_content&post_type=cloudnet_m_s_content', NULL);

            add_submenu_page('member_ship', 'CloudNet360 Content Post', 'Membership Content Post', 'manage_options', 'edit.php?post_type=cloudnet_m_s_content', NULL);
            // content
        }
    }

    public function cnsync_enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name . 'css-file', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cloudnet_sync-admin.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'font-file', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'bootstrap-file', 'https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'jquery-ui-css-file', plugin_dir_url(__FILE__) . 'css/jquery-ui.css', array(), $this->version, 'all');
    }

    public function cnsync_enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cloudnet_sync-admin.js', array('jquery'), $this->version, false);

        $data = array('ajax_url' => admin_url('admin-ajax.php'));
        wp_localize_script($this->plugin_name, 'ajax', $data);
        //wp_enqueue_script($this->plugin_name . 'jquery.min', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array('jquery'), $this->version, false);
        //wp_enqueue_script($this->plugin_name . 'jquery.min', 'https://code.jquery.com/jquery-1.12.4.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . 'boot-jq', 'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array('jquery'), false);
        wp_enqueue_script($this->plugin_name . 'sweetalert-jq', 'https://unpkg.com/sweetalert/dist/sweetalert.min.js', array('jquery'), $this->version, false);
        wp_enqueue_script($this->plugin_name . 'bootstrap-toggle-jq', 'https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js', array('jquery'), $this->version, false);
        //wp_enqueue_script($this->plugin_name.'jquery-ui-js', plugin_dir_url(__FILE__) . 'js/jquery-ui.js', array('jquery'), $this->version, false);

    }

    public function cnsync_page_function()
    {
        include_once 'partials/cnsync_sync-admin-display.php';
    }

    public function cnsync_subpage_function_orders()
    {
        //$this->get_data_from_category_api();
        //include_once 'partials/cnsync_orders_page.php';
        //$url_order = $this->get_current_url();
    }

    public function cnsync_subpage_function_api_settings()
    {
        $url_api_setting = $this->cnsync_get_current_url();
        include_once 'partials/cnsync_api_settings_page.php';
    }

    /* ------------CREATE THE TREE VIEW FOR THE ATTER SET--------------- */

    public function cnsync_get_all_attribute_groups_and_value()
    {
        global $wpdb;
        $attribute_data = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "cloudnet_product_attribute_group LEFT JOIN " . $wpdb->prefix . "cloudnet_product_attribute ON (" . $wpdb->prefix . "cloudnet_product_attribute.grouprowid = " . $wpdb->prefix . "cloudnet_product_attribute_group.grouprowid)", ARRAY_A);
        $attribute_groupname = $wpdb->get_results("SELECT groupname FROM " . $wpdb->prefix . "cloudnet_product_attribute_group WHERE 1", ARRAY_A);


        if (is_wp_error($attribute_data)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }


        if (is_wp_error($attribute_groupname)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }

        include_once 'partials/cnsync_display_attribute_groups.php';
    }

    public function cnsync_cloudnet_optin_display()
    {
        global $wpdb;
        $data = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'cloudnet_optin_form_data WHERE 1', ARRAY_A);


        if (is_wp_error($data)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }


        include_once 'partials/cnsync_optin_display_shortcode.php';
    }
    public function cnsync_cloudnet_survey_display()
    {
        global $wpdb;
        $data = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'cloudnet_optin_survey_data WHERE 1', ARRAY_A);


        if (is_wp_error($data)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }


        include_once 'partials/cnsync_optin_survey_display_shortcode.php';
    }

    public function cnsync_cr_form()
    {

        global $wpdb;
        $data = '';
        if (isset($_GET['id']) != '') {
            $data = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'cloudnet_optin_form_data WHERE id=' . $_GET['id'], ARRAY_A);
        } else {
            $data = array(
                'formname' => '',
                'formdata' => '',
                'visible' => '',
                'status' => ''
            );
        }


        if (is_wp_error($data)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
        include_once 'partials/cnsync_opt_form.php';
    }

    public function cnsync_cr_form_save()
    {
        $transient_name = md5('CN360_SYNC' . get_current_user_id());
        $notices = new CloudNetTransientAdminNotices($transient_name);
        global $wpdb;
        $tablename = $wpdb->prefix . 'cloudnet_optin_form_data';
        if (isset($_POST['cn_save'])) {

            if (!isset($_POST['cn_create_form']) || !wp_verify_nonce($_POST['cn_create_form'], 'cn_save_action')) {
                //echo' <div class="notice notice-error is-dismissible"><p>Sorry, your nonce did not verify.</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                $notices->add('save_cnsync', 'Sorry, your nonce did not verify.', 'error');
            } else {

                // process form data
                if (($_POST['cn_name']) != '') {
                    $formname = $_POST['cn_name'];
                }
                if (($_POST['form_content']) != '') {
                    $formdata = $_POST['form_content'];
                }
                if (isset($_POST['cn_disable']) && $_POST['cn_disable'] != '') {
                    $cn_disable = $_POST['cn_disable'];
                } else {
                    $cn_disable = '0';
                }

                if (($_POST['cn_devices']) != '') {
                    $cn_visible = $_POST['cn_devices'];
                }

                if (isset($_GET['id']) != '') {
                    $id = $_GET['id'];
                    $data = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'cloudnet_optin_form_data WHERE id=' . $id, ARRAY_A);
                    if (is_wp_error($data)) {
                        $error_string = $wpdb->get_error_messages();
                        //echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
                        $notices->add('save_cnsync', 'No such form exits.' . $error_string, 'warning');
                        wp_safe_redirect(admin_url() . "admin.php?page=form");
                        exit;
                    } else {
                        $update = $wpdb->query(
                            $wpdb->prepare(
                                "UPDATE $tablename SET formname='%s', formdata='%s', status='%s',visible='%s' WHERE id=%d",
                                $formname,
                                $formdata,
                                $cn_disable,
                                $cn_visible,
                                $id
                            )
                        );
                        if (is_wp_error($update)) {
                            $error_string = $wpdb->get_error_messages();
                            //echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
                            $notices->add('save_cnsync', 'Sorry, failed to save form ' . $formname . '.Error: ' . $error_string, 'error');
                            wp_safe_redirect(admin_url() . "admin.php?page=form");
                            exit;
                        }
                        if ($update !== false) {
                            //header("refresh:1;url=" . admin_url() . "admin.php?page=form");
                            //echo '<div class="notice notice-success is-dismissible"><p>Form updated successfully</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                            $notices->add('save_cnsync', 'Form ' . $formname . ' has been updated successfully.', 'success');
                            wp_safe_redirect(admin_url() . "admin.php?page=form");
                            exit;
                        } else {
                            // echo '<div class="notice notice-warning is-dismissible"><p>Form updated failed.</p><button type="button" class="notice-dismiss">span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                            $notices->add('save_cnsync', 'Sorry, failed to save form ' . $formname . '.', 'error');
                            wp_safe_redirect(admin_url() . "admin.php?page=form");
                            exit;
                        }
                    }
                } else {

                    $lastid = $wpdb->insert(
                        $tablename,
                        array(
                            'formname' => $formname,
                            'formdata' => $formdata,
                            'status' => $cn_disable,
                            'visible' => $cn_visible
                        ),
                        array('%s', '%s', '%s', '%s')
                    );
                    if ($lastid != '') {
                        //header("refresh:1;url=" . admin_url() . "admin.php?page=form");
                        //echo '<div class="notice notice-success is-dismissible"><p>Form created successfully</p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button></div>';
                        //$notices->add( 'save_cnsync', 'Form '.$formname.' created successfully.', 'success' );
                        wp_safe_redirect(admin_url() . "admin.php?page=form");
                        exit;
                    } else {
                        $notices->add('save_cnsync', 'Sorry, failed to save form ' . $formname . '.', 'error');
                        wp_safe_redirect(admin_url() . "admin.php?page=form");
                        exit;
                    }
                    if (is_wp_error($lastid)) {
                        $error_string = $wpdb->get_error_messages();
                        //echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
                        $notices->add('save_cnsync', 'Sorry, failed to save form ' . $formname . '.Error: ' . $error_string, 'error');
                        wp_safe_redirect(admin_url() . "admin.php?page=form");
                        exit;
                    }
                }
            }
        }
    }

    public function cnsync_optin_display_shortcode($atts)
    {
        ob_start();
        global $wpdb;
        if (!empty($atts['id'])) {
            $form_id = $atts['id'];
            $optin_data = $wpdb->prefix . 'cloudnet_optin_form_data';
            $form_data = $wpdb->get_results("SELECT * FROM $optin_data WHERE id= '$form_id '", ARRAY_A);
            if (!empty($form_data)) {
                $form_name = $form_data[0]['formname'];
                $form_data_html = stripslashes($form_data[0]['formdata']);
                $status = $form_data[0]['status'];

                if ($status == '0') {
                    $dy_class = $form_data[0]['visible'];

                    switch ($dy_class) {
                        case 'all':
                            echo '<div class="cn_form_output_all">' . $form_data_html . '</div>';
                            break;
                        case 'mobile_only':
                            echo '<div class="cn_form_output_mobile_only">' . $form_data_html . '</div>';
                            break;
                        case 'desktop_only':
                            echo '<div class="cn_form_output_desktop_only">' . $form_data_html . '</div>';
                            break;
                    }
                } else {
                    echo "<p>This shortcode is temporary disabled</p>";
                }
            }
            if (is_wp_error($form_data)) {
                $error_string = $wpdb->get_error_messages();
                echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
            }
        }
        return ob_get_clean();
    }

    public function cnsync_delete_shortcode()
    {
        global $wpdb;
        $optin_data = $wpdb->prefix . 'cloudnet_optin_form_data';
        $id = $_POST['id'];
        if ($id != '') {
            $delete_id = $wpdb->query('DELETE FROM  ' . $optin_data . ' WHERE id = "' . $id . '"');

            if ($delete_id > 0) {
                echo "Deleted successfully";
            } else {
                $error = $wpdb->get_error_messages();
                echo "something went wrong" . $error;
            }
        }
        wp_die();
    }
    /* ------------SURVEY FORMS CUSTOM CODE------------------------------*/
    public function cnsync_cr_survey_form()
    {

        global $wpdb;
        $data = '';
        if (isset($_GET['id']) != '') {
            $data = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'cloudnet_optin_survey_data WHERE id=' . $_GET['id'], ARRAY_A);
        } else {
            $data = array(
                'formname' => '',
                'formdata' => '',
                'visible' => '',
                'status' => ''
            );
        }


        if (is_wp_error($data)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
        include_once 'partials/cnsync_opt_survey_form.php';
    }

    public function cnsync_cr_survey_save()
    {
        $transient_name = md5('CN360_SYNC' . get_current_user_id());
        $notices = new CloudNetTransientAdminNotices($transient_name);
        global $wpdb;
        $tablename = $wpdb->prefix . 'cloudnet_optin_survey_data';
        if (isset($_POST['cn_survey_save'])) {

            if (!isset($_POST['cn_create_survey_form']) || !wp_verify_nonce($_POST['cn_create_survey_form'], 'cn_survey_save_action')) {
                $notices->add('save_cnsyn', 'Sorry, your nonce did not verify.', 'error');
            } else {

                // process form data
                if (($_POST['cn_name']) != '') {
                    $formname = $_POST['cn_name'];
                }
                if (($_POST['form_content']) != '') {
                    $formdata = $_POST['form_content'];
                }
                if (isset($_POST['cn_disable']) && $_POST['cn_disable'] != '') {
                    $cn_disable = $_POST['cn_disable'];
                } else {
                    $cn_disable = '0';
                }

                if (($_POST['cn_devices']) != '') {
                    $cn_visible = $_POST['cn_devices'];
                }

                if (isset($_GET['id']) != '') {
                    $id = $_GET['id'];
                    $data = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'cloudnet_optin_survey_data WHERE id=' . $id, ARRAY_A);
                    if (is_wp_error($data)) {
                        $error_string = $wpdb->get_error_messages();
                        $notices->add('save_cnsyn', 'No such form exits.' . $error_string, 'warning');
                        wp_safe_redirect(admin_url() . "admin.php?page=survey");
                        exit;
                    } else {
                        $update = $wpdb->query(
                            $wpdb->prepare(
                                "UPDATE $tablename SET formname='%s', formdata='%s', status='%s',visible='%s' WHERE id=%d",
                                $formname,
                                $formdata,
                                $cn_disable,
                                $cn_visible,
                                $id
                            )
                        );
                        if (is_wp_error($update)) {
                            $error_string = $wpdb->get_error_messages();
                            $notices->add('save_cnsyn', 'Sorry, failed to save form ' . $formname . '.Error: ' . $error_string, 'error');
                            wp_safe_redirect(admin_url() . "admin.php?page=survey");
                            exit;
                        }
                        if ($update !== false) {
                            //$notices->add( 'save_cnsyn', 'Form '.$formname.' has been updated successfully.', 'success' );
                            wp_safe_redirect(admin_url() . "admin.php?page=survey");
                            exit;
                        } else {
                            $notices->add('save_cnsyn', 'Sorry, failed to save form ' . $formname . '.', 'error');
                            wp_safe_redirect(admin_url() . "admin.php?page=survey");
                            exit;
                        }
                    }
                } else {

                    $lastid = $wpdb->insert(
                        $tablename,
                        array(
                            'formname' => $formname,
                            'formdata' => $formdata,
                            'status' => $cn_disable,
                            'visible' => $cn_visible
                        ),
                        array('%s', '%s', '%s', '%s')
                    );
                    if ($lastid != '') {
                        //$notices->add( 'save_cnsyn', 'Form '.$formname.' created successfully.', 'success' );
                        wp_safe_redirect(admin_url() . "admin.php?page=survey");
                        exit;
                    } else {
                        $notices->add('save_cnsyn', 'Sorry, failed to save form ' . $formname . '.', 'error');
                        wp_safe_redirect(admin_url() . "admin.php?page=survey");
                        exit;
                    }
                    if (is_wp_error($lastid)) {
                        $error_string = $wpdb->get_error_messages();
                        $notices->add('save_cnsyn', 'Sorry, failed to save form ' . $formname . '.Error: ' . $error_string, 'error');
                        wp_safe_redirect(admin_url() . "admin.php?page=survey");
                        exit;
                    }
                }
            }
        }
    }

    public function cnsync_optin_survey_display_shortcode($atts)
    {
        ob_start();
        global $wpdb;
        if (!empty($atts['id'])) {
            $form_id = $atts['id'];
            $optin_data = $wpdb->prefix . 'cloudnet_optin_survey_data';
            $form_data = $wpdb->get_results("SELECT * FROM $optin_data WHERE id= '$form_id '", ARRAY_A);
            if (!empty($form_data)) {
                $form_name = $form_data[0]['formname'];
                $form_data_html = stripslashes($form_data[0]['formdata']);
                $status = $form_data[0]['status'];

                if ($status == '0') {
                    $dy_class = $form_data[0]['visible'];

                    switch ($dy_class) {
                        case 'all':
                            echo '<div class="cn_form_output_all">' . $form_data_html . '</div>';
                            break;
                        case 'mobile_only':
                            echo '<div class="cn_form_output_mobile_only">' . $form_data_html . '</div>';
                            break;
                        case 'desktop_only':
                            echo '<div class="cn_form_output_desktop_only">' . $form_data_html . '</div>';
                            break;
                    }
                } else {
                    echo "<p>This shortcode is temporary disabled</p>";
                }
            }
            if (is_wp_error($form_data)) {
                $error_string = $wpdb->get_error_messages();
                echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
            }
        }
        return ob_get_clean();
    }

    public function cnsync_survey_delete_shortcode()
    {
        global $wpdb;
        $optin_data = $wpdb->prefix . 'cloudnet_optin_survey_data';
        $id = $_POST['id'];
        if ($id != '') {
            $delete_id = $wpdb->query('DELETE FROM  ' . $optin_data . ' WHERE id = "' . $id . '"');

            if ($delete_id > 0) {
                echo "Deleted successfully";
            } else {
                $error = $wpdb->get_error_messages();
                echo "something went wrong" . $error;
            }
        }
        wp_die();
    }


    /* ------------CREATE THE TREE VIEW FOR THE ATTER SET--------------- */

    public function cnsync_get_current_url()
    {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }

    /*public function cnsync_get_data_from_api() {

        $merchant_id = get_option('cloudnet_mar_api_key');
        $api_key = get_option('cloudnet_mar_api_signature');

        $target_url = 'https://www.secureinfossl.com/testapi/productList.html';

        if (!empty($merchant_id) && !empty($api_key)) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $target_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            $request = 'merchantid=' . urlencode($merchant_id);
            $request .= '&api_signature=' . urlencode($api_key);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_HEADER, 0); // Display headers
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1000);

            $response = curl_exec($ch);

            if (!curl_errno($ch)) {
                switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                    case 200:
                        //convert xml string into an object
                        $xml = simplexml_load_string($response);
                        //convert into json
                        $json = json_encode($xml);
                        //convert into associative array
                        $pro_data = json_decode($json, true);
                        $res_main = $this->cnsync_get_product_data($pro_data);
                        echo $res_main;
                        wp_die();
                        break;
                    default:
                        echo 'Unexpected HTTP code: ', $http_code, "\n";
                }
            }
        }
    }*/

    public function cnsync_get_data_from_api()
    {

        $merchant_id = get_option('cloudnet_mar_api_key');
        $api_key = get_option('cloudnet_mar_api_signature');

        $target_url = 'https://www.secureinfossl.com/testapi/productList.html';

        if (!empty($merchant_id) && !empty($api_key)) {
            $body = array('merchantid' => $merchant_id, 'api_signature' => $api_key);
            $request = new WP_Http();
            $response_full = $request->request($target_url, array('method' => 'POST', 'body' => $body));
            if (isset($response_full->errors)) {
                return array(500, 'Unknown Error');
            }
            $response_code = $response_full['response']['code'];
            if ($response_code === 200) {
                //convert xml string into an object
                $response = $response_full['body'];
                $xml = simplexml_load_string($response);
                //convert into json
                $json = json_encode($xml);
                //convert into associative array
                $pro_data = json_decode($json, true);
                $res_main = $this->cnsync_get_product_data($pro_data);
                // echo $res_main;
                // wp_die();
            } else {
                echo 'Unexpected HTTP code: ', $response_code, "\n";
            }
        }
    }

    public function cnsync_get_product_data($pro_data = array())
    {
        $products_loop = '';
        $prod_live_set = $pro_data['productcount']['totalcount'];

        /* ----------CHECK THE LIVE ARRAY STATUS--- */
        if ($prod_live_set == 1) {
            $products_loop = $pro_data['products'];
        } else {
            $products_loop = $pro_data['products']['product'];
        }
        /* ----------CHECK THE LIVE ARRAY STATUS--- */

        /* ----------CHECK THE SETTINGS----------- */
        $this->cnsync_update_store_settings();
        /* ----------CHECK THE CATEGORY-------- */
        $this->cnsync_get_data_from_category_api();

        /* ----------INSRET PRODUCTS THE LOOP ----------- */
        foreach ($products_loop as $product_value) {

            $this->cnsync_insert_product_data_cloud($product_value);
        }

        /* ----------INSRET THE LOOP END----------- */

        /* -----------GET ATTRIBUTE FORM API DATABASE AND SAVE IN ATTER TABLE-------- */

        $this->cnsync_get_attribute_form_cloudnet_api();

        /* -------------------------------------------- */
    }

    public function cnsync_insert_product_data_cloud($product)
    {
        global $wpdb;
        $sku = $product['sku'];
        $tablename_log = $wpdb->prefix . 'cloudnet_products';
        $pro_name = base64_decode($product['name']);
        // $longdesc = base64_decode($product['longdesc']);

        if (empty($product['shortdesc'])) {
            $shortdesc = ' ';
        } else {
            $shortdesc = base64_decode($product['shortdesc']);
            $shortdesc = $this->cnsync_rip_tags($shortdesc);
        }

        $product_link_id = base64_decode($product['product_link_id']);

        $cat_id = $product['categoryid'];
        $term_data = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'termmeta WHERE meta_value = ' . $cat_id . ' LIMIT 1', ARRAY_A);
        // 
        $tID = !empty($term_data) ? $term_data[0]['term_id'] : '';

        if (!empty($tID)) {
            $term = get_term($tID, 'cloudnet_category');

            $cat_name = $term->slug;
        }


        $lon = $this->cnsync_rip_tags((!empty($product['longdesc']) ? base64_decode($product['longdesc']) : true));
        $post_id = $this->cnsync_get_post_id_by_meta_key_and_value('_product_row_id_set', $product['product_row_id']);

        if (!$post_id) {

            $post_id = wp_insert_post(array(
                'post_type' => 'cloudnet_product',
                'post_title' => trim($pro_name),
                'post_content' => $lon,
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            ));
        } else {

            $my_post = array();
            $my_post['ID'] = $post_id;
            $my_post['post_title'] = trim($pro_name);
            $my_post['post_content'] = $lon;
            wp_update_post($my_post);
        }



        if ($post_id != '') {
            //insert post 
            wp_set_object_terms($post_id, $cat_name, 'cloudnet_category', true);

            $product_order_meta_value = get_post_meta($post_id, 'cloudnet_product_order_' . $tID, true);
            if (empty($product_order_meta_value)) {
                update_post_meta($post_id, 'cloudnet_product_order_' . $tID, 1);
            }
            if ($product['product_no'] != '')
                update_post_meta($post_id, '_product_no', $product['product_no']);
            if (!empty($product['product_row_id'])) {
                $input = $product['product_row_id'];
                //Product ID:
                $name = str_pad($input, 5, "0", STR_PAD_LEFT);
                $pr_id = "PRO-" . $name;
                update_post_meta($post_id, '_product_row_id', $pr_id);
                update_post_meta($post_id, '_product_row_id_set', $input);
            }

            if ($product['product_link_id'] != '')
                update_post_meta($post_id, '_product_link_id', $product['product_link_id']);
            if (!empty($product['sku']))
                update_post_meta($post_id, '_sku', $product['sku']);
            if (!empty($product['price']))
                update_post_meta($post_id, '_price', $product['price']);
            if (!empty($product['shortdesc']))
                update_post_meta($post_id, '_shortdesc', $shortdesc);
            if (!empty($product['categoryid']))
                update_post_meta($post_id, '_categoryid', $product['categoryid']);
            if (!empty($product['regularbuylink']))
                update_post_meta($post_id, '_regularbuylink', $product['regularbuylink']);
            if (!empty($product['regularbuylink']))
                update_post_meta($post_id, '_oneclickbuylink', $product['regularbuylink']);
            if (!empty($product['imagepath']))
                update_post_meta($post_id, '_imagepath', $product['imagepath']);

            $table_log_drop = "select * from wp_cloudnet_products where product_link_id = '" . trim($product['product_link_id']) . "'";
            if ($wpdb->query($table_log_drop) == 0) {
                $data = $wpdb->insert(
                    $tablename_log,
                    array(
                        'sku' => $product['sku'] != null ? trim($product['sku']) : null,
                        'product_no' => trim($product['product_no']),
                        'product_link_id' => trim($product['product_link_id'])
                    ),
                    array('%s', '%s', '%s')
                );


                if (is_wp_error($data)) {
                    $error_string = $wpdb->get_error_messages();
                    echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
                }
            }
        }

        if (is_wp_error($post_id)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
        if (is_wp_error($term_data)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }

    public function cnsync_get_attribute_form_cloudnet_api()
    {
        $merchant_id = get_option('cloudnet_mar_api_key');
        $api_key = get_option('cloudnet_mar_api_signature');
        $target_url = 'https://secureinfossl.com/testapi/productOption.html';

        if (!empty($merchant_id) && !empty($api_key)) {
            $body = array('merchantid' => $merchant_id, 'api_signature' => $api_key);
            $request = new WP_Http();
            $response_full = $request->request($target_url, array('method' => 'POST', 'body' => $body));
            if (isset($response_full->errors)) {
                return array(500, 'Unknown Error');
            }
            $response_code = $response_full['response']['code'];
            if ($response_code === 200) {
                //convert xml string into an object
                $response = $response_full['body'];
                $xml = simplexml_load_string($response);

                $json = json_encode($xml);

                $attribute_data = json_decode($json, true);
                if (!empty($attribute_data)) {
                    $this->cnsync_insert_attribute_data($attribute_data);
                }
                wp_die();
            } else {
                echo 'Unexpected HTTP code: ', $response_code, "\n";
            }
        }
        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $request = 'merchantid=' . urlencode($merchant_id);
        $request .= '&api_signature=' . urlencode($api_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HEADER, 0); // Display headers
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        $response = curl_exec($ch);
        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:

                    $xml = simplexml_load_string($response);

                    $json = json_encode($xml);

                    $attribute_data = json_decode($json, true);
                    if (!empty($attribute_data)) {
                        $this->cnsync_insert_attribute_data($attribute_data);
                    }
                    wp_die();
                    break;
                default:
                    echo 'Unexpected HTTP code: ', $http_code, "  \ n";
            }
        }
        */
    }

    public function cnsync_insert_attribute_data($attribute_data = array())
    {
        $attribute_group = $attribute_data['groups'];
        $attributes = $attribute_data['attributes']; // attributes array 
        $assignedattributes = $attribute_data['assignedattributes']; // assignedattributes array 
        $myspace_to_search = $assignedattributes['attributegroup']; // assignedattributes array sub array
        $product_attr = array();

        foreach ($attribute_group as $group_val) {
            foreach ($group_val as $group) {
                $this->cnsync_insert_attribute_groups($group);
            }
        }

        foreach ($attributes as $attributes_option) {
            foreach ($attributes_option as $options) {
                $this->cnsync_insert_attribute_groups_options($options);
            }
        }

        foreach ($myspace_to_search as $key => $node) {
            if ($node['productrowid'] != "") {
                $product_attr[$node['productrowid']][] = $node['attributerowid'];
            }
        }

        foreach ($product_attr as $pro_id => $pro_data) {
            $this->cnsync_get_attribute_mata_vlaue($pro_id, $pro_data);
        }
    }

    /* ------SELECT attribute post ID FROM attribute group table using  product row id and meta value---------------------- */

    public function cnsync_get_attribute_mata_vlaue($pro_id, $attr_data = array())
    {

        global $wpdb;
        $product_meta_table = $wpdb->prefix . 'postmeta';
        $product_attribute = $wpdb->prefix . 'cloudnet_product_attribute';

        $product_row_id = "_product_row_id_set";

        $get_attr_post = $wpdb->get_results('SELECT * FROM  ' . $product_meta_table . ' WHERE meta_key ="' . $product_row_id . '" AND meta_value=' . $pro_id . '', ARRAY_A);
        if (!empty($get_attr_post)) {
            update_post_meta($get_attr_post[0]['post_id'], '_product_ass_attrs', $attr_data);
        }


        if (is_wp_error($get_attr_post)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }

    public function post_meta_attributes($assigned_val)
    {
        global $wpdb;
        $pro_row_id = $assigned_val['productrowid'];
        $attributerowid = $assigned_val['attributerowid'];
        $product_row_id = "_product_row_id_set";

        $product_group_table = $wpdb->prefix . 'postmeta';
        $product_attribute = $wpdb->prefix . 'cloudnet_product_attribute';

        $get_attr_post = $wpdb->get_results('SELECT * FROM  ' . $product_group_table . ' WHERE meta_key ="' . $product_row_id . '" AND meta_value=' . $pro_row_id . '', ARRAY_A);
        $get_attribute_name = $wpdb->get_results('SELECT * FROM  ' . $product_attribute . ' WHERE attributerowid=' . $attributerowid . '', ARRAY_A);

        foreach ($get_attr_post as $get_attr_post_id) {
            $attr_post_id = $get_attr_post_id['post_id'];
            if ($attr_post_id) {

                /* ---------NEED TO UPDATE CODE HERE FOR ASSINGMENT-------------- */
                foreach ($get_attribute_name as $get_att_name) {
                    $attribute_name = $get_att_name['attributename'];
                    /* -------FIX NEEDED---------- */
                    update_post_meta($attr_post_id, 'cloudnet_product_attribute', $attribute_name);
                }

                /* ---------NEED TO UPDATE CODE HERE FOR ASSINGMENT-------------- */
            }
        }


        if (is_wp_error($get_attr_post)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }



        if (is_wp_error($get_attribute_name)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }

    public function cnsync_insert_attribute_groups($group = array())
    {
        global $wpdb;
        $product_group_table = $wpdb->prefix . 'cloudnet_product_attribute_group';

        $result = $wpdb->replace($product_group_table, array(
            'grouprowid' => $group['grouprowid'],
            'groupname' => $group['groupname'],
            'isrequired' => $group['isrequired']
        ));


        if (is_wp_error($result)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }

    public function cnsync_insert_attribute_groups_options($options = array())
    {
        global $wpdb;
        $attribute_table = $wpdb->prefix . 'cloudnet_product_attribute';
        $result = $wpdb->replace($attribute_table, array(
            'attributeid' => '',
            'grouprowid' => $options['grouprowid'],
            'attributerowid' => $options['attributerowid'],
            'attributename' => $options['attributename'],
            'weight' => $options['weight']
        ));
        if (is_wp_error($result)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }

    public function cnsync_api_add_option()
    {
        $res = 0;
        if (isset($_POST)) {
            update_option('cloudnet_mar_api_key', $_POST['merchant_id']);
            update_option('cloudnet_mar_api_signature', $_POST['api_signature']);
            echo $res = 1;
        }
        //echo json_encode(array('response' => $res));
        wp_die();
    }

    public function cnsync_api_mpro_option()
    {
        $res = 0;
        if (isset($_POST)) {
            if ($_POST['mpro_data'] == 1) {
                $this->__create_page();
            } else {
                $this->__delete_page();
            }

            update_option('mpro', $_POST['mpro_data']);
            echo 1;
        }
        //echo json_encode(array('response' => $res));
        wp_die();
    }
    function searchForpost_title($id)
    {
        $array = get_pages();
        foreach ($array as $key => $val) {
            if ($val->post_title == $id) {
                return $val;
            }
        }
        return null;
    }



    /**
     * Add a post display state for special WC pages in the page list table.
     *
     * @param array   $post_states An array of post display states.
     * @param WP_Post $post        The current post object.
     */
    public function cnsync_add_display_post_states($states, $post)
    {
        if (get_page_by_slug('login') === $post->ID) {
            $states[$post->post_title] = $post->post_title;
        }

        if (get_page_by_slug('sign-Up') === $post->ID) {
            $states[$post->post_title] = $post->post_title;
        }

        if (get_page_by_slug('content-page') === $post->ID) {
            $states[$post->post_title] = $post->post_title;
        }

        if (get_page_by_slug('memberships') === $post->ID) {
            $states[$post->post_title] = $post->post_title;
        }
        return $states;
    }

    function post_list_dummy()
    {
        return array(
            _x('Login', 'Page slug', 'CloudNet360') => '[cloudnet_login_page]',
            'Sign Up' => '[cloudnet_sign_up_page]',
            'Content Page' => '[cloudnet_content]',
            'Memberships' => '[cloudnet_memberships]',
        );
    }
    function __delete_page()
    {
        $pages_array = $this->post_list_dummy();

        foreach ($pages_array as $page_title => $page_content) {

            if ($this->searchForpost_title($page_title)) {
                $data = $this->searchForpost_title($page_title);
                wp_delete_post($data->ID, true);
            }
        }
    }

    function __create_page()
    {
        $pages_array = $this->post_list_dummy();

        foreach ($pages_array as $page_title => $page_content) {

            $page_args = array(

                'post_type'      => 'page',

                'post_status'    => 'publish',

                'post_title'     => esc_sql(ucwords($page_title)),

                'post_name'      => strtolower(trim($page_title)),

                'post_content'   => $page_content,

            );
            wp_insert_post($page_args);
        }
    }

    public function cnsync_create_products_post_type()
    {
        $args = array(
            'labels' => array(
                'name' => 'Products',
                'singular_name' => 'Product',
                'all_items' => 'Products',
                'title' => 'Products',
                'menu_name' => 'CloudNet360 Products', 'admin menu', 'plugin-textdomain',
                'name_admin_bar' => 'Products', 'add new on admin bar', 'plugin-textdomain',
                'singular_name' => 'Products',
                'edit_item' => 'Edit My Products',
                'new_item' => 'New Products',
                'view_item' => 'View Products',
                'items_archive' => 'CN360 Products Archive',
                'search_items' => 'Search Product',
                'not_found' => 'No Products found',
                'not_found_in_trash' => 'No Products found in trash',
            ),
            //FOR disallow edit post "Add"
            'capabilities' => array(
                'create_posts' => 'do_not_allow', // false < WP 4.5, credit @Ewout
            ),
            'map_meta_cap' => true,
            'supports' => array('title', 'editor', 'author', 'comments', 'excerpt'),
            'show_in_menu' => false,
            'public' => true,
            'show_ui' => true,
            'menu_icon' => 'dashicons-cloud',
            'taxonomies' => array('cloudnet_category'),
            'show_tagcloud' => false,
            'menu_position' => 8,
            'hierarchical' => true
        );

        register_post_type('cloudnet_product', $args);


        register_taxonomy(
            'cloudnet_category',
            'cloudnet_product',
            array(
                'hierarchical' => true,
                'label' => 'CN360 Categories',
                'show_admin_column' => true,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => false,
                'singular_name' => 'CloudNet_categorie',
                "rewrite" => true,
                "query_var" => true
            )
        );

        register_taxonomy('cloudnet_tags', 'cloudnet_product', array(
            'hierarchical' => true,
            'label' => 'CN360 Tags',
            'singular_name' => 'CloudNet_tag',
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_menu' => false,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'cloudnet_tags'),
        ));
    }

    public function cnsync_create_member_ship_products_post_type()
    {
        $args = array(
            'labels' => array(
                'name' => 'MemberShip Products',
                'singular_name' => 'MemberShip Product',
                'all_items' => 'MemberShip Products',
                'title' => 'MemberShip Products',
                'menu_name' => 'CloudNet360 MemberShip Products', 'admin menu', 'plugin-textdomain',
                'name_admin_bar' => 'MemberShip Products', 'add new on admin bar', 'plugin-textdomain',
                'singular_name' => 'MemberShip Products',
                'edit_item' => 'Edit My MemberShip Products',
                'new_item' => 'New MemberShip Products',
                'view_item' => 'View MemberShip Products',
                'items_archive' => 'CN360 MemberShip Products Archive',
                'search_items' => 'Search MemberShip Product',
                'not_found' => 'No MemberShip Products found',
                'not_found_in_trash' => 'No MemberShip Products found in trash',
            ),
            //FOR disallow edit post "Add"
            'capabilities' => array(
                'create_posts' => 'do_not_allow', // false < WP 4.5, credit @Ewout
            ),
            'map_meta_cap' => true,
            'supports' => array('title', 'editor', 'author', 'comments', 'excerpt','thumbnail'),
            'show_in_menu' => false,
            'public' => true,
            'show_ui' => true,
            'menu_icon' => 'dashicons-cloud',
            'taxonomies' => array('cloudnet_m_s_category'),
            'show_tagcloud' => false,
            'menu_position' => 8,
            'hierarchical' => true
        );

        register_post_type('cloudnet_m_s_product', $args);


        register_taxonomy(
            'cloudnet_m_s_category',
            'cloudnet_m_s_product',
            array(
                'hierarchical' => true,
                'label' => 'CN360 MemberShip Categories',
                'show_admin_column' => true,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => false,
                'singular_name' => 'CloudNet_Member_Ship_categorie',
                "rewrite" => true,
                "query_var" => true
            )
        );


        register_taxonomy('cloudnet_member_ship_tags', 'cloudnet_m_s_product', array(
            'hierarchical' => true,
            'label' => 'CN360 Tags',
            'singular_name' => 'CloudNet_tag',
            'show_ui' => true,
            'show_admin_column' => true,
            'show_in_menu' => false,
            'update_count_callback' => '_update_post_term_count',
            'query_var' => true,
            'rewrite' => array('slug' => 'cloudnet_member_ship_tags'),
        ));

        $args2 = array(
            'labels' => array(
                'name' => 'MemberShip Content',
                'singular_name' => 'MemberShip Content',
                'all_items' => 'MemberShip Content',
                'title' => 'MemberShip Content',
                'menu_name' => 'CloudNet360 MemberShip Content', 'admin menu', 'plugin-textdomain',
                'name_admin_bar' => 'MemberShip Content', 'add new on admin bar', 'plugin-textdomain',
                'singular_name' => 'MemberShip Content',
                'edit_item' => 'Edit My MemberShip Content',
                'new_item' => 'New MemberShip Content',
                'view_item' => 'View MemberShip Content',
                'items_archive' => 'CN360 MemberShip Content Archive',
                'search_items' => 'Search MemberShip Content',
                'not_found' => 'No MemberShip Content found',
                'not_found_in_trash' => 'No MemberShip Content found in trash',
            ),
            //FOR disallow edit post "Add"
            // 'capabilities' => array(
            //     'create_posts' => 'do_not_allow', // false < WP 4.5, credit @Ewout
            // ),
            'map_meta_cap' => true,
            'supports' => array('title', 'editor', 'author', 'comments', 'excerpt','thumbnail','post-formats'),
            'show_in_menu' => false,
            'public' => true,
            'show_ui' => true,
            'menu_icon' => 'dashicons-cloud',
            'taxonomies' => array('cloudnet_m_s_content'),
            'show_tagcloud' => false,
            'menu_position' => 8,
            'hierarchical' => true
        );


        register_post_type('cloudnet_m_s_content', $args2);

        register_taxonomy(
            'cloudnet_content',
            'cloudnet_m_s_content',
            array(
                'hierarchical' => true,
                'label' => 'CN360 Content Categories',
                'show_admin_column' => true,
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => false,
                'singular_name' => 'CloudNet_Content_categorie',
                "rewrite" => true,
                "query_var" => true
            )
        );
    }

    function cloudnet_menu_highlight($parent_file)
    {
        global $submenu_file, $current_screen, $pagenow;

        $taxonomy = $current_screen->taxonomy;
        if ($taxonomy == 'cloudnet_category') {
            $parent_file = 'cloud_net';
            if ($pagenow == 'edit-tags.php') {
                $submenu_file = 'edit-tags.php?taxonomy=' . $taxonomy . '&post_type=' . $current_screen->post_type;
            }
        }

        if ($taxonomy == 'cloudnet_m_s_category') {
            $parent_file = 'member_ship';
            if ($pagenow == 'edit-tags.php') {
                $submenu_file = 'edit-tags.php?taxonomy=' . $taxonomy . '&post_type=' . $current_screen->post_type;
            }
        }

        if ($taxonomy == 'cloudnet_content') {
            $parent_file = 'member_ship';
            if ($pagenow == 'edit-tags.php') {
                $submenu_file = 'edit-tags.php?taxonomy=' . $taxonomy . '&post_type=' . $current_screen->post_type;
            }
        }

        return $parent_file;
    }

    function cloudnet_category_column_header($columns)
    {
        unset($columns);
        $columns['cb'] = 'input type="checkbox" />';
        $columns['name'] = 'Name';
        $columns['posts'] = 'count';
        $columns['product_layout'] = 'Layout';
        $columns['category_short_code'] = 'Short Code';
        return $columns;
    }

    function cloudnet_category_column_content($value, $column_name, $term_id)
    {

        if ($column_name == 'category_short_code') {
            $value .= '<div style="margin-bottom:3px;"><span id="col1' . $term_id . '">[cloudnet_category_product_1column_view term_id=' . $term_id . ']</span>  &nbsp;&nbsp;<span class="cn_controls">
                            <a href="javascript:void(0);" class="cn_copy"  title="Copy shortcode"  onclick="copyFunction(\'col1' . $term_id . '\')">
                                <span class="dashicons dashicons-editor-code"></span>
                            </a>
                        </div>';

            $value .= '<div style="margin-bottom:3px;"><span id="col3' . $term_id . '">[cloudnet_category_product_3column_view term_id=' . $term_id . ']</span> &nbsp;&nbsp;<span class="cn_controls">
                            <a href="javascript:void(0);" class="cn_copy"  title="Copy shortcode"  onclick="copyFunction(\'col3' . $term_id . '\')">
                                <span class="dashicons dashicons-editor-code"></span>
                            </a>
                        </div>';
        } else if ($column_name == 'product_layout') {
            $value .= '<div style="margin-top:1px;margin-bottom:3px;">1 Column <a class="Column1ToolTip" href="javascript:void(0)" title="" ><i class="fa fa-info-circle" aria-hidden="true" style="color:red;font-size: 14px;"></i></a></div>';
            $value .= '<div style="margin-top:1px;margin-bottom:3px;">3 Column <a class="Column3ToolTip" href="javascript:void(0)" title="" ><i class="fa fa-info-circle" aria-hidden="true" style="color:red;font-size: 14px;"></i></a></div>';
        }
        return $value;
    }


    function cloudnet_m_s_category_column_header($columns)
    {
        unset($columns);
        $columns['cb'] = 'input type="checkbox" />';
        $columns['name'] = 'Name';
        $columns['posts'] = 'count';
        $columns['product_layout'] = 'Layout';
        $columns['category_short_code'] = 'Short Code';
        return $columns;
    }

    function cloudnet_m_s_category_column_content($value, $column_name, $term_id)
    {

        if ($column_name == 'category_short_code') {
            $value .= '<div style="margin-bottom:3px;"><span id="col1' . $term_id . '">[cloudnet_m_s_category_product_1column_view term_id=' . $term_id . ']</span>  &nbsp;&nbsp;<span class="cn_controls">
                            <a href="javascript:void(0);" class="cn_copy"  title="Copy shortcode"  onclick="copyFunction(\'col1' . $term_id . '\')">
                                <span class="dashicons dashicons-editor-code"></span>
                            </a>
                        </div>';

            $value .= '<div style="margin-bottom:3px;"><span id="col3' . $term_id . '">[cloudnet_m_s_category_product_3column_view term_id=' . $term_id . ']</span> &nbsp;&nbsp;<span class="cn_controls">
                            <a href="javascript:void(0);" class="cn_copy"  title="Copy shortcode"  onclick="copyFunction(\'col3' . $term_id . '\')">
                                <span class="dashicons dashicons-editor-code"></span>
                            </a>
                        </div>';
        } else if ($column_name == 'product_layout') {
            $value .= '<div style="margin-top:1px;margin-bottom:3px;">1 Column <a class="Column1ToolTip" href="javascript:void(0)" title="" ><i class="fa fa-info-circle" aria-hidden="true" style="color:red;font-size: 14px;"></i></a></div>';
            $value .= '<div style="margin-top:1px;margin-bottom:3px;">3 Column <a class="Column3ToolTip" href="javascript:void(0)" title="" ><i class="fa fa-info-circle" aria-hidden="true" style="color:red;font-size: 14px;"></i></a></div>';
        }
        return $value;
    }

    function cloudnet_content_column_header($columns)
    {
        unset($columns);
        $columns['cb'] = 'input type="checkbox" />';
        $columns['name'] = 'Name';
        $columns['posts'] = 'count';
        $columns['product_layout'] = 'Layout';
        $columns['category_short_code'] = 'Short Code';
        return $columns;
    }

    function cloudnet_content_column_content($value, $column_name, $term_id)
    {

        if ($column_name == 'category_short_code') {
            $value .= '<div style="margin-bottom:3px;"><span id="col1' . $term_id . '">[cloudnet_content_1column_view term_id=' . $term_id . ']</span>  &nbsp;&nbsp;<span class="cn_controls">
                            <a href="javascript:void(0);" class="cn_copy"  title="Copy shortcode"  onclick="copyFunction(\'col1' . $term_id . '\')">
                                <span class="dashicons dashicons-editor-code"></span>
                            </a>
                        </div>';

            $value .= '<div style="margin-bottom:3px;"><span id="col3' . $term_id . '">[cloudnet_content_3column_view term_id=' . $term_id . ']</span> &nbsp;&nbsp;<span class="cn_controls">
                            <a href="javascript:void(0);" class="cn_copy"  title="Copy shortcode"  onclick="copyFunction(\'col3' . $term_id . '\')">
                                <span class="dashicons dashicons-editor-code"></span>
                            </a>
                        </div>';
        } else if ($column_name == 'product_layout') {
            $value .= '<div style="margin-top:1px;margin-bottom:3px;">1 Column <a class="Column1ToolTip" href="javascript:void(0)" title="" ><i class="fa fa-info-circle" aria-hidden="true" style="color:red;font-size: 14px;"></i></a></div>';
            $value .= '<div style="margin-top:1px;margin-bottom:3px;">3 Column <a class="Column3ToolTip" href="javascript:void(0)" title="" ><i class="fa fa-info-circle" aria-hidden="true" style="color:red;font-size: 14px;"></i></a></div>';
        }
        return $value;
    }

    function cloudnet_category_description_link($actions, $post)
    {
        if ($post->taxonomy == 'cloudnet_category') {
            $actions['category_description'] = '<a href="#" title="' . strip_tags($post->description) . '" rel="permalink">Description</a>';
        }
        return $actions;
    }



    public function cnsync_meta_box_add()
    {
        add_meta_box('cloudnet-meta-box-id', 'CloudNet Product Details', array($this, 'cnsync_meta_box_price_fields'), 'cloudnet_product', 'normal', 'high');
        add_meta_box('cloudnet-meta-box-image', 'Upload Product Media', array($this, 'cnsync_meta_box_image_fields'), 'cloudnet_product', 'normal', 'high');
        add_meta_box('cloudnet-meta-box-video', 'Upload Product Video', array($this, 'cnsync_meta_box_video_fields'), 'cloudnet_product', 'normal', 'high');

        /* ----------ATTRIBUTE META SETUP PANEL----------- */
        add_meta_box('cloudnet_product_meta_box', '<strong>CN360 Attribute Groups</strong>', array($this, 'cnsync_get_all_attribute_groups_and_value'), 'cloudnet_product', 'side', 'low');
        /* -ATTRIBUTE META SETUP PANEL- */
    }

    public function cnsync_meta_box_price_fields()
    {
        global $post;
        get_post_type();
        $post_id = $post->ID;
        include_once 'partials/cnsync_metabox.php';
    }

    public function cnsync_meta_box_image_fields()
    {
        global $post;
        get_post_type();
        $post_id = $post->ID;
        include_once 'partials/cnsync_metabox_for_images.php';
    }

    public function cnsync_meta_box_video_fields()
    {
        global $post;
        get_post_type();
        $post_id = $post->ID;
        include_once 'partials/cnsync_metabox_for_video.php';
    }

    public function cnsync_filter_post_type_by_taxonomy()
    {
        global $typenow;
        $post_type = 'cloudnet_product'; // change to your post type
        $taxonomy = 'cloudnet_category'; // change to your taxonomy
        if ($typenow == $post_type) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);
            wp_dropdown_categories(array(
                'show_option_all' => __("{$info_taxonomy->label}"),
                'taxonomy' => $taxonomy,
                'name' => $taxonomy,
                'orderby' => 'name',
                'selected' => $selected,
                'show_count' => true,
                'hide_empty' => true,
            ));
        };
    }

    public function cnsync_convert_id_to_term_in_query($query)
    {
        global $pagenow;
        $post_type = 'cloudnet_product'; // change to your post type
        $taxonomy = 'cloudnet_category'; // change to your taxonomy
        $q_vars = &$query->query_vars;
        if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }
    }

    /* --------------------------Cart---------- */

    public function cnsync_update_store_settings()
    {

        //*GETTING CATEGORY LIST OF CLOUDNET360*//
        $merchant_id = get_option('cloudnet_mar_api_key');
        $api_key = get_option('cloudnet_mar_api_signature');

        $target_url = 'https://www.secureinfossl.com/testapi/basicSettings.html';

        if (!empty($merchant_id) && !empty($api_key)) {
            $body = array('merchantid' => $merchant_id, 'api_signature' => $api_key);
            $request = new WP_Http();
            $response_full = $request->request($target_url, array('method' => 'POST', 'body' => $body));
            if (isset($response_full->errors)) {
                return array(500, 'Unknown Error');
            }
            $response_code = $response_full['response']['code'];
            if ($response_code === 200) {
                //convert xml string into an object
                $response = $response_full['body'];
                $xml = simplexml_load_string($response);
                //convert into json
                $json = json_encode($xml);
                //convert into associative array
                $cat_data = json_decode($json, true);
                update_option('cloudnet_store_currency', $cat_data['currency']);
                update_option('cloudnet_store_currencysymbol', $cat_data['currencysymbol']);
                update_option('cloudnet_store_productidprefix', $cat_data['productidprefix']);
                //wp_die();
            } else {
                echo 'Unexpected HTTP code: ', $response_code, "\n";
            }
        }
        /*
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $request = 'merchantid=' . urlencode($merchant_id);
        $request .= '&api_signature=' . urlencode($api_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HEADER, 0); // Display headers
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);

        $response = curl_exec($ch);
        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:
                    //convert xml string into an object
                    $xml = simplexml_load_string($response);
                    //convert into json
                    $json = json_encode($xml);
                    //convert into associative array
                    $cat_data = json_decode($json, true);
                    update_option('cloudnet_store_currency', $cat_data['currency']);
                    update_option('cloudnet_store_currencysymbol', $cat_data['currencysymbol']);
                    update_option('cloudnet_store_productidprefix', $cat_data['productidprefix']);
                    break;
                default:
                    echo 'Unexpected HTTP code: ', $http_code, "\n";
            }
        }*/
    }

    /*public function cnsync_get_data_from_category_api() {
        // GETTING CATEGORY LIST OF CLOUDNET360
        $merchant_id = get_option('cloudnet_mar_api_key');
        $api_key = get_option('cloudnet_mar_api_signature');
        $target_url = 'https://www.secureinfossl.com/testapi/categoryList.html';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $request = 'merchantid=' . urlencode($merchant_id);
        $request .= '&api_signature=' . urlencode($api_key);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HEADER, 0); // Display headers
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);

        $response = curl_exec($ch);
        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:
                    //convert xml string into an object
                    $xml = simplexml_load_string($response);
                    //convert into json
                    $json = json_encode($xml);
                    //convert into associative array
                    $cat_data = json_decode($json, true);
                    $this->cnsync_put_category_data($cat_data);
                    break;
                default:
                    echo 'Unexpected HTTP code: ', $http_code, "\n";
            }
        }
    }*/

    public function cnsync_get_data_from_category_api()
    {
        $merchant_id = get_option('cloudnet_mar_api_key');
        $api_key = get_option('cloudnet_mar_api_signature');
        $target_url = 'https://www.secureinfossl.com/testapi/categoryList.html';
        $body = array('merchantid' => $merchant_id, 'api_signature' => $api_key);
        $request = new WP_Http();
        $response_full = $request->request($target_url, array('method' => 'POST', 'body' => $body));
        if (isset($response_full->errors)) {
            return array(500, 'Unknown Error');
        }
        $response_code = $response_full['response']['code'];
        if ($response_code === 200) {
            //convert xml string into an object
            $response = $response_full['body'];
            $xml = simplexml_load_string($response);
            //convert into json
            $json = json_encode($xml);
            //convert into associative array
            $cat_data = json_decode($json, true);
            $this->cnsync_put_category_data($cat_data);
        } else {
            echo 'Unexpected HTTP code: ', $response_code, "\n";
        }
    }

    public function cnsync_put_category_data($cat_data = array())
    {

        foreach ($cat_data['categories'] as $category_value) {
            $count = count($category_value);

            if ($count > 0) {
                $this->cnsync_insert_category_data_cloudnet($category_value);
            }
        }
    }

    public function cnsync_insert_category_data_cloudnet($category = array())
    {
        global $wpdb;
        $category_id = $category['categoryid'];
        $categroy_title = $category['categorytitle'];
        $term_data = $wpdb->get_results("SELECT * FROM `wp_terms` WHERE  name = '$categroy_title'", ARRAY_A);
        $count_name = count($term_data);

        if ($count_name == 0) {
            $terms = wp_insert_term(
                $categroy_title, // the term 
                'cloudnet_category', // the taxonomy
                array(
                    'slug' => $categroy_title,
                )
            );
            /* --------Updated By saurabh sir--------- */
            if (!is_wp_error($terms)) {
                update_term_meta($terms['term_id'], $categroy_title, $category_id, FALSE);
            } elseif (is_wp_error($terms)) {
                return true;
            }
        }
        if (is_wp_error($term_data)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }

    //add option for category.
    public function cnsync_cat_api_add_option()
    {
        $response = 0;
        if (!get_option('cloudnet_cat_api_key') && !get_option('cloudnet_cat_api_signature')) {
            if (add_option('cloudnet_cat_api_key', 'MER-00002') && add_option('cloudnet_cat_api_signature', 'VjJOU053RTNWRE1GWlFkdFV6VUhNQVl4QWpCVE1BPT0=')) {
                $response = 1;
            }
        } else {
            if (update_option('cloudnet_cat_api_key', 'MER-00002') || update_option('cloudnet_cat_api_signature', 'VjJOU053RTNWRE1GWlFkdFV6VUhNQVl4QWpCVE1BPT0=')) {
                $response = 1;
            }
        }
        echo json_encode(array('response' => $response));
        wp_die();
    }

    public function cnsync_delete_data()
    {
        global $wpdb;
        $arr = array(
            'post_status' => 'any',
            'post_type' => 'cloudnet_product',
            'posts_per_page' => -1,
        );
        $terms = get_terms([
            'taxonomy' => 'cloudnet_category',
            'hide_empty' => false,
        ]);
        foreach ($terms as $term) {
            wp_delete_term($term->term_id, 'cloudnet_category');
        }

        $terms = get_terms([
            'taxonomy' => 'cloudnet_m_s_category',
            'hide_empty' => false,
        ]);
        foreach ($terms as $term) {
            wp_delete_term($term->term_id, 'cloudnet_m_s_category');
        }

        $posts = get_posts($arr);
        foreach ($posts as $posts_val) {
            $post_id = $posts_val->ID;
            wp_delete_post($post_id, true);
            delete_post_meta($post_id, '_product_no', '');
            delete_post_meta($post_id, '_product_row_id', '');
            delete_post_meta($post_id, '_product_link_id', '');
            delete_post_meta($post_id, '_sku', '');
            delete_post_meta($post_id, '_price', '');
            delete_post_meta($post_id, '_shortdesc', '');
            delete_post_meta($post_id, '_categoryid', '');
            delete_post_meta($post_id, '_regularbuylink', '');
            delete_post_meta($post_id, '_oneclickbuylink', '');
            delete_post_meta($post_id, '_imagepath', '');
            //delete_post_meta($post_id, '_product_ass_attrs', '');
        }

        $arr = array(
            'post_status' => 'any',
            'post_type' => 'cloudnet_m_s_product',
            'posts_per_page' => -1,
        );

        $posts = get_posts($arr);
        foreach ($posts as $posts_val) {
            $post_id = $posts_val->ID;
            wp_delete_post($post_id, true);
            delete_post_meta($post_id, '_product_no', '');
            delete_post_meta($post_id, '_product_row_id', '');
            delete_post_meta($post_id, '_product_link_id', '');
            delete_post_meta($post_id, '_sku', '');
            delete_post_meta($post_id, '_price', '');
            delete_post_meta($post_id, '_shortdesc', '');
            delete_post_meta($post_id, '_categoryid', '');
            delete_post_meta($post_id, '_regularbuylink', '');
            delete_post_meta($post_id, '_oneclickbuylink', '');
            delete_post_meta($post_id, '_imagepath', '');
            //delete_post_meta($post_id, '_product_ass_attrs', '');
        }
        // category
        $this->cnsync_get_data_from_category_api();
        $this->cnsync_get_data_from_category_membership_pro_api();
        // category
        // product
        $this->cnsync_get_data_membership_pro_from_api();
        $this->cnsync_get_data_from_api();
        // product




        // $this->cnsync_delete_all_attribute_data();

        // echo json_encode(array('del_res' => 1));
        // wp_die();
    }

    public function cnsync_get_data_membership_pro_from_api()
    {

        $merchant_id = get_option('cloudnet_mar_api_key');
        $merchant_row_id = preg_replace('/\D+/', '', $merchant_id);
        $api_key = get_option('cloudnet_mar_api_signature');

        $target_url = 'https://www.secureinfossl.com/api/product_membership_pro.html';

        if (!empty($merchant_id) && !empty($api_key)) {
            $body = array('merchant_row_id' => $merchant_row_id);
            $request = new WP_Http();
            $response_full = $request->request($target_url, array('method' => 'POST', 'body' => $body));
            if (isset($response_full->errors)) {
                return array(500, 'Unknown Error');
            }
            $response_code = $response_full['response']['code'];
            if ($response_code === 200) {
                //convert xml string into an object
                $response = $response_full['body'];
                $xml = simplexml_load_string($response);
                //convert into json
                $json = json_encode($xml);
                //convert into associative array
                $pro_data = json_decode($json, true);
                $res_main = $this->cnsync_get_product_membership_pro_data($pro_data);
                // wp_die();
            } else {
                echo 'Unexpected HTTP code: ', $response_code, "\n";
            }
        }
    }

    public function cnsync_get_product_membership_pro_data($pro_data = array())
    {
        $products_loop = '';
        $prod_live_set = $pro_data['productcount']['totalcount'];

        /* ----------CHECK THE LIVE ARRAY STATUS--- */
        if ($prod_live_set == 1) {
            $products_loop = $pro_data['products'];
        } else {
            $products_loop = $pro_data['products']['product'];
        }
        /* ----------CHECK THE LIVE ARRAY STATUS--- */



        /* ----------INSRET PRODUCTS THE LOOP ----------- */
        foreach ($products_loop as $product_value) {

            $this->cnsync_insert_product_membership_pro_data_cloud($product_value);
        }



        /* -------------------------------------------- */
    }

    public function cnsync_insert_product_membership_pro_data_cloud($product)
    {
        global $wpdb;
        $sku = $product['sku'];
        $tablename_log = $wpdb->prefix . 'cloudnet_products';
        $pro_name = base64_decode($product['name']);
        // $longdesc = base64_decode($product['longdesc']);

        if (empty($product['shortdesc'])) {
            $shortdesc = ' ';
        } else {
            $shortdesc = base64_decode($product['shortdesc']);
            $shortdesc = $this->cnsync_rip_tags($shortdesc);
        }

        $product_link_id = base64_decode($product['product_link_id']);

        $cat_id = $product['categoryid'];
        $term_data = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'termmeta as wt join wp_term_taxonomy as wtt on wtt.term_id = wt.term_id and wtt.taxonomy = "cloudnet_m_s_category" WHERE wt.meta_value = ' . $cat_id . ' LIMIT 1', ARRAY_A);
        // 
        // write_log($term_data);
        $tID = !empty($term_data) ? $term_data[0]['term_id'] : '';

        if (!empty($tID)) {
            $term = get_term($tID, 'cloudnet_m_s_category');

            $cat_name = $term->slug;
        }


        $lon = $this->cnsync_rip_tags((!empty($product['longdesc']) ? base64_decode($product['longdesc']) : true));
        $post_id = $this->cnsync_get_post_id_by_meta_key_and_value('_product_row_id_set', $product['product_row_id']);

        if (!$post_id) {

            $post_id = wp_insert_post(array(
                'post_type' => 'cloudnet_m_s_product',
                'post_title' => trim($pro_name),
                'post_content' => $lon,
                'post_status' => 'publish',
                'comment_status' => 'closed',
                'ping_status' => 'closed'
            ));
        } else {

            $my_post = array();
            $my_post['ID'] = $post_id;
            $my_post['post_title'] = trim($pro_name);
            $my_post['post_content'] = $lon;
            wp_update_post($my_post);
        }



        if ($post_id != '') {
            //insert post 
            wp_set_object_terms($post_id, $cat_name, 'cloudnet_m_s_category', true);

            $product_order_meta_value = get_post_meta($post_id, 'cloudnet_product_order_' . $tID, true);
            if (empty($product_order_meta_value)) {
                update_post_meta($post_id, 'cloudnet_product_order_' . $tID, 1);
            }
            if ($product['product_no'] != '')
                update_post_meta($post_id, '_product_no', $product['product_no']);
            if (!empty($product['product_row_id'])) {
                $input = $product['product_row_id'];
                //Product ID:
                $name = str_pad($input, 5, "0", STR_PAD_LEFT);
                $pr_id = "PRO-" . $name;
                update_post_meta($post_id, '_product_row_id', $pr_id);
                update_post_meta($post_id, '_product_row_id_set', $input);
            }

            if ($product['product_link_id'] != '')
                update_post_meta($post_id, '_product_link_id', $product['product_link_id']);
            if (!empty($product['sku']))
                update_post_meta($post_id, '_sku', $product['sku']);
            if (!empty($product['price']))
                update_post_meta($post_id, '_price', $product['price']);
            if (!empty($product['shortdesc']))
                update_post_meta($post_id, '_shortdesc', $shortdesc);
            if (!empty($product['categoryid']))
                update_post_meta($post_id, '_categoryid', $product['categoryid']);
            if (!empty($product['regularbuylink']))
                update_post_meta($post_id, '_regularbuylink', $product['regularbuylink']);
            if (!empty($product['regularbuylink']))
                update_post_meta($post_id, '_oneclickbuylink', $product['regularbuylink']);
            if (!empty($product['imagepath']))
                update_post_meta($post_id, '_imagepath', $product['imagepath']);

            $table_log_drop = "select * from wp_cloudnet_products where product_link_id = '" . trim($product['product_link_id']) . "'";
            if ($wpdb->query($table_log_drop) == 0) {
                $data = $wpdb->insert(
                    $tablename_log,
                    array(
                        'sku' => $product['sku'] != null ? trim($product['sku']) : null,
                        'product_no' => trim($product['product_no']),
                        'product_link_id' => trim($product['product_link_id'])
                    ),
                    array('%s', '%s', '%s')
                );


                if (is_wp_error($data)) {
                    $error_string = $wpdb->get_error_messages();
                    echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
                }
            }
        }

        if (is_wp_error($post_id)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
        if (is_wp_error($term_data)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }

    public function cnsync_get_data_from_category_membership_pro_api()
    {
        $merchant_id = get_option('cloudnet_mar_api_key');
        $merchant_row_id = preg_replace('/\D+/', '', $merchant_id);
        $target_url = 'https://www.secureinfossl.com/api/category_membership_pro.html';
        $body = array('merchant_row_id' => $merchant_row_id,);
        $request = new WP_Http();
        $response_full = $request->request($target_url, array('method' => 'POST', 'body' => $body));
        if (isset($response_full->errors)) {
            return array(500, 'Unknown Error');
        }
        $response_code = $response_full['response']['code'];
        if ($response_code === 200) {
            //convert xml string into an object
            $response = $response_full['body'];
            //convert into associative array
            $cat_data = json_decode($response, true);
            $this->cnsync_put_category_membership_pro_data($cat_data);
        } else {
            echo 'Unexpected HTTP code: ', $response_code, "\n";
        }
    }

    public function cnsync_put_category_membership_pro_data($cat_data = array())
    {

        foreach ($cat_data as $category_value) {
            $count = count($category_value);

            if ($count > 0) {
                $this->cnsync_insert_category_membership_pro_data_cloudnet($category_value);
            }
        }
    }

    public function cnsync_insert_category_membership_pro_data_cloudnet($category = array())
    {
        global $wpdb;
        $category_id = $category['category_id'];
        $categroy_title = $category['category_description'];
        $term_data = $wpdb->get_results("SELECT * FROM `wp_terms` as wt join wp_term_taxonomy as wtt on wtt.term_id = wt.term_id and wtt.taxonomy = 'cloudnet_m_s_category' WHERE wt.name = '$categroy_title'", ARRAY_A);
        $count_name = count($term_data);

        if ($count_name == 0) {
            $terms = wp_insert_term(
                $categroy_title, // the term 
                'cloudnet_m_s_category', // the taxonomy
                array(
                    'slug' => $categroy_title,
                )
            );
            /* --------Updated By saurabh sir--------- */
            if (!is_wp_error($terms)) {
                update_term_meta($terms['term_id'], $categroy_title, $category_id, FALSE);
            } elseif (is_wp_error($terms)) {
                return true;
            }
        }
        if (is_wp_error($term_data)) {
            $error_string = $wpdb->get_error_messages();
            echo '<div id="message" class="error"><p>' . $error_string . '</p></div>';
        }
    }

    public function cnsync_delete_all_attribute_data()
    {
        global $wpdb;
        $attribute_table = $wpdb->prefix . 'cloudnet_product_attribute';
        $product_group_table = $wpdb->prefix . 'cloudnet_product_attribute_group';
        $delete1 = $wpdb->query("TRUNCATE TABLE $attribute_table");
        $delete2 = $wpdb->query("TRUNCATE TABLE $product_group_table");
    }

    public function cnsync_gall_save_post($post_id, $post)
    {
        global $post;
        $gallery_array = array();
        $uploadfiles = !@$_FILES['cloudnet_gallery'];
        $cncustompost = @$_POST['cncustompost'];

        if (isset($_POST['cncustompost'])) {
            update_post_meta($post_id, '_shortdesc', $cncustompost);
        }
        /*if (!empty($uploadfiles) && count($uploadfiles) > 0) {
            if (is_array($uploadfiles)) {
                foreach ($uploadfiles['name'] as $key => $value) {
                    // look only for uploded files
                    if ($uploadfiles['error'][$key] == 0) {
                        $filetmp = $uploadfiles['tmp_name'][$key];
                        //clean filename and extract extension
                        $filename = $uploadfiles['name'][$key];
                        // get file info
                        // @fixme: wp checks the file extension....
                        $filetype = wp_check_filetype(basename($filename), null);
                        $filetitle = preg_replace('/\.[^.]+$/', '', basename($filename));

                        $filename = uniqid() . '.' . $filetype['ext'];
                        $upload_dir = wp_upload_dir();

                        
                        $i = 0;
                        while (file_exists($upload_dir['path'] . '/' . $filename)) {
                            $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
                            $i++;
                        }

                        $filedest = $upload_dir['path'] . '/' . $filename;
                        
                        if (!is_writeable($upload_dir['path'])) {
                            $this->msg_e('Unable to write to directory %s. Is this directory writable by the server?');
                            return;
                        }
                        
                        if (!@move_uploaded_file($filetmp, $filedest)) {
                            $this->msg_e("Error, the file $filetmp could not moved to : $filedest ");
                            continue;
                        }
                        $attachment = array(
                            'post_mime_type' => $filetype['type'],
                            'post_title' => $filetitle,
                            'post_content' => '',
                            'post_status' => 'inherit'
                        );

                        $attach_id = wp_insert_attachment($attachment, $filedest);
                        require_once( ABSPATH . "wp-admin" . '/includes/image.php');
                        $attach_data = wp_generate_attachment_metadata($attach_id, $filedest);
                        wp_update_attachment_metadata($attach_id, $attach_data);
                        array_push($gallery_array, $attach_id);
                    }
                }
            }

            if (!empty($gallery_array) && count($gallery_array) > 0) {

                $gallery_img = get_post_meta($post_id, 'cloudnet_attachment_gallery_key', true);
                if (!empty($gallery_img)) {
                    
                    $result = array_merge($gallery_img, $gallery_array);
                    update_post_meta($post_id, 'cloudnet_attachment_gallery_key', $result);
                } else {
                    update_post_meta($post_id, 'cloudnet_attachment_gallery_key', $gallery_array);
                }
            }
        }*/
        if (isset($_POST['productImage'])) {
            $product_images = $_POST['productImage'];
            foreach ($product_images as $attach_id) {
                array_push($gallery_array, $attach_id);
            }
            if (!empty($gallery_array) && count($gallery_array) > 0) {

                $gallery_img = get_post_meta($post_id, 'cloudnet_attachment_gallery_key', true);
                if (!empty($gallery_img)) {

                    $result = array_merge($gallery_img, $gallery_array);
                    update_post_meta($post_id, 'cloudnet_attachment_gallery_key', $result);
                } else {
                    update_post_meta($post_id, 'cloudnet_attachment_gallery_key', $gallery_array);
                }
            }
        }

        $_product_row_id_set = get_post_meta($post_id, '_product_row_id_set', true);

        $gallery_img = get_post_meta($post_id, 'cloudnet_attachment_gallery_key', true);
        if (!empty($gallery_img[0])) {
            $set_primary_image = wp_get_attachment_url($gallery_img[0]);
            $this->cnsync_set_primary_image($set_primary_image, $_product_row_id_set);
        }

        //*****************update video into postmeta*****************/
        if (!empty($_POST['cloudnet_videos'])) {
            $video_url = $_POST['cloudnet_videos'];
            $cloudnet_videos = get_post_meta($post_id, 'cloudnet_videos_key', true);
            if (!empty($cloudnet_videos)) {
                foreach ($video_url as $vdurl) {
                    if (!empty($vdurl))
                        array_push($cloudnet_videos, trim($vdurl));
                }
                update_post_meta($post_id, 'cloudnet_videos_key', $cloudnet_videos);
            } else {
                update_post_meta($post_id, 'cloudnet_videos_key', $video_url);
            }
        }
        if (isset($_POST['video_short_series']) && !empty($_POST['video_short_series'])) {
            $video_short_series = $_POST['video_short_series'];
            $v_series = explode(',', $video_short_series);
            if (count($v_series) > 0) {
                update_post_meta($post_id, 'cloudnet_videos_short_series', $v_series);
            }
        }
        /* ------------------------------------------------------------ */
    }

    public function cnsync_set_primary_image($primary_image_url, $pwc_product_row_id)
    {
        // GETTING CATEGORY LIST OF CLOUDNET360
        $merchant_id = get_option('cloudnet_mar_api_key');
        $api_key = get_option('cloudnet_mar_api_signature');
        $target_url = 'https://secureinfossl.com/testapi/addProductImageFromWP.html';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);
        $request = 'merchantid=' . urlencode($merchant_id);
        $request .= '&api_signature=' . urlencode($api_key);
        $request .= '&pwc_product_row_id=' . urlencode($pwc_product_row_id);
        $request .= '&primary_image_url=' . urlencode($primary_image_url);


        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HEADER, 0); // Display headers
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);

        $response = curl_exec($ch);
        if (!curl_errno($ch)) {
            switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
                case 200:
                    //convert xml string into an object
                    $xml = simplexml_load_string($response);
                    //convert into json
                    $json = json_encode($xml);
                    //convert into associative array
                    $prod_data = json_decode($json, true);
                    break;
                default:
                    echo 'Unexpected HTTP code: ', $http_code, "\n";
            }
        }
    }

    public function cnsync_add_edit_form_multipart_encoding()
    {
        echo 'enctype="multipart/form-data"';
    }

    public function cnsync_delete_attachment()
    {

        $post_id = $_POST['post_id'];
        $id = $_POST['id'];
        $img_arr = get_post_meta($post_id, 'cloudnet_attachment_gallery_key', true);

        $shotred_series = get_post_meta($post_id, '_shotred_series', true);
        $srt_arrya = explode(',', $shotred_series);


        $key1 = array_search($id, $img_arr);
        unset($img_arr[$key1]);

        $key2 = array_search($id, $srt_arrya);
        unset($srt_arrya[$key2]);

        if (update_post_meta($post_id, 'cloudnet_attachment_gallery_key', $img_arr)) {
            update_post_meta($post_id, '_shotred_series', $srt_arrya);

            wp_delete_attachment($id, true);
            //delete image from folder

            $c = get_post_meta($post_id, 'cloudnet_attachment_gallery_key', true);
            if (!empty($c)) {
                echo '1';
            } else {
                echo '0';
            }
        }
        wp_die();
    }

    /* -----------------video upload from here --------------------- */

    public function cnsync_delete_video_attachment()
    {

        $post_id = $_POST['post_id'];
        $url = $_POST['url'];

        $video_urls = get_post_meta($post_id, 'cloudnet_videos_key', true);
        $cloudnet_videos_short_series = get_post_meta($post_id, 'cloudnet_videos_short_series', true);
        $vd_exp = explode(',', $cloudnet_videos_short_series);

        $key1 = array_search($url, $video_urls);
        $key2 = array_search($url, $vd_exp);

        unset($video_urls[$key1]);
        unset($vd_exp[$key2]);


        if (update_post_meta($post_id, 'cloudnet_videos_key', $video_urls)) {
            update_post_meta($post_id, 'cloudnet_videos_short_series', $vd_exp);
            $c = get_post_meta($post_id, 'cloudnet_videos_key', true);
            if (!empty($c)) {
                echo '1';
            } else {
                echo '0';
            }
        }
        wp_die();
    }

    public function cnsync_rip_tags($str)
    {
        $string = strip_tags($str);
        $string = html_entity_decode($string);
        // ----- remove HTML TAGs ----- 
        $string = preg_replace('/<[^>]*>/', ' ', $string);
        // ----- remove control characters ----- 
        $string = str_replace("\r", '', $string);    // --- replace with empty space
        $string = str_replace("\n", ' ', $string);   // --- replace with space
        $string = str_replace("\t", ' ', $string);   // --- replace with space
        // ----- remove multiple spaces ----- 
        $string = trim(preg_replace('/ {2,}/', ' ', $string));
        return $string;
    }

    public function cnsync_update_postmeta_video_short()
    {
        $r = 0;
        if (isset($_POST)) {
            $video_id = $_POST['meta_value'];
            $post_id = $_POST['post_id'];
            if (update_post_meta($post_id, 'cloudnet_videos_key', $video_id)) {
                $r = 1;
            }
        }
        echo $r;
        wp_die();
    }
    public function cnsync_update_postmeta_image_short()
    {
        $r = 0;
        if (isset($_POST)) {
            $img_id = $_POST['meta_value'];
            $post_id = $_POST['post_id'];
            if (update_post_meta($post_id, 'cloudnet_attachment_gallery_key', $img_id)) {
                $r = 1;
            }
        }
        echo $r;
        wp_die();
    }

    public function cnsync_disable_editors($post)
    {
        global $submenu_file, $current_screen, $pagenow, $_wp_post_type_features;

        $post_type = "cloudnet_product";
        $feature = "editor";
        if ($pagenow == 'post.php' && $post->post_type == $post_type) {

            if (isset($_wp_post_type_features[$post_type][$feature])) {

                remove_post_type_support($post_type, $feature);
                //echo get_post_field('post_content', $post_id);
                echo '<div class="welcome-panel">
        <div class="welcome-panel-content">
            <div class="tab-content">
     				<div class="tab-pane fade in active">
     					<div class="text-box-row">
                        	<div><label>Long Description:</label></div> ';
                echo nl2br($post->post_content);
                echo '</div>
                	</div>
                	 </div>
        </div>
    </div>';
            }
        }
    }

    function cnsync_enqueue_admin()
    {
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');

        wp_enqueue_script('media-upload');
    }

    function cnsync_get_post_id_by_meta_key_and_value($key, $value)
    {
        global $wpdb;
        $meta = $wpdb->get_results("SELECT * FROM `" . $wpdb->postmeta . "` WHERE meta_key='" . esc_sql($key) . "' AND meta_value='" . esc_sql($value) . "'");
        if (is_array($meta) && !empty($meta) && isset($meta[0])) {
            $meta = $meta[0];
        }
        if (is_object($meta)) {
            return $meta->post_id;
        } else {
            return false;
        }
    }


    function set_custom_cloudnet_product_columns($columns)
    {
        unset($columns['author']);
        unset($columns['comments']);
        if (isset($_GET['cloudnet_category']) && $_GET['cloudnet_category'] != '')
            $columns['product_order'] = __('Product Order');


        return $columns;
    }



    function manage_cloudnet_product_columns($column)
    {
        global $post;
        if ($column == 'product_order') {
            $catObj = get_term_by('slug', $_GET['cloudnet_category'], 'cloudnet_category');
            $catID = $catObj->term_id;
            $meta_value = get_post_meta($post->ID, 'cloudnet_product_order_' . $catID, true);
            echo '<input type="text" size="10" name="textOrd' . $post->ID . '" onkeypress="return event.charCode === 0 || /\d/.test(String.fromCharCode(event.charCode));" maxlength="3" value="' . $meta_value . '">';
        }
    }

    function custom_js_to_head()
    {

        if (isset($_GET['cloudnet_category']) && $_GET['cloudnet_category'] != '') {
            //$catObj = get_category_by_slug($_GET['cloudnet_category']); 
            //print_r($catObj);
            $catObj = get_term_by('slug', $_GET['cloudnet_category'], 'cloudnet_category');
            $catName = $catObj->name;
            $catID = $catObj->term_id;
?>
            <script>
                jQuery(function() {
                    jQuery("body.post-type-cloudnet_product .tablenav-pages").prepend('<div style="float:left;padding-right:7px"><input type="button" class="button button-primary button-large" value="Save Order" id="save-order" onclick="doSaveOrder()" style="height: 28px !important;line-height: 25px;box-shadow: 0 0 0 !important;"/><div>');

                    jQuery("body.post-type-cloudnet_product .wrap h1").append('&nbsp;in Category: <?= $catName ?>');
                    jQuery("#posts-filter").append('<input type="hidden" name="cn_category_id" class="post_status_page" value="<?= $catID ?>">');
                });
            </script>
        <?php
        } else if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'cloudnet_category') {
        ?>
            <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js?ver=1.0.0'></script>
            <script type='text/javascript' src='<?php echo CN360_SYNC__PLUGIN_URL; ?>admin/js/jquery-ui.js?ver=1.0.0'></script>
            <script>
                var $j = jQuery.noConflict(true);
                jQuery(function() {
                    //console.log(jQuery().jquery); // This prints v1.4.2
                    //console.log($j().jquery); // This prints v1.9.1
                    $j(".Column1ToolTip").tooltip({
                        content: '<img src="<?php echo CN360_SYNC__PLUGIN_URL; ?>admin/images/one-column.jpg" />'
                    });
                    $j(".Column3ToolTip").tooltip({
                        content: '<img src="<?php echo CN360_SYNC__PLUGIN_URL; ?>admin/images/three-column-layout.jpg" />'
                    });
                });
            </script>
        <?php
        } else if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'cloudnet_m_s_category') {
        ?>
            <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js?ver=1.0.0'></script>
            <script type='text/javascript' src='<?php echo CN360_SYNC__PLUGIN_URL; ?>admin/js/jquery-ui.js?ver=1.0.0'></script>
            <script>
                var $j = jQuery.noConflict(true);
                jQuery(function() {
                    //console.log(jQuery().jquery); // This prints v1.4.2
                    //console.log($j().jquery); // This prints v1.9.1
                    $j(".Column1ToolTip").tooltip({
                        content: '<img src="<?php echo CN360_SYNC__PLUGIN_URL; ?>admin/images/one-column.jpg" />'
                    });
                    $j(".Column3ToolTip").tooltip({
                        content: '<img src="<?php echo CN360_SYNC__PLUGIN_URL; ?>admin/images/three-column-layout.jpg" />'
                    });
                });
            </script>
        <?php
        } else if (isset($_GET['taxonomy']) && $_GET['taxonomy'] == 'cloudnet_content') { ?>

            <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js?ver=1.0.0'></script>
            <script type='text/javascript' src='<?php echo CN360_SYNC__PLUGIN_URL; ?>admin/js/jquery-ui.js?ver=1.0.0'></script>
            <script>
                var $j = jQuery.noConflict(true);
                jQuery(function() {
                    //console.log(jQuery().jquery); // This prints v1.4.2
                    //console.log($j().jquery); // This prints v1.9.1
                    $j(".Column1ToolTip").tooltip({
                        content: '<img src="<?php echo CN360_SYNC__PLUGIN_URL; ?>admin/images/one-column.jpg" />'
                    });
                    $j(".Column3ToolTip").tooltip({
                        content: '<img src="<?php echo CN360_SYNC__PLUGIN_URL; ?>admin/images/three-column-layout.jpg" />'
                    });
                });
            </script>
        <?php
        }
    }



    function cn_save_order_action_hook_function()
    {
        // do something
        //Array ( [s] => [post_status] => all [post_type] => cloudnet_product [_wpnonce] => 91d394adc8 [_wp_http_referer] => /wordpress/wp-admin/edit.php?post_type=cloudnet_product&cloudnet_category=category1 [action] => cn_save_order [m] => 0 [cloudnet_category] => 0 [paged] => 1 [textOrd24] => 4 [textOrd26] => [textOrd27] => 2 [textOrd28] => [action2] => -1 [cn_category_id] => 20 )
        //print_r($_POST);
        if (isset($_POST['cn_category_id']) && $_POST['cn_category_id'] != '') {
            $posts = get_posts(
                array(
                    'posts_per_page' => -1,
                    'post_type' => 'cloudnet_product',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'cloudnet_category',
                            'field' => 'term_id',
                            'terms' => $_POST['cn_category_id'],
                        )
                    )
                )
            );
            foreach ($posts as $value) {
                $post_id = $value->ID;
                //echo $_POST['textOrd'.$post_id].'<br/>';
                //$meta_value = get_post_meta($post_id, 'cloudnet_product_order_'.$_POST['cn_category_id'], true);
                //if( !empty($meta_value) ) {
                update_post_meta($post_id, 'cloudnet_product_order_' . $_POST['cn_category_id'], $_POST['textOrd' . $post_id]);
                /*}else {
   					add_post_meta( $post_id, 'cloudnet_product_order_'.$_POST['cn_category_id'], $_POST['textOrd'.$post_id]);
				}*/
            }
        }
        wp_safe_redirect($_POST['_wp_http_referer']);
        //echo 'saved'; exit();
    }

    function cn_save_post_callback($post_id)
    {
        global $post;
        if (@$post->post_type == 'cloudnet_product') {
            $arrCategories = $_POST['tax_input']['cloudnet_category']; //$_POST['tax_input[cloudnet_category]'];
            foreach ($arrCategories as $catId) {
                if ($catId > 0) {
                    $product_order_meta_value = get_post_meta($post_id, 'cloudnet_product_order_' . $catId, true);
                    if (empty($product_order_meta_value)) {
                        update_post_meta($post_id, 'cloudnet_product_order_' . $catId, 1);
                    }
                }
            }
        }
        wp_cache_flush();
    }

    function cn_save_survey_post_callback($post_id)
    {
        global $post;
        if (@$post->post_type == 'cloudnet_product') {
            $arrCategories = $_POST['tax_input']['cloudnet_category']; //$_POST['tax_input[cloudnet_category]'];
            foreach ($arrCategories as $catId) {
                if ($catId > 0) {
                    $product_order_meta_value = get_post_meta($post_id, 'cloudnet_product_order_' . $catId, true);
                    if (empty($product_order_meta_value)) {
                        update_post_meta($post_id, 'cloudnet_product_order_' . $catId, 1);
                    }
                }
            }
        }
        wp_cache_flush();
    }
}
class ExtraRun
{
    public function init()
    {
        add_filter('admin_init', array($this, 'show_hide_acf_menu'));
        add_action('rest_api_init', array($this, 'adduser_api_init'));
        add_action('add_meta_boxes', array($this, 'membership_add_custom_box'));
        add_action('save_post', array($this, 'membership_save_postdata'));
        add_action('admin_footer', array($this, 'my_action_javascript'));
    }

    public function adduser_api_init()
    {
        register_rest_route('cnsync/v1', 'createuser', array(
            'methods' => 'POST',
            'callback' => array($this, 'register_user')
        ));
    }

    public function register_user(WP_REST_Request $request)
    {
        $params = $request->get_params();

        if (empty($params['username']) || empty($params['password']) || empty($params['email'])) {
            return new WP_Error('mssing_params', 'Missing Params', array('status' => 422));
        }
        $user_wp = wp_create_user($params['username'], $params['password'], $params['email']);

        if (is_wp_error($user_wp)) {
            $error = $user_wp->get_error_message();
            return wp_send_json_error($error, 400);
        }
        $user = get_user_by('id', $user_wp);
        return wp_send_json($user, 200);
    }
    // hide ACF menus for all users except those specified
    public function show_hide_acf_menu()
    {
        // edit.php?post_type=acf-field-group
        remove_menu_page('edit.php?post_type=acf-field-group');
        // return true;
    }
    public function membership_add_custom_box()
    {
        $screens = ['cloudnet_m_s_content'];
        foreach ($screens as $screen) {
            add_meta_box('membership_box_id', 'Membership Products', 'membership_custom_box_html', $screen, 'normal', 'high');
        }
    }
    public  function membership_save_postdata($post_id)
    {
        if (array_key_exists('membership_meta_key_name', $_POST)) {
            write_log($_POST['membership_meta_key_name']);
            // foreach ($_POST['membership_meta_key_name'] as $value) :
            update_post_meta($post_id, '_membership_meta_key', $_POST['membership_meta_key_name']);
            // endforeach;
        } else {
            delete_post_meta($post_id, '_membership_meta_key');
        }
    }

    public function my_action_javascript()
    { ?>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                if($("#acf-field_63849639028ea-non-premium").is(":checked")){
                    jQuery('#membership_box_id').hide();
                }
                if($("acf-field_63849639028ea-premium").is(":checked")){
                    jQuery('#membership_box_id').show();
                }
                jQuery('#acf-field_63849639028ea-non-premium').change(function(e) {
                    jQuery('#membership_box_id').hide();
                });
                jQuery('#acf-field_63849639028ea-premium').change(function(e) {
                    jQuery('#membership_box_id').show();
                });
            });
        </script> <?php
                }
            }
            function membership_custom_box_html($post)
            {
                $posts = get_posts(
                    array(
                        'post_type' => 'cloudnet_m_s_product',
                        'order' => 'ASC',
                        'orderby' => 'meta_value_num',
                    )
                );
                foreach ($posts as $value) {
                    // $meta_id = get_post_meta($post->ID, '_membership_meta_key', true);
                    $postmeta = maybe_unserialize(get_post_meta($post->ID, '_membership_meta_key', true));
                    if (is_array($postmeta) && in_array($value->ID, $postmeta)) {
                        $checked = 'checked="checked"';
                    } else {
                        $checked = null;
                    }
                    ?>
        <div class="checkbox">
            <label>
                <input type="checkbox" name="membership_meta_key_name[]" value="<?php echo $value->ID; ?>" <?php echo $checked ?>>
                <?php echo $value->post_title ?>
            </label>
        </div>

<?php
                }
            }




?>