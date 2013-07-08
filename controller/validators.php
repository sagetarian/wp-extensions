<?php
/*
 * @file validators
 * list of validators
 */

function wcpt_get_youtube_id( $youtube_url ) {
	$url = parse_url($youtube_url);
	if( $url['host'] !== 'youtube.com' &&
        $url['host'] !== 'www.youtube.com'&&
        $url['host'] !== 'youtu.be'&&
        $url['host'] !== 'www.youtu.be')
        return '';

    if( $url['host'] === 'youtube.com' || $url['host'] === 'www.youtube.com' ) :
    	parse_str(parse_url($youtube_url, PHP_URL_QUERY), $query_string);
    	return $query_string["v"];
    endif;

    $youtube_id = substr( $url['path'], 1 );
    if( strpos( $youtube_id, '/' ) )
    	$youtube_id = substr( $youtube_id, 0, strpos( $youtube_id, '/' ) );
    return $youtube_id;
}

function wcpt_validate_youtube_url( $youtube_url ) {

	$youtube_id = wcpt_get_youtube_id( $youtube_url );

	if( !$youtube_id )
		return '';


    return 'http://www.youtube.com/watch?v='.$youtube_id;

}

add_filter( 'wcpt_validate_youtube_url', 'wcpt_validate_youtube_url' );
add_filter( 'wto_validate_youtube_url', 'wcpt_validate_youtube_url' );

?>