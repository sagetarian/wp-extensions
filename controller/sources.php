<?php
/*
 * @file sources
 * different option sources
 */

function wpext_source_posts( $return, $args ) {

	extract( $args );

	$post_types = trim( $post_types );

	if( $post_types )
		$post_types = explode( ',', $post_types );
	else
		$post_types = array( 'post' );

	$posts = get_posts( array(
		'post_type' => $post_types,
		'posts_per_page' => -1,
		'post_status' => 'publish'
	) );

	if( !$display_source_id )
		$display_source_id = 0;

	foreach( $posts as $post ) :

		if( $display_source && !is_bool( $display_source ) )
			$source = $display_source;
		else
			$source = $post->post_type;

		$return[$post->ID] = $display_source ? 
			$post->post_title . ' <span class="source" id="source-'. $display_source_id .'">&nbsp;' . $source . '&nbsp;</span>' : 
			$post->post_title;
	endforeach;

	return $return;

}

add_filter( 'wpext_source_posts', 'wpext_source_posts', 10, 3 );