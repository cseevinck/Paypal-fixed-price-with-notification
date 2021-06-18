<?php
if ( ! defined( 'ABSPATH' ) ) exit; 

/**
* 
* This is used to display the admin options page for this plugin
*
*/

add_action( 'admin_menu', 'ppfpn_add_admin_menu' );
add_action( 'admin_init', 'ppfpn_define_section_and_fields' );

function ppfpn_add_admin_menu(  ) { 
	add_menu_page( 'TF Paypal Donations', 'TF Paypal Donations', 'manage_options', 'ppfpn_payments', 'ppfpn_options_page' );
}

function ppfpn_define_section_and_fields(  ) { 
	// Array with names and descriptions of fields to be used in the admin pages
	$ppfpn_fields = array (
			"don_list_hdr" => "Donations List Header",
			"give_to" => "Donations List", 
			"paypal_email" => "Paypal Email Account", 
			"notification_to_email" => "Notification To Email",
			"donate_image" => "Donate image URL",  
			"disable_css" => "Disable Plugin CSS", 
			"paypal_testing" => "Use Paypal Sandbox for testing", 
			"log" => "Turn on debug logging", 
			"log_display" => "URL of page for log file displays",  
			"ipn_url" => "URL to use in PayPal setup for IPN"
	);

	register_setting( 'ppfpn_pluginPage', 'ppfpn_settings' );

	add_settings_section(
	'ppfpn_pluginPage_section', 
	__( '', 'wordpress' ), 
	'ppfpn_settings_section_callback', 
	'ppfpn_pluginPage'
	);

	foreach ($ppfpn_fields as $key => $value) {
		add_settings_field( 
			'ppfpn_' . $key, 
			__( $value, 'wordpress' ), 
			'ppfpn_' . $key . '_render', 
			'ppfpn_pluginPage', 
			'ppfpn_pluginPage_section' 
			);
		}
}

function ppfpn_give_to_render(  ) { 

	$options = get_option( 'ppfpn_settings' );
	?>
	<textarea name='ppfpn_settings[ppfpn_give_to]' rows="10" cols="70" maxlength="1000" class='wide' required><?php if(isset($options['ppfpn_give_to']))
	{echo $options['ppfpn_give_to'];} ?></textarea>
	<?php
}

function ppfpn_paypal_email_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
	<input type='email' name='ppfpn_settings[ppfpn_paypal_email]' value='<?php if(isset($options['ppfpn_paypal_email']))
	{echo $options['ppfpn_paypal_email'];} ?>' class='wide' required>
	<?php
}

function ppfpn_notification_to_email_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
		<input type='email' name='ppfpn_settings[ppfpn_notification_to_email]' value='<?php if(isset($options['ppfpn_notification_to_email']))
		{echo $options['ppfpn_notification_to_email'];} ?>' class='wide' required>
	<?php
}

function ppfpn_notification_from_email_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
	<input type='email' name='ppfpn_settings[ppfpn_notification_from_email]' value='<?php if(isset($options['ppfpn_notification_from_email']))
	{echo $options['ppfpn_notification_from_email'];} ?>' class='wide' required>
	<?php
}

function ppfpn_notification_reply_to_email_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
	<input type='email' name='ppfpn_settings[ppfpn_notification_reply_to_email]' value='<?php if(isset($options['ppfpn_notification_reply_to_email']))
	{echo $options['ppfpn_notification_reply_to_email'];} ?>' class='wide' required>
	<?php
}

function ppfpn_don_list_hdr_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
	<input type='text' name='ppfpn_settings[ppfpn_don_list_hdr]' value='<?php if(isset($options['ppfpn_don_list_hdr']))
	{echo $options['ppfpn_don_list_hdr'];} ?>' class='wide' required style=''>
	<?php
}

function ppfpn_donate_image_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
	<input type='text' name='ppfpn_settings[ppfpn_donate_image]' 
	value='<?php if(isset($options['ppfpn_donate_image']))
	{echo $options['ppfpn_donate_image'];} else{ echo("https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif");} ?>' class='wide'>
	<?php
}

function ppfpn_disable_css_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
	<input type='checkbox' id='ppfpn_disable_css' name='ppfpn_settings[ppfpn_disable_css]' 
	<?php checked( isset($options['ppfpn_disable_css']), 1 ); ?> value='1'>
	<?php
}

function ppfpn_log_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	
	$upload_dir = wp_upload_dir();
  $upload_dir = $upload_dir['basedir'];
  $file_curr  = $upload_dir . '/' . PPFPN_CURRENT_LOG;
	?>
	<input type='checkbox' id='ppfpn_log' name='ppfpn_settings[ppfpn_log]' 
	<?php checked( isset($options['ppfpn_log']), 1 ); ?> value='1'>  <?php echo "File location & names: " .$upload_dir . '/' . PPFPN_CURRENT_LOG
					 . " and ... " . PPFPN_OLDER_LOG; ?>
	<?php
}

function ppfpn_log_display_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
	<input type='text' name='ppfpn_settings[ppfpn_log_display]' 
	value='<?php if(isset($options['ppfpn_log_display']))
	{echo $options['ppfpn_log_display'];} ?>' class='wide' required>
	<?php
}

function ppfpn_paypal_testing_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
	<input type='checkbox' id='ppfpn_paypal_testing' name='ppfpn_settings[ppfpn_paypal_testing]' 
	<?php checked( isset($options['ppfpn_paypal_testing']), 1 ); ?> value='1'>
	<?php
}

function ppfpn_ipn_url_render(  ) { 
	$options = get_option( 'ppfpn_settings' );
	?>
	<?php echo site_url()."/?action=". PPFPN_IPN_ID; ?><br>
	For instructions see: https://developer.paypal.com/docs/api-basics/notifications/ipn/IPNSetup/
	<?php
}

function ppfpn_settings_section_callback(  ) { 
	echo __( '', 'wordpress' );
}

function ppfpn_options_page(  ) { 
	?>
<div id='ppfpn-admin'>
	<form action='options.php' method='post'>
		<input type="hidden" name="destination" value="<?php echo admin_url('admin.php?page=ppfpn_donations')?>"/>
			<h2>TF Paypal Donations<br>Setup Page</h2>
			<?php
			settings_fields( 'ppfpn_pluginPage' );
			do_settings_sections( 'ppfpn_pluginPage' );
			ppfpn_log("log in admin 1: ", $_POST); 
			?>
		<div class='ppfpn_form_section'>  
			<?php	submit_button();
			ppfpn_log("log in admin 2: ", $_POST); 
			?>
	 	</div> 
	</form>
</div>
<?php
}
?>