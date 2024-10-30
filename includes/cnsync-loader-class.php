<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       http://techexeitsolutions.com
 * @since      1.0.0
 *
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/includes
 */
/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/includes
 * @author     http://techexeitsolutions.com
 */
class Cloudnet_sync_Loader
{
    /**
     * The array of actions registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $actions    The actions registered with WordPress to fire when the plugin loads.
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * @since    1.0.0
     * @access   protected
     * @var      array    $filters    The filters registered with WordPress to fire when the plugin loads.
     */
    protected $filters;

    /**
     * Initialize the collections used to maintain the actions and filters.
     *
     * @since    1.0.0
     */
    public function __construct()
    {

        $this->actions = array();
        $this->filters = array();
    }

    /**
     * Add a new action to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     * @param    string               $hook             The name of the WordPress action that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the action is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
     */
    public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Add a new filter to the collection to be registered with WordPress.
     *
     * @since    1.0.0
     * @param    string               $hook             The name of the WordPress filter that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
     * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
     */
    public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * A utility function that is used to register the actions and hooks into a single
     * collection.
     *
     * @since    1.0.0
     * @access   private
     * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
     * @param    string               $hook             The name of the WordPress filter that is being registered.
     * @param    object               $component        A reference to the instance of the object on which the filter is defined.
     * @param    string               $callback         The name of the function definition on the $component.
     * @param    int                  $priority         The priority at which the function should be fired.
     * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
     * @return   array                                  The collection of actions and filters registered with WordPress.
     */
    private function add($hooks, $hook, $component, $callback, $priority, $accepted_args)
    {

        $hooks[] = array(
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args
        );

        return $hooks;
    }

    /**
     * Register the filters and actions with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }
        foreach ($this->actions as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }

        if (!function_exists('write_log')) {

            function write_log($log)
            {
                if (true === WP_DEBUG) {
                    if (is_array($log) || is_object($log)) {
                        error_log(print_r($log, true));
                    } else {
                        error_log($log);
                    }
                }
            }
        }

        if (!function_exists('get_page_by_slug')) {
            /**
             * Retrieve a page given its slug.
             *
             * @global wpdb $wpdb WordPress database abstraction object.
             *
             * @param string       $page_slug  Page slug
             * @param string       $output     Optional. Output type. OBJECT, ARRAY_N, or ARRAY_A.
             *                                 Default OBJECT.
             * @param string|array $post_type  Optional. Post type or array of post types. Default 'page'.
             * @return WP_Post|null ID
             */
            function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page')
            {
                global $wpdb;

                if (is_array($post_type)) {
                    $post_type = esc_sql($post_type);
                    $post_type_in_string = "'" . implode("','", $post_type) . "'";
                    $sql = $wpdb->prepare("
                            SELECT ID
                            FROM $wpdb->posts
                            WHERE post_name = %s
                            AND post_type IN ($post_type_in_string)
                        ", $page_slug);
                } else {
                    $sql = $wpdb->prepare("
                            SELECT ID
                            FROM $wpdb->posts
                            WHERE post_name = %s
                            AND post_type = %s
                        ", $page_slug, $post_type);
                }

                $page = $wpdb->get_var($sql);

                if (!empty($page))
                    return get_post($page, $output)->ID;

                return null;
            }
        }


        // See http://codex.wordpress.org/Plugin_API/Filter_Reference/cron_schedules
        add_filter('cron_schedules', 'isa_add_every_five_minutes');
        function isa_add_every_five_minutes($schedules)
        {
            $schedules['every_five_minutes'] = array(
                'interval'  => 60,
                'display'   => __('Every 1 Minutes', 'textdomain')
            );
            return $schedules;
        }

        // Schedule an action if it's not already scheduled
        if (!wp_next_scheduled('isa_add_every_five_minutes')) {
            wp_schedule_event(time(), 'every_five_minutes', 'isa_add_every_five_minutes');
        }

        // Hook into that action that'll fire every five minutes
        add_action('isa_add_every_five_minutes', 'every_five_minutes_event_func');
        function every_five_minutes_event_func()
        {
            $merchant_id = get_option('cloudnet_mar_api_key');
            $api_key = get_option('cloudnet_mar_api_signature');
            $date = new DateTime('now');
            $date->modify('last day of this month');
            $start_month = date('Y-m-01');
            $end_month = $date->format('Y-m-d');

            if (!empty($merchant_id) && !empty($api_key)) {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    // CURLOPT_URL => 'https://secureinfossl.com/api/getOrderInfo.html',
                    // CURLOPT_RETURNTRANSFER => true,
                    // CURLOPT_ENCODING => '',
                    // CURLOPT_MAXREDIRS => 10,
                    // CURLOPT_TIMEOUT => 0,
                    // CURLOPT_FOLLOWLOCATION => true,
                    // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    // CURLOPT_CUSTOMREQUEST => 'POST',
                    // CURLOPT_POSTFIELDS => array('merchantid' => $merchant_id, 'signature' => $api_key, 'fromdate' => $start_month, 'todate' => $end_month)
                    CURLOPT_URL => "https://secureinfossl.com/api/getorders.html?merchant_id=" . $merchant_id . "&signature=" . $api_key . "",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                ));

                $response = curl_exec($curl);

                $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

                curl_close($curl);

                if ($httpcode == 200) {

                    $array = json_decode($response, true);

                    foreach ($array as $item) {
                        if ($item['products']['productcount'] > 1) {
                            order_array_product($item['products'], $item['customer']);
                        } else {
                            order_single_product($item['products']['product'], $item['customer']);
                        }
                    }
                }

                // do something here you can perform anything
            }
        }
        function order_single_product($product, $customer)
        {
            $cloudnet_m_s_product = get_posts(
                array(
                    'numberposts' => -1,
                    'post_type' => 'cloudnet_m_s_product',
                    'order' => 'ASC',
                )
            );
            foreach ($cloudnet_m_s_product as $pro) {
                if ($pro->post_title == $product['name']) {
                    create_user_order($customer['shippingname'], $customer['email'], $product['encproductrowid']);
                }
            }
        }
        function order_array_product($product, $customer)
        {
            $cloudnet_m_s_product = get_posts(
                array(
                    'numberposts' => -1,
                    'post_type' => 'cloudnet_m_s_product',
                    'order' => 'ASC',
                )
            );

            write_log('order_array_product');

            foreach ($cloudnet_m_s_product as $pro) {
                foreach ($product['product'] as $pro2) {
                    if ($pro->post_title == $pro2['name']) {
                        create_user_order($customer['shippingname'], $customer['email'], $pro2['encproductrowid']);
                    }
                }
            }
        }

        function create_user_order($username, $email, $encproductrowid)
        {
            $user_name = str_replace(" ","_",$username);
            $user_wp = wp_create_user($user_name, 'password', $email);
            if (!is_wp_error($user_wp)) {
                // $user = get_user_by('id', $user_wp);
                add_user_meta($user_wp, 'memebership', 1, true);
                add_user_meta($user_wp, 'encproductrowid', $encproductrowid, true);

                try {
                    send_welcome_email_to_new_user($user_name);
                } catch (\Throwable $th) {
                    //throw $th;
                    write_log($th);
                }
            }else{
                $error = $user_wp->get_error_message();
                write_log($error);
            }
            
        }

        function send_welcome_email_to_new_user($username) {
            $user = get_user_by('login', $username);
            $user_email = $user->user_email;
            // for simplicity, lets assume that user has typed their first and last name when they sign up
            $user_full_name = $user->user_nicename;
        
            // Now we are ready to build our welcome email
            $to = $user_email;
            $subject = "Hi " . $user_full_name . ", Welcome to Our MemberShip!";
            $body = '
                      <h1>Dear ' . $user_full_name . ',</h1></br>
                      <p>Thank you for joining our MemberShip. Your account is now active.</p>
                      <p>Please go ahead and navigate around your account.</p>
                      <p>username: '.$user->user_login.'</p>
                      <p>password: password</p>
                      <p>Kind Regards,</p>
                      <p>cloudnet360 </p>
            ';
            $headers = array('Content-Type: text/html; charset=UTF-8');
            if (wp_mail($to, $subject, $body, $headers)) {
              error_log("email has been successfully sent to user whose email is " . $user_email);
            }else{
              error_log("email failed to sent to user whose email is " . $user_email);
            }
          }
    }
}
