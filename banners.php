<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<div id="wrap">
<?php 
	global $wpdb;
	$page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
	$mode = isset($_REQUEST['mode'])?$_REQUEST['mode']:'';
	
	
	$limit = 20;
	$adjacents = 2; 
	
	$targetpage = admin_url( 'admin.php?page=banner' );  
	$condition = "";
	$total_records = apabs_count_records();
	$total_pages     = $total_records/$limit;
	
	
	
	
	$pageid = $_GET['pageid'];
	if($pageid) 
		$start = ($pageid - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;	
		

/* ---------  Custom Function start here ------------ */
function apabs_count_records()
{ global $wpdb;
	$res = $wpdb->get_results("select * from ".$wpdb->prefix."banners WHERE 1= 1 order by id DESC ", OBJECT);
	return count($res);	
}

function apabs_get_status($id)
{ global $wpdb;
	$result = $wpdb->get_results("select list_status from ".$wpdb->prefix."banners WHERE id = '$id' ", OBJECT);
	foreach( $result as $entry ) {
		$list_order = $entry->list_status;
	}
	return $list_order;	
}


/* ---------  Custom Function ends here ------------ */
	
	
if($mode=='delete')
{
	$wpdb->query("delete from ".$wpdb->prefix."banners where id=$_REQUEST[pid]");
}





if($mode=='changeStatus')
{
	$result = $wpdb->get_results("select list_status from ".$wpdb->prefix."banners WHERE id = $_REQUEST[pid]", OBJECT);
	foreach( $result as $entry ) {
		if($entry->list_status == '1')
			{ $status_change_to = '0';
			  $status_change_message = 'Row successfully unpublished.';	
			}
		else{
			$status_change_to = '1';
			$status_change_message = 'Row successfully published.';	
			}	
		$wpdb->update($wpdb->prefix.'banners',array('list_status'=>$status_change_to),array('id'=>$_REQUEST['pid']));
	}
	
	
}


$result = $wpdb->get_results("select * from ".$wpdb->prefix."banners WHERE 1= 1 order by id DESC limit $start, $limit");
?>
<div class="wrap"><h2> <img src="<?php echo apabs_URL.'/images/banner_big.png';?>" border="0" > Home Page Banners
<a href="<?php echo $_SERVER["PHP_SELF"]?>?page=list-plugin-data1" class="button">Add New</a> 
 
<span id="wp_paginate" > <div class="pagination-holder"><ul>  <?php 
//include apabs_URL. '/paginations.php'; 
		   					echo $pagination;
		 ?> </ul> </div> </span> 
</h2>



</div>

<?php
if(isset($_REQUEST['status'])) : ?>
	<div id="message" class="updated" style="margin-left:0;">
    <?php if(isset($_REQUEST['status']) && $_REQUEST['status'] == 'add') { echo '<p>Banner successfully added.</p>';} ?>  
     <?php if(isset($_REQUEST['status']) && $_REQUEST['status'] == 'update') { echo '<p>Banner successfully updated.</p>';} ?> 
     <?php if(isset($_REQUEST['status']) && $_REQUEST['status'] == 'changeStatus') { echo '<p>'.$status_change_message.'</p>';} ?>  	
    </div>
<?php
	  endif; 
?>

<table class="widefat fixed comments">
    <thead>
    	<tr>
            <th width="5%">S.No.</th>
            <th width="13%">Title </th>
            <th width="19%"> Banner</th>
            <th width="15%"> URL</th>
            <th width="10%">Publish Status</th> 
            <th width="8%">Action</th>
    	</tr>
    </thead>
    
    <tbody>
    
    <?php if( $result ) { ?>
 
            <?php
            $count = 1;
            $class = '';
            foreach( $result as $entry ) {
               ?>
 
            <tr<?php echo $class; ?>>
                <td><?php echo (($pages->current_page -1) * $pages->items_per_page) + $count; ?></td>
                <td><?php echo $entry->bannerName; ?></td> 
                <td><?php
if($entry->imgPath != '')
	echo '<p><label> &nbsp; </label><img src="'.$entry->imgPath.'" border="0" width="234" height="117"></p>';

?></td>  
                <td><?php echo stripslashes($entry->link); ?></td>                 
               
                
                 <td>
                <?php 
			if($entry->list_status == '1')
				{ $image_icon_status =  '<img src="'.apabs_URL.'/images/published.png" border="0" title="Click to Unpublish"  />';
				$status_title_change = 'Unpublish';
				}
			else
				{ $image_icon_status = '<img src="'.apabs_URL.'/images/unpublished.png" border="0"  title="Click to Publish"  />';	
				$status_title_change = 'Publish';
				}
				?>
                <a href="<?php echo $_SERVER["PHP_SELF"]?>?page=<?php echo $page;?>&pid=<?php echo $entry->id;?>&status=changeStatus&mode=changeStatus<?php echo $extra_link;?>" onclick="return confirm('Are you sure you want to  <?php echo $status_title_change;?>?')">
                <?php echo $image_icon_status; ?>
                </a></td>
                
			   
                
                
             
                <td><a href="<?php echo $_SERVER["PHP_SELF"]?>?page=list-plugin-data1&pid=<?php echo $entry->id;?>&mode=edit">Edit</a> | <a href="<?php echo $_SERVER["PHP_SELF"]?>?page=<?php echo $page;?>&pid=<?php echo $entry->id;?>&mode=delete" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
            </tr> 
            <?php
                $count++;
            }
            ?>
 
        <?php } else { ?>
        <tr>
            <td colspan="6">No record found.</td>
        </tr>
    <?php } ?>
    </tbody>
    
    <tfoot>
        <tr>
            <th width="5%">S.No.</th>
            <th width="13%">Title </th>
            <th width="19%"> Banner</th>
            <th width="15%"> URL</th>
            <th width="10%">Publish Status</th> 
            <th width="8%">Action</th>

    	</tr>
    </tfoot>
    
 </table>

</div>