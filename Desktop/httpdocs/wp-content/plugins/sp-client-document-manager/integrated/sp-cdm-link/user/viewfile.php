<?php 



add_filter('sp_cdm_viewfile_download_url', array('sp_cdm_link_viewfile', 'viewfile_delete_button'),10,2);

add_filter('sp_cdm_viewfile_revision_button', array('sp_cdm_link_viewfile', 'viewfile_delete_button_rev'),10,2);
add_filter('sp_cdm_viewfile_replace_file_info', array('sp_cdm_link_viewfile', 'viewfile_image'),10,2);


add_filter('sp_cdm_viewfile_image', array('sp_cdm_link_viewfile', 'viewfile_image_list'),10,2);
add_filter('spcdm/file_list/link', array('sp_cdm_link_viewfile', 'filelist_link'),10,2); 
class sp_cdm_link_viewfile{
		
		
		function filelist_link($link, $r){
			
			if($r['file'] == 'link' && get_option( 'sp_cdm_link_style', 'window' )== 'redirect'){
				$link = 'sp_cdm_link_go(\''.$r['url'].'\');';
				
			}
			return $link;
		}
		function viewfile_image_list($img, $r){
			
			if($r['file'] == 'link'){
				$img = '<a target="_blank" href="' . $r['url'] . '"><img src="' . SP_CDM_LINK_URL . '/images/url.png"  style="width:32px"> </a>';
				
			}
			return  $img;	
		}
		function viewfile_image( $info_left_column, $r){
			
			if($r[0]['file'] == 'link'){
				 $info_left_column = '<a target="_blank" href="' . $r[0]['url'] . '"><img src="' . SP_CDM_LINK_URL . '/images/url.png" > </a>';
				
			}
			return  $info_left_column;
		}
	
		function viewfile_delete_button($html,$r){
			
			if($r[0]['file'] == 'link'){
				
			unset($html);
			$html = '<a target="_blank" href="' . $r[0]['url'] . '" title="Download" style="margin-right:15px"  ><img src="' . SP_CDM_LINK_URL . '/images/url.png" style="width:25px"> ' . sprintf('View %s', get_option('sp_cdm_link_word','Link')) . '</a>';	
			}
		
		return $html;
		
		}
		
		function viewfile_delete_button_rev($html,$r){
			
			if($r[0]['file'] == 'link'){
				
			unset($html);
			
			}
		
		return $html;
		
		}
	
	
	
	
	
}