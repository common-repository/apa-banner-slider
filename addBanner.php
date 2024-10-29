<?php 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
global $wpdb;
$page = isset($_REQUEST['page'])?$_REQUEST['page']:'';
$mode = isset($_REQUEST['mode'])?$_REQUEST['mode']:'';
 

// santitize_string

$bannerName = filter_var($_POST['bannerName'], FILTER_SANITIZE_STRING);
$link = filter_var($_POST['link'], FILTER_SANITIZE_URL);
$banner_heading = filter_var($_POST['banner_heading'], FILTER_SANITIZE_STRING);
$banner_subheading = filter_var($_POST['banner_subheading'], FILTER_SANITIZE_STRING);



if(isset($_POST['bannerbtn']))
{
	//if(!empty($_POST['bannerName'] ) && $_FILES['imgPath']['tmp_name']) { 
	
	
	
  if(!empty($_FILES['imgPath']['tmp_name']))
    {				
		if ($_FILES['imgPath']['error'] > 0) 				
			$error = 1;
		else 
		{
			$arr = explode('.', $_FILES['imgPath']['name']);
			$ext = array_pop($arr);
						
			if(strtolower($ext) == 'jpg' || strtolower($ext) == 'jpeg' || strtolower($ext) == 'png')						
			{	
				$uploads = wp_upload_dir();
			  
				if (is_writable($uploads['path']))
				{						
					$uploadfile=true;
				}
				
				$upload=$_FILES['imgPath'];
			   
				if ($upload['tmp_name'])
				{					
					$file=handle_image_upload($upload);
					if ($file)
					{
						$img_url=$file['url'];
						
						$size='medium';
						
						$resized = image_make_intermediate_size( $file['file'], 1500,750,50 );
						if ($resized)
						{
							$img_src=$uploads['url'] .'/'.$resized['file'];
							update_post_meta( $post_id, 'glp_banner', $img_src);
						 }
						else
							$img_src=$img_url;
						
						$image_uploaded=true;
					}
					else
						$error=__('Please upload a valid image.',plugin_domain);
				}
				else 
				{
					$img_url=$url;
					$img_src=$url;
				}
							
			}
		}
		
		
		
		
		
    }
	
 
	if($mode=='edit'){
	
	  if(!empty($_FILES['imgPath']['tmp_name']))
	  {	
		$wpdb->update($wpdb->prefix.'banners',array('bannerName'=>filter_var($_POST['bannerName'], FILTER_SANITIZE_STRING), 'imgPath'=>filter_var($img_src, FILTER_SANITIZE_URL), 'link'=>filter_var($_POST['link'], FILTER_SANITIZE_URL), 'banner_heading'=>filter_var($_POST['banner_heading'], FILTER_SANITIZE_STRING), 'banner_subheading'=>filter_var($_POST['banner_subheading'], FILTER_SANITIZE_STRING), 'heading_style'=>$_POST['heading_style'] ,'list_status'=>$_POST['list_status']),array('id'=>$_POST['bannerid']));
	
	  } else {
	
			$wpdb->update($wpdb->prefix.'banners',array('bannerName'=>filter_var($_POST['bannerName'], FILTER_SANITIZE_STRING), 'link'=>filter_var($_POST['link'], FILTER_SANITIZE_URL), 'banner_heading'=>filter_var($_POST['banner_heading'], FILTER_SANITIZE_STRING), 'banner_subheading'=>filter_var($_POST['banner_subheading'], FILTER_SANITIZE_STRING), 'heading_style'=>$_POST['heading_style'] ,'list_status'=>$_POST['list_status']),array('id'=>$_POST['bannerid'])); 
		  
		  }
		
		
	$db_status = 'update';	
	}
	else
	{
		
		if(!empty($_POST['bannerName'] ) && $_FILES['imgPath']['tmp_name']) { 
		$wpdb->insert($wpdb->prefix.'banners', array('bannerName'=>filter_var($_POST['bannerName'], FILTER_SANITIZE_STRING), 'link'=>filter_var($_POST['link'], FILTER_SANITIZE_URL), 'banner_heading'=>filter_var($_POST['banner_heading'], FILTER_SANITIZE_STRING), 'banner_subheading'=>filter_var($_POST['banner_heading'], FILTER_SANITIZE_STRING), 'heading_style'=>$_POST['heading_style'],'imgPath'=>filter_var($img_src, FILTER_SANITIZE_URL),'list_status'=>$_POST['list_status']));
		$db_status = 'add';	
		}else { $error_message="This Field Is Required";
		}
	}
	


} 

/*else 
{
	$error_message="This Field Is Required";
	
}

}*/
if($mode=='edit')
{
	$result = $wpdb->get_row("select * from ".$wpdb->prefix."banners where id=$_REQUEST[pid]");
	

}


?>

<div id="wrap">
<div class="wrap"><h2>

 <?php 
	if($mode=='edit')
		echo '<img src="'.apabs_URL.'/images/edit.png" border="0"  /> Edit Banner';
	else
		echo '<img src="'.apabs_URL.'/images/add.png" border="0"  /> Add Banner';	
?> </h2>
</div>

<div class="wrap">
<form name="bannerfrm" action="" method="post" enctype="multipart/form-data">
 
<p>
<label>Banner Title: </label> <input type="text" style="width:250px;" name="bannerName" value="<?php if($mode=='edit')echo stripslashes($result->bannerName);?>" />
<input type="hidden" name="bannerid" value="<?php if($mode=='edit')echo $result->id;?>" /> <?php echo $error_message; ?></p>


<p><label>Banner Link : </label> 
<input type="text" style="width:250px;" name="link" value="<?php if($mode=='edit')echo stripslashes($result->link);?>" />
 
 </p>

<p><label>Image Title : </label> 
<input type="text" style="width:250px;" name="banner_heading" value="<?php if($mode=='edit')echo stripslashes($result->banner_heading);?>" />
 
</p>

<p><label>Image Description : </label> 
<input type="text" style="width:250px;" name="banner_subheading" value="<?php if($mode=='edit')echo stripslashes($result->banner_subheading);?>" />

</p>

<p><label>Heading Style: </label> 
		<select name="heading_style" id="heading_style" style="width:150px; padding:3px;" >
        	<option value="1" <?php if($mode=='edit' && $result->heading_style == '1') { echo ' selected="selected"';}?> > Left </option>
            <option value="0"  <?php if($mode=='edit' && $result->heading_style == '0') { echo ' selected="selected"';}?> > Center </option>
        </select></p>
        

<p><label>Banner Image: </label> <input type="file" name="imgPath" />  <?php echo $error_message; ?> </p>
<?php
if($result->imgPath != '')
	echo '<p><label> &nbsp; </label><img src="'.$result->imgPath.'" border="0"  width="600" height="300"></p>';

?>
 


<p><label>Status: </label> 
		<select name="list_status" id="list_status" style="width:150px; padding:3px;" >
        	<option value="1" <?php if($mode=='edit' && $result->list_status == '1') { echo ' selected="selected"';}?> > Publish </option>
            <option value="0"  <?php if($mode=='edit' && $result->list_status == '0') { echo ' selected="selected"';}?> > Unpublish </option>
        </select></p>

<p><label> &nbsp; </label> <input type="submit" name="bannerbtn"  value="Save" style="cursor:pointer;" /></p>
</form>

</div>


</div>
