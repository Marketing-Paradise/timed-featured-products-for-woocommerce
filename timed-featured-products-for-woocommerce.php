<?php
/*
 * Plugin Name: Timed featured products for Woocommerce
 * Description: Feature woocommerce products for a limited time.
 * Version: 1.0.0
 * Requires Plugins: woocommerce
 * Author: Marketing Paradise
 * Author URI: https://mkparadise.com/
 * License: GPLv2 or later
 * Text Domain: timed-featured-products-for-woocommerce
 * Domain Path: /languages

 * @link      https://mkparadise.com/
 * @package   Timed_Featured_Products_for_Woocommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

register_activation_hook( __FILE__, array( 'TimedFeatured_Admin', 'timedfeatured_activate_plugin' ) );
register_deactivation_hook( __FILE__, array( 'TimedFeatured_Admin', 'timedfeatured_unschedule_task' ) );

final class TimedFeatured_Principal {

    public function __construct() {
        $this->load_dependencies();
        new TimedFeatured_Admin();
        new TimedFeatured_Public();
    }

    private function load_dependencies() {
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-timed-featured-admin.php';
        require_once plugin_dir_path( __FILE__ ) . 'includes/class-timed-featured-public.php';
    }
}

/**
 * Display message if we deactivate WooCommerce
 */
function timedfeatured_init_plugin() {
    
    if ( ! class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', 'timedfeatured_warning_woocommerce' );
        return;
    }

    new TimedFeatured_Principal();
}
add_action( 'plugins_loaded', 'timedfeatured_init_plugin' );

// If WooCommerce is not active, we will launch a warning.
function timedfeatured_warning_woocommerce() {
    ?>
    <div class="notice notice-error is-dismissible">
        <p>
            <strong><?php esc_html_e( 'Minimum order for WooCommerce:', 'timed-featured-products-for-woocommerce' ); ?></strong>
            <?php esc_html_e( 'This plugin requires WooCommerce to be installed and active in order to work.', 'timed-featured-products-for-woocommerce' ); ?>
        </p>
    </div>
    <?php
}
