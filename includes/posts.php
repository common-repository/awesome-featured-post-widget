<?php
//Featured post functions

//It will show outputs of featured posts
function mfpw_random_posts( $args ) {
	echo mfpw_get_random_posts( $args );
}

//It will generate featured post markups
function mfpw_get_random_posts( $args, $id ) {
	
	// Assign a default, empty variable
	$html = '';

	// Here, we will merge the input arguments and the default arguments
	$args = wp_parse_args( $args, mfpw_get_default_args() );

	// It extracts the array to allow for easy use of defined variables
	extract( $args );

	// Allow devs to hook in the needed stuff before the loop starts
	do_action( 'mfpw_before_loop', $args );         // this hook is used to add content to all query
	do_action( 'mfpw_before_loop_' . $id, $args );  // this hook is used to add content to spesific query

	//Its will get the posts
	$posts = mfpw_get_posts( $args, $id );
	
	if ( $posts->have_posts() ) :	//if_1 opens

	//-----------------------------To View Post in Slider View---------------------------------
	
	if( $args['post_in_slider'] == true ) :	//if_2 opens
		
		$html .= '<div class="item product-slider" id="my-featured-post-widget">';
		
			while ( $posts->have_posts() ) : $posts->the_post();

					$html .= '<div class="product-slider-item">';
					
						$html .= '<div class="the-date">';
							
							if ( $args['date'] ) :
								$date = get_the_date();
								
								$html .= '<time datetime="' . esc_html( get_the_date( 'c' ) ) . '"><span class="big">' . get_the_date( 'j' ) . '</span><span class="small">' . get_the_date( 'M' ) . '</span><span class="small">' . get_the_date( 'Y' ) . '</span></time>';
								
							elseif ( $args['date_modified'] ) : 
							
								$date = get_the_modified_date();
													
								$html .= '<time datetime="' . esc_html( get_the_modified_date( 'c' ) ) . '"><span class="big">' . get_the_modified_date( 'j' ) . '</span><span class="small">' . get_the_modified_date( 'M' ) . '</span><span class="small">' . get_the_modified_date( 'Y' ) . '</span></time>';
								
							endif;
							
						$html .= '</div>';	//the-date div ends

						if ( $args['thumbnail'] ) :

							// Check if the selected post has post thumbnail
							if ( has_post_thumbnail() ) :

					       		// It will display custom thumbnail sizes
								$thumb_id = get_post_thumbnail_id();  //gets the featured image ID only
								$img_url  = wp_get_attachment_url( $thumb_id ); //gets the featured img URL
								$image    = mfpw_resize( $img_url, $args['thumbnail_width'], $args['thumbnail_height'], true );
								

								$html .= '<a class="product-image" href="' . esc_url( get_permalink() ) . '"  rel="bookmark" style="background: #67D7EB url('.esc_url( $image ).') no-repeat center center; background-size: 100%;">';
								$html .= '</a>';

					// If no post thumbnail found, then it will check if "Get The Image" plugin exist or not and display the image
							elseif ( function_exists( 'get_the_image' ) ) :
							
							  if ( $args['thumbnail_custom'] ) :
									$html .= get_the_image( array(
										'width'        => (int) $args['thumbnail_width'],
										'height'       => (int) $args['thumbnail_height'],
										'image_class'  => 'mfpw-thumbnail align' . esc_attr( $args['thumbnail_align'] ),
										'image_scan'   => true,
										'echo'         => false,
										'link_to_post' => true,
									) );
								else:
									$html .= get_the_image( array(
										'size'         => $args['thumbnail_size'],
										'image_class'  => 'mfpw-thumbnail align' . esc_attr( $args['thumbnail_align'] ),
										'image_scan'   => true,
										'echo'         => false,
										'link_to_post' => true,
									) );
								endif;

							// It will display nothing
							else :
								$html .= null;
							endif;

						endif;
					
					$html .= '<div class="product-meta-data">';
	                	
						$html .= '<div class="slider-post-title"><a class="owl-carousel-item-imgtitle" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_attr( get_the_title() ) . '</a></div>';
						
						//Display Post Categories
						if ( !empty( $args['show_meta'] ) && !empty( $args['post_meta'] ) && $args['post_meta'] == '[post_categories]' ) :						
							$pCat = array(
								'sep'    => ', ',
								'before' => __( '<i class="fa fa-folder"></i> ', 'mfpw' ),
								'after'  => '',
							);
		
							$cats = get_the_category_list( trim( $pCat['sep'] ) . ' ' );
							
							$html .= sprintf( '<span class="%s">', 'entry-categories' ) . $pCat['before'] . $cats . $pCat['after'] . '</span>';
						endif;
							
						//Display Post Tags
						if ( !empty( $args['show_meta'] ) && !empty( $args['post_meta'] ) && $args['post_meta'] == '[post_tags]' ) :
							$pTag = array(
								'after'  => '',
								'before' => __( '<i class="fa fa-tags"></i> ', 'mfpw' ),
								'sep'    => ', ',
							);
									
							$tags = get_the_tag_list( $pTag['before'], trim( $pTag['sep'] ) . ' ', $pTag['after'] );
							$html .= sprintf( '<span class="%s">', 'entry-tags' ) . $tags . '</span>';							
						endif;
						
						//display both categories and tags
						if ( !empty( $args['show_meta'] ) && !empty( $args['post_meta'] ) && $args['post_meta'] == '[post_categories] [post_tags]' ) :
						
							//post categories
							$pCat = array(
								'sep'    => ', ',
								'before' => __( '<i class="fa fa-folder"></i> ', 'mfpw' ),
								'after'  => '',
							);
		
							$cats = get_the_category_list( trim( $pCat['sep'] ) . ' ' );
							
							$html .= sprintf( '<span class="%s">', 'entry-categories' ) . $pCat['before'] . $cats . $pCat['after'] . '</span>';
							
							//post tags
							$pTag = array(
								'after'  => '',
								'before' => __( '<i class="fa fa-tags"></i> ', 'mfpw' ),
								'sep'    => ', ',
							);
		
							$tags = get_the_tag_list( $pTag['before'], trim( $pTag['sep'] ) . ' ', $pTag['after'] );
							$html .= sprintf( '<span class="%s">', 'entry-tags' ) . $tags . '</span>';
						endif;
						
						//display post content or excerpt
						if ( $args['excerpt'] ) :
							$html .= '<div class="owl-carousel-item-imgcontent">' . wp_trim_words(  apply_filters( 'mfpw_excerpt', get_the_excerpt() ), $args['excerpt_length'], '...' ) . sprintf( ' <div class="slider-read-more-link"><a href="%s"> %s </a></div>', get_permalink(), '' . esc_html( $args['more_text'] ) )  . '</div>';
						endif;				
						
					$html .= '</div>'; //product-meta-data div ends
					
				$html .= '</div>';	//product-slider-item div ends

			endwhile;
		
		$html .= '</div>';	//item product-slider div ends
				
		//slider stylesheet
		$html .= "<style>
			@import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,700);
			@import url('http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css');
			.owl-carousel .owl-wrapper:after {
				content: ".";
				display: block;
				clear: both;
				visibility: hidden;
				line-height: 0;
				height: 0;
			}
			/* display none until init */
			.owl-carousel{
				display: none;
				position: relative;
				width: 100%;
				-ms-touch-action: pan-y;
			}
			.owl-carousel .owl-wrapper{
				display: none;
				position: relative;
				-webkit-transform: translate3d(0px, 0px, 0px);
			}
			.owl-carousel .owl-wrapper-outer{
				overflow: hidden;
				position: relative;
				width: 99.99%;
			}
			.owl-carousel .owl-wrapper-outer.autoHeight{
				-webkit-transition: height 500ms ease-in-out;
				-moz-transition: height 500ms ease-in-out;
				-ms-transition: height 500ms ease-in-out;
				-o-transition: height 500ms ease-in-out;
				transition: height 500ms ease-in-out;
			}
				
			.owl-carousel .owl-item{
				float: left;
			}
			.owl-controls .owl-page,
			.owl-controls .owl-buttons div{
				cursor: pointer;
			}
			.owl-controls {
				-webkit-user-select: none;
				-khtml-user-select: none;
				-moz-user-select: none;
				-ms-user-select: none;
				user-select: none;
				-webkit-tap-highlight-color: rgba(0, 0, 0, 0);
			}

			/* mouse grab icon */
			.grabbing { 
			    cursor:url(grabbing.png) 8 8, move;
			}

			/* fix */
			.owl-carousel  .owl-wrapper,
			.owl-carousel  .owl-item{
				-webkit-backface-visibility: hidden;
				-moz-backface-visibility:    hidden;
				-ms-backface-visibility:     hidden;
			  -webkit-transform: translate3d(0,0,0);
			  -moz-transform: translate3d(0,0,0);
			  -ms-transform: translate3d(0,0,0);
			}

			.product-slider { box-sizing: border-box; font-family: 'roboto', 'arial', sans-serif; padding: 0 !important; }
			.product-slider * { box-sizing: inherit; font-family: inherit; }
			.product-slider .fa { font-family: 'FontAwesome'; }
			.product-slider-item { position: relative; overflow: hidden; border-radius: 5px; height: 180px; background-color: #67d7eb; }
			.product-image { display: block; text-align: center; padding: 15px; height: 180px; margin-left: 20%; }
			
			.product-meta-data { background: rgba(150, 240, 240, 0.8); color: #333; font-size: 14px; line-height: 1.4; position: absolute; top: 0; left: -100%; height: 100%; width: 100%; transition: all 0.3s linear; z-index: 6; padding: 15px 15px 15px 25%; overflow: hidden; padding-bottom: 25px; }
			.product-slider-item:hover .product-meta-data { left: 0; }
			.product-slider-item .the-date { position: absolute; top: 0; height: 100%; width: 20%; background: #67d7eb; padding: 5px; color: #333; text-align: center; line-height: 1.4; z-index: 9; border-right: 1px solid bfc516; }
			.product-slider-item .the-date .big { display: block; font-weight: bold; font-size: 20px; }
			.product-slider-item .the-date .small { display: block; }
			
			.product-meta-data .entry-categories { display: block; font-size: 12px; margin: 5px auto 10px; }
			.product-meta-data .entry-tags { display: inline-block; font-size: 12px; position: absolute; left: 25%; bottom: 8px; width: 110px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
			.product-meta-data .entry-categories a:hover { padding: 0 5px; }
			
			.owl-carousel-item-imgcontent { border-top: 1px solid #4c8990; padding-top: 10px; margin-top: 10px; }
			
			.product-meta-data .slider-post-title { font-size: 25px; font-weight: bold; margin-top: -10px; font-family: 'Roboto Slab', sans-serif; }
			.product-meta-data .slider-post-title a { display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
			.product-meta-data a { color: inherit; }

			.product-meta-data .slider-read-more-link { padding: 5px 0; position: absolute; right: 5px; bottom: 0; }
			.product-meta-data .slider-read-more-link a { color: inherit; text-transform: uppercase; display: inline-block; font-weight: 700; padding: 3px 5px; border: 1px solid #333; border-radius: 5px; font-size: 12px; transition: all 0.5s; }
			.product-meta-data .slider-read-more-link a:hover { text-decoration: none; background: #67D7EB; }

			#my-featured-post-widget .owl-buttons { width: 100%; opacity: 0; }
			#my-featured-post-widget:hover .owl-buttons { opacity: 0.5; }
			#my-featured-post-widget .owl-buttons > div { width: 30px; height: 30px; line-height: 30px; text-align: center; background: #000; color: #fff; position: absolute; top: 35%; }
			#my-featured-post-widget .owl-buttons .owl-prev { left: 1px; border-radius: 0 3px 3px 0; }
			#my-featured-post-widget .owl-buttons .owl-next { right: 1px; border-radius: 3px 0 0 3px; }

			#my-featured-post-widget .owl-pagination { text-align: center; margin-top: 10px; }
			#my-featured-post-widget .owl-pagination .owl-page { display: inline-block; width: 10px; height: 10px; background: #444; margin: 0 3px; border-radius: 50%; opacity: 0.5; }
			#my-featured-post-widget .owl-pagination .owl-page span { display: none; }
			#my-featured-post-widget .owl-pagination .owl-page.active { opacity: 1; }
			</style>";
		
		//variables defined for jquery
		//For Paging
		$pagingValue = $args['paging'] ;
		
		if($pagingValue == 1)	
		{ $pVal = 'true';}
		elseif($pagingValue == 0 || $pagingValue == '' || $pagingValue == null)	
		{ $pVal = 'false';}
		
		//For Autoplay
		$autoplayValue = $args['autoplay'] ;
		
		if($autoplayValue == 1)	
		{ 
			$aVal = 'true , ' . $args['time_interval'];
		}
		elseif($autoplayValue == 0 || $autoplayValue == '' || $autoplayValue == null)	
		{ 
			$aVal = 'false'; 
		}
		
		//For Stop on Hover
		$stopHoverValue = $args['stop_hover'] ;
		
		if($stopHoverValue == 1)	
		{ $shVal = 'true';}
		elseif($stopHoverValue == 0 || $stopHoverValue == '' || $stopHoverValue == null)	
		{ $shVal = 'false';}
		
		// For Slide Speed		
		$slideSpeedValue = $args['slide_speed'] ;
				
		//script to display slider
		$html .= '<script>
		jQuery(document).ready(function(){
			jQuery(".item.product-slider").each(function(){
				jQuery(this).owlCarousel({
			singleItem: true,
			autoPlay: (' . $aVal . '),
			stopOnHover : ' . $shVal . ',
			navigation: true,
			navigationText: ["‹","›"],
			pagination: ' . $pVal . ',
			slideSpeed: ' . $slideSpeedValue . ',
			autoHeight: true,
			rewindSpeed : 500,
		});
			});
		});
		</script>';
		
		//-----------------------------To View Post in Normal List View---------------------------------
		 
		elseif ( $args['post_in_slider'] == false ) : //elseif_2 open
		
		$html = '<div class="mfpw-random-' . sanitize_html_class( $args['post_type'] ) . ' ' . sanitize_html_class( $args['css_class'] ) . '">';

			$html .= '<ul class="mfpw-ul">';

				while ( $posts->have_posts() ) : $posts->the_post();

					$html .= '<li class="mfpw-li mfpw-clearfix">';
					
						if ( $args['thumbnail'] ) :

							// Check if the selected post has post thumbnail
							if ( has_post_thumbnail() ) :

					       		// It will display custom thumbnail sizes
								$thumb_id = get_post_thumbnail_id(); //gets the featured image ID only
								$img_url  = wp_get_attachment_url( $thumb_id ); // Gets the featured img URL
								$image    = mfpw_resize( $img_url, $args['thumbnail_width'], $args['thumbnail_height'], true );
								

								$html .= '<a href="' . esc_url( get_permalink() ) . '"  rel="bookmark">';
									if ( $args['thumbnail_custom'] ) :
										$html .= '<img class="mfpw-thumbnail align' . esc_attr( $args['thumbnail_align'] ) . '" src="' . esc_url( $image ) . '" alt="' . esc_attr( get_the_title() ) . '">';
									else :
										$html .= get_the_post_thumbnail( get_the_ID(), $args['thumbnail_size'], array( 'alt' => esc_attr( get_the_title() ), 'class' => 'mfpw-thumbnail align' . esc_attr( $args['thumbnail_align'] ) ) );
									endif;
								$html .= '</a>';

					// If no post thumbnail found, then it will check if "Get The Image" plugin exist or not and display the image
							elseif ( function_exists( 'get_the_image' ) ) :
								if ( $args['thumbnail_custom'] ) :
									$html .= get_the_image( array(
										'width'        => (int) $args['thumbnail_width'],
										'height'       => (int) $args['thumbnail_height'],
										'image_class'  => 'mfpw-thumbnail align' . esc_attr( $args['thumbnail_align'] ),
										'image_scan'   => true,
										'echo'         => false,
										'link_to_post' => true,
									) );
								else:
									$html .= get_the_image( array(
										'size'         => $args['thumbnail_size'],
										'image_class'  => 'mfpw-thumbnail align' . esc_attr( $args['thumbnail_align'] ),
										'image_scan'   => true,
										'echo'         => false,
										'link_to_post' => true,
									) );
								endif;

							// It will display nothing
							else :
								$html .= null;
							endif;

						endif;

						if ( $args['date'] ) :
							$date = get_the_date();
							if ( $args['date_relative'] ) :
								$date = sprintf( __( '%s ago', 'awesome-featured-post-widget' ), human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) );
							endif;
							$html .= '<br> <b><time class="mfpw-time published" datetime="' . esc_html( get_the_date( 'c' ) ) . '">' . esc_html( $date ) . '</time></b>';
						
						elseif ( $args['date_modified'] ) : 
						
							$date = get_the_modified_date();
							if ( $args['date_relative'] ) :
								$date = sprintf( __( '%s ago', 'awesome-featured-post-widget' ), human_time_diff( get_the_modified_date( 'U' ), current_time( 'timestamp' ) ) );
							endif;
							$html .= '<br> <b><time class="mfpw-time modfied" datetime="' . esc_html( get_the_modified_date( 'c' ) ) . '">' . esc_html( $date ) . '</time></b>';
						endif;
						
						$html .= '<br><a class="mfpw-title" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . esc_attr( get_the_title() ) . '</a>';

						//display post content or excerpt
						if ( $args['excerpt'] ) :
							$html .= '<div class="mfpw-summary">' . 'Content: ' . wp_trim_words(apply_filters( 'mfpw_excerpt', get_the_excerpt()), $args['excerpt_length'], '...' ) . sprintf(' <a href="%s"> &nbsp;&nbsp;&nbsp;&nbsp; %s </a>', get_permalink(), esc_html( $args['more_text'] )) . '</div>';
						endif;
						
						//Display Post Categories
						if ( !empty( $args['show_meta'] ) && !empty( $args['post_meta'] ) && $args['post_meta'] == '[post_categories]' ) :
						
							$pCat = array(
								'sep'    => ', ',
								'before' => __( 'Category: ', 'mfpw' ),
								'after'  => '',
							);
		
							$cats = get_the_category_list( trim( $pCat['sep'] ) . ' ' );
							
							$html .= sprintf( '<br> &nbsp;&nbsp;&nbsp; <span class="%s">', 'entry-categories' ) . $pCat['before'] . $cats . $pCat['after'] . '</span>';
						endif;
							
						//Display Post Tags
						if ( !empty( $args['show_meta'] ) && !empty( $args['post_meta'] ) && $args['post_meta'] == '[post_tags]' ) :
							$pTag = array(
								'after'  => '',
								'before' => __( 'Tags: ', 'mfpw' ),
								'sep'    => ', ',
							);
		
							$tags = get_the_tag_list( $pTag['before'], trim( $pTag['sep'] ) . ' ', $pTag['after'] );
							$html .= sprintf( '<br> &nbsp;&nbsp;&nbsp; <span class="%s">', 'entry-tags' ) . $tags . '</span>';
							
						endif;
						
						//display both categories and tags
						if ( !empty( $args['show_meta'] ) && !empty( $args['post_meta'] ) && $args['post_meta'] == '[post_categories] [post_tags]' ) :
						
							//post categories
							$pCat = array(
								'sep'    => ', ',
								'before' => __( 'Category: ', 'mfpw' ),
								'after'  => '',
							);
		
							$cats = get_the_category_list( trim( $pCat['sep'] ) . ' ' );
							
							$html .= sprintf( '<br> &nbsp;&nbsp;&nbsp; <span class="%s">', 'entry-categories' ) . $pCat['before'] . $cats . $pCat['after'] . '</span>';
							
							//post tags
							$pTag = array(
								'after'  => '',
								'before' => __( 'Tags: ', 'mfpw' ),
								'sep'    => ', ',
							);
		
							$tags = get_the_tag_list( $pTag['before'], trim( $pTag['sep'] ) . ' ', $pTag['after'] );
							$html .= sprintf( '<br> &nbsp;&nbsp;&nbsp; <span class="%s">', 'entry-tags' ) . $tags . '</span>';
						endif;						

					$html .= '</li>';

				endwhile;

			$html .= '</ul>';
			
		$html .= '</div>';	// mfpw-random div ends
		
		endif;	//if_2 close
	 		
			
	endif;	//if_1 close

	// It will allow to restore original Post Data
	wp_reset_postdata();

	// Allow devs to hook in the needed stuff after the loop starts
	do_action( 'mfpw_after_loop', $args );         // this hook is used to add content to all query
	do_action( 'mfpw_after_loop_' . $id, $args );  // this hook is used to add content to spesific query

	// It will return the related posts markup
	return wp_kses_post( $args['before'] ) . $html . wp_kses_post( $args['after'] );
	
}

//function to get post query
function mfpw_get_posts( $args, $id ) {

	// post query arguments
	$query = array(
		'offset'              => $args['offset'],
		'posts_per_page'      => $args['limit'],
		'orderby'             => $args['orderby'],
		'order'               => $args['order'],
		'post_type'           => $args['post_type'],
		'post_status'         => $args['post_status'],
		'ignore_sticky_posts' => $args['ignore_sticky'],
		//'page_id'             => $args['page_id'],
		//'post__in'            => $args['postMonths']
		'date_query'         => array(
									array(
										'column' => 'post_date',
										'after'  => $args['postMonths'] .' months ago', 
										/* after => '>' & before => '<'*/
										'compare' => '',
									)
							)
	);

	// display post based on categorys
	if ( ! empty( $args['cat'] ) ) {
		$query['category__in'] = $args['cat'];
	}

	//display post based on post tags
	if ( ! empty( $args['tag'] ) ) {
		$query['tag__in'] = $args['tag'];
	}
	
	//It will allow plugin developer to filter the default query data
	$query = apply_filters( 'mfpw_query' . $id, $query ); 	
	
	// Performs or execute the query
	//$posts = new WP_Query( $query . '&monthnum=' . date( 'n', current_time( 'timestamp' ) ) );
	$posts = new WP_Query( $query );

	//return $posts;
	return $posts;
}

?>