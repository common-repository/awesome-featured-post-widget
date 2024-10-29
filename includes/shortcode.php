<?php
//Display featured posts with shortcode
function mfpw_shortcode( $atts ) {

	//get shortcode sttributes
	$args = shortcode_atts( mfpw_get_default_args(), $atts );

	//It will load default stylesheet
	wp_enqueue_style( 'mfpw-style' );

	//It will display the shortcode content
	return mfpw_get_random_posts( $args, get_the_ID() );

}

//hook to add shortcode 
add_shortcode( 'mfpw', 'mfpw_shortcode' );

?>