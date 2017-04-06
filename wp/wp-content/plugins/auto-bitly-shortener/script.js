var $ = jQuery.noConflict();
$(document).ready(function(){
    
    /*######## Add New Campaign Page ########*/
    
    //Change form based on campaign type
    $('select[name="type"]').change(function(){
        var type = $('select[name="type"]').val();
        if(type == "custom"){
            $('.add-campaign .analytics').hide();
            $('.add-campaign .custom').show();
        }
        if(type == "analytics"){
            $('.add-campaign .custom').hide();
            $('.add-campaign .analytics').show();
        }
    });
    
    //validate form after add campaign form submitted
    $('.add-campaign').submit(function(){
        //remove error class from all fields
        $('input').removeClass('error');
        
        var formValid = 1;
        var type = $('select[name="type"]').val();
        
        //if type = analytics
        if(type == "analytics"){
            var name        = $('.analytics input[name="aname"]').val();
            var medium      = $('input[name="medium"]').val();
            var source      = $('input[name="source"]').val();
            
            if(name == ""){
                formValid = 0;
                $('.analytics input[name="name"]').addClass('error');
            }
            if(medium == ""){
                formValid = 0;
                $('input[name="medium"]').addClass('error');
            }
            if(source == ""){
                formValid = 0;
                $('input[name="source"]').addClass('error');
            }
        }
        
        //if type = custom
        if(type == "custom"){
            var name        = $('.custom input[name="cname"]').val();
            var url         = $('input[name="url"]').val();
            
            if(name == ""){
                formValid = 0;
                $('.custom input[name="name"]').addClass('error');
            }
            if(url == ""){
                formValid = 0;
                $('input[name="url"]').addClass('error');
            }
        }
        
        if(formValid == 0){
            alert('Empty Required Field');
            return false;
        }
        
    });
    
    /*######## Manage Campaign Part ########*/
    //Delete single campaign
    $('a.delete-campaign').click(function(){
        return confirm('Are you sure to delete this campaign?');
    });
    
    //Delete multiple campaign
    $('form.bulk-action').submit(function(){
        var formOkay = 1;
        var action = $('select[name="action"]').val();
        if(action == -1){
            formOkay = 0;
        }
        if($('input[name="post[]"]:checked').length < 1){
            formOkay = 0;
        }
        
        if(formOkay == 0){
            alert('Please check at least one campaign & select a valid action');
            return false;
        }
    });
    
    /*######## Settings Part ########*/
    $('form.settings').submit(function(){
        
        //remove error class
        $('input[name="user-access-token"]').removeClass('error');
        
        var user_access_token       = $('input[name="user-access-token"]').val();
        
        //add error class
        var formOkay = 1;
        if(user_access_token == ""){
            formOkay = 0;
            $('input[name="user-access-token"]').addClass('error');
        }
        
        if(formOkay == 0){
            alert('Empty Required Field');
            return false;
        }
    });
    
    /*######## On Post/Page Area ########*/
    
    //select short link on click
    $("#shartd_com_bitly input.short-link").focus(function(){ 
        $(this).select(); 
    });
});