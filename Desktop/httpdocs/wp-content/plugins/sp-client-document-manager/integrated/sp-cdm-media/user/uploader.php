<?php

add_action('sp_cdm_after_file_upload', array('sp_cdm_media_uploader', 'after_upload'),10,2);

add_filter('sp_cdm_add_buttons', array('sp_cdm_media_uploader', 'button'));
add_filter('sp_cdm_upload_bottom', array('sp_cdm_media_uploader', 'add_form'));





add_action( 'wp_ajax_sp_cdm_media_save_embed', array('sp_cdm_media_uploader', 'save_embed'));
add_action( 'wp_ajax_nopriv_sp_cdm_media_save_embed', array('sp_cdm_media_uploader', 'save_embed'));


add_filter('sp_cdm_viewfile_image', array('sp_cdm_media_uploader', 'thumbnail'),10,2);


class sp_cdm_media_uploader{
	
		
	
		function thumbnail($img,$r){
			
			if($r['file'] == 'embed'){
			
			$img = '<img src="' . SP_CDM_PLUGIN_URL . 'images/video.png" width="32" >';	
				
			}
			
			return $img;
		}
	
		function after_upload($target_path,$uid){
			
			
			sp_cdm_media_screenshot($target_path);
			
			
		}
		
		
		function save_embed(){
			global $wpdb;
			

			
	$insert_file['uid'] = $_POST['uid'];
	$insert_file['cid'] = $_POST['cid'];
	$insert_file['name'] = $_POST['file-name'];
	$insert_file['file'] = 'embed';
	$insert_file['embed'] = $_POST['embed'];
	$insert_file['pid'] = $_POST['pid'];
	$insert_file['notes'] =  $_POST['notes'];
	$insert_file['tags'] =  $_POST['tags'];

	#check if its a group
		if($_COOKIE['cdm_group_id'] != ''  ){
		$insert_file['group_id'] = $_COOKIE['cdm_group_id'];
			if(sp_cdm_group_client( $_COOKIE['cdm_group_id']) != false){
				$insert_file['client_id'] = sp_cdm_group_client( $_COOKIE['cdm_group_id']);
			}
				
		}
		#check if client is set
		if($_COOKIE['cdm_client_id'] != ''){
		$insert_file['client_id'] = $_COOKIE['cdm_client_id'];	
		}
	foreach($insert_file as $key=>$value){ if(is_null($value)){ unset($insert_file[$key]); } }
	$wpdb->insert("".$wpdb->prefix."sp_cu", $insert_file);
	$message['file_id'] = $wpdb->insert_id;

			
			
			$message['success'] = '1';
			echo json_encode($message);
			die();
			
			
			
		}
			
	function add_form($html){
		
		global $wpdb;
		
			
	
		$html = apply_filters('sp_cdm_media_before_form' , $html);
		$html .='<div style="display:none">
		
			
			<div class="remodal" data-remodal-id="add-embed">
			'. sp_cdm_media_uploader::upload_dialog().'
					</div>';
		
		return $html;
	}
	
	
	
		 function upload_dialog()
    {
        global $wpdb;
        global $current_user;
		
		if($current_user->ID != ''){
        if ($_GET['id'] != '') {
            $uid =$_GET['id'];
        } else {
            $uid = $current_user->ID;
        }
	
        $html .= '




<form  action="' . $_SERVER['REQUEST_URI'] . '" method="post" enctype="multipart/form-data" id="cdm_embed_media" >
<input type="hidden" name="pid" value="0" class="cdm_premium_pid_field">
<input type="hidden" name="action" value="sp_cdm_media_save_embed">
<input type="hidden" name="uid" value="'.$uid .'">
';

if( $_GET['page'] == 'sp-client-document-manager-fileview') {
$html .='<input type="hidden" name="admin-uploader" value="1">';	
}
        $html .= '<div>';

		
	
		$html .='<p>
		<label>' . __("File Name", "sp-cdm") . ' <span style="color:red">*<span></label>
		<input  type="text" name="file-name" class="required_name" >';
		
		$html .='</p> ';
	if(function_exists('sp_cdm_display_categories')){
        //$html .= sp_cdm_display_projects();
        $html .= sp_cdm_display_categories();
		
	}
      
	
$html .=' <p>
 <label>' . __("Embed Code", "sp-cdm") . '</label>
   <textarea id="tags" name="embed"  style="width:90%;height:100px"></textarea>

  </p>';
	
		
		
         if (get_option('sp_cu_enable_tags') == 1) {
                $html .= '

 <p>
 <label>' . __("Tags:", "sp-cdm") . '</label>
   <textarea id="tags" name="tags"  style="width:90%;height:30px"></textarea>

  </p>';
         
            
        } else {
            $html .= '<p>

    <label>' . __("Notes", "sp-cdm") . ':</label>
	<textarea style="width:90%;height:50px" name="dlg-upload-notes"></textarea>

  </p>

  ';
  

        }
		if(function_exists('display_sp_cdm_form')){
		$html .= display_sp_cdm_form();
		}
			$spcdm_form_upload_fields = '';
		$spcdm_form_upload_fields .= apply_filters('spcdm_form_upload_fields',$spcdm_form_upload_fields);
		
		$html .= $spcdm_form_upload_fields;
		
	
        $html .= '

		
			<div style="padding-top:15px">
					<input type="submit"  class="btn btn-primary" value="' . __("Add Embeded Video","sp-cdm").'">
</div>
			
				

						<div class="sp_change_indicator" ></div>	
			<div class="cdm_debug"></div>
						';
        $html .= '

</div>';
        $timestamp = time();
        $html .= '



	</form>

		

	

	';
    
      return $html;
		}
    }
		function button($html){
		
		  $html .= '  <a href="#add-embed"  class="sp_cdm_add_file hide_add_file_permission">Embed Video</a> ';
		  
		  return $html;
	}
	
	
	
}