<?php
    
    global $wpdb;

    //define class for inputs
    $cNamelass = $mediumClass = $sourceClass = $cNamelass = $urlClass = '';
    
	//Form submission
    if(isset($_POST['type'])){
        $type           = sanitize_text_field($_POST['type']);
        $formOkay       = 1;
        if($type == 'analytics'){
            $name               = sanitize_text_field($_POST['aname']);
            $medium             = sanitize_text_field($_POST['medium']);
            $source             = sanitize_text_field($_POST['source']);
            $term               = sanitize_text_field($_POST['term']);
            $content            = sanitize_text_field($_POST['content']);
            
            //check if fields are not empty
            if($name == ""){
                $formOkay = 0;
                $aNameClass = 'error';
            }
            
            if($medium == ''){
                $formOkay = 0;
                $mediumClass = 'error';
            }
            
            if($source == ""){
                $formOkay = 0;
                $sourceClass = 'error';
            }
            
            if($formOkay == 0){
                $errorMessage = "ERROR!! Empty Required Fields.";
            }else{
                //insert post
                $post_fields = array(
                    'post_title'            => $name,
                    'post_content'          => '',
                    'post_author'           => get_current_user_id(),
                    'post_date'             => date("Y-m-d H:i:s"),
                    'post_type'             => 'shartd_com_bitly',
                    'post_status'           => 'publish'
                );
                $post_id = wp_insert_post($post_fields);
                if($post_id == false){
                    $errorMessage = "ERROR!! Please try again later.";
                }else{
                    $successMessage = 'Campaign Successfully Added';
                    //insert metadata
                    add_post_meta($post_id, 'shartd_com_bitly_campaign_source', $source);
                    add_post_meta($post_id, 'shartd_com_bitly_campaign_term', $term);
                    add_post_meta($post_id, 'shartd_com_bitly_campaign_content', $content);
                    add_post_meta($post_id, 'shartd_com_bitly_campaign_type', $type);
                    add_post_meta($post_id, 'shartd_com_bitly_campaign_medium', $medium);
                }
            }
            
        }else{
            $name               = sanitize_text_field($_POST['cname']);
            $url                = sanitize_text_field($_POST['url']);
            
            if($name == ''){
                $formOkay = 0;
                $cNamelass = 'error';
            }
            
            if($url == ''){
                $formOkay = 0;
                $urlClass = 'error';
            }
            
            if($formOkay == 0){
                $errorMessage = "ERROR!! Empty Required Fields.";
            }else{
                //insert post
                $post_fields = array(
                    'post_title'            => $name,
                    'post_content'          => '',
                    'post_author'           => get_current_user_id(),
                    'post_date'             => date("Y-m-d H:i:s"),
                    'post_type'             => 'shartd_com_bitly',
                    'post_status'           => 'publish'
                );
                $post_id = wp_insert_post($post_fields);
                if($post_id == false){
                    $errorMessage = "ERROR!! Please try again later.";
                }else{
                    $successMessage = 'Campaign Successfully Added';
                    //insert metadata
                    add_post_meta($post_id, 'shartd_com_bitly_campaign_url', $url);
                    add_post_meta($post_id, 'shartd_com_bitly_campaign_type', $type);
                }
            }
        }
    }
?>

<div class="wrap">
    <div class="shartd-bitly">
        <h1>Add New Campaign</h1>
        <?php if(isset($successMessage)):?>
            <div id="message" class="updated notice notice-success is-dismissible">
                <p><?php echo $successMessage; ?></p>
            </div>
        <?php endif;?>
        <?php if(isset($errorMessage)):?>
            <div id="message" class="error notice notice-error is-dismissible">
                <p><?php echo $errorMessage; ?></p>
            </div>
        <?php endif;?>
        <form action="" method="post" class="add-campaign">
            <p>Campaign Type<span class="red">*</span><br />
                <select name="type">
                    <option value="analytics">Google Analytics</option>
                    <option value="custom">Custom</option>
                </select>
                <div class="analytics">
                    <p>Campaign Name(utm_campaign)<span class="red">*</span><br /><input class="text <?php echo $aNameClass; ?>" name="aname" /></p>
                    <p>Campaign Medium(utm_medium)<span class="red">*</span><br /><input class="text <?php echo $mediumClass; ?>" name="medium" /></p>
                    <p>Campaign Source(utm_source)<span class="red">*</span><br /><input class="text <?php echo $sourceClass; ?>" name="source" /></p>
                    <p>Campaign Term(utm_term)<br /><input class="text" name="term" /></p>
                    <p>Campaign Content(utm_content)<br /><input class="text" name="content" /></p>
                </div>
                <div class="custom">
                    <p>Campaign Name<span class="red">*</span><br /><input class="text <?php echo $cNamelass; ?>" name="cname" /></p>
                    <p>Custom URL<span class="red">*</span><br /><input class="text <?php echo $urlClass; ?>" name="url" /><br /><em>Let's say you want to add <strong>?rel=fb</strong> to the end of every links in this campaign, then put <strong>?rel=fb</strong> on the above field</em></p>
                </div>
                <p><input type="submit" class="addcamp" value="Add Campaign" /></p>
            </p>
        </form>
    </div>
</div>