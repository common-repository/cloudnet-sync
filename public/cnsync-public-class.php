<?php

/*
 * The public-facing functionality of the plugin.
 *
 * @link       http://techexeitsolutions.com
 * @since      1.0.0
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/public
 * @author     http://techexeitsolutions.com
 */
class cnsync_Public
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
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->init_function();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function cnsync_enqueue_styles()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Cloudnet_sync_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cloudnet_sync_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/cloudnet_sync-public.css', array(), $this->version, 'all');
        wp_enqueue_style($this->plugin_name . 'cn360', plugin_dir_url(__FILE__) . 'css/cn360_main.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function cnsync_enqueue_scripts()
    {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Cloudnet_sync_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Cloudnet_sync_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/cloudnet_sync-public.js', array('jquery'), $this->version, false);
        wp_localize_script($this->plugin_name, 'ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    }

    public function cnsync_products_showcase()
    {

        $this->cnsync_page_display();
    }

    public function cnsync_page_display()
    {
        $arr = array(
            'post_type' => 'cloudnet_product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'offset' => 0,
            'orderby' => 'date',
            'order' => 'DESC',
        );
        $posts = get_posts($arr);
        if (!empty($posts)) {
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_product_grid_view.php';
        }
    }

    public function cnsync_page_list_view()
    {

        $arr = array(
            'post_type' => 'cloudnet_product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'offset' => 0,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $posts = get_posts($arr);

        if (!empty($posts)) {
            /* --cloudnet_product_list_view -- */
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cloudnet_product_list_view.php';
        }
    }

    public function cnsync_product_single_view($arr)
    {
        global $wpdb;
        $post_id = $arr['wp_product_id'];

        $value = get_post($post_id);

        if (!empty($value)) {
            /* --cloudnet_product_single_view -- */
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_product_single_view.php';
        }
    }

    public function cnsync_product_1column_view($arr)
    {
        global $wpdb;
        $term_id = $arr['term_id'];

        $term_id = $arr['term_id'];
        $posts = get_posts(
            array(
                'posts_per_page' => -1,
                'post_type' => 'cloudnet_product',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cloudnet_category',
                        'field' => 'term_id',
                        'terms' => $term_id,
                    )
                ),
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'cloudnet_product_order_' . $term_id
            )
        );

        if (!empty($posts)) {
            /* --cloudnet_product_1column_view -- */
            ob_start();
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_product_1column_view.php';
            return ob_get_clean();
        }
    }

    public function cnsync_product_3column_view($arr)
    {
        global $wpdb;
        $term_id = $arr['term_id'];

        $posts = get_posts(
            array(
                'posts_per_page' => -1,
                'post_type' => 'cloudnet_product',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cloudnet_category',
                        'field' => 'term_id',
                        'terms' => $term_id,
                    )
                ),
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'cloudnet_product_order_' . $term_id
            )
        );
        //print_r($posts);
        if (!empty($posts)) {
            /* --cloudnet_product_single_view -- */
            ob_start();
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_product_3column_view.php';
            return ob_get_clean();
        }
    }

    public function cnsync_m_s_product_1column_view($arr)
    {
        global $wpdb;
        $term_id = $arr['term_id'];

        $term_id = $arr['term_id'];
        $posts = get_posts(
            array(
                'posts_per_page' => -1,
                'post_type' => 'cloudnet_m_s_product',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cloudnet_m_s_category',
                        'field' => 'term_id',
                        'terms' => $term_id,
                    )
                ),
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'cloudnet_product_order_' . $term_id
            )
        );

        if (!empty($posts)) {
            /* --cloudnet_product_1column_view -- */
            ob_start();
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_product_1column_view.php';
            return ob_get_clean();
        }
    }

    public function cloudnet_m_s_content_1column_view($arr)
    {
        global $wpdb;
        $term_id = $arr['term_id'];

        $posts = get_posts(
            array(
                'posts_per_page' => -1,
                'post_type' => 'cloudnet_m_s_content',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cloudnet_content',
                        'field' => 'term_id',
                        'terms' => $term_id,
                    )
                ),
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'cloudnet_product_order_' . $term_id
            )
        );
        //print_r($posts);
        if (!empty($posts)) {
            /* --cloudnet_product_single_view -- */
            ob_start();
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_product_3column_view.php';
            return ob_get_clean();
        }
    }

    public function cloudnet_m_s_content_3column_view($arr)
    {
        global $wpdb;
        $term_id = $arr['term_id'];

        $term_id = $arr['term_id'];
        $posts = get_posts(
            array(
                'posts_per_page' => -1,
                'post_type' => 'cloudnet_m_s_content',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cloudnet_content',
                        'field' => 'term_id',
                        'terms' => $term_id,
                    )
                ),
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'cloudnet_product_order_' . $term_id
            )
        );

        if (!empty($posts)) {
            /* --cloudnet_product_1column_view -- */
            ob_start();
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_product_1column_view.php';
            return ob_get_clean();
        }
    }

    public function cnsync_m_s_product_3column_view($arr)
    {
        global $wpdb;
        $term_id = $arr['term_id'];

        $posts = get_posts(
            array(
                'posts_per_page' => -1,
                'post_type' => 'cloudnet_m_s_product',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'cloudnet_m_s_category',
                        'field' => 'term_id',
                        'terms' => $term_id,
                    )
                ),
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'meta_key' => 'cloudnet_product_order_' . $term_id
            )
        );
        //print_r($posts);
        if (!empty($posts)) {
            /* --cloudnet_product_single_view -- */
            ob_start();
            require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_product_3column_view.php';
            return ob_get_clean();
        }
    }


    public function cnsync_cloudnet_login_page()
    {
        global $wpdb;
        ob_start(); 
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_login_page.php';
        return ob_get_clean();
    }
    public function cnsync_cloudnet_sign_up_page()
    {
        global $wpdb;
        ob_start();
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_sign_up_page.php';
        return ob_get_clean();
    }

    public function cnsync_cloudnet_memberships()
    {
        global $wpdb;
        $paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;
        $posts = get_posts(
            array(
                'posts_per_page' => 6,
                'post_type' => 'cloudnet_m_s_product',
                'order' => 'ASC',
                'orderby' => 'meta_value_num',
                'paged' => $paged
            )
        );
        ob_start();
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_cloudnet_memberships_page.php';
        return ob_get_clean();
    }

    public function cnsync_cloudnet_content()
    {
        global $wpdb;
       
        ob_start();
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/cnsync_cloudnet_content_page.php';
        return ob_get_clean();
    }

    public function cnsync_single_product($single_template)
    {
        global $wpdb, $post;
        /* -- Checks for single template by post type -- */
        if ($post->post_type == 'cloudnet_product') {

            $single_template = plugin_dir_path(__FILE__) . 'templates/single-cloudnet_product.php';
        }

        if ($post->post_type == 'cloudnet_m_s_product') {

            $single_template = plugin_dir_path(__FILE__) . 'templates/single-cloudnet_product.php';
        }
        if ($post->post_type == 'cloudnet_m_s_content') {

            $single_template = plugin_dir_path(__FILE__) . 'templates/single-cloudnet_content.php';
        }

        return $single_template;
    }

    public function cnsync_product_categories($template)
    {
        global $wp_query, $post;
        /* -- Checks for single template by post type -- */
        if (is_tax('cloudnet_category')) {

            $template = plugin_dir_path(__FILE__) . 'templates/taxonomy-cloudnet_category.php';
        }

        return $template;
    }

    public function cnsync_add_to_cartproduct()
    {
        $attr_groupname = array();
        $attr_optioname = array();

        if (isset($_POST)) {
            if ($_POST['pwc_order_temp_id'] == 'null' && $_POST['pwc_order_token'] == 'null') {
                setcookie('pwc_order_temp_id', 'null', time() + (86400 * 30), "/");
                setcookie('pwc_order_token', 'null', time() + (86400 * 30), "/");
            } else {
                unset($_COOKIE['pwc_order_temp_id']);
                unset($_COOKIE['pwc_order_token']);

                $ptemid = trim($_POST['pwc_order_temp_id']);
                $ptokenid = trim($_POST['pwc_order_token']);

                setcookie('pwc_order_temp_id', $ptemid, time() + (86400 * 30), "/");
                setcookie('pwc_order_token', $ptokenid, time() + (86400 * 30), "/");
            }


            /* ------------------------------------------------- */
            $post_id = $_POST['pId'];
            $pwc_product_link_id = trim($_POST['pwc_product_link_id']);
            $addtocart_quantiy = trim($_POST['addtocart_quantiy']);

            if (!empty($_POST['attr_groupname']) && !empty($_POST['attr_optioname'])) {
                $attr_groupname = $_POST['attr_groupname'];
                $attr_optioname = $_POST['attr_optioname'];
            }


            $target_url = 'https://secureinfossl.com/api/addToCart';
            $target_url = 'https://secureinfossl.com/api/addToCart?apikey=PS4s1S3DF5rw5Fod5s4w8e4xds5d7w5e%3D&productlinkid=bccbdcace6abe8d150eddb7cb9cc3e36&quantity=1&thankyouurl=&recurringprofilerowid=&attributerowid=&ordertempid=11038183&token=0fa2abb05812b80a322bc95d0d7376864b74b14d';
            $merchant_id = get_option('cloudnet_mar_api_key');
            $api_key = get_option('cloudnet_mar_api_signature');

            $API_KEY = 'PS4s1S3DF5rw5Fod5s4w8e4xds5d7w5e=';
            $thankyouurl = '';
            $recurring_profile = '';
            $csv_options = '';
            if (!empty($_POST['attributes'])) {
                $csv_options = implode(",", $_POST['attributes']);
            }

            /* ------------------------------------------------- */
            //$ch = curl_init();
            //curl_setopt($ch, CURLOPT_URL, $target_url);
            //curl_setopt($ch, CURLOPT_POST, 1);



            // for 2nd time and more
            if (($_POST['pwc_order_temp_id'] != NULL) && ($_POST['pwc_order_token'] != NULL)) {

                /*$request = 'apikey=' . urlencode($API_KEY)
                        . '&productlinkid=' . urlencode($pwc_product_link_id)
                        . '&quantity=' . urlencode($addtocart_quantiy)
                        . '&thankyouurl=' . urlencode($thankyouurl)
                        . '&recurringprofilerowid=' . urlencode($recurring_profile)
                        . '&attributerowid=' . urlencode($csv_options)
                        . '&ordertempid=' . urlencode($_POST['pwc_order_temp_id'])
                        . '&token=' . urlencode($_POST['pwc_order_token']);*/
                $body = array('apikey' => $API_KEY, 'productlinkid' => $pwc_product_link_id, 'quantity' => $addtocart_quantiy, 'thankyouurl' => $thankyouurl, 'recurringprofilerowid' => $recurring_profile, 'attributerowid' => $csv_options, 'ordertempid' => $_POST['pwc_order_temp_id'], 'token' => $_POST['pwc_order_token']);
            } else {

                // for 1st time add to cart
                /*$request = 'apikey=' . urlencode($API_KEY)
                        . '&productlinkid=' . urlencode($pwc_product_link_id)
                        . '&quantity=' . urlencode($addtocart_quantiy)
                        . '&thankyouurl=' . urlencode($thankyouurl)
                        . '&recurringprofilerowid=' . urlencode($recurring_profile)
                        . '&attributerowid=' . urlencode($csv_options);*/
                $body = array('apikey' => $API_KEY, 'productlinkid' => $pwc_product_link_id, 'quantity' => $addtocart_quantiy, 'thankyouurl' => $thankyouurl, 'recurringprofilerowid' => $recurring_profile, 'attributerowid' => $csv_options);
            }

            /* ------------------------------------------------- */
            /*curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
            curl_setopt($ch, CURLOPT_HEADER, 0); // Display headers
            curl_setopt($ch, CURLOPT_REFERER, 'single-cloudnet_product.php');
            curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 300);

            $response = curl_exec($ch);*/


            $request = new WP_Http();
            $response_full = $request->request($target_url, array('method' => 'POST', 'body' => $body));
            if (isset($response_full->errors)) {
                return array(500, 'Unknown Error');
            }

            /* ------------------------------------------------- */
            //if (!curl_errno($ch)) {
            /*switch ($http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE)) {*/
            switch ($http_code = $response_full['response']['code']) {
                case 200:
                    $response = $response_full['body'];
                    $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);

                    $url = '';
                    $img_id = get_post_meta($post_id, 'cloudnet_attachment_gallery_key', true);
                    $img_id_s = get_post_meta($post_id, '_shotred_series', true);

                    /* ------------------------------- */
                    if (!empty($img_id[0]) && empty($img_id_s[0])) {
                        $url = wp_get_attachment_url($img_id[0]);
                    } else {
                        $url = wp_get_attachment_url($img_id_s[0]);
                    }
                    if ($url == '') {
                        $url = 'NULL';
                    }


                    /* ------------------------------- */
                    $token = (array) $xml->order->token;

                    $ordertempid = (array) $xml->order->ordertempid;

                    $orderitemid = (array) $xml->order->orderitemid;
                    $redirecturl = (array) $xml->order->redirecturl;



                    /* -------------Assing new values in session---- */
                    unset($_COOKIE['pwc_order_temp_id']);
                    unset($_COOKIE['pwc_order_token']);

                    /* -------------Assing new values in session---- */

                    setcookie('pwc_order_temp_id', trim($ordertempid[0]), time() + (86400 * 30), "/");
                    setcookie('pwc_order_token', trim($token[0]), time() + (86400 * 30), "/");

                    /* -------------Assing new values in session---- */

                    $price = get_post_meta($post_id, '_price', true);
                    $item_pr_total = round(($price * $addtocart_quantiy), 2);

                    /* ---------set the item price per product---- */

                    $ret_cart_item = array(
                        'product_id' => $post_id,
                        'product_name' => get_the_title($post_id),
                        'product_site_url' => get_the_permalink($post_id),
                        'product_price' => get_option('cloudnet_store_currencysymbol') . ' ' . $item_pr_total,
                        'product_sku' => get_post_meta($post_id, '_sku', true),
                        'product_image_url' => trim($url),
                        'product_link_id' => trim($pwc_product_link_id),
                        'product_qty' => trim($addtocart_quantiy),
                        'response' => 'added',
                        'ordertempid' => $ordertempid[0],
                        'token' => $token[0],
                        'orderitemid' => $orderitemid[0],
                        'redirecturl' => $redirecturl[0],
                        'user_ip' => $this->cnsync_sl_get_ip(),
                        'attr_groupname' => json_encode($attr_groupname),
                        'attr_optioname' => json_encode($attr_optioname),
                    );

                    $retun_push_st = $this->cnsync_incart_products($post_id, $ret_cart_item);
                    if ($retun_push_st) {
                        echo json_encode($ret_cart_item);
                    }
                    wp_die();
                    break;
                default:
                    echo 'Unexpected HTTP code: ', $http_code, "\n";
            }
            //}
        }
    }

    public function cnsync_incart_products($post_id, $product_data = array())
    {

        global $wpdb;
        $cart_table = $wpdb->prefix . 'cloudnet_incart_products';
        $push_cart = true;
        $user_ip = $this->cnsync_sl_get_ip();

        if (!empty($post_id) && !empty($product_data)) {
            $push_cart = $wpdb->insert(
                $cart_table,
                array(
                    'post_id' => $post_id,
                    'product_data' => json_encode($product_data),
                    'user_ip' => $user_ip
                ),
                array(
                    '%d',
                    '%s',
                    '%s'
                )
            );

            if ($push_cart == 'false') {
                echo $wpdb->last_error;
            }
        }
        return $push_cart;
    }

    public function cnsync_procedtochekout()
    {
        global $wpdb;
        $cart_table = $wpdb->prefix . 'cloudnet_incart_products';
        $push_cart = true;
        $user_ip = $this->cnsync_sl_get_ip();

        $rem_check = $wpdb->delete($cart_table, array('user_ip' => $user_ip), array('%s'));

        if ($rem_check == 'false') {
            echo $wpdb->last_error;
        }
    }

    public function cnsync_content_data_load()
    {
        $ajaxposts = get_posts(
            array(
                'posts_per_page' => 6,
                'post_type' => 'cloudnet_m_s_content',
                'order' => 'ASC',
                'paged' => $_POST['paged'],
            )
        );
        
          $response = '';
        
          if(count($ajaxposts) > 0) {
            http_response_code(200);
    
            foreach($ajaxposts as $ajaxpost):
    
                $post_id = $ajaxpost->ID;
    
                $post_type = get_post_type($post_id);
                $taxonomies = get_object_taxonomies($post_type);
                $taxonomy_names = wp_get_object_terms($post_id, $taxonomies, array("fields" => "ids"));
    
                $name_ids = count($taxonomy_names) > 0 ? implode(" ", $taxonomy_names) : '';
    
                $taxonomy_names = wp_get_object_terms($post_id, $taxonomies, array("fields" => "names"));
    
                $name_tex = count($taxonomy_names) > 0 ? implode(", ", $taxonomy_names) : '';
    
                if (!has_post_thumbnail($post_id)) {
                    $fimg = CN360_SYNC__PLUGIN_URL . 'admin/images/img_found.jpg';
                } else {
                    $fimg = wp_get_attachment_url(get_post_thumbnail_id($post_id));
                }
    
                $prod_short_desc = get_the_content(null, false, $post_id);
    
                $categories = get_the_terms($post_id, 'cloudnet_content');
                $date = '';
                foreach ((!empty($categories) ? $categories : []) as $category) {
    
                    $date_string = get_field('release_date', $category);
                    $date = $date_string;
                }
    
                $response .='<div class="box '.$name_ids.'"><div class="date">'.date("d-m-Y", strtotime($ajaxpost->post_modified)).'</div> <div class="badge">'.$name_tex.'</div><img class="thumbnail" src="'.$fimg.'"></img><div class="content">
                <h1>'. $ajaxpost->post_title .'</h1>
                <div style="line-height: 1.6; margin-top: 0.625rem;">
                <p>'.(strlen($prod_short_desc) > 50 ? htmlspecialchars(substr($prod_short_desc, 250)) . '....' : htmlspecialchars($prod_short_desc)).'</p>';
                if ($date <= date('Y-m-d')) :
                $response .='<a class="article__author" href="<?= $value->guid ?>">Details</a>';
                else :
                $response .='<a class="article__author" href="<?= $value->guid ?>">Not Release content</a>';
                endif;
                $response .='</div>
                </div></div>';
            endforeach;
          } else {
            http_response_code(400);
            $response = [];
          }
        
          echo ($response);
          exit;
    }


    public function cnsync_incart_data_byip()
    {

        global $wpdb;
        $cart_table = $wpdb->prefix . 'cloudnet_incart_products';
        $user_ip = $this->cnsync_sl_get_ip();
        if (isset($user_ip) && $user_ip != "") {
            $get_cart = $wpdb->get_results('SELECT * FROM  ' . $cart_table . ' WHERE user_ip ="' . $user_ip . '"', ARRAY_A);

            if (!empty($get_cart)) {
                echo json_encode($get_cart);
            } else {
                echo '500';
            }
        } else {
            echo "error";
        }
        wp_die();
    }

    public function cnsync_incart_item_remove()
    {
        global $wpdb;
        $cart_table = $wpdb->prefix . 'cloudnet_incart_products';
        $rem_check = false;

        /* --------------------------------------------------- */
        if (isset($_POST['item_id'])) {
            $item_id = $_POST['item_id'];
            $rem_check = $wpdb->delete($cart_table, array('id' => $item_id), array('%d'));
        }

        /* --------------Add delete item  api script---------- */
        $product_detail = $wpdb->get_results('SELECT * FROM  ' . $cart_table . ' WHERE id ="' . $item_id . '" LIMIT 1', ARRAY_A);
        $all_pdata = $product_detail[0]['product_data'];

        /* --------------------------------------------------- */
        $p_data = json_decode($all_pdata, true);
        $target_url = 'https://secureinfossl.com/api/removeFromCart.html';
        $API_KEY = 'PS4s1S3DF5rw5Fod5s4w8e4xds5d7w5e=';

        /* --------------------------------------------------- */
        $orderitemid = trim($_POST['orderitemid']);

        $pwc_order_temp_id = trim($_COOKIE["pwc_order_temp_id"]); //NULL;
        $pwc_order_token = trim($_COOKIE["pwc_order_token"]); //NULL;


        $pwc_product_link_id = trim($p_data['product_link_id']);

        /*$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $target_url);
        curl_setopt($ch, CURLOPT_POST, 1);

        $request = 'apikey=' . urlencode($API_KEY)
                . '&productlinkid=' . urlencode($pwc_product_link_id)
                . '&orderitemid=' . urlencode($orderitemid);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_HEADER, 0); // Display headers
        curl_setopt($ch, CURLOPT_REFERER, 'cnsync-public-class.php');
        //curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 300);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'error';
        } else {
            curl_close($ch);
        }
        //$addtocart_response = xml_clean($response);
        //$addtocart_response = xml_parser_string_to_array($response);
		*/

        $body = array('apikey' => $API_KEY, 'productlinkid' => $pwc_product_link_id, 'orderitemid' => $orderitemid);
        $request = new WP_Http();
        $response_full = $request->request($target_url, array('method' => 'POST', 'body' => $body));
        if (isset($response_full->errors)) {
            return array(500, 'Unknown Error');
        }
        $response = $response_full['body'];
        $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);


        /* ---------------------------------------------- */
        $token = (array) $xml->order->token;
        $ordertempid = (array) $xml->order->ordertempid;
        $orderitemid = (array) $xml->order->orderitemid;
        $redirecturl = (array) $xml->order->redirecturl;

        /* -------------Assing new values in session---- */

        unset($_COOKIE['pwc_order_temp_id']);
        unset($_COOKIE['pwc_order_token']);


        setcookie('pwc_order_temp_id', trim($ordertempid[0]), time() + (86400 * 30), "/");
        setcookie('pwc_order_token', trim($token[0]), time() + (86400 * 30), "/");

        /* ----------------------------------------------------- */

        /* --------------Add delete item  api script---------- */
        echo $rem_check;
        wp_die();
    }

    public function cnsync_sl_get_ip()
    {

        $pwc_cartuser_ip = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
        }
        $ip = filter_var($ip, FILTER_VALIDATE_IP);
        $ip = ($ip === false) ? '0.0.0.0' : $ip;

        if ($_COOKIE["pwc_cartuser_ip"] == NULL) {
            $uk = rand(0, 999999);
            $pwc_cartuser_ip = $uk . $ip;
            setcookie('pwc_cartuser_ip', $pwc_cartuser_ip, time() + (86400 * 30), "/");
        } else {
            $pwc_cartuser_ip = $_COOKIE["pwc_cartuser_ip"];
        }
        return $pwc_cartuser_ip;
    }

    public function cnsync_sl_getfront_ip()
    {
        $pwc_cartuser_ip = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
        }
        $ip = filter_var($ip, FILTER_VALIDATE_IP);
        $ip = ($ip === false) ? '0.0.0.0' : $ip;

        if ($_COOKIE["pwc_cartuser_ip"] == NULL) {
            $uk = rand(0, 999999);
            $pwc_cartuser_ip = $uk . $ip;
            setcookie('pwc_cartuser_ip', $pwc_cartuser_ip, time() + (86400 * 30), "/");
        } else {
            $pwc_cartuser_ip = $_COOKIE["pwc_cartuser_ip"];
        }
        echo $pwc_cartuser_ip;
        wp_die();
    }

    public function cnsync_add_popcart()
    {
        $pwc_order_temp_id = @$_COOKIE["pwc_order_temp_id"];
        $pwc_order_token = @$_COOKIE["pwc_order_token"];
        $send_c = "send_ckout('$pwc_order_temp_id','$pwc_order_token')";

        echo '<div class="cn360-section"><div class="cln_cart_popup" id="cloud_Modal" tabindex="-1" role="dialog" aria-labelledby="cloud_Modal-2">
                <div class="cn360_modal-dialog cn360_modal-lg" role="document">
                    <div class="cn360_modal-content">
                    <button type="button" class="cn360_close">&times;</button>
                        <div class="cn360_modal-body">                          
                           <ul class="pop_top_list">
                           <li class="cn360_containet-fluid" >
                            <div class="cn360_row clearfix pop_head">
                            <div class="cn360_col-md-2"><h4>CART ITEMS</h4></div>
                            <div class="cn360_col-md-5"><h4 style="opacity:0 !important;">Product name</h4></div>
                           <div class="cn360_col-md-5 pop_right_head"><h4>QTY</h4><h4>ITEM PRICE</h4><h4>TOTAL</h4><h4 style="width: 30px;">&nbsp;</h4></div>
                           </div>
                           </li>
                           </ul>
                            <ul id="cart_body_set">

                            </ul>
                            <div class="pop_bottom"><div class="text_left">Total Items : <span class="itemCount"></span></div><div class="text_right"><b>Grand Total :</b> $<span class="gdTotal"></span></div></div>
                        </div>

                        <div class="cn360_modal-footer">
                            <button type="button" class="cn360_btn btn-dialog continue">Continue Shopping</button>
                            <button type="button" class="chk_btn" onclick="' . $send_c . '"><span><span class="chk-2-text">Proceed To Checkout</span></span> <svg aria-hidden="true" data-prefix="fas" data-icon="caret-right" role="img" xmlns="https://www.w3.org/2000/svg" viewBox="0 0 192 512" class="svg-inline--fa fa-caret-right fa-w-6 fa-3x"><path fill="currentColor" d="M0 384.662V127.338c0-17.818 21.543-26.741 34.142-14.142l128.662 128.662c7.81 7.81 7.81 20.474 0 28.284L34.142 398.804C21.543 411.404 0 402.48 0 384.662z" class=""></path></svg></button>
                        </div>
                    </div> 
                </div> 
            </div></div>';
    }

    public function cnsync_get_cart_tip_count()
    {

        global $wpdb;
        $cart_table = $wpdb->prefix . 'cloudnet_incart_products';
        $iip = $this->cnsync_sl_get_ip();
        $get_cart = $wpdb->get_results('SELECT COUNT(*) FROM  ' . $cart_table . ' WHERE user_ip ="' . $iip . '"', ARRAY_A);
        $get_cart_qty = $wpdb->get_results('SELECT * FROM  ' . $cart_table . ' WHERE user_ip ="' . $iip . '"', ARRAY_A);

        $qty = array();
        $qty_data = array();
        foreach ($get_cart_qty as $get_cart_qty_val) {
            $qty_data[] = json_decode($get_cart_qty_val['product_data'], true);
        }
        $total_qty = '0';
        foreach ($qty_data as $qty_data_val) {
            $total_qty += trim($qty_data_val['product_qty']);
        }

        $cct = $get_cart[0]['COUNT(*)'];

        if ($_COOKIE["pwc_order_temp_id"] == 'null' || $_COOKIE["pwc_order_temp_id"] == 'undefined') {
            $pwc_order_temp_id = 'null';
        } else {

            $pwc_order_temp_id = @$_COOKIE["pwc_order_temp_id"];
        }

        if ($_COOKIE["pwc_order_token"] == 'null' || $_COOKIE["pwc_order_token"] == 'undefined') {

            $pwc_order_token = 'null';
        } else {

            $pwc_order_token = @$_COOKIE["pwc_order_token"];
        }

        echo json_encode(array('cct' => $cct, 'ordertempid' => $pwc_order_temp_id, 'token' => $pwc_order_token, 'cart_total' => $total_qty));

        wp_die();
    }

    public function init_function()
    {
        add_action('init', array($this, 'create_account'));
        add_action('init', array($this, 'login_account'));
    }


    public function login_account()
    {

        if (isset($_POST['login_account'])) {
            // var_dump($_POST);
            // this returns the user ID and other info from the user name
            $user = get_user_by('login', $_POST['username']);

            if (!$user) {
                // if the user name doesn't exist
                cnsync_errors()->add('empty_username', __('Invalid username'));
            } elseif (!isset($_POST['password']) || $_POST['password'] == '') {
                // if no password was entered
                cnsync_errors()->add('empty_password', __('Please enter a password'));
            } elseif (!wp_check_password($_POST['password'], $user->user_pass, $user->ID)) {
                // if the password is incorrect for the specified user
                cnsync_errors()->add('empty_password', __('Incorrect password'));
            }

            // retrieve all error messages
            $errors = cnsync_errors()->get_error_messages();

            // only log the user in if there are no errors
            if (empty($errors)) {

                wp_clear_auth_cookie();
                wp_set_current_user($user->ID);
                wp_set_auth_cookie($user->ID);

                $redirect_to = user_admin_url();
                wp_safe_redirect($redirect_to);
                exit;
            }
        }
    }

    public function create_account()
    {

        if (isset($_POST['create_account'])) {
            $username = $_POST['username'];
            $password = $_POST['password_confirm'];
            $email = $_POST['email'];

            if (username_exists($username)) {
                // Username already registered
                cnsync_errors()->add('username_unavailable', __('Username already taken'));
            }
            if (!validate_username($username)) {
                // invalid username
                cnsync_errors()->add('username_invalid', __('Invalid username'));
            }
            if ($username == '') {
                // empty username
                cnsync_errors()->add('username_empty', __('Please enter a username'));
            }
            if (!is_email($email)) {
                //invalid email
                cnsync_errors()->add('email_invalid', __('Invalid email'));
            }
            if (email_exists($email)) {
                //Email address already registered
                cnsync_errors()->add('email_used', __('Email already registered'));
            }
            if ($password == '') {
                // passwords do not match
                cnsync_errors()->add('password_empty', __('Please enter a password'));
            }

            $errors = cnsync_errors()->get_error_messages();

            // only create the user in if there are no errors
            if (empty($errors)) {

                $new_user_id = wp_insert_user(
                    array(
                        'user_login'        => $username,
                        'user_pass'             => $password,
                        'user_email'        => $email,
                        'user_registered'    => date('Y-m-d H:i:s'),
                        'role'                => 'subscriber'
                    )
                );
                if ($new_user_id) {
                    // send an email to the admin alerting them of the registration
                    wp_new_user_notification($new_user_id);

                    wp_clear_auth_cookie();
                    wp_set_current_user($new_user_id);
                    wp_set_auth_cookie($new_user_id);

                    $redirect_to = user_admin_url();
                    wp_safe_redirect($redirect_to);
                    exit;
                }
            }
        }
    }
}
