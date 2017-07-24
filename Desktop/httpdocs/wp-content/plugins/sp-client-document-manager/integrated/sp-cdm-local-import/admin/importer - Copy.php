<?php
add_filter('sp_client_upload_nav_menu', array('sp_cdm_local_import_admin', 'top_menu'));
add_action('sp_cu_admin_menu', array('sp_cdm_local_import_admin', 'menu'));



add_action( 'wp_ajax_sp_cdm_import_show_folders', array('sp_cdm_local_import_admin', 'ajax_get_folders'));
add_action( 'wp_ajax_sp_cdm_import_show_folders', array('sp_cdm_local_import_admin', 'ajax_get_folders'));

add_action( 'wp_ajax_sp_cdm_import_check_files', array('sp_cdm_local_import_admin', 'ajax_check_files'));
add_action( 'wp_ajax_nopriv_sp_cdm_import_check_files', array('sp_cdm_local_import_admin', 'ajax_check_files'));

add_action( 'wp_ajax_sp_cdm_import_start_import', array('sp_cdm_local_import_admin', 'ajax_start_import'));
add_action( 'wp_ajax_nopriv_sp_cdm_import_start_import', array('sp_cdm_local_import_admin', 'ajax_start_import'));

add_action('admin_init', array('sp_cdm_local_import_admin', 'session'));

class sp_cdm_local_import_admin{
	function session(){
		
    session_start();

		
	}
	function ajax_check_files(){
		echo '<div style="margin:10px;padding:10px;background-color:#EFEFEF;border:1px solid #CCC;border-radius:10px;">';
		echo '<strong>Checking</strong> 	'.$_POST['path'].'......<br><br>';
	
		echo sp_cdm_local_import_admin::count_local_files($_POST['path']);
		echo '</div>';
	
	die();
		
		
	}
	
	function ajax_start_import(){
		echo '<div style="margin:10px;padding:10px;background-color:#EFEFEF;border:1px solid #CCC;border-radius:10px;">';
	
	 echo '<pre>';
	  sp_cdm_local_import_admin::copy_local_files($_POST['path'],$_POST['uid']);
	   echo '</pre>';

		echo '</div>';
	
	die();
		
		
	}
	
	
function add_folder($name,$pid){
	
	global $wpdb;
	if($_SESSION['import_pid'] == ''){
		
		$_SESSION['import_pid'] = $_POST['pid'];
		
	}
	$insert['name'] = $name;
	$insert['uid'] = $_POST['uid'];
	$insert['parent'] = $pid;
	foreach($insert as $key=>$value){ if(is_null($value)){ unset($insert[$key]); } }	
	$wpdb->insert("" . $wpdb->prefix . "sp_cu_project", $insert);

	$_SESSION['import_pid'] = $wpdb->insert_id;
	return $wpdb->insert_id;
}
function add_file($file,$pid,$uid){
	global $wpdb;
	
	
	
	$file_contents = file_get_contents($file);
	$dir = '' . SP_CDM_UPLOADS_DIR . '' . $uid . '/';
	
	
	 if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
		
	$local_file_path = ''.$dir.''.basename($file).'';	
	file_put_contents($local_file_path, $file_contents);
	#echo $local_file_path;
	
	$insert['name'] = basename($file);
	$insert['file'] = basename($file);
	$insert['uid'] = $uid ;
	$insert['pid'] = $pid;
	#print_r($insert);
	foreach($insert as $key=>$value){ if(is_null($value)){ unset($insert[$key]); } }	
	$wpdb->insert("" . $wpdb->prefix . "sp_cu", $insert);
	
	return $wpdb->insert_id;
	
	
}

function copy_local_files($dir) {
   $contents = array();
  # print_r($_POST);
   	if($_SESSION['import_pid'] == ''){
		
		$_SESSION['import_pid'] = $_POST['pid'];
		
	}
    if($dir == ''){
	$dir = $_POST['path'];	
	}
    if($uid == ''){
	$uid = $_POST['uid'];	
	}
	
/*
   #print_r($_SESSION);
    foreach (scandir($dir) as $node) {
        if ($node == '.' || $node == '..') continue;
        if (!is_dir($dir . '/' . $node)) {
			    $contents['__file_import'][] = $dir . '/' .$node;
				sp_cdm_local_import_admin::add_file($dir . '/' .$node,$uid);
			
		
        } else {
        $insert_folder = sp_cdm_local_import_admin::add_folder($node,$uid);
		
         $contents[$node] =  sp_cdm_local_import_admin::copy_local_files($dir . '/' . $node,$uid);
			echo '<div class="updated"><p>Imported '.$node.'!</p></div>';
        }
    }
	
	*/
	
	$structure = sp_cdm_local_import_admin::find_folder_structure($dir,$_POST['pid']);
	 sp_cdm_local_import_admin::process($structure,$_POST['pid'],$_POST['uid']);
	

	#sp_cdm_local_import_admin::copy_local_files_process($contents,$uid,$destination);

		
	
    return $contents;
}



function count_path($path){
	$path_dir = explode("/", $dir);
	$total = count($path_dir) -1;
	return $total;
}
function process($dir,$pid,$uid){
	print_r($dir);
	ksort($dir);
	
if($pid == ''){
	
	$pid = 0;
	
}
$file_count = 0;
$folder_count= 0;
	$path_dir = explode("/", $_POST['path']);
	$total = count($path_dir) -1;	
	$starting_path = $path_dir[$total];
	
	$_SESSION['structure'] = array();
		foreach($dir as $path=>$files){
		
	$loop_path_dir = explode("/", $path);
	$loop_total = count($loop_path_dir) -1;	
	$current_folder = $loop_path_dir[$loop_total];
	
	if($loop_total >= $total){
	
	
		if($path ==$_POST['path']){
			
			foreach($files as $file_key=>$file){
			if(!in_array($file,array('.','..')) && $file_key != '__base_id'){
			sp_cdm_local_import_admin::add_file($path.'/'.$file,$pid,$uid);
			$file_count++;
			}
			}
				
		}else{
				
				if(count($loop_path_dir) > count($path_dir)){
					
				$loop_parent = count($loop_path_dir) -2;	
				$parent_folder = $loop_path_dir[$loop_parent];
					echo $parent_folder;
					echo '-';
					echo $starting_path;
					
					if($parent_folder == $starting_path){
					
					$parent = $_POST['pid'];
						
					}else{
						$parent_path = preg_replace('|/[^/]*$|','', $path);
						
					$parent = $_SESSION['structure'][$parent_path.'_'.$parent_folder];
						
					}
					echo 'parent:'.$parent_path.'_'.$parent_folder.'';
					
						$pid = sp_cdm_local_import_admin::add_folder($current_folder ,$parent,$uid);
						$folder_count++;
						$_SESSION['structure'][$path.'_'.$current_folder] = $pid;
							foreach($files as $file_key=>$file){
						if(!in_array($file,array('.','..')) && $file_key != '__base_id'){
						sp_cdm_local_import_admin::add_file($path.'/'.$file,$pid,$uid);	
						$file_count++;
						}
						}
					
					
					
				}
	
		}
	}
		}
		echo '<div class="updated"><p>Imported '. $file_count.' files and '.$folder_count.' folders!</p></div>';
		print_r( $_SESSION['structure']);
}
function get_base($dir){
		
		$base = explode("/", $dir);
		$base_total = count($base ) -1;	
		$current_folder = $loop_path_dir[$loop_total];
}
function find_folder_structure($dir){
	
$ritit = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($dir), RecursiveIteratorIterator::SELF_FIRST
);

$map = array();
foreach ($ritit as $splFileInfo) {
    $dir = dirname($splFileInfo->getRealPath());
	
    $map[ $dir ][] = $splFileInfo->getFileName();
}

	$path_dir = explode("/", $_POST['path']);
	$total = count($path_dir);
	$total_starting = count($path_dir);
foreach($map as $key=>$array){
		
		
		
	$path_dir_loop = explode("/", $key);
	$total_loop = count($path_dir_loop);
	$total_current = $total_loop -1;
	$starting_path = $path_dir_loop[$total_current];
	$total_parent = $total_loop -2;
	if($total_loop >= $total){
	$parent_path = $path_dir_loop[$total_parent];
	}else{
	$parent_path = $_POST['pid'];	
	}
if($total_loop >= $total){
	$arr[$key] = $array;
	$arr[$key]['__base_id'] = rand();
	#$arr[$key]['__folder'] = $starting_path;
	#$arr[$key]['__parent'] = $parent_path;
		
	
}
}
print_r($map);exit;
return $arr;
	
}
function plotTreeCreate_folders($arr, $indent=0, $mother_run=true,$pid = 0){
    if ($mother_run) {
        // the beginning of plotTree. We're at rootlevel
        echo "start\n";
    }

    foreach ($arr as $k=>$v){
        // skip the baseval thingy. Not a real node.
        if ($k == "__base_val") continue;
        // determine the real value of this node.
        $show_val = (is_array($v) ? $v["__base_val"] : $v);
      
		if(is_array($v)){
			$pid = sp_cdm_local_import_admin::add_folder($k,$pid);
			 sp_cdm_local_import_admin::plotTree($v, ($indent+1), false,$pid);
		}
	  
      
    }

    if ($mother_run) {
        echo "end\n";
    }
}
function plotTree($arr, $indent=0, $mother_run=true,$pid = 0){
    if ($mother_run) {
        // the beginning of plotTree. We're at rootlevel
        echo "start\n";
    }

    foreach ($arr as $k=>$v){
        // skip the baseval thingy. Not a real node.
        if ($k == "__base_val") continue;
        // determine the real value of this node.
        $show_val = (is_array($v) ? $v["__base_val"] : $v);
      
	  
	  	if(!is_array($v)){
			
			sp_cdm_local_import_admin::add_file($v,$pid);
		}
	  	
		
		if(is_array($v)){
			$pid = sp_cdm_local_import_admin::add_folder($k,$pid);
			 sp_cdm_local_import_admin::plotTree($v, ($indent+1), false,$pid);
		}
	  
      
    }

    if ($mother_run) {
        echo "end\n";
    }
}
function get_folder_structure($dir){
	
		  $ite=new RecursiveDirectoryIterator($dir);

    $bytestotal=0;
    $nbfiles=0;
	$iterator = new RecursiveIteratorIterator($ite);

    foreach ($iterator as $filename=>$cur) {
     
	  if(!is_dir($filename)){
	    $filesize=$cur->getSize();
        $bytestotal+=$filesize;
        $nbfiles++;
		$cutname = str_replace($dir,'',$filename);
        $files[$cutname] = $filename;
	  }
    }
	
	
	
	
	return sp_cdm_local_import_admin::explodeTree($files, $delimiter = '/',true);
	
}
function count_local_files($path) { 
		if(is_dir($path)){
			
			
			  $ite=new RecursiveDirectoryIterator($path);

    $bytestotal=0;
    $nbfiles=0;
	$iterator = new RecursiveIteratorIterator($ite);

    foreach ($iterator as $filename=>$cur) {
      
	  if(!is_dir($filename)){
	    $filesize=$cur->getSize();
        $bytestotal+=$filesize;
        $nbfiles++;
        $files[] = $filename;
	  }
    }
	
    $bytestotal=number_format($bytestotal);


			 return  ' <div class="updated"><p>'. $nbfiles.' Files located in this directory with a total of '.$bytestotal.' bytes</p></div>';
		}else{
			return ' <div class="error"><p>File does not appear to be a valid directory!</p></div>';
			
		}
}

function explodeTree($array, $delimiter = '_', $baseval = false)
{
    if(!is_array($array)) return false;
    $splitRE   = '/' . preg_quote($delimiter, '/') . '/';
    $returnArr = array();
    foreach ($array as $key => $val) {
        // Get parent parts and the current leaf
        $parts  = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
        $leafPart = array_pop($parts);

        // Build parent structure
        // Might be slow for really deep and large structures
        $parentArr = &$returnArr;
        foreach ($parts as $part) {
            if (!isset($parentArr[$part])) {
                $parentArr[$part] = array();
            } elseif (!is_array($parentArr[$part])) {
                if ($baseval) {
                    $parentArr[$part] = array('__base_val' => $parentArr[$part]);
                } else {
                    $parentArr[$part] = array();
                }
            }
            $parentArr = &$parentArr[$part];
        }

        // Add the final part to the structure
        if (empty($parentArr[$leafPart])) {
            $parentArr[$leafPart] = $val;
        } elseif ($baseval && is_array($parentArr[$leafPart])) {
            $parentArr[$leafPart]['__base_val'] = $val;
        }
    }
    return $returnArr;
}	
	
	function ajax_get_folders(){
		
		
		if($_POST['user_id'] == '-1'){
			
			echo 'Choose a user first';
			
		}else{
	
		echo sp_cdm_display_projects_select_by_id($_POST['user_id'] ,'sp-cdm-import-user',$class = 'sp-cdm-import-user');
			
		}
	
		
	die();	
	}
	
	
	function menu(){
	
	add_submenu_page('sp-client-document-manager', __("Local Import", "sp-cdm"), __("Local Import", "sp-cdm"), 'sp_cdm', 'sp-client-document-manager-local-import', array(
        'sp_cdm_local_import_admin',
        'view'
    ));
		
	}
	
	function top_menu($html){
		
		$html .= '<li><a href="admin.php?page=sp-client-document-manager-local-import" >' . __("Local Import", "sp-cdm") . '</a></li>';
		return $html;	
	}
	function view(){
		$_SESSION['import_pid'] = '';
	
	 echo '<h2>' . __("Local Import", "sp-cdm") . '</h2>' . sp_client_upload_nav_menu() . '
	 <form action="" method="post">
	 	 <table class="wp-list-table widefat fixed posts" cellspacing="0">
		 <tr><td style="width:200px">Local Path</td><td><input type="text" name="local-path" value="'.$_SERVER['DOCUMENT_ROOT'] .'" style="width:400px" class="sp-cdm-import-check-files-location"> <a href="#" class="sp-cdm-import-check-files button" >Check Files</a> <div class="sp-cdm-check-files-view"></div></td></tr>
		 <tr><td>Assign to user</td><td>'.wp_dropdown_users(array('name' => 'assign-to', 'echo'=> false, 'class'=>'sp-cdm-import-assign','show_option_none'=>'Select a user')) .'</td></tr>
		 <tr><td >Destination Folder</td><td><span class="sp-cdm-import-folders">Choose a user first</span></td></tr>
		 <tr><td ></td><td><input type="submit" name="import-files" class="sp-cdm-start-import" value="Import"></td></tr>
		 </table>
	 
	 </form>
	 
	 ';
	 
	 
	 
	 
	 
	
	
	}
}