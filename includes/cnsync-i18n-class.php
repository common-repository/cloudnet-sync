<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://techexeitsolutions.com
 * @since      1.0.0
 *
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    cloudnet360_sync
 * @subpackage cloudnet360_sync/includes
 * @author     http://techexeitsolutions.com
 */
class Cloudnet_sync_i18n {
    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
                'cloudnet_sync', false, dirname(dirname(plugin_basename(__FILE__))) . '/languages/'
        );
    }
}?>