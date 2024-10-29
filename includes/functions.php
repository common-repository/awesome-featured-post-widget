<?php 
    $nounce2 = wp_create_nonce( 'reject_posts' );
	global $final_array;
	global $final_posts;

	//Here are the various functions used by the plugin
	
//action hook for custom css
add_action( 'mfpw_before_loop', 'mfpw_custom_css', 1 );

//sets default arguments for used by the plugin
function mfpw_get_default_args() {

	$defaults = array(
		'title'             => esc_attr__( 'Awesome Featured Post Widget', 'awesome-featured-post-widget' ),
		'title_url'         => '',
		'offset'            => 0,
		'limit'             => 3,
		'post_type'         => 'post',
		
		'post_status'       => 'publish',
		'ignore_sticky'     => 0,
		'taxonomy'          => '',
		'term_slug'         => '',
		'cat'               => array(),		
		'tag'               => array(),		
		'thumbnail'         => false,
		'thumbnail_size'    => 'mfpw-thumbnail',
		'thumbnail_align'   => 'right',
		'thumbnail_custom'  => false,
		
		'thumbnail_width'   => 200,
		'thumbnail_height'  => 200,
		'image_placement'   => 'before-title',
		'excerpt'           => false,
		'excerpt_length'    => 3,		
		'date'              => false,
		'date_modified'     => false,
		'date_relative'     => false,		
		'show_meta'         => '',
		'post_meta'         => '[post_categories] [post_tags]',
		
		'page_id'           => array(),
		'show_pages'        => array(),
		'orderby'           => 'rand',
      	'order'             => 'DESC',
		'more_text'         => esc_attr__( 'Read More', 'awesome-featured-post-widget' ),
		'custom_taxonomy'   => '',		
		
		'custom_post_type'  => 'post',
		'allow_custom_post'	=> false,
		'css'               => '',
		'before'            => '',
		'after'             => '',
		'postMonths'        => '1',
		
		'homepage'          => 1,
		'frontpage'         => 1,
		'page'              => false,
		'category'          => false,
		'single'            => false,
		'archivedate'       => false,
		'archive'           => false,
		'tag1'              => false,
		'attachment'        => false,
		'taxonomy1'         => false,
		'author'            => false,
		'search'            => false,
		'not_found'         => false,
		'login_page'        => false,
		'checkall'          => false,
				
		//for slider
		'post_in_slider'    => false,
		'autoplay'          => false,
		'paging'            => false,
		'stop_hover'        => false,
		'time_interval'     => 2000,
		'slide_speed'       => 500
	);

	// It will allow plugin developer to filter the default arguments.
	return apply_filters( 'mfpw_default_args', $defaults );

}

//code for custom css
function mfpw_custom_css( $args ) {

	// It helps to sanitize custom CSS
	$css = $args['css'];
	$css = wp_kses( $css, array( '\'', '\"', '>', '+' ) );
	$css = str_replace( '&gt;', '>', $css );

	if ( ! empty( $css ) ) {
		echo '<style>' . $css . '</style>';
	}
}

// It will check wheather current Taxonomy have terms or not
function get_mfpw_terms_list( $tax = '' ){
  if( ($tax == '') || ( $tax == 'none' ) ) return false;
  
  $terms = get_terms( $tax, 'orderby=name&hide_empty=1' );
  
  return $terms;
}

//It gets taxonomy list
function get_mfpw_taxonomy_list( $post_type = '' ){
  if( ($post_type == '') || ( $post_type == 'none' ) ) return false;
  
  $taxonomy_names = get_object_taxonomies( $post_type, 'objects' );
  
  return $taxonomy_names;
}

//It will exclude taxonomies and related terms from list of available terms/taxonomies form
function mfpw_exclude_taxonomies( $taxonomy ) {
    $filters = array( '', 'nav_menu', 'post_format' );
    $filters = apply_filters( 'mfpw_exclude_taxonomies', $filters );
    return(!in_array( $taxonomy->name, $filters ));
}


// It will generate Taxonomies List
function mfpw_taxonomy_list( $post_type = '' ){
  if( isset($_POST['post_type']) )
    $post_type = $_POST['post_type'];
    
  if($post_type == '') return false;
  
  $taxonomy_names = get_object_taxonomies( $post_type, 'objects' );
  $taxonomy_names = array_filter( $taxonomy_names, 'mfpw_exclude_taxonomies' );
  
  if( $taxonomy_names ){
    
    foreach( $taxonomy_names as $mfpw_taxonomy)        
      echo '<option style="padding-right:10px;" value="'.$mfpw_taxonomy->name.'" '. selected( $option_val, $instance['taxonomy'], false ) .'>'. $mfpw_taxonomy->labels->singular_name .'</option>' . "\n";
        
  } 
}

//It will display list of terms
function mfpw_term_list( $term = '' ) {

	// Arguments
	$args = array(
		'number' => 99
	);

	// It will allow plugin to filter the arguments
	$args = apply_filters( 'mfpw_term_list_args', $args );

	//gets the terms
	$terms = get_terms( $term, $args );

	return $terms;
}

//action hooks to display selected category posts
add_action( 'wp_ajax_show_posts', 'show_posts' );
add_action( 'wp_ajax_nopriv_show_posts', 'show_posts' );

//function to show selected category posts
function show_posts() 
{
	$check_cat = $_POST['cat'];
	$cat = explode(",",$check_cat);
		
	if($_POST['cat'] == ',')
	{	
		echo "<h3><b> Please select Post Categories </b></h3>";
	}
	else
	{
		$query = new WP_Query( array( 'cat' => $cat ) );
		$total_posts=$query->posts;

		echo "<table id='tableId'>";
		echo "<tbody>";
		
			foreach( $total_posts as $post ):
				//get index value of post id
				$key = array_search($post, $total_posts);
							
				//get post id
				$i++;
				$GLOBALS['final_array'][$i]=$post->ID;
						
				echo "<tr>";
					echo "<td width='100%'> 
						<b>".$post->post_title."</b> 
					</td>";	
				echo "</tr>";
			endforeach;
			
			//for string
			$post_string = implode(',',$GLOBALS['final_array']);
			echo "<input type='hidden' id='post_string' value='".$post_string."'>";	 	
							
		echo "</tbody>";
		echo "</table>";
	}
	die();		 
}

/* Function which remove Plugin Update Notices – awesome-featured-post-widget
function filter_plugin_updates( $value ) {
    unset( $value->response['awesome-featured-post-widget/awesome-featured-post-widget.php'] );
    return $value;
}
add_filter( 'site_transient_update_plugins', 'filter_plugin_updates' );*/


?>

