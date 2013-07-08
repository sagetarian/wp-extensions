<?php
/*
 * @file post-types
 * automatically create various custom post type and metaboxes
 */

include_once "validators.php";

function wcpt_init() {

	$post_types = apply_filters( 'wcpt_get_post_types',  array() );

	// loop through all custom post types to register
	foreach( $post_types as $id => $cpt ) :

		if( !$cpt['register_post_type'] )
			continue;

		$args = $cpt['args'];

		$slug = $args['slug'] ? $args['slug'] : $id;

		$defaults = array(
			'rewrite' => array( 'slug' => $slug ),
			'supports' => array( 'title', 'editor' ),
			'menu_position' => null,
			'has_archive' => true,
			'public' => true,
			'labels' => array(
				'name' => __( $cpt['name'] ),
				'singular_name' => __(  $cpt['singular_name'] ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New '.$cpt['singular_name'] ), 
				'edit_item' => __( 'Edit '.$cpt['singular_name'] ),
				'view_item' => __( 'View '.$cpt['singular_name'] ),
				'search_items' => __('Search '.$cpt['name'] ),
			)
		);
		unset( $args['slug'] );

		$args = wp_parse_args( $args, $defaults );

		if( !is_array( $args['supports'] ) )
			$args['supports'] = explode( ',', $args['supports'] );

		register_post_type( $id, $args );

	endforeach;

}

function wcpt_add_meta_boxes() {

	$post_types = apply_filters( 'wcpt_get_post_types',  array() );

	// loop through all custom post types to register
	foreach( $post_types as $id => $cpt ) :

		if( !$cpt['meta'] )
			continue;

		foreach( $cpt['meta'] as $m_id => $meta ):

			$defaults = array(
				'side' => 'normal',
				'priority' => 'low'
			);
			$args = wp_parse_args( $meta, $defaults );

			add_meta_box( 
	           $id.'-'.$m_id,
	           $meta['title'],
	           'wcpt_metabox_callback',
	           $id,
	           $args['side'],
	           $args['priority'], 
	           $meta['fields']
	    	);

		endforeach;

	endforeach;

}

function wcpt_metabox_callback( $post, $metabox ) {

	$post_id = $post->ID;
	$fields = $metabox['args'];
	
	foreach( $fields as $field_id => $field ):

		do_action( 'wcpt_display_'.$field['type'].'_field', $field_id, $field );

	endforeach;

}

function wcpt_save_meta_fields( $post_id ) {

	// skip autosaves
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

	global $post;

	$post_types = apply_filters( 'wcpt_get_post_types',  array() );

	$id = $post->post_type;
	$cpt = $post_types[ $id ];


	if( !isset( $post_types[ $id ] ) || !$cpt['meta'] )
		return;

	foreach( $cpt['meta'] as $m_id => $meta ):

		foreach( $meta['fields'] as $field_id => $field ) :

			//if( isset( $_POST['wcpt_'.$field_id] ) ) :
			
				$value = $_POST['wcpt_'.$field_id];
				if( $field['validator'] )
					$value = apply_filters( 'wcpt_validate_'.$field['validator'], $value );

				update_post_meta( $post_id, $field_id, $value );

				if( $field['trigger'] )
					do_action( $field['trigger'], $field );

			//endif;

		endforeach;

	endforeach;

}

/**
 * internal function that gets the post meta even if the meta key is an array
 *
 * @since 1.0
 * @author shannon
 */
function _wcpt_get_post_meta( $post_id, $meta_key, $skip_empty_rows = false ) {

	if( $skip_empty_rows ) :

		$value = get_post_meta( $post_id, $meta_key, true );
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

	return get_post_meta( $post_id, $meta_key, true );
}

function _wcpt_get_image_from_src( $src, $size = 'full' ) {
	global $wpdb;
	$images = $wpdb->get_results( "SELECT ID FROM ".$wpdb->posts." WHERE `guid` = '".$src."'" );
	if( !count( $images ) )
		return $src;

	if( $image = wp_get_attachment_image_src( $images[0]->ID, $size ) )
		return $image[0];
	return $src;
}

add_action( 'init', 'wcpt_init' );
add_action( 'add_meta_boxes', 'wcpt_add_meta_boxes' );
add_action( 'save_post', 'wcpt_save_meta_fields' );

?>