<?php

	$file = str_replace( '\\', '/', __FILE__ ); // windows fix

	if( strpos( $file, 'wp-content/plugins/' ) !== false ) :
		define( 'WPEXT_URL', plugins_url( '', $file ) );
	else :
		$relative_url = str_replace( get_template_directory(), '', dirname( $file ) );
		define( 'WPEXT_URL', get_template_directory_uri().$relative_url );
	endif;