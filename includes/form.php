<?php
//Forms to be displayed in Widget
// It will exit, if we accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
$nounce1 = wp_create_nonce( 'show_posts' );
?>

<script>
	jQuery( function( $ ) {

		// Cache selector in a variable
		var $form = $( ".mfpw-form-tabs" );

		$form.tabs({
			active   : $.cookie( "activetab" ),
			activate : function( event, ui ) {
				$.cookie( "activetab", ui.newTab.index(), {
					expires : 10
				});
			}
		}).addClass( "ui-tabs-vertical" );

		// Add custom class
		$form.closest( ".widget-inside" ).addClass( "mfpw-bg" );

	});

	//for tab-3
  function fetchData(instance_val, select_id){     
    (function(mfpw) {
    
      wpWidgets.save( mfpw('#' + select_id).closest('div.widget'), 0, 1, 0 );
      return false;   
      
    })(jQuery);
  } 
  
 //for show post button in tab-4
 jQuery( document ).ready( function( $ ) {
	
	//for show post
	jQuery('#save').click(function() { //start function when Show posts button is clicked
			var chkArray  = [];
		
			/* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
			$('.category:checked').each(function() {
				chkArray.push($(this).val());
			});
			var selected;
			selected = chkArray.join(',') + ",";
			jQuery.ajax({
				type: "post",url: "<?php echo admin_url('admin-ajax.php'); ?>",data: { action: 'show_posts', cat: selected , _ajax_nonce: '<?php echo $nonce1; ?>' },
				dataType: 'html',
				success: function(response){ //so, if data is retrieved, store it in html
					jQuery("#showcat").html(response); 
				}
			}); //close jQuery.ajax
		return false;
	});    
	  
	//for checkall functionality for pages
	$(".checkall").change(function () {
   		$(".showPost").prop('checked', $(this).prop("checked"));
	});
	
	//for checkall functionality in custom category
	$("#custom_checkall").change(function () {
		$(".category").prop ('checked', $(this).prop('checked'));
	});
	
	//for checkall functionality in custom tag
	$("#custom_tag_checkall").change (function () {
		$(".category").prop ('checked', $(this).prop('checked'));
	});
	
	//for checkall functionality for pages
	$("#page_checkall").change(function () {
   		$(".show_pages").prop('checked', $(this).prop("checked"));
	});
		
		//for tab-4 -> apply_custom_post		
		var update_pizza = function () {
			if ($(".allow_custom_post_checkbox").is(":checked")) {
				//tab-3 - taxonomy
				$(".taxonomy_select").prop("disabled", "disabled");
				$(".taxonomy_category_select").prop("disabled", "disabled");
				$(".taxonomy_tag_select").prop("disabled", "disabled");
								
				//tab-4 - custom-taxonomy
				$(".custom_taxonomy_select").prop("disabled", false);
				$(".category").prop("disabled", false);
				$("#custom_checkall").prop("disabled", false);
				$("#custom_tag_checkall").prop("disabled", false);
				$("#save").prop("disabled", false);
			}
			else {
				//tab-3 - taxonomy
				$(".taxonomy_select").prop("disabled", false);
				$(".taxonomy_category_select").prop("disabled", false);
				$(".taxonomy_tag_select").prop("disabled", false);
				
				//tab-4 - custom-taxonomy
				$(".custom_taxonomy_select").prop("disabled", "disabled");
				$(".category").prop("disabled", "disabled");
				$("#custom_checkall").prop("disabled", "disabled");
				$("#custom_tag_checkall").prop("disabled", "disabled");
				$("#save").prop("disabled", "disabled");
			}
		};
		
		$(update_pizza);//instance is created so that after reload of page the effect of jquery remains same
		$(".allow_custom_post_checkbox").change(update_pizza);
		
		//for tab-7 post_in_slider	
		var update_relative_date = function () {
			if ($(".show_slider_checkbox").is(":checked")) {
				//tab-6
				$(".date_relative_checkbox").prop("disabled", "disabled");
				//tab-7
				$(".given_thumbnail_size_select").prop("disabled", "disabled");
				$(".customize_thumbnail_width").prop("disabled", false);
				//$(".customize_thumbnail_width").val(200);
				$(".customize_thumbnail_height").prop("disabled", false);
				//$(".customize_thumbnail_height").val(200);
				$(".custom_thumbnail_checkbox").prop("disabled", false);
				$('.custom_thumbnail_checkbox').prop('checked', true);
			}
			else {
				//tab-6
				$(".date_relative_checkbox").prop("disabled", false);
				//tab-7
				$(".given_thumbnail_size_select").prop("disabled", false);	
				$(".customize_thumbnail_width").prop("disabled", "disabled");
				$(".customize_thumbnail_height").prop("disabled", "disabled");
				$(".custom_thumbnail_checkbox").prop("disabled", "disabled");
				$('.custom_thumbnail_checkbox').prop('checked', false);				
			}
		};	
		
		$(update_relative_date);//instance is created so that after reload of page the effect of jquery remains same
		$(".show_slider_checkbox").change(update_relative_date);	
		
});
  
</script>

<div class="mfpw-form-tabs">

	<ul class="mfpw-tabs">
		<li><a href="#tab-1"><?php _ex( 'General Details', 'widget tab name', 'awesome-featured-post-widget' ); ?></a></li>
		<li><a href="#tab-2"><?php _ex( 'Select No of Posts', 'widget tab name', 'awesome-featured-post-widget' ); ?></a></li>
		<li><a href="#tab-3"><?php _ex( 'Select Category', 'widget tab name', 'awesome-featured-post-widget' ); ?></a></li>
     <?php if ($instance['post_type'] != 'page' ): //used only when post_type is post ?>
		<li><a href="#tab-4"><?php _ex( 'Custom Post Selection', 'widget tab name', 'awesome-featured-post-widget' ); ?></a></li>
     <?php endif; ?>
        <li><a href="#tab-5"><?php _ex( 'Slider Options', 'widget tab name', 'awesome-featured-post-widget' ); ?></a></li>
		<li><a href="#tab-6"><?php _ex( 'Display Content Options', 'widget tab name', 'awesome-featured-post-widget' ); ?></a></li>
        <li><a href="#tab-7"><?php _ex( 'Display Thumbnails', 'widget tab name', 'awesome-featured-post-widget' ); ?></a></li>
        <li><a href="#tab-8"><?php _ex( 'Where to Show', 'widget tab name', 'awesome-featured-post-widget' ); ?></a></li>       
		<li><a href="#tab-9"><?php _ex( 'Custom CSS', 'widget tab name', 'awesome-featured-post-widget' ); ?></a></li>         
	</ul>

	<div class="mfpw-tabs-content">

		<div id="tab-1" class="mfpw-tab-content">

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>">
					<?php _e( 'Title', 'awesome-featured-post-widget' ); ?>
				</label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />            </p>

			<p>           
				<label for="<?php echo $this->get_field_id( 'before' ); ?>">
					<?php _e( 'HTML or text before the featured posts', 'awesome-featured-post-widget' );?>
				</label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'before' ); ?>" name="<?php echo $this->get_field_name( 'before' ); ?>" rows="3"><?php echo htmlspecialchars( stripslashes( $instance['before'] ) ); ?></textarea>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'after' ); ?>">
					<?php _e( 'HTML or text after the featured posts', 'awesome-featured-post-widget' );?>
				</label>
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'after' ); ?>" name="<?php echo $this->get_field_name( 'after' ); ?>" rows="3"><?php echo htmlspecialchars( stripslashes( $instance['after'] ) ); ?></textarea>
			</p>

		</div><!-- #tab-1 -->

		<div id="tab-2" class="mfpw-tab-content">

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['ignore_sticky'], 1 ); ?> id="<?php echo $this->get_field_id( 'ignore_sticky' ); ?>" name="<?php echo $this->get_field_name( 'ignore_sticky' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'ignore_sticky' ); ?>">
					<?php _e( 'Ignore sticky posts', 'awesome-featured-post-widget' ); ?>
				</label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'limit' ); ?>">
					<?php _e( 'Number of posts to show', 'awesome-featured-post-widget' ); ?>
				</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'limit' ); ?>" name="<?php echo $this->get_field_name( 'limit' ); ?>" type="number" step="1" min="-1" value="<?php echo (int) $instance['limit']; ?>" />
				<small>-1 <?php _e( 'to show all posts.', 'awesome-featured-post-widget' ); ?></small>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'offset' ); ?>">
					<?php _e( 'Offset', 'awesome-featured-post-widget' ); ?>
				</label>
				<input type="number" step="1" min="0" class="widefat" id="<?php echo $this->get_field_id( 'offset' ); ?>" name="<?php echo $this->get_field_name( 'offset' ); ?>" value="<?php echo (int) $instance['offset']; ?>" />
				<small><?php _e( 'The number of posts to skip', 'awesome-featured-post-widget' ); ?></small>
			</p>
           
			<p>
				<label for="<?php echo $this->get_field_id( 'orderby' ); ?>">
                	<?php _e( 'Order By', 'awesome-featured-post-widget' ); ?>
                </label>
                <select class="widefat" id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
						<option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php _e( 'Date', 'awesome-featured-post-widget' ); ?></option>
						<option value="title" <?php selected( 'title', $instance['orderby'] ); ?>><?php _e( 'Title', 'awesome-featured-post-widget' ); ?></option>
						<option value="parent" <?php selected( 'parent', $instance['orderby'] ); ?>><?php _e( 'Parent', 'awesome-featured-post-widget' ); ?></option>
						<option value="ID" <?php selected( 'ID', $instance['orderby'] ); ?>><?php _e( 'ID', 'awesome-featured-post-widget' ); ?></option>
						<option value="comment_count" <?php selected( 'comment_count', $instance['orderby'] ); ?>><?php _e( 'Comment Count', 'awesome-featured-post-widget' ); ?></option>
						<option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php _e( 'Random', 'awesome-featured-post-widget' ); ?></option>
                </select>
			</p>
			
            <p>
                <label for="<?php echo $this->get_field_id( 'order' ); ?>">	
					<?php _e( 'Order', 'awesome-featured-post-widget' ); ?>
                </label>
                <select class="widefat" id="<?php echo $this->get_field_id( 'order' ); ?>" name="<?php echo $this->get_field_name( 'order' ); ?>">
					<option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php _e( 'Descending (3, 2, 1)', 'awesome-featured-post-widget' ); ?></option>
					<option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php _e( 'Ascending (1, 2, 3)', 'awesome-featured-post-widget' ); ?></option>
				</select>
			</p>
            
            <p>
                <label for="<?php echo $this->get_field_id( 'postMonths' ); ?>">	
					<?php _e( 'Select No of Months', 'awesome-featured-post-widget' ); ?>
                </label>
                <select class="widefat" id="<?php echo $this->get_field_id( 'postMonths' ); ?>" name="<?php echo $this->get_field_name( 'postMonths' ); ?>">
					<option value="1" <?php selected( '1', $instance['postMonths'] ); ?>><?php _e( '1', 'awesome-featured-post-widget' ); ?></option>
					<option value="2" <?php selected( '2', $instance['postMonths'] ); ?>><?php _e( '2', 'awesome-featured-post-widget' ); ?></option>
                    <option value="3" <?php selected( '3', $instance['postMonths'] ); ?>><?php _e( '3', 'awesome-featured-post-widget' ); ?></option>
                    <option value="4" <?php selected( '4', $instance['postMonths'] ); ?>><?php _e( '4', 'awesome-featured-post-widget' ); ?></option>
                    <option value="5" <?php selected( '5', $instance['postMonths'] ); ?>><?php _e( '5', 'awesome-featured-post-widget' ); ?></option>
				</select>
			</p>

		</div><!-- #tab-2 -->

		<div id="tab-3" class="mfpw-tab-content">

			<p>
				<label for="<?php echo $this->get_field_id( 'post_type' ); ?>">
					<?php _e( 'Post type', 'awesome-featured-post-widget' ); ?>
				</label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'post_type' ); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" onChange="fetchData(this.value,'<?php echo $this->get_field_id( 'post_type' ); ?> ');">
					<?php foreach ( get_post_types( array( 'public' => true ), 'objects' ) as $post_type ) { 
					 if( $post_type->name == 'post' || $post_type->name == 'page') : ?>
						
                        <option value="<?php echo esc_attr( $post_type->name ); ?>" <?php selected( $instance['post_type'], $post_type->name ); ?>>
							<?php echo esc_html( $post_type->labels->singular_name ); ?>
                        </option>
                       
					<?php endif; } ?>
				</select>
                <span id="pt-spinner" class="spinner"></span>
			</p>
           
            <?php
			if( $instance['post_type'] == 'post' ):  //for post
            // It will create taxonomies drop down list
            $mfpw_taxonomies =  get_mfpw_taxonomy_list( $instance['post_type'] );
			if( $mfpw_taxonomies ):  
			?>
              <p>
                <label for="<?php echo $this->get_field_id( 'taxonomy' );?>">
                    <?php echo _e('Select Post Category Type', 'awesome-featured-post-widget' );?>
                </label>                
                
                <select class="taxonomy_select" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" onChange="fetchData(this.value,'<?php echo $this->get_field_id( 'taxonomy' ); ?> ');">

					<option style="padding-right:10px;" value="<?php echo $mfpw_taxonomy->name; ?>" <?php selected( $instance['taxonomy'], false ); ?> >
                        <?php _e( 'All Taxonomies', 'awesome-featured-post-widget' ); ?>               
					</option>
                    
                    <?php
                    $mfpw_taxonomies = array_filter( $mfpw_taxonomies, 'mfpw_exclude_taxonomies' );
                    foreach( $mfpw_taxonomies as $mfpw_taxonomy) { 	
                    ?>                           
                    <option style="padding-right:10px;" value="<?php echo $mfpw_taxonomy->name; ?>" <?php selected( $mfpw_taxonomy->name, $instance['taxonomy'] ); ?> >
                        <?php echo esc_html( $mfpw_taxonomy->label ); ?>
                    </option>
                    <?php } ?>
				</select><span id="tax-spinner" class="spinner"></span>                
             </p>
           
		    <?php 
			endif; 
            
			// for getting taxonomy terms
			$terms =  get_mfpw_terms_list( $instance['taxonomy'] );	
			//chech whether the selected taxonomy is category or not
			if ($instance['taxonomy'] == 'category' ): 		
            
			//It will create Terms Drop Down List
            if( $terms ):	
			
			?>           
                <p>
                    <label for="<?php echo $this->get_field_id( 'cat' ); ?>">
                        <?php echo _e( 'Type of Category', 'awesome-featured-post-widget' ); ?>                    
                    </label> 
                    
                    <select class="taxonomy_category_select" id="<?php echo $this->get_field_id( 'cat' ); ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>" onChange="fetchData(this.value,'<?php echo $this->get_field_id( 'cat' ); ?> ');">
    
                        <option style="padding-right:10px;" value="" <?php selected( $instance['cat'], false ); ?>>
                            <?php _e( 'Select Type', 'awesome-featured-post-widget' ); ?>
                        </option>
                        <?php	foreach( $terms as $term) {	?>
                        <option style="padding-right:10px;" value="<?php echo $term->term_id;?>" <?php selected( $term->term_id, $instance['cat'] ); ?> >
                            <?php echo esc_html( $term->name ); ?>
                        </option>
                        <?php } ?>
                    </select>
                </p>           
            
            <?php 
			endif; 
			
			//check whether the selected taxonomy is post tag or not	
			elseif ($instance['taxonomy'] == 'post_tag' ):	
			
			//It will create terms drop down list       
            if( $terms ):
			
			?>
           
                <p>
                    <label for="<?php echo $this->get_field_id( 'tag' ); ?>">
                        <?php echo _e( 'Select Tag', 'awesome-featured-post-widget' ); ?>                    
                    </label> 
                    
                    <select class="taxonomy_tag_select" id="<?php echo $this->get_field_id( 'tag' ); ?>" name="<?php echo $this->get_field_name( 'tag' ); ?>" onChange="fetchData(this.value,'<?php echo $this->get_field_id( 'tag' ); ?> ');">
    
                        <option style="padding-right:10px;" value="" <?php selected( $instance['tag'], false ); ?>>
                            <?php _e( 'Select Type', 'awesome-featured-post-widget' ); ?>
                        </option>
                        <?php	foreach( $terms as $term) {	?>
                        <option style="padding-right:10px;" value="<?php echo $term->term_id; ?>" <?php selected( $term->term_id, $instance['tag'] ); ?> >
                            <?php echo esc_html( $term->name ); ?>
                        </option>
                        <?php } ?>
                    </select>
                </p>           
            
            <?php 
				endif;	
			endif; 	
			
			endif; 	//for post		
			
			// It will create Pages Drop Down List
            if( $instance['post_type'] == 'page' ):	 //for page
            ?>
            <div class="mfpw-multiple-check-form">
            <p>
                <label>
                    <?php _e( 'Select Pages', 'awesome-featured-post-widget' ); ?>
                </label>
                <ul>
				<?php 
					$total_pages=get_pages($instance['page_id']);					
					foreach($total_pages as $page):					
				?>
					<li>
                      <input type="checkbox" value="<?php echo $page->ID; ?>" id="<?php echo $this->get_field_id( 'show_pages' ) . '-' . (int) $page->ID; ?>" name="<?php echo $this->get_field_name( 'show_pages' ); ?>[]" <?php  checked( is_array( $instance['show_pages'] ) && in_array( $page->ID, $instance['show_pages'] ) ); ?> class="<?php echo "show_pages" ?>"  />
                                    
                      <label for="<?php echo $this->get_field_id( 'show_pages' ) . '-' . (int) $page->ID; ?>">
							<?php echo $page->post_title; ?>
					  </label>
					</li>
					<?php endforeach; ?>
				</ul>               
             <p>
              <ul>  
              	<li>
                	<input class="checkbox_enable" id="page_checkall" type="checkbox" name="page_checkall"/>
                    <label> <?php _e( 'Check all', 'awesome-featured-post-widget' ); ?> </label>
                	<br />
                </li>                   
 			 </ul>
             </p>
            </div>
            <?php
            
            endif; 	 //for page
			
			 //It will create show meta code
             if ($instance['post_type'] != 'page' ): ?>
             	<p>
                   <input value="1" class="checkbox" type="checkbox" <?php checked( $instance['show_meta'] ); ?> id="<?php echo $this->get_field_id('show_meta'); ?>" name="<?php echo $this->get_field_name('show_meta'); ?>">            
                   <label for="<?php echo $this->get_field_id( 'show_meta' ); ?>">
                       <?php _e( 'Show Post Meta', 'awesome-featured-post-widget' ); ?>
                   </label>
                </p>
                
                <p>
                   <small><?php _e( 'Ex:[post_categories] [post_tags]', 'awesome-featured-post-widget' ); ?></small>     				
                   <input id="<?php echo $this->get_field_id( 'post_meta' ); ?>" type="text" class="widefat" value="<?php echo esc_attr( $instance['post_meta'] ); ?>" name="<?php echo $this->get_field_name( 'post_meta' );?>">
                </p>
            <?php endif; ?>
            
			<p>
				<label for="<?php echo $this->get_field_id( 'post_status' ); ?>">
					<?php _e( 'Post status', 'awesome-featured-post-widget' ); ?>
				</label>
				<select class="widefat" id="<?php echo $this->get_field_id( 'post_status' ); ?>" name="<?php echo $this->get_field_name( 'post_status' ); ?>" >
					<?php foreach ( get_available_post_statuses() as $status_value => $status_label ) { ?>
						<option value="<?php echo esc_attr( $status_label ); ?>" <?php selected( $instance['post_status'], $status_label ); ?>><?php echo esc_html( ucfirst( $status_label ) ); ?></option>
					<?php } ?>
				</select>
			</p>
            
		</div><!-- #tab-3 -->
        
        <?php if ($instance['post_type'] != 'page' ): //used only when post_type is post ?>
  		<div id="tab-4" class="mfpw-tab-content"> <!-- for custom post -->
       		<p>
            	<input class="allow_custom_post_checkbox" type="checkbox" id="<?php echo $this->get_field_id( 'allow_custom_post' ); ?>" name="<?php echo $this->get_field_name('allow_custom_post'); ?>" <?php checked( $instance['allow_custom_post'] ); ?> />
                
				<label>
					<?php _e( 'Allow To Select Custom Posts', 'awesome-featured-post-widget' ); ?>
				</label>                
           </p>	          
           
		   <?php
		    $mfpw_custom_taxonomies =  get_mfpw_taxonomy_list( 'post' );
			if( $mfpw_custom_taxonomies ):	  //if_all_taxonomy_open
			?>
              <p>
                <label>
                    <?php echo _e('Select Post Category Type', 'awesome-featured-post-widget' );?>
                </label>   
                
               <select class="custom_taxonomy_select" id="<?php echo $this->get_field_id( 'custom_taxonomy' ); ?>" name="<?php echo $this->get_field_name( 'custom_taxonomy' ); ?>" onChange="fetchData(this.value,'<?php echo $this->get_field_id( 'custom_taxonomy' ); ?> ');" >

					<option style="padding-right:10px;" value="<?php echo $mfpw_cus_taxonomy->name; ?>" <?php selected( $instance['custom_taxonomy'], false ); ?> >
                        <?php _e( 'All Taxonomies', 'awesome-featured-post-widget' ); ?>               
					</option>
                    
                    <?php
                    $mfpw_custom_taxonomies = array_filter( $mfpw_custom_taxonomies, 'mfpw_exclude_taxonomies' );
                    foreach( $mfpw_custom_taxonomies as $mfpw_cus_taxonomy) { 	
                    ?>                           
                    <option style="padding-right:10px;" value="<?php echo $mfpw_cus_taxonomy->name; ?>" <?php selected( $mfpw_cus_taxonomy->name, $instance['custom_taxonomy'] ); ?> >
                        <?php echo esc_html( $mfpw_cus_taxonomy->label ); ?>
                    </option>
                    <?php } ?>
                    
				</select>
                <span id="tax-spinner" class="spinner"></span>                               
             </p>
           
		    <?php 
			endif; 	//if_all_taxonomy_close
			
			//for getting all taxonomy terms
			$terms_custom =  get_mfpw_terms_list( $instance['custom_taxonomy'] );	
			//check whether custom_taxonomy is category or not
			if ($instance['custom_taxonomy'] == 'category' ): 	//if_1 open	
			
			//It will create terms drop down list         
            if( $terms_custom ):	//if_2 open			 	
			?>         
             <p>
             <div class="mfpw-multiple-check-form">
                <label>
					<?php _e( 'Category List', 'awesome-featured-post-widget' ); ?>
				</label>
				<ul>
					<?php foreach ( mfpw_term_list( 'category' ) as $custom_category ) : ?>
						<li>
							<input type="checkbox" value="<?php echo (int) $custom_category->term_id; ?>" id="<?php echo $this->get_field_id( 'cat' ) . '-' . (int) $custom_category->term_id; ?>" name="<?php echo $this->get_field_name( 'cat' ); ?>[]" <?php checked( is_array( $instance['cat'] ) && in_array( $custom_category->term_id, $instance['cat'] ) ); ?> class="<?php echo "category" ?>" />
							
                            <label for="<?php echo $this->get_field_id( 'cat' ) . '-' . (int) $custom_category->term_id; ?>">
								<?php echo esc_html( $custom_category->name ); ?>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
                
                <?php
					$cat_array = $instance['cat'];
					if(!empty($cat_array))
					{
						$chek_cat = implode(",",$cat_array);
					}
				?>
                <ul>  
                    <li>
                   <input class="checkbox_enable" id="custom_checkall" type="checkbox" name="custom_checkall"/>
                    <label> <?php _e( 'Check all', 'awesome-featured-post-widget' ); ?> </label>
                	<br />
                    </li>                   
 				</ul>
                <ul>  
                  <li>
                  <input class="widefat" type="hidden" id="cat" value="<?php if(!empty($chek_cat)){ echo $chek_cat; }?>" >
                  &nbsp;&nbsp;&nbsp;
                  <input type="button" class="button button-primary" name="save" value="Show Posts" id="save"/>
                  </li>                   
 				</ul>
                <ul>
	                <div id="showcat" ></div>                  
                </ul>
             </div>  
             </p>           
            <?php			 
			endif; 	//if_2 close
			
			//check whether custom_taxonomy is tag or not	
			elseif ($instance['custom_taxonomy'] == 'post_tag' ):	//elseif_1 open		
			
			//It will create terms drop down list        
            if( $terms_custom ):	//if_3 open
			?>           
             <p>
             <div class="mfpw-multiple-check-form">
				<label>
					<?php _e( 'Post-Tag List', 'awesome-featured-post-widget' ); ?>
				</label>
				<ul>
					<?php foreach ( mfpw_term_list( 'post_tag' ) as $custom_post_tag ) : ?>
						<li>
							<input type="checkbox" value="<?php echo (int) $custom_post_tag->term_id; ?>" id="<?php echo $this->get_field_id( 'tag' ) . '-' . (int) $custom_post_tag->term_id; ?>" name="<?php echo $this->get_field_name( 'tag' ); ?>[]" <?php checked( is_array( $instance['tag'] ) && in_array( $custom_post_tag->term_id, $instance['tag'] ) ); ?> class="<?php echo "category" ?>"/>
							
                            <label for="<?php echo $this->get_field_id( 'tag' ) . '-' . (int) $custom_post_tag->term_id; ?>">
								<?php echo esc_html( $custom_post_tag->name ); ?>
							</label>
						</li>
					<?php endforeach; ?>
				</ul>
                
                <?php
					$tag_array = $instance['tag'];
					$chek_tag = implode(",",$tag_array);
				?>
                <ul>  
                    <li>
                   <input class="checkbox_enable" id="custom_tag_checkall" type="checkbox" name="custom_tag_checkall" />
                    <label> <?php _e( 'Check all', 'awesome-featured-post-widget' ); ?> </label>
                	<br />
                    </li>                   
 				</ul>               
			</div>     
            </p>           
            <?php 
			endif;	//if_3 close
			
			endif; 	//if_1 close			
			?>        
           		
        </div><!-- #tab-4-->
		<?php endif; //used only when post_type is post ?>
		 <div id="tab-5" class="mfpw-tab-content">
        <p>
        	<input id="<?php echo $this->get_field_id( 'post_in_slider' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'post_in_slider' ); ?>" <?php checked( $instance['post_in_slider'] ); ?> class="show_slider_checkbox" />
			<label for="<?php echo $this->get_field_id( 'post_in_slider' ); ?>">
				<?php _e( 'Show Posts In Slider', 'awesome-featured-post-widget' ); ?>
			</label>
            <hr />
            	<h3 align="center"><?php _e( 'Settings In Slider', 'awesome-featured-post-widget' ); ?></h3>
            <hr />
            
        </p>
        
        <p>
        	<label style="padding-right:5em;">
				<?php _e( 'AutoPlay', 'awesome-featured-post-widget' ); ?>
			</label>
        	<input id="<?php echo $this->get_field_id( 'autoplay' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'autoplay' ); ?>" <?php checked( $instance['autoplay'] ); ?> />            
        </p>
       
        <p>
        	<label style="padding-right:4.2em;">
				<?php _e( 'Pagination', 'awesome-featured-post-widget' ); ?>
			</label>
            <input id="<?php echo $this->get_field_id( 'paging' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'paging' ); ?>"  <?php checked( $instance['paging'] ); ?> />
        </p>
        
        <p>
        	<label style="padding-right:2.2em;">
				<?php _e( 'Stop On Hover', 'awesome-featured-post-widget' ); ?>
			</label>
            <input id="<?php echo $this->get_field_id( 'stop_hover' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'stop_hover' ); ?>"  <?php checked( $instance['stop_hover'] ); ?>  />
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id( 'time_interval' ); ?>">
              	<?php _e( 'Time Interval', 'awesome-featured-post-widget' ); ?>
            </label>
            <small><?php _e( '( in milliseconds )', 'awesome-featured-post-widget' ); ?></small>
			<input class="widefat" type="number" id="<?php echo $this->get_field_id('time_interval'); ?>" name="<?php echo $this->get_field_name('time_interval'); ?>" value="<?php echo (int)( $instance['time_interval'] ); ?>">                   
        </p>
        
        <p>
        	<label for="<?php echo $this->get_field_id( 'slide_speed' ); ?>">
              	<?php _e( 'Sliding Speed', 'awesome-featured-post-widget' ); ?>
            </label>
            <small><?php _e( '( in milliseconds )', 'awesome-featured-post-widget' ); ?></small>
			<input class="widefat" type="number" id="<?php echo $this->get_field_id('slide_speed'); ?>" name="<?php echo $this->get_field_name('slide_speed'); ?>" value="<?php echo (int)( $instance['slide_speed'] ); ?>">                   
        </p>
        </div><!-- #tab-5-->

		<div id="tab-6" class="mfpw-tab-content">

			<p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['excerpt'] ); ?> id="<?php echo $this->get_field_id( 'excerpt' ); ?>" name="<?php echo $this->get_field_name( 'excerpt' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'excerpt' ); ?>">
					<?php _e( 'Display excerpt in words', 'awesome-featured-post-widget' ); ?>
				</label>
           </p>
           
           <p>
				<input class="checkbox" type="checkbox" <?php checked( $instance['date'] ); ?> id="<?php echo $this->get_field_id( 'date' ); ?>" name="<?php echo $this->get_field_name( 'date' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'date' ); ?>">
					<?php _e( 'Display Date', 'awesome-featured-post-widget' ); ?>
				</label>
            </p>
            
            <p>
				<input id="<?php echo $this->get_field_id( 'date_modified' ); ?>" name="<?php echo $this->get_field_name( 'date_modified' ); ?>" type="checkbox" <?php checked( $instance['date_modified'] ); ?> />
				<label for="<?php echo $this->get_field_id( 'date_modified' ); ?>">
					<?php _e( 'Display Modified Date', 'awesome-featured-post-widget' ); ?>
				</label>
			</p>
            
            <p>
				<input id="<?php echo $this->get_field_id( 'date_relative' ); ?>" name="<?php echo $this->get_field_name( 'date_relative' ); ?>" type="checkbox" <?php checked( $instance['date_relative'] ); ?> class="date_relative_checkbox" />
				<label for="<?php echo $this->get_field_id( 'date_relative' ); ?>">
					<?php _e( 'Use Relative Date. eg: 5 days ago', 'awesome-featured-post-widget' ); ?>
				</label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_id( 'excerpt_length' ); ?>">
					<?php _e( 'Excerpt Length in words', 'awesome-featured-post-widget' ); ?>
				</label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'excerpt_length' ); ?>" name="<?php echo $this->get_field_name( 'excerpt_length' ); ?>" type="number" step="1" min="0" value="<?php echo (int)( $instance['excerpt_length'] ); ?>" />
			</p>

     		<p>
				<label for="<?php echo $this->get_field_id( 'more_text' ); ?>">
                	<?php _e( 'More Text:', 'awesome-featured-post-widget' ); ?>
                </label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('more_text'); ?>" name="<?php echo $this->get_field_name('more_text'); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>">
			</p>
           
        </div><!-- #tab-6 -->

				<div id="tab-7" class="mfpw-tab-content">

			<?php if ( current_theme_supports( 'post-thumbnails' ) ) : ?>

				<p>
					<input class="checkbox" type="checkbox" <?php checked( $instance['thumbnail'], 1 ); ?> id="<?php echo $this->get_field_id( 'thumbnail' ); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>"/>
					<label for="<?php echo $this->get_field_id( 'thumbnail' ); ?>">
						<?php _e( 'Show Featured Image', 'awesome-featured-post-widget' ); ?>
					</label>
               </p>
		               
			   <p>
               		<small style="color:#F00; font-size:11px; font-weight:bold""><?php _e( 'Can be used only when you are not using "Slider Options"', 'awesome-featured-post-widget' ); ?></small><br />
					<label for="<?php echo $this->get_field_id( 'thumbnail_size' ); ?>" >
						<?php _e( 'Thumbnail / Featured Image Size ', 'awesome-featured-post-widget' ); ?>
					</label>
					<select class="given_thumbnail_size_select" id="<?php echo $this->get_field_id( 'thumbnail_size' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail_size' ); ?>" style="width:100%;">
						<?php foreach ( get_intermediate_image_sizes() as $size ) { ?>
							<option value="<?php echo esc_attr( $size ); ?>" <?php selected( $instance['thumbnail_size'], $size ); ?>><?php echo esc_html( $size ); ?></option>
						<?php }	?>
					</select>				
				</p>

				<p>
					<input class="custom_thumbnail_checkbox" type="checkbox" <?php checked( $instance['thumbnail_custom'], 1 ); ?> id="<?php echo $this->get_field_id( 'thumbnail_custom' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail_custom' ); ?>" />
					<label for="<?php echo $this->get_field_id( 'thumbnail_custom' ); ?>">
						<?php _e( 'Give Thumbnail Sizes For Slider', 'awesome-featured-post-widget' ); ?>
					</label>
                    <br />
                    <small style="color:#F00; font-size:11px; font-weight:bold"><?php _e( 'Ideal image size - 200px x 200px', 'awesome-featured-post-widget' ); ?></small>
                    <br />
                    <small style="color:#F00; font-size:11px; font-weight:bold""><?php _e( 'Height & Width should not be less than actual image size ', 'awesome-featured-post-widget' ); ?></small>
                </p>
                
                <p>                 				
					<label for="<?php echo $this->get_field_id( 'thumbnail_width' ); ?>">
						<?php _e( 'Customize Width For Thumbnail', 'awesome-featured-post-widget' ); ?>
					</label>                    
					<input class="customize_thumbnail_width" id="<?php echo $this->get_field_id( 'thumbnail_width' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail_width' ); ?>" type="number" step="1" min="200" value="<?php echo (int)( $instance['thumbnail_width'] ); ?>" />
                    
                    <br /><br />
                    
                    <label for="<?php echo $this->get_field_id( 'thumbnail_width' ); ?>">
						<?php _e( 'Customize Height For Thumbnail', 'awesome-featured-post-widget' ); ?>
					</label>
					<input class="customize_thumbnail_height" id="<?php echo $this->get_field_id( 'thumbnail_height' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail_height' ); ?>" type="number" step="1" min="200" value="<?php echo (int)( $instance['thumbnail_height'] ); ?>" />
                    
				</p>
            
				<p>
					<label for="<?php echo $this->get_field_id( 'thumbnail_align' ); ?>">
						<?php _e( 'Thumbnail / Featured Image Alignment', 'awesome-featured-post-widget' ); ?>
					</label>
					<select class="widefat" id="<?php echo $this->get_field_id( 'thumbnail_align' ); ?>" name="<?php echo $this->get_field_name( 'thumbnail_align' ); ?>" style="width:100%;">
                    	<option value="left" <?php selected( $instance['thumbnail_align'], 'left' ); ?>><?php _e( 'Left', 'awesome-featured-post-widget' ) ?></option>
						<option value="right" <?php selected( $instance['thumbnail_align'], 'right' ); ?>><?php _e( 'Right', 'awesome-featured-post-widget' ) ?></option>
						<option value="center" <?php selected( $instance['thumbnail_align'], 'center' ); ?>><?php _e( 'Center', 'awesome-featured-post-widget' ) ?></option>
					</select>
				</p>

			<?php else : ?>
				<p><?php __('Post Thumbnail Feature is not supported by your current theme. Please check your theme details', 'awesome-featured-post-widget'); ?></p>
			<?php endif; ?>
		</div><!-- #tab-7 -->

		<div id="tab-8" class="mfpw-tab-content">
       	<p>
				<label>
					<?php _e( 'Where to show', 'awesome-featured-post-widget' ); ?>
				</label>
                <fieldset>
            <legend> 
            	<?php _e( 'Checks, where you want to show your widget or on which page. By default, it will be showing on the homepage and the front page', 'awesome-featured-post-widget' ); ?>      
            </legend>
          
          <fieldset>
          <p>
                <input id="<?php echo $this->get_field_id( 'homepage' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'homepage' ); ?>" class="showPost" <?php checked( $instance['homepage'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'homepage' ); ?>">
                	<?php _e( 'Home Page', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'frontpage' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'frontpage' ); ?>" class="showPost" <?php checked( $instance['frontpage'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'frontpage' ); ?>">
                	<?php _e( 'Front Page (e.g. a static page as homepage)', 'awesome-featured-post-widget' ); ?> 
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'page' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'page' ); ?>" class="showPost"  <?php checked( $instance['page'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'page' ); ?>">
                	<?php _e( '"Page" pages', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'category' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'category' ); ?>" class="showPost" <?php checked( $instance['category'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'category' ); ?>">
                	<?php _e( 'Category Page', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'single' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'single' ); ?>" class="showPost"  <?php checked( $instance['single'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'single' ); ?>">
                	<?php _e( 'Single post pages', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'archivedate' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'archivedate' ); ?>" class="showPost" <?php checked( $instance['archivedate'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'archivedate' ); ?>">
                	<?php _e( 'Archive pages', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'archive' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'archive' ); ?>" class="showPost"  <?php checked( $instance['archive'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'archive' ); ?>">
                	<?php _e( 'Post Type Archives', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'tag1' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'tag1' ); ?>" class="showPost"  <?php checked( $instance['tag1'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'tag1' ); ?>">
                	<?php _e( 'Tag pages', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'attachment' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'attachment' ); ?>" class="showPost"  <?php checked( $instance['attachment'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'attachment' ); ?>">
                	<?php _e( 'Attachments', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'taxonomy1' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'taxonomy1' ); ?>" class="showPost"  <?php checked( $instance['taxonomy1'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'taxonomy1' ); ?>">
                	<?php _e( 'Custom Taxonomy pages', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'author' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'author' ); ?>" class="showPost"   <?php checked( $instance['author'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'author' ); ?>">
                	<?php _e( 'Author pages', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'search' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'search' ); ?>" class="showPost"   <?php checked( $instance['search'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'search' ); ?>">
                	<?php _e( 'Search Results', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'not_found' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'not_found' ); ?>" class="showPost"  <?php checked( $instance['not_found'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'not_found' ); ?>">
                	<?php _e( 'Not Found', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
                
                <input id="<?php echo $this->get_field_id( 'login_page' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'login_page' ); ?>" class="showPost"   <?php checked( $instance['login_page'] ); ?> />
                <label for="<?php echo $this->get_field_id( 'login_page' ); ?>">
                	<?php _e( 'Login Page', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
          </p>
                
                <input id="<?php echo $this->get_field_id( 'checkall' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'checkall' ); ?>" class="checkall"   <?php checked( $instance['checkall'] ); ?> />
                <label>
                	<?php _e( 'Check all', 'awesome-featured-post-widget' ); ?>
                </label>
                <br>
            </p>    
            </fieldset>          
        
        </div><!-- #tab-8-->       
        
       <div id="tab-9" class="mfpw-tab-content">
       		<p>
				<hr />
                    <h3 align="center"><?php _e( 'Add Custom CSS', 'awesome-featured-post-widget' ); ?></h3>
                <hr />
                <br />
				<textarea class="widefat" id="<?php echo $this->get_field_id( 'css' ); ?>" name="<?php echo $this->get_field_name( 'css' ); ?>" style="height:300px;"><?php echo $instance['css']; ?></textarea>
			</p>

		</div><!-- #tab-9 -->
        
	</div><!-- .mfpw-tabs-content -->

</div>

