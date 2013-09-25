<?php
/*
 * @file taxonomies
 * automatically create various custom taxonomies 
 */

function wct_init() {

	$taxonomies = apply_filters( 'wct_get_taxonomies',  array() );
	$have_meta = false;

	// loop through all custom post types to register
	foreach( $taxonomies as $id => $ct ) :

		if( !$ct['register_taxonomy'] )
			continue;

		$defaults = array(
			'query_var' => $id,
			'public' => true,
			'rewrite' => array( 'slug' => $id, 'with_front' => false ),
			'hierarchical' => true,
			'labels' => array(
				'name' => __( $ct['name'] ),
				'singular_name' => __( $ct['singular_name'] ),
				'search_items' =>  __( 'Search '.$ct['singular_name'] ),
				'all_items' => __( 'All '.$ct['name'] ),
				'parent_item' => __( 'Parent '.$ct['singular_name'] ),
				'parent_item_colon' => __( 'Parent '.$ct['singular_name'].':' ),
				'edit_item' => __( 'Edit '.$ct['singular_name'] ), 
				'update_item' => __( 'Update '.$ct['singular_name'] ),
				'add_new_item' => __( 'Add New '.$ct['singular_name'] ),
				'new_item_name' => __( 'New '.$ct['singular_name'].' Name' ),
			) 
		);

		if( !isset( $ct['args'] ) )
			$ct['args'] = array();

		$args = wp_parse_args( $ct['args'], $defaults );
		//var_dump( $args );

		register_taxonomy( $id, $ct['post_types'], $args );

		if( !@$ct['meta'] )
			continue;

		add_action( $id.'_add_form_fields', 'wct_add_meta_fields' );  
		add_action( $id.'_edit_form_fields', 'wct_add_meta_fields' );

		add_action( 'edited_'.$id, 'wct_save_meta_fields', 10, 3 );  
		add_action( 'created_'.$id, 'wct_save_meta_fields', 10, 3 );

		if( is_admin() && @$_GET['taxonomy'] == $id )
			$have_meta = true;

	endforeach;


	if( $have_meta )
		wp_enqueue_media();

}

function wct_add_meta_fields( $id ) {

	$taxonomies = apply_filters( 'wct_get_taxonomies',  array() );

	if( !is_string( $id ) )
		$id = $id->taxonomy;

	$ct = $taxonomies[ $id ];

	// loop through all custom post types to register
	$source = 'add-taxonomy';

	if( $_GET['action'] == 'edit' )
		$source = 'edit-taxonomy';

	foreach( $ct['meta'] as $field_id => $field ) 
		do_action( 'wct_display_'.$field['type'].'_field', $field_id, $field, $source );

}

function wct_save_meta_fields( $term_id, $term_taxonomy_id ) {

	global $wpdb;

	$term_slug = false;
	$taxonomies = apply_filters( 'wct_get_taxonomies',  array() );

	$taxonomy_slug = $wpdb->get_var( "SELECT taxonomy FROM {$wpdb->term_taxonomy} WHERE term_taxonomy_id = '{$term_taxonomy_id}'");

	if( !$taxonomy_slug )
		return;

	$term = get_term( $term_id, $taxonomy_slug );

	if( !$term || is_wp_error( $term ) )
		return;

	$term_slug = $term->slug;
	$ct = $taxonomies[$taxonomy_slug];

	foreach( $ct['meta'] as $field_id => $field ) :
		
		$value = $_POST['wcpt_'.$field_id];
		if( $field['validator'] )
			$value = apply_filters( 'wcpt_validate_'.$field['validator'], $value );

		update_metadata( 'term', $term_id, $field_id, $value );

		if( $field['trigger'] )
			do_action( $field['trigger'], $field );

	endforeach;

}

function wct_create_table() {

	global $wpdb;
	$wpdb->termmeta = $wpdb->prefix.'termmeta';

	$wpdb->get_results("CREATE TABLE IF NOT EXISTS `{$wpdb->termmeta}` (
	  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
	  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
	  `meta_key` varchar(255) DEFAULT NULL,
	  `meta_value` longtext,
	  PRIMARY KEY (`meta_id`)
	) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

}

function wct_taxonomies_admin_init() {

	global $pagenow;

	wp_register_script(  'wp-extension', WPEXT_URL.'/view/admin-script.js', array('jquery'), 1.0, true );

	if( $pagenow == 'edit-tags.php' ) :
		wp_enqueue_script(  'wp-extension' );
	endif;

}

/**
 * internal function that gets the post meta even if the meta key is an array
 *
 * @since 1.0
 * @author shannon
 */
function _wct_get_term_meta( $term_id, $meta_key, $skip_empty_rows = false ) {

	if( $skip_empty_rows ) :

		$value = get_metadata( 'term', $term_id, $meta_key, true );

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

	return get_metadata( 'term', $term_id, $meta_key, true );
}

add_action( 'init', 'wct_create_table', 9 );
add_action( 'init', 'wct_init', 9 );
add_action( 'admin_init', 'wct_taxonomies_admin_init' );