<?php
 /**
 * Plugin Name: Widget Twitter
 * Plugin URI: http://web-dorado.com/products/wordpress-twitter-integration-plugin.html
 * Description: The Widget Twitter plugin lets you to fully integrate your WordPress site with your Twitter account.  
 * Version: 1.0.6
 * Author:          WebDorado
 * Author URI:      https://web-dorado.com
 * License: GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
 
 
define('WD_WDTI_DIR', WP_PLUGIN_DIR . "/" . plugin_basename(dirname(__FILE__)));
define('WD_WDTI_URL', plugins_url(plugin_basename(dirname(__FILE__))));
define('WD_WDTI_VERSION_FREE', "1.0.6");

//Twitter Integration Plugin menu. 

function twitt_options_panel() {
  $parent_slug = null;
  if( get_option( "wdti_subscribe_done" ) == 1 ){
    $parent_slug = "twitter_integration";
    $twitt_page = add_menu_page('Widget Twitter', 'Widget Twitter', 'manage_options', 'twitter_integration', 'twitter_integration', WD_WDTI_URL . '/images/new_twitt.png');
    add_action('admin_print_styles-' . $twitt_page, 'twitt_styles');
    add_action('admin_print_scripts-' . $twitt_page, 'twitt_scripts');
  }
  $licensing_plugins_page = add_submenu_page($parent_slug, 'Licensing', 'Licensing', 'manage_options', 'licensing_twitter_integration', 'twitter_integration');



  $uninstall_page = add_submenu_page('twitter_integration', 'Uninstall', 'Uninstall', 'manage_options', 'uninstall_twitter_integration', 'twitter_integration');
   add_action('admin_print_styles-' . $uninstall_page, 'twitt_styles');
   add_action('admin_print_scripts-' . $uninstall_page, 'twitt_scripts');
   
}
add_action('admin_menu', 'twitt_options_panel',9);
add_action('wp_ajax_addPostsPages', 'twitt_filemanager_ajax');
add_action('admin_init', 'setup_redirect');

// Add the Twitter Integration button to editor for shortcode.

add_filter('mce_external_plugins', 'twitt_register');
add_filter('mce_buttons', 'twitt_add_button', 0);
add_action('wp_ajax_WDTIShortcode', 'twitt_filemanager_ajax');
add_action('admin_head', 'twitt_admin_ajax');

function twitt_register($plugin_array) {
  $url = WD_WDTI_URL . '/js/twitt_editor_button.js';
  $plugin_array["twitt_mce"] = $url;
  return $plugin_array;
}

function twitt_add_button($buttons) {
  array_push($buttons, "twitt_mce");
  return $buttons;
}

function twitt_admin_ajax() {
  ?>
  <script>
    var twitt_admin_ajax = '<?php echo add_query_arg(array('action' => 'WDTIShortcode' , 'function_kind' => 'display_shortcode_for_twitt'), admin_url('admin-ajax.php')); ?>';
    var twitt_plugin_url = '<?php echo WD_WDTI_URL; ?>';
  </script>
  <?php
}

// Twitter Integration Widget.

if (class_exists('WP_Widget')) {
  require_once(WD_WDTI_DIR . '/admin/controllers/WDTIControllerWidget.php');
  add_action('widgets_init', create_function('', 'return register_widget("WDTIControllerWidget");'));
}

// Twitter Integration functions for popup

function twitt_filemanager_ajax() {
  global $wpdb;
  require_once(WD_WDTI_DIR . '/framework/WDWTILibrary.php');
  $page = WDWTILibrary::get('action');
  if ($page != '') { 
    require_once (WD_WDTI_DIR . '/popupcontent/controller.php');
    $controller_class = 'PopupcontentController';
    $controller = new $controller_class();
    $controller->execute();
  }
} 

// Twitter Integration functions for page_nav,search 

function  twitter_integration() {
  global $wpdb;
  require_once(WD_WDTI_DIR . '/framework/WDWTILibrary.php');
  $page = WDWTILibrary::get('page');
   if ($page == 'twitter_integration' or $page == 'uninstall_twitter_integration' or $page == 'featured_plugins_twitter_integration' or $page == 'licensing_twitter_integration') {

     global  $wdti_options;
     if(!class_exists("DoradoWebConfig")){
       include_once (WD_WDTI_DIR . "/wd/config.php");
     }

     if(!class_exists("DoradoWebDeactivate")) {
       include_once (WD_WDTI_DIR . "/wd/includes/deactivate.php");
     }

     $config = new DoradoWebConfig();

     $config->set_options( $wdti_options );
     $deactivate_reasons = new DoradoWebDeactivate($config);
     //$deactivate_reasons->add_deactivation_feedback_dialog_box();
     $deactivate_reasons->submit_and_deactivate();



    require_once (WD_WDTI_DIR . '/admin/controllers/WDTIController' . ucfirst(strtolower($page)) . '.php');
    $controller_class = 'WDTIController' . ucfirst(strtolower($page));
    $controller = new $controller_class();
    $controller->execute();
  }
}

//Twitter Integration frontend

add_shortcode('Widget_Twitter', 'twitt_shortcode');
function twitt_shortcode($atts) {
  extract(shortcode_atts(array(
	      'id' => 'no Twitter'
     ), $atts));	 
	 ob_start();
     front_end_twitt($id);
	 return ob_get_clean();
}

//by shortcode

function front_end_twitt($id) {
  global $wpdb;
  global $post;
  $query = "SELECT * FROM ".$wpdb->prefix."twitter_integration WHERE (id LIKE '%" . $id . "%') AND `published`=1 ";
  $param = $wpdb->get_row($query);
    if($param) {
		switch($param->type) {
		    case 'tweetbutton':
		        if($param->url_type=='normal') {
	             $url = $param->url;
                } 
			    else {
	             $url = get_permalink($post->ID);
				} 
			    $param->code=str_replace('autoSITEURLauto',$url,$param->code);			 
			    if($param->tw_text=='')
			     $param->code=str_replace('data-text=""','data-text="' . $post->post_title . '"',$param->code);
            break;		   
		    case 'mention':
		        if($param->tw_text=='')
			     $param->code=str_replace('&text="','&text=' . $post->post_title . '"',$param->code); 
            break;		  
            case 'hashtag':
		        if($param->tw_text=='')
			     $param->code=str_replace('&text="','&text=' . $post->post_title . '"',$param->code);
            break;
		}
        echo $param->code;
    }
    else 
        echo 'no Twitter with current id';
}

//by choosen posts or pages 

add_filter('the_content','twitt_front_end',1000);

function twitt_front_end($content) {
  global $wpdb;  
  global $post; 
  $continue = false;
  $query = "SELECT * FROM ".$wpdb->prefix."twitter_integration WHERE (posts LIKE '%" . $post->ID . "," . "%' OR posts='all_posts' OR pages LIKE '%" . $post->ID . "," . "%' OR pages='all_pages') AND `published`=1 ";
  $params = $wpdb->get_results($query); 
    if($params) { 
        foreach ($params as $param) {
			if($param->posts=='all_posts') $param->posts .= ',all_posts'; 
			if($param->pages=='all_pages') $param->pages .= ',all_pages';
            $sorted_posts=explode(',',$param->posts);
			$sorted_pages=explode(',',$param->pages); 
			if($post->post_type=='post') {
				for ($i=0;$i <= (count($sorted_posts)-1);$i++) { 
					if($sorted_posts[$i]==$post->ID or $param->posts=='all_posts,all_posts')
						$continue = true;
				}
			}
			elseif($post->post_type=='page') {
				for ($j=0;$j <= (count($sorted_pages)-1);$j++) {
					if($sorted_pages[$j]==$post->ID or $param->pages=='all_pages,all_pages')
						$continue = true;
				}
			}
			if($continue) { 
				switch($param->type) {
					case 'tweetbutton':
						if($param->url_type=='normal') {
						 $url = $param->url;
						} 
						else {
						 $url = get_permalink($post->ID);
						}
						$param->code=str_replace('autoSITEURLauto',$url,$param->code); 			
						if($param->tw_text=='')
						 $param->code=str_replace('data-text=""','data-text="' . $post->post_title . '"',$param->code);
					break;		   
					case 'mention':
						if($param->tw_text=='')
						 $param->code=str_replace('&text="','&text=' . $post->post_title . '"',$param->code);
					break;  
					case 'hashtag':
						if($param->tw_text=='')
						 $param->code=str_replace('&text="','&text=' . $post->post_title . '"',$param->code);
					break;
				}		  
				if($post->post_type=='post') { 
					switch($param->place) {
						case 'top':		   
							$content =  $param->code . $content;
						break;
						case 'bottom':		   
							$content =  $content . $param->code;
						break;
						case 'both':		   
							$content = $param->code . $content . $param->code;
						break;
					}
				} 
				else if ($post->post_type=='page') { 
					switch($param->item_place) {
						case 'top':		   
							$content =  $param->code . $content;
						break;
						case 'bottom':		   
							$content =  $content . $param->code;
						break;
						case 'both':		   
							$content = $param->code . $content . $param->code;
						break;
					}
				}
				$continue = false;
			}	
		}
		return $content;
	}
    else 
	    return $content;
}

//Twitter Integration Activate plugin.

function twitter_integration_activate() {
  $version = get_option("WD_WDTI_VERSION_FREE");
  if($version == false){
    add_option("WD_WDTI_VERSION_FREE" , WD_WDTI_VERSION_FREE);
  }
  global $wpdb;
  $twitter_params = "CREATE TABLE IF NOT EXISTS `" . $wpdb->prefix . "twitter_integration` (
    `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `title` varchar(255) NOT NULL,
    `type` varchar(255) NOT NULL,
	`order` bigint(20) NOT NULL,
    `published` tinyint(5) NOT NULL,
    `url` varchar(200) NOT NULL,
    `lang` varchar(200) NOT NULL,
    `width` varchar(255) NOT NULL,
    `dnt` varchar(15) NOT NULL,
    `count_mode` varchar(255) NOT NULL,
    `url_type` varchar(50) NOT NULL,
	`via` varchar(80) NOT NULL,
    `tw_text` varchar(4000) NOT NULL,
    `lang_type` varchar(255) NOT NULL,
    `counturl` varchar(255) NOT NULL,
    `but_size` varchar(255) NOT NULL,
    `align` varchar(255) NOT NULL,
    `show_screen_name` varchar(255) NOT NULL,
    `place` varchar(255) NOT NULL,
    `item_place` varchar(255) NOT NULL,
    `css` varchar(255) NOT NULL,
    `height` varchar(255) NOT NULL,
    `login_text` varchar(255) NOT NULL,
    `posts` text NOT NULL,
    `pages` text NOT NULL,
    `code` text NOT NULL,
    `show_count` varchar(255) NOT NULL,
    `theme` varchar(255) NOT NULL,
    `link_color` varchar(255) NOT NULL,
    `chrome` varchar(255) NOT NULL,
    `border` varchar(255) NOT NULL,
    `tweet_limit` varchar(255) NOT NULL,
    `aria_polite` varchar(255) NOT NULL,
    `show_replies` varchar(255) NOT NULL,
    `screen_name` varchar(255) NOT NULL,
    `widget_id` varchar(255) NOT NULL,
    `timeline_type` varchar(255) NOT NULL,
    `tweet_to` varchar(255) NOT NULL,
    `username_to_1` varchar(255) NOT NULL,
    `username_to_2` varchar(255) NOT NULL,
    `tw_stories` varchar(4000) NOT NULL,
    `tw_hashtag` varchar(255) NOT NULL,
    `noheader` varchar(200) NOT NULL,
    `nofooter` varchar(255) NOT NULL,
    `noborders` varchar(255) NOT NULL,
    `noscrollbar` varchar(255) NOT NULL,
	`transparent` varchar(255) NOT NULL,	
     PRIMARY KEY (`id`)
  ) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
  $wpdb->query($twitter_params);
  add_option('wdti_do_activation_set_up_redirect', 1);
}
 register_activation_hook(__FILE__, 'twitter_integration_activate');
 
 //Twitter Integration styles
 
 function twitt_styles() {
  wp_enqueue_style('twitt_tables', WD_WDTI_URL . '/css/twitt_tables.css' ,array(), WD_WDTI_VERSION_FREE);
  wp_admin_css('thickbox');
   $get_current_screen = get_current_screen();
   if($get_current_screen->base == "widget-twitter_page_uninstall_twitter_integration") {
     wp_enqueue_style('wdti_deactivate-css',  WD_WDTI_URL . '/wd/assets/css/deactivate_popup.css', array(), WD_WDTI_VERSION_FREE);
   }
}



//Twitter Integration scripts

 function twitt_scripts() {
  wp_enqueue_script('thickbox');
  wp_enqueue_script('twitt_admin', WD_WDTI_URL . '/js/twitt.js',array(), WD_WDTI_VERSION_FREE);
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-sortable');
  wp_enqueue_script('jscolor', WD_WDTI_URL . '/js/jscolor/jscolor.js' ,array(), WD_WDTI_VERSION_FREE);

   $get_current_screen = get_current_screen();
   if($get_current_screen->base == "widget-twitter_page_uninstall_twitter_integration") {
     wp_enqueue_script('wdti-deactivate-popup', WD_WDTI_URL.'/wd/assets/js/deactivate_popup.js', array(), WD_WDTI_VERSION_FREE, true );
     $admin_data = wp_get_current_user();

     wp_localize_script( 'wdti-deactivate-popup', 'wdtiWDDeactivateVars', array(
       "prefix" => "wdti" ,
       "deactivate_class" =>  'wdti_deactivate_link',
       "email" => $admin_data->data->user_email,
       "plugin_wd_url" => "https://web-dorado.com/products/wordpress-twitter-integration-plugin.html",
     ));
   }

 }
function setup_redirect() {
  if (get_option('wdti_do_activation_set_up_redirect')) {
    update_option('wdti_do_activation_set_up_redirect',0);
    wp_safe_redirect( admin_url( 'admin.php?page=wdti_subscribe' ) );
    exit;
  }
}


add_action( 'init', "wd_wdti_init" );
function wd_wdti_init(){
  if( !isset($_REQUEST['ajax']) && is_admin() ){
    if( !class_exists("DoradoWeb") ){
      require_once(WD_WDTI_DIR . '/wd/start.php');
    }
    global $wdti_options;
    $wdti_options = array (
      "prefix" => "wdti",
      "wd_plugin_id" => 56,
      "plugin_title" => "Twitter Widget",
      "plugin_wordpress_slug" => "widget-twitter",
      "plugin_dir" => WD_WDTI_DIR,
      "plugin_main_file" => __FILE__,
      "description" => __('Widget Twitter is a WordPress plugin, which provides full Twitter Integration for your WordPress site.', 'wdit'),
      // from web-dorado.com
      "plugin_features" => array(
        0 => array(
          "title" => __("Embedded Timelines", "wdti"),
          "description" => __("Widget Twitter allows to add 4 types of embedded timelines for Twitter-activity display on your website, including user timeline, favorites, list, search.", "wdti"),
        ),
        1 => array(
          "title" => __("Twitter buttons", "wdti"),
          "description" => __("Widget Twitter allows you to add different Twitter buttons to your pages and posts. The product includes a set of Twitter buttons, such as Tweet, Mention, Follow, Hash tag. In addition it includes Twitter Timeline display possibility. ", "wdti"),
        ),
        2 => array(
          "title" => __("Customizable", "wdti"),
          "description" => __("The plugin uses a wide range of options, which allows customizing the basic features of the buttons (button size, width/height, color, language and etc.). Changes can be made both for the plugin appearance and functionality.", "wdti"),
        ),
        3 => array(
          "title" => __("User-friendly", "wdti"),
          "description" => __("Widget Twitter uses simple and user-friendly design. It is easy in use: most of the features can be managed within a few clicks. ", "wdti"),
        ),
      ),
      // user guide from web-dorado.com
      "user_guide" => array(
        0 => array(
          "main_title" => __("Adding Twitter social plugins to the website", "wdti"),
          "url" => "https://web-dorado.com/wordpress-widget-twitter/adding-twitter-social-plugins.html",
          "titles" => array(
            array(
              "title" => __("Adding a Tweet Button", "wdti"),
              "url" => "https://web-dorado.com/wordpress-widget-twitter/adding-twitter-social-plugins/tweet-button.html"
            ),
            array(
              "title" => __("Adding a Follow Button", "wdti"),
              "url" => "https://web-dorado.com/wordpress-widget-twitter/adding-twitter-social-plugins/follow-button.html"
            ),
            array(
              "title" => __("Adding a Timeline Box", "wdti"),
              "url" => "https://web-dorado.com/wordpress-widget-twitter/adding-twitter-social-plugins/timeline-box.html"
            ),
            array(
              "title" => __("Adding a Mention Button", "wdti"),
              "url" => "https://web-dorado.com/wordpress-widget-twitter/adding-twitter-social-plugins/mention-button.html"
            ),
            array(
              "title" => __("Adding a Hash Tag Button", "wdti"),
              "url" => "https://web-dorado.com/wordpress-widget-twitter/adding-twitter-social-plugins/hash-tag-button.html"
            )
          )
        ),
        1 => array(
          "main_title" => __("Publishing Widget Twitter as a Widget.", "wdti"),
          "url" => "https://web-dorado.com/wordpress-widget-twitter/publishing-as-widget.html",
          "titles" => array()
        ),
        2 => array(
          "main_title" => __("Publishing Widget Twitter plugins in a page or a post.", "wdti"),
          "url" => "https://web-dorado.com/wordpress-widget-twitter/publishing-plugins-into-page-post.html",
          "titles" => array()
        ),
      ),
      "overview_welcome_image" => WD_WDTI_URL . '/images/welcome_image.png',
      "video_youtube_id" => null,  // e.g. https://www.youtube.com/watch?v=acaexefeP7o youtube id is the acaexefeP7o
      "plugin_wd_url" => "https://web-dorado.com/products/wordpress-twitter-integration-plugin.html",
      "plugin_wd_demo_link" => "http://wpdemo.web-dorado.com/twitter-tools/?_ga=1.217024213.212018776.1470817467",
      "plugin_wd_addons_link" => "",
      "after_subscribe" => "admin.php?page=overview_wdti", // this can be plagin overview page or set up page
      "plugin_wizard_link" => null,
      "plugin_menu_title" => "Widget Twitter",
      "plugin_menu_icon" => WD_WDTI_URL . '/images/new_twitt.png',
      "deactivate" => true,
      "subscribe" => true,
      "custom_post" => 'twitter_integration',  // if true => edit.php?post_type=contact
      "menu_capability" => "manage_options",
      "menu_position" => 9,
    );

    dorado_web_init($wdti_options);
  }

}
?>