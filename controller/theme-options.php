<?php
/*
 * @file theme-options
 * automatically create various theme options for the wordpress backend
 */

include_once "validators.php";

/**
 * register the theme options page
 *
 * @since 1.0
 * @author shannon
 */
function wto_theme_options_admin_menu() {
	$options = apply_filters( 'wto_options', array() );
	if(!$options) return;
    add_theme_page( __('Theme Options'), __('Theme Options'), 'manage_options', 'theme-options', 'wto_options_page' );
}

/**
 * register the theme options css
 *
 * @since 1.0
 * @author shannon
 */
function wto_theme_options_admin_init() {
    wp_enqueue_style( 'wp-extension', get_template_directory_uri().'/inc/wp-extensions/view/admin-style.css', array(), 1.0 );
    if( isset( $_GET['page'] ) && $_GET['page'] == 'theme-options' ) wp_enqueue_media();
}

/**
 * draw the options page
 *
 * @since 1.0
 * @author shannon
 */
function wto_options_page() {
	global $wto_saved;

	$options = apply_filters( 'wto_options', array() );

?>
<div class="wrap">
<div id="icon-options-general" class="icon32"><br></div>
<h2 class="nav-tab-wrapper">
<?php foreach( $options as $option_group_id => $option_group ) : ?>
<a href="#<?php echo $option_group_id; ?>" onclick="return wto_tab(this)" class="nav-tab" id="<?php echo $option_group_id; ?>"><?php echo $option_group['title']; ?></a>
<?php endforeach; ?>
</h2>
<form action="" method="post">
	<input type="hidden" name="wpext_save" value="1" />
	 <?php wp_nonce_field('wpext_save','wpext_save_nonce'); ?>
<?php if( $wto_saved ) : ?>
<div id="message" class="updated below-h2"><p>Options saved.</p></div>
<?php endif; ?>

<?php foreach( $options as $option_group_id => $option_group ) : ?>
<div class="tab" id="tab-<?php echo $option_group_id; ?>" style="display: none;">
	<table class="form-table"><tbody>
	<?php 

		if( $option_group['fields'] ) foreach( $option_group['fields'] as $field_id => $field ) : 

			if( $field['type'] != 'title' ) :
				?><tr><td><label for="wcpt_<?php echo $field_id; ?>"><?php echo $field['name']; ?></label></td><td><?php 
				unset( $field['name'] );
			else:
				?><tr><td colspan="2"><?php 
			endif;

			do_action( 'wto_display_'.$field['type'].'_field', $field_id, $field, 'theme-options' );

			if( $field['type'] != 'title' ) :
				?></td></tr><?php 
			endif;

		endforeach; 
	?>
	</tbody></table>
</div>
<?php endforeach; ?>
<p class="submit"><input type="submit" name="submit" id="submit" class="button-primary" value="Save Options"></p>
</form>
<script>
	function wto_tab( group_obj ) {
		var id = jQuery(group_obj).attr('id');
	    jQuery('.nav-tab').removeClass('nav-tab-active');
	    jQuery(group_obj).addClass('nav-tab-active');
	    jQuery('.tab').hide();
	    jQuery('#tab-'+id).show();
	    return true;
	}

	if(jQuery('.nav-tab-wrapper').length && window.location.hash.toString().length) {
        var group_id = window.location.hash.toString().replace("#",'');
        jQuery('.nav-tab').removeClass('nav-tab-active');
        jQuery('#'+group_id).addClass('nav-tab-active');
        jQuery('.tab').hide();
        jQuery('#tab-'+group_id).show();
    } else {
    	jQuery('.nav-tab-wrapper a:first').trigger('click');
    }
</script>
</div>
<?php

}

add_action('admin_menu', 'wto_theme_options_admin_menu');
add_action('admin_init', 'wto_theme_options_admin_init');

function _wto_get_option( $option_id, $skip_empty_rows = false ) {
	$wto_options = get_option( 'wp_theme_options' );

	if( $skip_empty_rows ) :

		$value = $wto_options[ $option_id ];
		if( !is_array( $value ) || !count( $value ) )
			return $value;

		$pre_value = $value;
		$value = array();

		foreach( $pre_value as $row_id => $row ) : 

			$skip = true;

			foreach( $row as $column )
				if( $column ) $skip = false;

			if( $skip )
				continue;

			$value[ $row_id ] = $row;

		endforeach; 
		return $value;

	endif;

	return $wto_options[ $option_id ];
}

function _wto_update_option( $option_id, $value ) {
	$wto_options = get_option( 'wp_theme_options' );
	$wto_options[ $option_id ] = $value;
	update_option( 'wp_theme_options', $wto_options );
}

function _wto_save() {

	global $wto_saved;
	
	if ( !wp_verify_nonce( $_POST['wpext_save_nonce'], 'wpext_save' ) ) wp_die('Unable to save.');

	$options = apply_filters( 'wto_options', array() );

	foreach( $options as $option_group_id => $option_group ) :

		if( $option_group['fields'] ) foreach( $option_group['fields'] as $field_id => $field ) :

			$value = $_POST['wcpt_'.$field_id];
			if( $field['validator'] )
				$value = apply_filters( 'wto_validate_'.$field['validator'], $value );
			_wto_update_option( $field_id, $value );

			if( $field['trigger'] )
				do_action( $field['trigger'], $field );

		endforeach;

	endforeach;

	$wto_saved = true;
}

if( $_POST['wpext_save'] ) add_action('init', '_wto_save');
