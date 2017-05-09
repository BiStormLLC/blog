<?php
/**
 * BiStorm functions and definitions
 *
 * @package BiStorm
 */


if ( ! function_exists( 'bistorm_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bistorm_setup() {


	
}
endif; // bistorm_setup
add_action( 'after_setup_theme', 'bistorm_setup' );

// functions.php
function enqueue_ajax_load_more() {
   wp_enqueue_script('ajax-load-more'); // Already registered, just needs to be enqueued   
}
add_action( 'wp_enqueue_scripts', 'enqueue_ajax_load_more' );

// Add anchor links to excerpts
function bistorm_trim_excerpt($text) {
  $raw_excerpt = $text;
  if ( '' == $text ) {
    $text = get_the_content('');
    $text = strip_shortcodes( $text );
    $text = apply_filters('the_content', $text);
    $text = str_replace(']]>', ']]>', $text);
    $text = strip_tags($text, '<a>');
    $excerpt_length = apply_filters('excerpt_length', 55);
    $excerpt_more = apply_filters('excerpt_more', ' ' . '[...]');
    $words = preg_split('/(<a.*?a>)|\n|\r|\t|\s/', $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE );
    if ( count($words) > $excerpt_length ) {
      array_pop($words);
      $text = implode(' ', $words);
      $text = $text . $excerpt_more;
      } 
    else {
      $text = implode(' ', $words);
      }
    }
  return apply_filters('new_wp_trim_excerpt', $text, $raw_excerpt);
  }
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'bistorm_trim_excerpt');

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function bistorm_widgets_init() {
	
}
add_action( 'widgets_init', 'bistorm_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function bistorm_scripts() {
}
add_action( 'wp_enqueue_scripts', 'bistorm_scripts' );


/**
 * TGMPA register
 */
function bistorm_register_required_plugins() {

}
add_action( 'tgmpa_register', 'bistorm_register_required_plugins' );





/**
 * Custom rendering of excerpt for front page
 */
function bistorm_the_excerpt() {
	$content_type = bistorm_content_get_content_type();
	$content = bistorm_content_get_content();
 	if($content_type == 'twitter') {
	 	$excerpt = $content;
		$excerpt = apply_filters('the_content', $excerpt);
		$excerpt = str_replace(']]>', ']]&gt;', $excerpt);
		$excerpt = str_replace("\r", "<br />", $excerpt);
	} else {
		$excerpt = get_the_excerpt();
	}
        echo $excerpt;
}

/**
 * Return the post content
 */
function bistorm_content_get_content() {
	$content = get_the_content();
	return $content;
}


/**
 * Determine if the content type is a social share
 */
function bistorm_content_get_content_type() {
	$content_type = 'post';
	$content = bistorm_content_get_content();
	$title = get_the_title();
	
	// Tweet
	if( strpos(strtolower($title), 'twitter') !== FALSE  || preg_match('/[Twitter @]^/', $title) ) {
            $content_type = 'twitter';
	}	

	return $content_type;
}


/**
 * Custom excert array for managing content published through external services
 * 
 * NOT IN USE
 */
function bistorm_content_excerpt( $content ) {
	$content_array = array(
		'content' => "",
		'images' => array(),
		'tags' => array(),
	);
	
	$content_by_link = explode('http' , $content );
	$urls = array();
	if( count($content_by_link) > 1) {
		foreach($content_by_link AS $string_with_link) {
			$end_of_url = strpos($string_with_link, " ");
			$sub_url = substr($string_with_link, 0, $end_of_url);
			$rest_of_string = substr($string_with_link, $end_of_url);
			$url = 'http' . $sub_url;
			$anchor = "<a href='" . $url . "' target='_blank'>" . $url . "</a> " . $rest_of_string;
			array_push($urls, $anchor);
		}
		for($i=1; $i < count($content_by_link); $i++) {
			$content_by_link[$i] = $urls[$i];
		}
		return implode($content_by_link);
		
	}
}

/**
 * Parses a string, finds images and places them into an array
 * 
 * NOT IN USE
 * 
 * RETURN: array $images
 */
function bistorm_get_content_images( $content ) {
	$pattern = '/^.*\.(jpg|jpeg|png|gif)$/i';
	preg_match($pattern, $content, $matches);
	if(count($matches)) {
		var_dump($matches);
	}
	return $matches;
	
	$content_by_link = explode('http' , $content );
	$urls = array();
	if( count($content_by_link) > 1) {
		foreach($content_by_link AS $string_with_link) {
			$end_of_url = strpos($string_with_link, " ");
			$sub_url = substr($string_with_link, 0, $end_of_url);
			$rest_of_string = substr($string_with_link, $end_of_url);
			$url = 'http' . $sub_url;
			$anchor = "<a href='" . $url . "' target='_blank'>" . $url . "</a> " . $rest_of_string;
			array_push($urls, $anchor);
		}
		for($i=1; $i < count($content_by_link); $i++) {
			$content_by_link[$i] = $urls[$i];
		}
		return implode($content_by_link);
		
	}
}

/**
 * Allow svg mime type for upload
 */
function bistorm_cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  $mimes['svgz'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'bistorm_cc_mime_types');