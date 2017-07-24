<?php 


add_action('sp_cdm_settings_add_tab', array('sp_cdm_link_settings' , 'tab'));
add_action('sp_cdm_settings_add_tab_content', array('sp_cdm_link_settings', 'tab_content'));


class sp_cdm_link_settings{
	
	
	function tab(){
		
	echo ' <li><a href="#cdm-tab-link">Links</a></li>';	
		
	}
	
	
	function tab_content(){
		
		$text_api = get_option( 'sp_cdm_link_style', 'window' );
		
			
		if($text_api == 'window'){
			$window_selected = 'selected="selected"';
		}
		if($text_api == 'redirect'){
			$redirect_selected = 'selected="selected"';
		}
		
		
	echo '<div id="cdm-tab-link">	

 <table class="wp-list-table widefat fixed posts" cellspacing="0">


  

  

    <tr>

    <td width="300"><strong>Display Style</strong><br><em>Open the file window or redirect to file.</em></td>

    <td><select name="sp_cdm_link_style"><option value="window" '.$window_selected.'>File Window</option><option value="redirect" '.$redirect_selected.'>Redirect to URL</option></select></td>

  </tr>
  <tr>

    <td width="300"><strong>Word for tab</strong><br><em>The tab title, default is "Link"</em></td>

    <td><input type="text" name="sp_cdm_link_word"  value="' . get_option('sp_cdm_link_word','Link') . '"  style="width:100%"> </td>

  </tr> 
 
    <tr>

    <td>&nbsp;</td>

    <td><input type="submit" name="save_options" value="Save Options"></td>

  </tr>
  </table>';
	
	
	
	echo '</div>';
		
	}
}