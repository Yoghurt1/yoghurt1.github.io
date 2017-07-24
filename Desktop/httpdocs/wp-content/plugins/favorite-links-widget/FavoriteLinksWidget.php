<?php
/*
Plugin Name: Favorite Links Widget
Plugin URI: http://www.anil2u.info/
Description: Favorite Links Widget by Anil Kumar Panigrahi to display the Favorite links in your Wordpress sidebar  ...
Version: 1.3
Author: Anil Kumar Panigrahi
Author URI: http://www.anil2u.info/myprofile/
Text Domain: favorite-links-widget
*/
Class FL_Widget extends WP_Widget{
	
	public function __construct(){
		parent::__construct(
			'fl_widget', // Base ID
			'Favorite Link Widget', // Name
			array( 'description' => __( 'A Favorite Link Widget is developed by Anil Kumar Panigrahi', 'text_domain' ), ) // Args
		);
		
	}
	
	public function widget($args,$instance){
		$title = apply_filters( 'widget_title', $instance['title'] );
		      
        $text_link1 = $instance['text_link1'];
		$href_link1 = $instance['href_link1'];
		
		$text_link2 = $instance['text_link2'];
		$href_link2 = $instance['href_link2'];
		
		$text_link3 = $instance['text_link3'];
		$href_link3 = $instance['href_link3'];
		
		$text_link4 = $instance['text_link4'];
		$href_link4 = $instance['href_link4'];
		
		$text_link5 = $instance['text_link5'];
		$href_link5 = $instance['href_link5'];
		

		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
		
		echo '<div class="widget-text"><ul>';
		
		if ( ! empty( $text_link1 ) && ! empty( $href_link1 ) && $text_link1 !='New Text1' && $href_link1 !='New Link1')
			echo '<li><a href="'.$href_link1.'">'.$text_link1.'</a></li>';
		
		if ( ! empty( $text_link2 ) && ! empty( $href_link2 ) && $text_link2 !='New Text2' && $href_link2 !='New Link2')
			echo '<li><a href="'.$href_link2.'">'.$text_link2.'</a></li>';
			
		if ( ! empty( $text_link3 ) && ! empty( $href_link3 ) && $text_link3 !='New Text3' && $href_link3 !='New Link3')
			echo '<li><a href="'.$href_link3.'">'.$text_link3.'</a></li>';
			
		if ( ! empty( $text_link4 ) && ! empty( $href_link4 ) && $text_link4 !='New Text4' && $href_link4 !='New Link4')
			echo '<li><a href="'.$href_link4.'">'.$text_link4.'</a></li>';
			
		if ( ! empty( $text_link5 ) && ! empty( $href_link5 ) && $text_link5 !='New Text5' && $href_link5 !='New Link5')
			echo '<li><a href="'.$href_link5.'">'.$text_link5.'</a></li>';					
		
        echo '</ul></div>';
		
		//echo __( 'Hello, World!', 'text_domain' );
		echo $args['after_widget'];
	}
	
	public function form($instance){
		if(isset($instance['title'])){
			$title = $instance['title'];
		}else{
			$title = __('New Widget Title','text_domain');
		}
		
        if(isset($instance['text_link1'])){
			$text_link1 = $instance['text_link1'];
		}else{
			$text_link1 = __('New Text1','text_domain');
		}
		if(isset($instance['href_link1'])){
			$href_link1 = $instance['href_link1'];
		}else{
			$href_link1 = __('New Link1','text_domain');
		}
		
		if(isset($instance['text_link2'])){
			$text_link2 = $instance['text_link2'];
		}else{
			$text_link2 = __('New Text2','text_domain');
		}
		if(isset($instance['href_link2'])){
			$href_link2 = $instance['href_link2'];
		}else{
			$href_link2 = __('New Link2','text_domain');
		}
		
		if(isset($instance['text_link3'])){
			$text_link3 = $instance['text_link3'];
		}else{
			$text_link3 = __('New Text3','text_domain');
		}
		if(isset($instance['href_link3'])){
			$href_link3 = $instance['href_link3'];
		}else{
			$href_link3 = __('New Link3','text_domain');
		}
		
		if(isset($instance['text_link4'])){
			$text_link4 = $instance['text_link4'];
		}else{
			$text_link4 = __('New Text4','text_domain');
		}
		if(isset($instance['href_link4'])){
			$href_link4 = $instance['href_link4'];
		}else{
			$href_link4 = __('New Link4','text_domain');
		}
		
		if(isset($instance['text_link5'])){
			$text_link5 = $instance['text_link5'];
		}else{
			$text_link5 = __('New Text5','text_domain');
		}
		if(isset($instance['href_link5'])){
			$href_link5 = $instance['href_link5'];
		}else{
			$href_link5 = __('New Link5','text_domain');
		}
		
		
		
		?>
		<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Widget Title:' ); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<hr />
		<p>
        <label for="<?php echo $this->get_field_id('text_link1'); ?>"><?php _e('Link Title1:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('text_link1'); ?>" name="<?php echo $this->get_field_name('text_link1'); ?>" type="text" value="<?php echo $text_link1; ?>" />
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('href_link1'); ?>"><?php _e('Link 1:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('href_link1'); ?>" name="<?php echo $this->get_field_name('href_link1'); ?>" type="text" value="<?php echo $href_link1; ?>" />
        </p>
        
        <hr />
		<p>
        <label for="<?php echo $this->get_field_id('text_link2'); ?>"><?php _e('Link Title2:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('text_link2'); ?>" name="<?php echo $this->get_field_name('text_link2'); ?>" type="text" value="<?php echo $text_link2; ?>" />
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('href_link2'); ?>"><?php _e('Link 2:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('href_link2'); ?>" name="<?php echo $this->get_field_name('href_link2'); ?>" type="text" value="<?php echo $href_link2; ?>" />
        </p>
        
        <hr />
        <p>
        <label for="<?php echo $this->get_field_id('text_link3'); ?>"><?php _e('Link Title3:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('text_link3'); ?>" name="<?php echo $this->get_field_name('text_link3'); ?>" type="text" value="<?php echo $text_link3; ?>" />
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('href_link3'); ?>"><?php _e('Link 3:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('href_link3'); ?>" name="<?php echo $this->get_field_name('href_link3'); ?>" type="text" value="<?php echo $href_link3; ?>" />
        </p>
        
        <hr />
        <p>
        <label for="<?php echo $this->get_field_id('text_link4'); ?>"><?php _e('Link Title4:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('text_link4'); ?>" name="<?php echo $this->get_field_name('text_link4'); ?>" type="text" value="<?php echo $text_link4; ?>" />
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('href_link4'); ?>"><?php _e('Link 4:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('href_link4'); ?>" name="<?php echo $this->get_field_name('href_link4'); ?>" type="text" value="<?php echo $href_link4; ?>" />
        </p>
        
        <hr />
        <p>
        <label for="<?php echo $this->get_field_id('text_link5'); ?>"><?php _e('Link Title5:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('text_link5'); ?>" name="<?php echo $this->get_field_name('text_link5'); ?>" type="text" value="<?php echo $text_link5; ?>" />
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('href_link5'); ?>"><?php _e('Link 5:'); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id('href_link5'); ?>" name="<?php echo $this->get_field_name('href_link5'); ?>" type="text" value="<?php echo $href_link5; ?>" />
        </p>

		<?php
	}
	
	public function update($new_instance,$old_instance){
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		
        $instance['text_link1'] = ( ! empty( $new_instance['text_link1'] ) ) ? strip_tags( $new_instance['text_link1'] ) : '';
		$instance['href_link1'] = ( ! empty( $new_instance['href_link1'] ) ) ? strip_tags( $new_instance['href_link1'] ) : '';   
		
		$instance['text_link2'] = ( ! empty( $new_instance['text_link2'] ) ) ? strip_tags( $new_instance['text_link2'] ) : '';
		$instance['href_link2'] = ( ! empty( $new_instance['href_link2'] ) ) ? strip_tags( $new_instance['href_link2'] ) : '';
		
		$instance['text_link3'] = ( ! empty( $new_instance['text_link3'] ) ) ? strip_tags( $new_instance['text_link3'] ) : '';
		$instance['href_link3'] = ( ! empty( $new_instance['href_link3'] ) ) ? strip_tags( $new_instance['href_link3'] ) : '';
		
		$instance['text_link4'] = ( ! empty( $new_instance['text_link4'] ) ) ? strip_tags( $new_instance['text_link4'] ) : '';
		$instance['href_link4'] = ( ! empty( $new_instance['href_link4'] ) ) ? strip_tags( $new_instance['href_link4'] ) : '';
		
		$instance['text_link5'] = ( ! empty( $new_instance['text_link5'] ) ) ? strip_tags( $new_instance['text_link5'] ) : '';
		$instance['href_link5'] = ( ! empty( $new_instance['href_link5'] ) ) ? strip_tags( $new_instance['href_link5'] ) : '';

		return $instance;
	}
}

function register_fl_widget() {
    register_widget( 'FL_Widget' );
}
add_action( 'widgets_init', 'register_fl_widget' );
?>
