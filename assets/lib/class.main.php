<?php

// Main plugin class - be mindful of namespace
class wpblockadmin {
	
	private $errors = array();
	
	public function initialize() {
		add_action('admin_menu', array('wpblockadmin', 'add_plugin_menu'));	
	}

	// Register the plugin page
	public function add_plugin_menu(){
		
		// Add page to the admin options
		add_management_page( 'WP Block', 'WP Block', 'manage_options', 'wpblockadmin', array('wpblockadmin','options_page'));
	}

	
	
	// Main plugin options page
	public function options_page(){
		
		//must check that the user has the required capability 
		if (!current_user_can('manage_options'))
		{
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
		// variables for the field and option names 
		$opt_names = array(
			array( 'label' => 'Your Secret Key', 'option' => 'wpblockadmin_option_value'),
		);
		$hidden_field_name = 'wpblockadmin_submit_hidden';
	
		// See if the user has posted us some information
		// If they did, this hidden field will be set to 'Y'
		if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
	
			foreach ( $opt_names as $option ) {
				$opt_val = $_POST[ $option['option'] ];
				update_option( $option['option'], $opt_val );
			}
			?>
			<div class="updated"><p><strong><?php _e('Secret Key Updated.', 'wpblockadmin' ); ?></strong></p></div>
			<?php
	
		}
	
		// Read in existing option value from database
		$opt_values = array();
		foreach ( $opt_names as $option ) {
			$opt_values[$option['option']] = get_option( $option['option'] );
		}
		
		// Now display the settings editing screen
		echo '<div class="wrap">';
	
		// header
	
		echo "<h2>" . __( 'WP Block Settings', 'wpblockadmin' ) . "</h2>";
	
		// settings form
		
		?>
	
		<form name="form1" method="post" action="">
		<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">
			
			<?php foreach ( $opt_names as $option ) { ?>
				<p><?php _e($option['label'], 'cgapi' ); ?> 
				<input type="text" name="<?php echo $option['option']; ?>" value="<?php echo $opt_values[$option['option']]; ?>" />
				</p><hr />
			<?php } ?>
		
			<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
			</p>
			
		</form>
		</div>
		
	<?php
			
	}

	// RECORD ERROR
	private function error($message) {
		$errors[] = __($message);
	}
	

	// SHOW MESSAGES
	private function showMessages() {
		if(!$errors) return;
		?>
		<div class="updated wp-database-backup-updated error"><p><strong><?php e('The following errors were reported:') ?></strong></p>
			<?php foreach($this->errors as $err) {
			print '<p>' . __($err) . '</p>';
			} ?>
		</div>
	<?php }
	
	
}
?>