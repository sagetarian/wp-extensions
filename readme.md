WP-Extensions
=============

Include this in your theme to add Theme Options and Metaboxes programmatically and easily in your theme. A great way to avoid attaching to many plugins to a client site.

How to use
----------

#### In functions.php

    require_once "includes/wp-extensions/init.php";
    
    function products_post_type( $post_types ) {

        $post_types['products'] = array(
            'register_post_type' => true,
            'args' => array(
              'supports' => 'title,editor,thumbnail',
              'menu_position' => 5,
              'rewrite' => false,
              'publicly_queryable' => false
            ),
            'name' => 'Products',
            'singular_name' => 'Product',
            'meta' => array(
                'details' => array(
                    'title' => __('Details'),
                    'side' => 'side',
                    'fields' => array(
                        'section-1' => array(
                            'type' => 'title',
                            'value' => __('Price')
                        ),
                        'price' => array(
                            'type' => 'text',
                        ),
                        'section-2' => array(
                            'type' => 'title',
                            'value' => __('Weight')
                        ),
                        'weight' => array(
                            'type' => 'text',
                        ),
                    )
                ),
            )
        );

        return $post_types;
    }

    add_filter( 'wcpt_get_post_types', 'products_post_type' );
    
    function theme_options( $options ) {
	    $options = array(
		    'general' => array(
			    'title' => __('General'),
			    'fields' => array(
				    'section-1' => array(
					    'type' => 'title',
                    	'value' => __('Social Profiles'),
                    	'description' => __('Set the links to all your social profiles.'),
				    ),
				    'facebook' => array(
					    'type' => 'text',
					    'name' => __('Facebook'),
				    ),
				    'twitter' => array(
					    'type' => 'text',
					    'name' => __('Twitter'),
				    ),
				    'linkedin' => array(
					    'type' => 'text',
					    'name' => __('LinkedIn'),
				    ),
				    'pinterest' => array(
					    'type' => 'text',
					    'name' => __('Pinterest'),
				    ),
				    'section-2' => array(
					    'type' => 'title',
                    	'value' => __('Others'),
                    	'description' => __('Other options for the site.'),
				    ),
				    'youtube_url' => array(
					    'type' => 'text',
					    'name' => __('Featured Video'),
					    'description' => __('Link to a YouTube clip.'),
					    'validator' => 'youtube_url'
				    ),
				    'section-3' => array(
					    'type' => 'title',
                    	'value' => __('Twitter Feeds'),
				    ),
				    'twitter_feeds' => array(
					    'type' => 'text',
					    'name' => __('Twitter Feeds'),
					    'description' => __('Comma seperated list of twitter handles.'),
				    ),
				    'twitter_follow_feeds' => array(
					    'type' => 'settings-group',
                    	'name' => __('Twitter Follow Feeds'),
                        'description' => __('Add twitter handles.'),
                        'twitter_handle' => array(
                            'type' => 'text',
                            'value' => __('Twitter Handles')
                        ),
				    )
			    )
		    )
	    );
	    return $options;
    }

    add_filter('wto_options', 'theme_options');
    
#### Further documentation needed for various field types
