<?php
/*
 * @file fields
 * display meta box fields
 */

/**
 * A field that just acts as a section header
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[value] - the section title
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_title_field( $field_id, $field, $source = 'posts' ) {

	extract( $field );

	switch( $source ) :
		case 'posts' :
			?><h4 id="wcpt_<?php echo $field_id; ?>"><?php echo $value; ?></h4><?php
			break;
		default:
			?><p id="wcpt_<?php echo $field_id; ?>"><strong><?php echo $value; ?></strong></p><?php
			if( $description ) : ?><p><?php echo $description; ?></p><?php endif; 
	endswitch;

}

/**
 * A field that acts as a text input
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[name] - the label of the input
 *      field[placeholder] - the inputs placeholder
 *      field[description] - a <em> description
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_text_field( $field_id, $field, $source = 'posts' ) {

	global $post;


	$id = str_replace( array('[', ']'), '_', $field_id );
	extract( $field );

	switch( $source ) :
		case 'posts' :
			$value_override = $field['value_override'] ? $field['value_override'] : _wcpt_get_post_meta( $post->ID, $field_id );
			break;
		default:
			$value_override = $field['value_override'] ? $field['value_override'] : _wto_get_option( $field_id );
	endswitch;

	$value_override = htmlentities( $value_override, ENT_QUOTES );

	?>

	<?php if( $name ) : ?><p><label  for="wcpt_<?php echo $field_id; ?>"><?php echo $name; ?>:</label></p><?php endif; ?>
	<p>
		<input name="wcpt_<?php echo $field_id; ?>" id="wcpt_<?php echo $id; ?>" type="text" class="widefat" value='<?php echo $value_override; ?>' placeholder="<?php echo $placeholder; ?>" />
		<?php if( $description ) : ?><em><?php echo $description; ?></em><?php endif; ?>
	</p>

	<?php
}


/**
 * A field that acts as a simple textarea
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[name] - the label of the input
 *      field[placeholder] - the inputs placeholder
 *      field[description] - a <em> description
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_simple_textarea_field( $field_id, $field, $source = 'posts' ) {

	global $post;


	$id = str_replace( array('[', ']'), '_', $field_id );
	extract( $field );

	switch( $source ) :
		case 'posts' :
			$value_override = $field['value_override'] ? $field['value_override'] : _wcpt_get_post_meta( $post->ID, $field_id );
			break;
		default:
			$value_override = $field['value_override'] ? $field['value_override'] : _wto_get_option( $field_id );
	endswitch;

	$value_override = htmlentities( $value_override, ENT_QUOTES );

	?>

	<?php if( $name ) : ?><p><label  for="wcpt_<?php echo $field_id; ?>"><?php echo $name; ?>:</label></p><?php endif; ?>
	<p>
		<textarea name="wcpt_<?php echo $field_id; ?>" id="wcpt_<?php echo $id; ?>" type="text" class="widefat"><?php echo $value_override; ?></textarea>
		<?php if( $description ) : ?><em><?php echo $description; ?></em><?php endif; ?>
	</p>

	<?php
}

/**
 * A field that acts as a text input
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[name] - the label of the input
 *      field[placeholder] - the inputs placeholder
 *      field[description] - a <em> description
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_date_field( $field_id, $field, $source = 'posts' ) {

	global $post;


	$id = str_replace( array('[', ']'), '_', $field_id );
	extract( $field );

	switch( $source ) :
		case 'posts' :
			$value_override = $field['value_override'] ? $field['value_override'] : _wcpt_get_post_meta( $post->ID, $field_id );
			break;
		default:
			$value_override = $field['value_override'] ? $field['value_override'] : _wto_get_option( $field_id );
	endswitch;

	$value_override = htmlentities( $value_override, ENT_QUOTES );

	?>

	<?php if( $name ) : ?><p><label  for="wcpt_<?php echo $field_id; ?>"><?php echo $name; ?>:</label></p><?php endif; ?>
	<p>
		<input name="wcpt_<?php echo $field_id; ?>" id="wcpt_<?php echo $id; ?>" type="text" class="widefat datepicker" value='<?php echo $value_override; ?>' placeholder="<?php echo $placeholder; ?>" />
		<?php if( $description ) : ?><em><?php echo $description; ?></em><?php endif; ?>
	</p>

	<script>
		jQuery(function() {
			jQuery('.datepicker').datepicker();
		});
	</script>

	<?php

	wp_enqueue_script( 'jquery-ui-datepicker' );
	wp_enqueue_style('jquery-style', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');

}

/**
 * A field that acts as a checkbox input
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[name] - the label of the input
 *      field[value] - the checkboxes value
 *      field[description] - a <em> description
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_checkbox_field( $field_id, $field, $source = 'posts' ) {
	
	global $post;

	$id = str_replace( array('[', ']'), '_', $field_id );
	extract( $field );

	switch( $source ) :
		case 'posts' :
			$value_override = $field['value_override'] ? $field['value_override'] : _wcpt_get_post_meta( $post->ID, $field_id );
			break;
		default:
			$value_override = $field['value_override'] ? $field['value_override'] : _wto_get_option( $field_id );
	endswitch;

	?>

	
	<p>
		<input name="wcpt_<?php echo $field_id; ?>" id="wcpt_<?php echo $id; ?>" type="checkbox" value='<?php echo $value; ?>' <?php checked( $value, $value_override ); ?> />
		<?php if( $name ) : ?><label  for="wcpt_<?php echo $field_id; ?>"><?php echo $name; ?></label><?php endif; ?>
	</p>

	<?php if( $description ) : ?><p><em><?php echo $description; ?></em></p><?php endif; ?>

	<?php
}

/**
 * A field that acts as a select input
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[name] - the label of the input
 *      field[value] - the checkboxes value
 *      field[description] - a <em> description
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_select_field( $field_id, $field, $source = 'posts' ) {
	
	global $post;
	global $wcpt_prefix;

	$id = str_replace( array('[', ']'), '_', $field_id );
	extract( $field );

	switch( $source ) :
		case 'posts' :
			$current = $field['value_override'] ? $field['value_override'] : _wcpt_get_post_meta( $post->ID, $field_id );
			break;
		default:
			$current = $field['value_override'] ? $field['value_override'] : _wto_get_option( $field_id );
	endswitch;

	if( !$current )
		$current = $default_value;

	?>

	<?php if( $name ) : ?><p><label  for="wcpt_<?php echo $field_id; ?>"><?php echo $name; ?>:</label></p><?php endif; ?>
	<p>
		<select name="wcpt_<?php echo $field_id; ?>" id="wcpt_<?php echo $id; ?>" type="text">
			<?php foreach( $options as $opt_value => $option ) : ?>
			<option value='<?php echo $opt_value ? $opt_value : $option; ?>' <?php selected( $opt_value ? $opt_value : $option, $current ); ?>><?php echo $option; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php if( $description ) : ?><p><em><?php echo $description; ?></em></p><?php endif; ?>

	<?php
}

/**
 * A field that just acts as a dynamic settings group
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[add_description] - the description for the add button
 *		field[delete_description] - the description for the delete button
 *		field[delete_description] - the description for the delete button
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_array_field( $field_id, $field, $source = 'posts' ) {

	global $post;

	$field = wp_parse_args( $field, array(
		'add_description' => __('Add'),
		'delete_description' => __('Delete')
	));

	switch( $source ) :
		case 'posts' :
			$pre_value = _wcpt_get_post_meta( $post->ID, $field_id, true );
			break;
		default:
			$pre_value = _wto_get_option( $field_id, true );
	endswitch;

	extract( $field );
	$column_count = 1;

	$have_textarea = false;
	foreach( $field as $subfield_id => $subfield ) : if( !is_array( $subfield ) || $subfield['type'] !== 'textarea') continue;
		$have_textarea = true;
	endforeach;

	?>

	<table class="shippingrows widefat form-table" id="wcpt_<?php echo $field_id; ?>" cellspacing="0">

		<thead><tr>
			<th class="column-cb check-column" id="cb"><input type="checkbox" class="all" /></th>
			<?php foreach( $field as $subfield ) : if( !is_array( $subfield ) || !$subfield['type'] ) continue; ++$column_count; ?>
			<th><?php echo $subfield['value']; ?></th>
			<?php endforeach; ?>
		</tr></thead>

		<tfoot><tr><th colspan="<?php echo $column_count; ?>" style="text-align:center;">
			<a href="#" class="add button alignleft">+ <?php echo $add_description; ?></a>
			<a href="#" class="remove button alignright"><?php echo $delete_description; ?></a>
			<small><?php echo $description; ?></small>
		</th></tr></tfoot>

		<tbody>

			<?php 
				$rows = 0;
				$columns = array();
				$row_count = 0;

				if( is_array( $pre_value ) ) foreach( $pre_value as $row_id => $row ) : ++$row_count;

			?>
			<tr id="<?php echo $field_id; ?>-<?php echo $rows; ?>">

				<th class="check-column"><input type="checkbox" /></th>

				<?php foreach( $field as $subfield_id => $subfield ) : if( !is_array( $subfield ) || !$subfield['type'] ) continue; $subfield['value_override'] = $row[$subfield_id]; ?>
				<td><?php do_action( 'wcpt_display_'.$subfield['type'].'_field', $field_id.'['.$rows.']['.$subfield_id.']', $subfield, $source ); ?></td>
				<?php endforeach; ?>

			</tr>
			<?php

					++$rows;

				endforeach; 
			?>


			<tr id="<?php echo $field_id; ?>-template" class="wcpt-template">

				<th class="check-column"><input type="checkbox" /></th>

				<?php $row = 0; foreach( $field as $subfield_id => $subfield ) : if( !is_array( $subfield ) || !$subfield['type'] ) continue; $row_id = '%name%'; if( $have_textarea ) $row_id = $row_count; ?>
				<td><?php do_action( 'wcpt_display_'.$subfield['type'].'_field', $field_id.'['.$row_id.']['.$subfield_id.']', $subfield, $source ); ?></td>
				<?php endforeach; ?>

			</tr>

		</tbody>

	</table>

	<script>

		if( !jQuery('#wcpt_<?php echo $field_id; ?> .wcpt-template .wp-editor-wrap').length ) {

			jQuery('#wcpt_<?php echo $field_id; ?> .wcpt-template').hide();

			jQuery('#wcpt_<?php echo $field_id; ?> .add.button').click(function(e) {

				var item = jQuery('#wcpt_<?php echo $field_id; ?> .wcpt-template').after( jQuery('#wcpt_<?php echo $field_id; ?> .wcpt-template').clone() )
					.removeClass('wcpt-template')
					.css('opacity', 0)
					.show()
					.animate({opacity:1});

				var row = 0;
				jQuery('#wcpt_<?php echo $field_id; ?> .wcpt-template').parent().children().not('.wcpt-template').each( function() {
					jQuery(this).find('[name]').each( function() {
						var $this = jQuery(this);
						var src = $this.attr('name').replace('%name%', row);
						$this.attr('name', src);
					});
					++row;
				});


				e.preventDefault();
				return false;

			});

		} else {

			// only allow a user to add if there isn't an editor in the row
			jQuery('#wcpt_<?php echo $field_id; ?> .add.button').hide();

		}

		jQuery('#wcpt_<?php echo $field_id; ?> .remove.button').click(function(e) {

			jQuery('#wcpt_<?php echo $field_id; ?> tbody tr').each( function() {
				
				var $this = jQuery(this);

				if( $this.hasClass('wcpt-template') )
					return;

				if( $this.find('.check-column input:checked').length )
					$this.animate({opacity:0}, function() {
						$this.remove();
					});

			});

			e.preventDefault();
			return false;

		});

	</script>

	<?php
}

/**
 * A field that just acts as a section header
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[value] - the section title
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_textarea_field( $field_id, $field, $source = 'posts' ) {

	global $post;
	
	$id = str_replace( array('[', ']'), '_', $field_id );
	extract( $field );

	switch( $source ) :
		case 'posts' :
			$content = $field['value_override'] ? $field['value_override'] : _wcpt_get_post_meta( $post->ID, $field_id );
			break;
		default:
			$content = $field['value_override'] ? $field['value_override'] : _wto_get_option( $field_id );
	endswitch;

	wp_editor( $content, 'wcpt_'.$id, array(
		'media_buttons' => false,
		'textarea_name' => 'wcpt_'.$field_id,
	) );

}

/**
 * A field that allows the uploading of an image
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[value] - the section title
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_image_field( $field_id, $field, $source = 'posts' ) {

	extract( $field );

	global $post;

	$id = str_replace( array('[', ']'), '_', $field_id );
	extract( $field );

	switch( $source ) :
		case 'posts' :
			$value_override = $field['value_override'] ? $field['value_override'] : _wcpt_get_post_meta( $post->ID, $field_id );
			break;
		default:
			$value_override = $field['value_override'] ? $field['value_override'] : _wto_get_option( $field_id );
	endswitch;

	?>

	<?php if( $name ) : ?><p><label  for="wcpt_<?php echo $field_id; ?>"><?php echo $name; ?>:</label></p><?php endif; ?>
	
	<div class="widefat">
		<input readonly name="wcpt_<?php echo $field_id; ?>" id="wcpt_<?php echo $id; ?>" type="text" value='<?php echo $value_override; ?>' placeholder="<?php echo $placeholder; ?>" />
		<input type="button" id="wcpt_<?php echo $id; ?>_button" class="wcpt_image_button button" value="Choose Image" /><br/>
	</div>

	<p>
		<img src="<?php echo $value_override; ?>" style="<?php if( !$value_override ) echo 'display:none; '; ?>max-width: 100%;" />

		<?php if( $description ) : ?><em><?php echo $description; ?></em><?php endif; ?>

		<script>
			jQuery(function(){

				jQuery('body').on('click', '.wcpt_image_button', function() {

					var $this = jQuery(this);

					if ( typeof wp !== 'undefined' && wp.media && wp.media.editor ) {

						window.original_send = wp.media.editor.send.attachment;

						wp.media.editor.send.attachment = function( a, b ) {
							console.log('attach');
						   $this.prev().val(b.url);
						   $this.parent().next().find('img').attr( 'src', b.url ).css({'opacity': 0, 'max-width': '80%'}).show().animate({'opacity': 1});
					    };

					    wp.media.editor.open( 'image' );

					    window.original_send_to_editor = window.send_to_editor; 

					    window.send_to_editor = function(html) {}

					}

				});

				/* fix */
				jQuery('.wcpt_image_button').on('click', function() {

					var $this = jQuery(this);

					if ( typeof wp !== 'undefined' && wp.media && wp.media.editor ) {

						window.original_send = wp.media.editor.send.attachment;

						wp.media.editor.send.attachment = function( a, b ) {
							console.log('attach');
						   $this.prev().val(b.url);
						   $this.parent().next().find('img').attr( 'src', b.url ).css({'opacity': 0, 'max-width': '80%'}).show().animate({'opacity': 1});
					    };

					    wp.media.editor.open( 'image' );

					    window.original_send_to_editor = window.send_to_editor; 

					    window.send_to_editor = function(html) {}

					}

				});

			});

			if( typeof wcpt_image_uploads === 'undefined' || !wcpt_image_uploads ) {
				
				jQuery(function() {

					wp.media.view.Modal.prototype.on('close', function(){ 

						if( window.original_send ) {

							wp.media.editor.send.attachment = window.original_send;
							window.send_to_editor = window.original_send_to_editor;

							window.original_send = false;

						}

					});

				});

				wcpt_image_uploads = true;

			}
			
		</script>

	</p>

	<?php
}


/**
 * A field that allows the uploading of a file using the media uploader
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[value] - the section title
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_file_field( $field_id, $field, $source = 'posts' ) {

	extract( $field );

	global $post;

	$id = str_replace( array('[', ']'), '_', $field_id );
	extract( $field );

	switch( $source ) :
		case 'posts' :
			$value_override = $field['value_override'] ? $field['value_override'] : _wcpt_get_post_meta( $post->ID, $field_id );
			break;
		default:
			$value_override = $field['value_override'] ? $field['value_override'] : _wto_get_option( $field_id );
	endswitch;

	?>

	<?php if( $name ) : ?><p><label  for="wcpt_<?php echo $field_id; ?>"><?php echo $name; ?>:</label></p><?php endif; ?>
	
	<div class="widefat">
		<input readonly name="wcpt_<?php echo $field_id; ?>" id="wcpt_<?php echo $id; ?>" type="text" value='<?php echo $value_override; ?>' placeholder="<?php echo $placeholder; ?>" />
		<input type="button" id="wcpt_<?php echo $id; ?>_button" class="wcpt_file_button button" value="Choose File" /><br/>
	</div>

	<p>
		<?php if( $description ) : ?><em><?php echo $description; ?></em><?php endif; ?>

		<script>
			jQuery(function(){

				jQuery('body').on('click', '.wcpt_file_button', function() {

					var $this = jQuery(this);

					if ( typeof wp !== 'undefined' && wp.media && wp.media.editor ) {

						window.original_send = wp.media.editor.send.attachment;

						wp.media.editor.send.attachment = function( a, b ) {
							console.log('attach');
						    $this.prev().val(b.url);
					    };

					    wp.media.editor.open( 'image' );

					    window.original_send_to_editor = window.send_to_editor; 

					    window.send_to_editor = function(html) {}

					}

				});

				/* fix */
				jQuery('.wcpt_file_button').on('click', function() {

					var $this = jQuery(this);

					if ( typeof wp !== 'undefined' && wp.media && wp.media.editor ) {

						window.original_send = wp.media.editor.send.attachment;

						wp.media.editor.send.attachment = function( a, b ) {
							console.log('attach');
						   	$this.prev().val(b.url);
					    };

					    wp.media.editor.open( 'image' );

					    window.original_send_to_editor = window.send_to_editor; 

					    window.send_to_editor = function(html) {}

					}

				});

			});

			if( typeof wcpt_file_uploads === 'undefined' || !wcpt_file_uploads ) {
				
				jQuery(function() {

					wp.media.view.Modal.prototype.on('close', function(){ 

						if( window.original_send ) {

							wp.media.editor.send.attachment = window.original_send;
							window.send_to_editor = window.original_send_to_editor;

							window.original_send = false;

						}

					});

				});

				wcpt_file_uploads = true;

			}
			
		</script>

	</p>

	<?php
}

/**
 * A field that produces a dropdown a list of posts this post can be related to
 *
 * @param field_id 	the fields id
 * @param field 	the field options:
 *		field[value] - the section title
 *
 * @since 1.0
 * @author shannon
 */
function wpext_display_posts_field( $field_id, $field, $source = 'posts' ) {
	
	global $post;
	global $wcpt_prefix;

	$id = str_replace( array('[', ']'), '_', $field_id );
	extract( $field );

	$posts = array();

	if( trim($post_types) )
		$post_types = explode(',', trim($post_types));
	else
		$post_types = array('post');

	$posts = get_posts( array(
		'post_type' => $post_types,
		'posts_per_page' => -1,
		'post_status' => 'publish'
	) );

	switch( $source ) :
		case 'posts' :
			$current = $field['value_override'] ? $field['value_override'] : _wcpt_get_post_meta( $post->ID, $field_id );
			break;
		default:
			$current = $field['value_override'] ? $field['value_override'] : _wto_get_option( $field_id );
	endswitch;

	if( !$current )
		$current = $default_value;

	?>

	<?php if( $name ) : ?><p><label  for="wcpt_<?php echo $field_id; ?>"><?php echo $name; ?>:</label></p><?php endif; ?>
	<p>
		<select class="widefat" name="wcpt_<?php echo $field_id; ?>" id="wcpt_<?php echo $id; ?>" type="text">
			<option value="0">None</option>
			<?php foreach( $posts as $the_post ) : ?>
			<option value="<?php echo $the_post->ID; ?>" <?php selected( $the_post->ID, $current ); ?>><?php echo $the_post->post_title; ?></option>
			<?php endforeach; ?>
		</select>
	</p>
	<?php if( $description ) : ?><p><em><?php echo $description; ?></em></p><?php endif; ?>

	<?php
}

add_action( 'wcpt_display_title_field', 'wpext_display_title_field', 10, 3 );
add_action( 'wcpt_display_text_field', 'wpext_display_text_field', 10, 3 );
add_action( 'wcpt_display_checkbox_field', 'wpext_display_checkbox_field', 10, 2 );
add_action( 'wcpt_display_select_field', 'wpext_display_select_field', 10, 2 );
add_action( 'wcpt_display_dropdown_field', 'wpext_display_select_field', 10, 2 );
add_action( 'wcpt_display_array_field', 'wpext_display_array_field', 10, 2 );
add_action( 'wcpt_display_settings-group_field', 'wpext_display_array_field', 10, 2 );
add_action( 'wcpt_display_textarea_field', 'wpext_display_textarea_field', 10, 2 );
add_action( 'wcpt_display_simple_textarea_field', 'wpext_display_simple_textarea_field', 10, 2 );
add_action( 'wcpt_display_image_field', 'wpext_display_image_field', 10, 2 );
add_action( 'wcpt_display_file_field', 'wpext_display_file_field', 10, 2 );
add_action( 'wcpt_display_posts_field', 'wpext_display_posts_field', 10, 2 );
add_action( 'wcpt_display_date_field', 'wpext_display_date_field', 10, 2 );


add_action( 'wto_display_title_field', 'wpext_display_title_field', 10, 3 );
add_action( 'wto_display_text_field', 'wpext_display_text_field', 10, 3 );
add_action( 'wto_display_checkbox_field', 'wpext_display_checkbox_field', 10, 3 );
add_action( 'wto_display_select_field', 'wpext_display_select_field', 10, 3 );
add_action( 'wto_display_dropdown_field', 'wpext_display_select_field', 10, 3 );
add_action( 'wto_display_array_field', 'wpext_display_array_field', 10, 3 );
add_action( 'wto_display_settings-group_field', 'wpext_display_array_field', 10, 3 );
add_action( 'wto_display_date_field', 'wpext_display_date_field', 10, 3 );
add_action( 'wto_display_posts_field', 'wpext_display_posts_field', 10, 3 );
add_action( 'wto_display_textarea_field', 'wpext_display_textarea_field', 10, 3 );
add_action( 'wto_display_simple_textarea_field', 'wpext_display_simple_textarea_field', 10, 3 );
add_action( 'wto_display_image_field', 'wpext_display_image_field', 10, 3 );
add_action( 'wto_display_file_field', 'wpext_display_file_field', 10, 3 );

?>