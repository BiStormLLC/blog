<?php
/*
Plugin Name: Auto Bitly Shortener
Plugin URI: http://www.shartd.com/
Description: Generates Bitly shortlinks of every posts in your site for different campaigns you create & shows in add/edit post page automatically.
Author: Zahid Habib
Author URI: http://www.zahidhabib.com/
Text Domain: shartd-bitly
Version: 1.0.1
*/

//include required files
include_once 'bitly-api.php';

//Run necessary hooks
add_action( 'admin_menu', 'shartd_bitly_as_menu' );
add_action( 'admin_init', 'shartd_bitly_as_init' );

//Create admi panel menu
function shartd_bitly_as_menu(){
    add_menu_page( 'Bitly Shortener', 'Bitly Shortener', 'manage_options', 'shartd-bitly-as', 'show_main_page', 'dashicons-admin-links');
    add_submenu_page( 'shartd-bitly-as', 'Add Campaign', 'Add Campaign', 'manage_options', 'shartd-bitly-new', 'shartd_bitly_new' );
    add_submenu_page( 'shartd-bitly-as', 'Settings', 'Settings', 'manage_options', 'shartd-bitly-settings', 'shartd_bitly_settings' );
}

function show_main_page(){
    include 'manage-campaigns.php';
}

function shartd_bitly_new(){
    include 'new-campaign.php';
}

function shartd_bitly_settings(){
    include 'settings.php';
}

//include css & js file
function shartd_bitly_as_init(){
    wp_enqueue_style('shartd-bitly-as', plugins_url( 'auto-bitly-shortener/style.css', dirname(__FILE__) ));
    wp_enqueue_script('shartd-bitly-as', plugins_url( 'auto-bitly-shortener/script.js', dirname(__FILE__) ), array('jquery'));
    wp_enqueue_style( 'shartd-bitly-as' );
    wp_enqueue_script( 'shartd-bitly-as' );
}

//show admin message
$token_status = get_option('shartd_com_bitly_status', 0);
if($token_status == 0){
    add_action('admin_notices', 'shartd_com_bitly_notice');
}

function shartd_com_bitly_notice(){ ?>
    <div class="error">
        <p><?php _e( 'Invalid or Empty Access Token. Please update access token in plugin setttings menu', 'shartd-com-bitly' ); ?></p>
    </div>   
<?php }

function showMessage($message, $errormsg = false)
{
  if ($errormsg) {
    echo '<div id="message">';
  }
  else {
    echo '<div id="message">';
  }
  echo '<p><strong>' . $message . '</strong></p></div>';
}

//show short links in post/page page
add_action( 'add_meta_boxes', 'shartd_com_bitly_meta' );

function shartd_com_bitly_meta(){
    $screens = array( 'post', 'page' );
	foreach ( $screens as $screen ) {
		add_meta_box('shartd_com_bitly', 'Bitly Short Links', 'shartd_com_bitly_meta_callback', $screen, 'side', 'high');
	}
}

function shartd_com_bitly_meta_callback(){
    
    //get settings
    $access_token       = get_option('shartd_com_bitly_access_token', '');
    $domain             = get_option('shartd_com_bitly_domain', '');
    
    //set params
    $params = array();
    $params['access_token'] = $access_token;
    $params['domain'] = $domain;
    
    //get all campaigns
    $post_permalink = get_permalink();
    $post_status = get_post_status();
    $get_campaigns = get_posts(array('post_type' => 'shartd_com_bitly', 'post_status' => 'publish'));
    foreach($get_campaigns as $campaign_details): 
    
    //get post metadata
    $post_meta = get_post_meta($campaign_details->ID);
    
    //get all required variables
    $type = $post_meta['shartd_com_bitly_campaign_type']['0'];
    if($type == 'analytics'){
        $name           = $campaign_details->post_title;
        $source         = $post_meta['shartd_com_bitly_campaign_source']['0'];
        $term           = $post_meta['shartd_com_bitly_campaign_term']['0'];
        $content        = $post_meta['shartd_com_bitly_campaign_content']['0'];
        $medium         = $post_meta['shartd_com_bitly_campaign_medium']['0'];
        
        $final_url      = $post_permalink.'?utm_source='.$source.'&utm_medium='.$medium.'&utm_campaign='.$name;
        if($term != ''){
            $final_url .= '&utm_term='.$term;
        }
        if($content != ''){
            $final_url .= '&utm_content='.$content;
        }
    }else{
        $url            = $post_meta['shartd_com_bitly_campaign_url']['0'];
        $final_url      = $post_permalink.$url;
    }
    
    //get short link
    if($post_status == 'publish' || $post_status == 'future' || $post_status == 'private'){
        $params['longUrl'] = $final_url;
        $short_link_req = bitly_get('shorten', $params);
        if($short_link_req['status_code'] == 200){
            $short_url = $short_link_req['data']['url'];
        }else{
            $short_url = 'An Error Occured!!';
        }    
    }else{
        $short_url = '';
    }
    
    
    ?>
    <div class="row">
        <p><?php echo $campaign_details->post_title; ?><br /><input type="text" class="short-link" value="<?php echo $short_url; ?>" /></p>
    </div>
    <?php
    endforeach;
}

?>