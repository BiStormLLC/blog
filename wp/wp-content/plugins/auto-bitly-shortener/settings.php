<?php
	//update settings
    $user_access_token_class = $domain_class = '';
    if(isset($_POST['domain'])){
        $user_access_token      = sanitize_text_field($_POST['user-access-token']);
        $domain                 = sanitize_text_field($_POST['domain']);
        
        //check if any field empty
        $formOkay = 1;
        if($user_access_token == ''){
            $formOkay = 0;
            $user_access_token_class = 'error';
        }
        
        if($domain == ''){
            $formOkay = 0;
            $domain_class = 'error';
        }
        
        if($formOkay == 1){
            
            //check if clent secret is okay
            $params = array();
            $params['access_token'] = $user_access_token;
            $params['longUrl'] = get_site_url();
            $params['domain'] = 'bit.ly';
            $results = bitly_get('shorten', $params);
            $status_code = $results['status_code'];
            if($status_code == 200){
                //update settings info
                update_option('shartd_com_bitly_access_token', $user_access_token);
                update_option('shartd_com_bitly_domain', $domain);
                update_option('shartd_com_bitly_status', 1);
                $successMessage = 'Settings Successfully Updated';
            }else{
                $errorMessage = 'ERROR!! Invalid Access Token';
            }
        }else{
            $errorMessage = 'ERROR!! Empty Required Field';
        }
        
    }
    
    //get current settings
    $user_access_token  = get_option('shartd_com_bitly_access_token', '');
    $domain             = get_option('shartd_com_bitly_domain', '');
    
?>
<div class="wrap">
    <div class="shartd-bitly">
        <h1>Manage Settings</h1>
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
        <form action="" method="post" class="settings">
            <p>User Access Token<span class="red">*</span><br /><input class="text <?php echo $user_access_token_class; ?>" name="user-access-token" value="<?php echo $user_access_token; ?>" /><br />Generate your <a href="https://bitly.com/a/oauth_apps" target="_blank">token here</a></p>
            <p>Domain<span class="red">*</span><br />
                <select name="domain">
                    <option <?php if($domain == 'bit.ly'){echo 'selected=""';} ?> >bit.ly</option>
                    <option <?php if($domain == 'j.mp'){echo 'selected=""';} ?>>j.mp</option>
                    <option <?php if($domain == 'bitly.com'){echo 'selected=""';} ?>>bitly.com</option>
                </select>
            </p>
            <p><input type="submit" value="Update Settings" /></p>
        </form>
    </div>
</div>