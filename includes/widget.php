<?php
//Custom featured posts widget.
class Awesome_Featured_Post_Widget extends WP_Widget {

	//constructor 
	function __construct() {
		
		// It allow to set up the widget options
		$widget_options = array(
			'classname'   => 'awesome-featured-post-widget',
			'description' => __( 'A simple plugin that is use to add featured post in widget', 'awesome-featured-post-widget' )
		);

		$control_ops = array(
			'width'  => 450			
		);

		// It allow to create the widget
		parent::__construct(
			'mfpw-widget',                                        
			__( 'Awesome Featured Post Widget', 'awesome-featured-post-widget' ), 
			$widget_options,                                     
			$control_ops                                        
		);

		// action hook to add inline default stylesheet 
		if ( is_active_widget( false, false, $this->id_base ) ) {
			add_action( 'wp_enqueue_scripts', array( $this, 'mfpw_default_style' ) );
		}
	}

	//function add default stylesheet
	public function mfpw_default_style() {
		wp_enqueue_style( 'mfpw-style' );
	}
	
	
	/** Display output of the widget based on the arguments input through the widget controls **/
	
	//this function will display widget
	function widget( $args, $instance ) {
		
		//It is used to display the post on selected pages only 
		$show_widget = $this->check_output($instance);
				
		if ($show_widget) :
		
		extract( $args );


		// Get the random posts.
		$random = mfpw_get_random_posts( $instance, $this->id );
		
		// Check if the random posts exist
		if ( $random ) :

			// It will display output of the theme's $before_widget wrapper.
			echo $before_widget;

			if ( ! empty( $instance['title'] ) ) { 
				echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
			}

			// It will display the posts on selected page
			echo $random;
						
			// It will close the theme's widget wrapper
			echo $after_widget;

			endif;

		endif;
	}

	/** Update the widget control options for the particular instance of the widget **/
	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']             = strip_tags( $new_instance['title'] );
		$instance['title_url']         = esc_url_raw( $new_instance['title_url'] );

		$instance['offset']            = (int) $new_instance['offset'];
		$instance['limit']             = (int) $new_instance['limit'];
		$instance['ignore_sticky']     = isset( $new_instance['ignore_sticky'] ) ? (bool) $new_instance['ignore_sticky'] : 0;
		$instance['post_type']         = esc_attr( $new_instance['post_type'] );
		$instance['postMonths']        = esc_attr( $new_instance['postMonths'] );
		$instance['post_status']       = esc_attr( $new_instance['post_status'] );
		$instance['taxonomy']          = esc_attr( $new_instance['taxonomy'] );
		$instance['cat']               = $new_instance['cat'];
		$instance['tag']               = $new_instance['tag'];
		$instance['show_pages']        = $new_instance['show_pages'];
		$instance['page_id']           = $new_instance['page_id'];
		$instance['thumbnail']         = isset( $new_instance['thumbnail'] ) ? (bool) $new_instance['thumbnail'] : false;
		$instance['term_slug']         = esc_attr( $new_instance['term_slug'] ); 
		$instance['custom_taxonomy']   = esc_attr( $new_instance['custom_taxonomy'] );
		$instance['more_text']         = $new_instance['more_text'];
		$instance['show_meta']         = isset( $new_instance['show_meta'] ) ? (bool) $new_instance['show_meta'] : false;	
		$instance['post_meta']         = $new_instance['post_meta'];
		$instance['orderby']           = esc_attr( $new_instance['orderby'] );
		$instance['order']             = esc_attr( $new_instance['order'] );
		$instance['allow_custom_post'] = isset( $new_instance['allow_custom_post'] ) ? (bool) $new_instance['allow_custom_post'] : false;
		$instance['thumbnail_size']    = esc_attr( $new_instance['thumbnail_size'] );
		$instance['thumbnail_align']   = esc_attr( $new_instance['thumbnail_align'] );
		$instance['thumbnail_custom']  = isset( $new_instance['thumbnail_custom'] ) ? (bool) $new_instance['thumbnail_custom'] : false;
		$instance['thumbnail_width']   = (int) $new_instance['thumbnail_width'];
		$instance['thumbnail_height']  = (int) $new_instance['thumbnail_height'];

		$instance['excerpt']           = isset( $new_instance['excerpt'] ) ? (bool) $new_instance['excerpt'] : false;
		$instance['excerpt_length']    = (int) $new_instance['excerpt_length'];
		$instance['date']              = isset( $new_instance['date'] ) ? (bool) $new_instance['date'] : false;
		$instance['date_modified']     = isset( $new_instance['date_modified'] ) ? (bool) $new_instance['date_modified'] : false;
		$instance['date_relative']     = isset( $new_instance['date_relative'] ) ? (bool) $new_instance['date_relative'] : false;

		$instance['css']               = $new_instance['css'];
		$instance['css_class']         = sanitize_html_class( $new_instance['css_class'] );
		$instance['before']            = wp_kses_post( $new_instance['before'] );
		$instance['after']             = wp_kses_post( $new_instance['after'] );

		//for where to show tab
		$instance['homepage'] 			= isset( $new_instance['homepage'] ) ? (bool) $new_instance['homepage'] : false;		
		$instance['frontpage'] 			= isset( $new_instance['frontpage'] ) ? (bool) $new_instance['frontpage'] : false;		
		$instance['page'] 				= isset( $new_instance['page'] ) ? (bool) $new_instance['page']:false;				
		$instance['category'] 			= isset( $new_instance['category'] ) ? (bool) $new_instance['category'] : false;		
		$instance['single'] 			= isset( $new_instance['single'] ) ? (bool) $new_instance['single'] : false;		
		$instance['archivedate'] 		= isset( $new_instance['archivedate'] ) ? (bool) $new_instance['archivedate'] : false;		
		$instance['archive'] 			= isset( $new_instance['archive'] ) ? (bool) $new_instance['archive'] : false;		
		$instance['tag1'] 				= isset( $new_instance['tag1'] ) ? (bool) $new_instance['tag1'] : false;		
		$instance['attachment'] 		= isset( $new_instance['attachment'] ) ? (bool) $new_instance['attachment'] : false;		
		$instance['taxonomy1'] 			= isset( $new_instance['taxonomy1'] ) ? (bool) $new_instance['taxonomy1'] : false;		
		$instance['author']             = isset( $new_instance['author'] ) ? (bool) $new_instance['author'] : false;		
		$instance['search'] 			= isset( $new_instance['search'] ) ? (bool) $new_instance['search'] : false;		
		$instance['not_found'] 			= isset( $new_instance['not_found'] ) ? (bool) $new_instance['not_found'] : false;		
		$instance['login_page'] 		= isset( $new_instance['login_page'] ) ? (bool) $new_instance['login_page'] : false;
		$instance['checkall'] 		    = isset( $new_instance['checkall'] ) ? (bool) $new_instance['checkall'] : false;
		
		//for slider tab
		$instance['post_in_slider']     = isset( $new_instance['post_in_slider'] ) ? (bool) $new_instance['post_in_slider'] : false;
		$instance['autoplay'] 		    = isset( $new_instance['autoplay'] ) ? (bool) $new_instance['autoplay'] : false;
		$instance['paging'] 		    = isset( $new_instance['paging'] ) ? (bool) $new_instance['paging'] : false;
		$instance['stop_hover'] 		= isset( $new_instance['stop_hover'] ) ? (bool) $new_instance['stop_hover'] : false;
		$instance['time_interval'] 		= (int) $new_instance['time_interval'];
		$instance['slide_speed'] 		= (int) $new_instance['slide_speed'];		
		
		return $instance;	
	}

	/** Display the widget control options in the Widgets admin screen **/

	//It will create widget form
	function form( $instance ) {

		// It will merge the user-selected arguments with the defaults arguments
		$instance = wp_parse_args( (array) $instance, mfpw_get_default_args() );
		
		// It extracts the array to allow easy use of variables
		extract( $instance );

		// It loads the widget form
		include( MFPW_INC . 'form.php' );
	}
	
	function check_output($instance) 
	{	
		// get the type of page, we're actually on	
		if (is_front_page()) $pagetype[]='frontpage';
		if (is_home()) $pagetype[]='homepage';
		if (is_page()) $pagetype[]='page';
		if (is_category()) $pagetype[]='category';
		if (is_single()) $pagetype[]='single';
		if (is_date()) $pagetype[]='archivedate';
		if (is_archive()) $pagetype[]='archive';
		if (is_tag()) $pagetype[]='tag1';
		if (is_attachment()) $pagetype[]='attachment';
		if (is_tax()) $pagetype[]='taxonomy1';
		if (is_author()) $pagetype[]='author';
		if (is_search()) $pagetype[]='search';
		if (is_404()) $pagetype[]='not_found';
		if (!isset($pagetype)) $pagetype[]='login_page';
		
		// display only, if said so in the settings of the widget		
		foreach ($pagetype as $page) if ($instance[$page]) $show_widget = true;
		
		return $show_widget;	
		
	}
}
?>