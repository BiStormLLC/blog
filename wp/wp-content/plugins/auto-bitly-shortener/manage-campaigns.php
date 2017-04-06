<?php
	global $wpdb;
    
    /*####### Delete Single Campaign #######*/
    if(isset($_GET['delete'])){
        $post_id    = intval($_GET['delete']);
        
        //check post type & validate
        $get_post = get_post($post_id);
        if($get_post->post_type == 'shartd_com_bitly'){
            
            //delete post
            $delete = wp_delete_post($post_id, true);
            if($delete){
                $successMessage = 'Campaign Successfully Deleted';
            }else{
                $errorMessage = 'ERROR!! Something Went Wrong. Please Try Again';
            }
            
        }else{
            $errorMessage = 'ERROR!! Invalid Action';
        }
    }
    
    /*####### Delete Multiple Campaign #######*/
    if(isset($_POST['post'])){
        $post_ids  = array_map('absint', $_POST['post']);
        $action    = intval($_POST['action']);
        
        if($action == -1 || count($post_ids) == 0){
            $errorMessage = 'ERROR!! Please Check At Least One Campaign & Select A Valid Action';
        }else{
            $deleteSuccess = 0;
            for($i=0; $i<count($post_ids); $i++){
                $delete = wp_delete_post($post_ids[$i], true);
                if($delete){
                    $deleteSuccess = 1;
                }
            }
            if($deleteSuccess == 1){
                $successMessage = 'Campaigns Successfully Deleted';
            }else{
                $errorMessage = 'ERROR!! Something Went Wrong. Please Try Again';
            }
        }
    }
    
    /*####### Get All Campaigns #######*/
    
    //get current page
    if(isset($_GET['paged'])){
        $paged          = intval($_GET['paged']);
    }else{
        $paged          = 1;
    }
    
    //get total pages
    $perPage = 20;
    $totalPosts = count(get_posts(array('posts_per_page' => -1, 'author' => get_current_user_id(), 'post_type' => 'shartd_com_bitly')));
    $totalPages = ceil($totalPosts/$perPage);
    
    $post_args = array(
        'posts_per_page'   => $perPage,
    	'orderby'          => 'date',
    	'order'            => 'DESC',
    	'post_type'        => 'shartd_com_bitly',
    	'author'	       => get_current_user_id(),
    	'post_status'      => 'publish'
    );
    $get_posts = get_posts($post_args);
    
?>
<div class="wrap"><div class="shartd-bitly">
<h1>Manage Campaigns <a class="page-title-action" href="admin.php?page=shartd-bitly-new">Add New</a></h1>
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
<!-- Top Actions-->
<form action="" method="post" class="bulk-action">
<div class="tablenav top">
    <div class="alignleft actions bulkactions">
        <label for="bulk-action-selector-top" class="screen-reader-text">Select bulk action</label>
        <select name="action" id="bulk-action-selector-top">
            <option value="-1" selected="selected">Bulk Actions</option>
            <option value="1">Delete</option>
        </select>
        <input type="submit" name="" id="doaction" class="button action" value="Apply" />
    </div>
    <div class="tablenav-pages">
        <span class="pagination-links">
            <a class="first-page disabled" title="Go to the first page" href="admin.php?page=shartd-bitly-as">&laquo;</a>
            <a class="prev-page disabled" title="Go to the previous page" href="admin.php?page=shartd-bitly-as<?php if($paged > 1){echo '?paged='.($paged-1);}else{echo "#";} ?>">&lsaquo;</a>
            <span class="paging-input">
                <?php echo $paged; ?> of <span class="total-pages"><?php echo $totalPages; ?></span>
            </span>
            <a class="next-page" title="Go to the next page" href="<?php if($paged<$totalPages){echo 'admin.php?page=shartd-bitly-as?paged='.($paged+1);}else{echo '#';} ?>">&rsaquo;</a>
            <a class="last-page" title="Go to the last page" href="<?php if($paged<$totalPages){echo 'admin.php?page=shartd-bitly-as?paged='.$totalPages;}else{echo '#';} ?>">&raquo;</a>
        </span>
    </div>
</div>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
    	<tr>
    		<th id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></th>
            <th scope="col" id="title" class="manage-column column-title column-primary desc"><span>Name</span></th>
            <th scope="col" id="author" class="manage-column column-author">Medium</th>
            <th scope="col" id="categories" class="manage-column column-categories">Source</th>
            <th scope="col" id="tags" class="manage-column column-tags">Type</th>
            <th scope="col" id="tags" class="manage-column column-tags">URL</th>
           	<th scope="col" id="categories" class="manage-column column-categories">Author</th>
            <th scope="col" id="tags" class="manage-column column-tags">Date</th>
        </tr>
	</thead>

	<tbody id="the-list">
        <?php if($totalPosts == 0): ?>
		<tr class="no-items"><td class="colspanchange" colspan="8">No campaign found.</td></tr>	</tbody>
        <?php 
        
            else:
            $sn=0;
            foreach($get_posts as $post_details): 
            
            //get post author
            $get_author = get_userdata($post_details->post_author);
            $postID     = $post_details->ID;
            
            //get post meta
            $campaign_source    = get_post_meta($post_details->ID, 'shartd_com_bitly_campaign_source');
            $campaign_type      = get_post_meta($post_details->ID, 'shartd_com_bitly_campaign_type');
            $campaign_medium    = get_post_meta($post_details->ID, 'shartd_com_bitly_campaign_medium');
            $campaign_url       = get_post_meta($post_details->ID, 'shartd_com_bitly_campaign_url');
            
            $sn++;
        ?>
            <tr class="type-post status-publish format-standard has-post-thumbnail category-amazing iedit author-other level-0 <?php if($sn%2 == 1){echo 'alternate';} ?>">
				<th scope="row" class="check-column">
				    <label class="screen-reader-text" for="cb-select-<?php echo $postID; ?>">Select <?php echo $post_details->post_title; ?></label>
				    <input id="cb-select-<?php echo $postID; ?>" type="checkbox" name="post[]" value="<?php echo $postID; ?>">
				</th>
                <td class="post-title page-title column-title"><strong><?php echo $post_details->post_title; ?></strong>
                    <div class="row-actions">
                        <span class="edit"><a class="delete-campaign" href="admin.php?page=shartd-bitly-as&paged=<?php echo $paged; ?>&delete=<?php echo $post_details->ID; ?>" title="Edit this item">Delete</a></span>
                    </div>
                </td>
    			<td class="author column-author"><?php echo $campaign_medium['0']; ?></td>
                <td class="categories column-categories"><?php echo $campaign_source['0']; ?></td>
                <td class="tags column-tags"><?php echo $campaign_type['0']; ?></td>
                <td class="tags column-tags"><?php echo $campaign_url['0']; ?></td>
               	<td class="categories column-categories"><?php if($get_author->first_name != '' || $get_author->last_name != ''){echo $get_author->first_name.' '.$get_author->last_name;}else{echo $get_author->user_login;} ?></td>
                <td class="tags column-tags"><?php echo $post_details->post_date; ?></td>
            </tr>
        <?php endforeach; endif; ?>
	<tfoot>
	   <tr>
    		<th id="cb" class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-1">Select All</label><input id="cb-select-all-1" type="checkbox"></th>
            <th scope="col" id="title" class="manage-column column-title column-primary desc"><span>Name</span></th>
            <th scope="col" id="author" class="manage-column column-author">Medium</th>
            <th scope="col" id="categories" class="manage-column column-categories">Source</th>
            <th scope="col" id="tags" class="manage-column column-tags">Type</th>
            <th scope="col" id="tags" class="manage-column column-tags">URL</th>
           	<th scope="col" id="categories" class="manage-column column-categories">Author</th>
            <th scope="col" id="tags" class="manage-column column-tags">Date</th>
        </tr>
	</tfoot>

</table>
</form>
</div>
</div>