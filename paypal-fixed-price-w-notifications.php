<?php
if ( ! defined( 'ABSPATH' ) ) exit; 
ob_clean(); 
ob_start(); // this makes wp_redirect work
/** 
* Plugin Name: Paypal Fixed Price With Notification 
* Description: A plugin to accept Paypal payments using IPN. Shortcode: [ppfpn-paypal]price[/ppfpn-paypal]
* Version: 1.0 - June 18, 2021 
*/

// use ppfpn as prefix for stuff

const PPFPN_IPN_ID = "IPN_Handler";

// define log file function
require_once('inc/ppfpn-log.php');

add_shortcode('tppfpn-paypal', 'ppfpn_shortcode_control');
/**
 * ppfpn_shortcode_control
 * 
 * We will get control here at page init and, 
 * when the buttons on the log form page is clicked
 * 
 */

function ppfpn_shortcode_control() {  
    ppfpn_log("tppfpn_shortcode_control ", $_POST); // log file entry
    $options = get_option( 'ppfpn_settings' );

    // display payment form if this is not log file display 
    if (( !isset ($_POST['ppfpn_log'])) && ( !isset ($_POST['ppfpn_log_delete']))){
        ppfpn_log("ppfpn_shortcode_control for payment form display ", ""); 
        ob_start();
        require_once('templates/payment-form.php');
        return ob_get_clean();
    }
    // redirect to log file display page 
    else if ((isset ($_POST['ppfpn_log'])) && ($_POST['ppfpn_log'] == 'Submit')) {
        ppfpn_log("ppfpn_shortcode_control - Redirect to: ", $options['ppfpn_log_display']); 
        wp_redirect( $options['ppfpn_log_display'] . '?file=' . $_POST["what_file"] );
        return; 
    }
    // See if this is a delete files request 
    else if ((isset ($_POST['ppfpn_log_delete'])) && ($_POST['ppfpn_log_delete'] == 'Submit')) {
        $upload_dir = wp_upload_dir();
        $upload_dir = $upload_dir['basedir'];

        if(file_exists($upload_dir . '/' . PPFPN_CURRENT_LOG)){
            unlink($upload_dir . '/' . PPFPN_CURRENT_LOG);
        }
        if(file_exists($upload_dir . '/' . PPFPN_OLDER_LOG)){
            unlink($upload_dir . '/' . PPFPN_OLDER_LOG);
        }
        wp_redirect($_SERVER['HTTP_REFERER'] . '?file=deleted' );
        exit(); 
    }
    else {
        ppfpn_log("ppfpn_shortcode_control: Unknown event= ", $_POST); 
    }
}

/**
 * Assign the correct template to the log display page. 
 */
function ppfpn_change_page_template($template) {
    $options = get_option( 'ppfpn_settings' );
    if (get_permalink(get_the_ID()) == $options['ppfpn_log_display']){    
        $template = plugin_dir_path(__FILE__) . 'templates/log-display.php';
    }
    return $template;
}
add_filter('template_include', 'ppfpn_change_page_template', 99);

/**
 * Enqueue plugin styles
 */
function ppfpn_register_styles() {
    wp_enqueue_style('paypal-fixed-price-w-notification-styles', plugin_dir_url( __FILE__ ) . 'css/ppfpnstyle.css' );
};

$options = get_option( 'ppfpn_settings' );
$disable_css = $options['ppfpn_disable_css'];
if(!$disable_css) {
	add_action('wp_enqueue_scripts','ppfpn_register_styles');
};

/** 
 *  Define a paypal ipn listener
 *  from: https://webkul.com/blog/paypal-ipn-integration-wordpress/  
 * 
*/
add_action( 'init', 'ppfpn_paypal_ipn' );

require_once('inc/ipn-handler.php');
require_once('inc/notification-email.php');

/** 
 * Include code segments for admin and admin styles and log file display
 * 
*/   
require_once('inc/ppfpn-admin.php');
require_once('inc/ppfpn-admin-styles.php');
require_once('inc/ppfpn-display-logs.php');