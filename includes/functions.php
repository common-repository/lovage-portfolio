<?php
/**
 * The plugin functions.
 * All functions are pluggable, so you can copy it to your functions.php and make changes.
 * @version 1.0.0
 * @package Lovage Portfolio
 */

/**
 * Show the portfolio media
 */
if( ! function_exists( 'lovage_portfolio_media' ) ) {
	function lovage_portfolio_media(){

		global $post;

		$media_type = apply_filters( 'lovage_portfolio_media_type', 'image' );
	    $media_images = json_decode( get_post_meta( $post->ID, '_lovage_portfolio_images', true ), TRUE );
	  
	    switch( $media_type ) {
		  
	  	  case 'image':

	  	    if( isset( $media_images ) ){
				foreach ( $media_images as $image ) {
					echo '<div class="media-item"><img src="'.esc_url( $image['url'] ).'" class="lovage-portfolio-image lovage-portfolio-' . esc_attr( $post->ID ) . '-image-' . esc_attr( $image['id'] ) . '" alt="' . esc_html( $image['alt'] ) . '" /></div>';
				}
			}
			break;

		  case 'audio':
		    do_action( 'lovage_portfolio_show_audio' );
		    break;

		  case 'video':
		    do_action( 'lovage_portfolio_show_video' );
		    break;

	    }
	}
}
add_action( 'lovage_portfolio_media', 'lovage_portfolio_media' );


/**
 * Show the portfolio information
 */
if( ! function_exists( 'lovage_portfolio_info' ) ) {
	function lovage_portfolio_info(){

		global $post;

		$info = array(
	  	  esc_html__( 'Client Name', 'lovage-portfolio' ) => get_post_meta( $post->ID, '_lovage_portfolio_client_name', true ),
	  	  esc_html__( 'Project URL', 'lovage-portfolio' ) => get_post_meta( $post->ID, '_lovage_portfolio_project_url', true ),
	  	  esc_html__( 'Skills Needed', 'lovage-portfolio' ) => get_post_meta( $post->ID, '_lovage_portfolio_skills_needed', true ),
	  	  esc_html__( 'Finish Date', 'lovage-portfolio' ) => get_post_meta( $post->ID, '_lovage_portfolio_finish_date', true )
	    );

		foreach( $info as $key => $val ){
			if( strpos( $val, 'http://' ) === 0 || strpos( $val, 'https://' ) === 0 ){
			  echo '<li><strong>' . esc_html( $key ) . ':</strong> <a href="' .esc_url( $val ). '" target="_blank">' . esc_url( $val ) . '</a></li>';
			}else{
			  echo '<li><strong>' . esc_html( $key ) . ':</strong> ' . esc_html( $val ) . '</li>';
			}
	    }
	}
}
add_action( 'lovage_portfolio_info', 'lovage_portfolio_info' );

/**
 * The portfolio grid items makeup.
 */
if( ! function_exists( 'lovage_portfolio_grid_item' ) ){
	function lovage_portfolio_grid_item(){
	?>
		<div class="portfolio-item <?php echo apply_filters( 'lovage_portfolio_item_extra_class', '' );?>">

			<div class="portfolio-thumbnail">
			  
			  <?php 
			  /**
			   * Hook for adding new elements before the thumbnail
			   * Usage: add_action( 'lovage_portfolio_item_before_thumbnail', 'YOUR FUNCTION' )
			   */
			  do_action( 'lovage_portfolio_item_before_thumbnail' );
			  ?>

			  <a href="<?php the_permalink();?>" title="<?php the_title();?>" class="portfolio-overlay"></a>

			  <?php the_post_thumbnail( 'lovage-portfolio-3-columns' ); ?>
			</div>

			<?php 
			/**
		     * Hook for adding new elements before the title
		     * Usage: add_action( 'lovage_portfolio_item_before_title', 'YOUR FUNCTION' )
		     */
			do_action( 'lovage_portfolio_item_before_title' );
			?>

			<h4 class="title"><a href="<?php the_permalink();?>" title="<?php the_title();?>"><?php the_title();?></a></h4>

			<?php 
			/**
		     * Hook for adding new elements after the title
		     * Usage: add_action( 'lovage_portfolio_item_after_title', 'YOUR FUNCTION' )
		     */
			do_action( 'lovage_portfolio_item_after_title' );
			?>
		</div>
	<?php
	}
}
add_action( 'lovage_portfolio_grid_items', 'lovage_portfolio_grid_item' );

/**
 * Show the portfolio post navigation
 */
if( ! function_exists( 'lovage_portfolio_post_navi' ) ) {
	function lovage_portfolio_post_navi(){
		the_posts_pagination(
			array(
				'mid_size'  => 2,
				'prev_text' => sprintf(
					'%s <span class="nav-prev-text">%s</span>',
					'&larr;',
					__( 'Newer posts', 'twentynineteen' )
				),
				'next_text' => sprintf(
					'<span class="nav-next-text">%s</span> %s',
					__( 'Older posts', 'twentynineteen' ),
					'&rarr;'
				),
			)
	   );
	}
}

/**
 * Register Shortcode
 */
if( ! function_exists('lovage_portfolio_grid_shortcode') ) {
	function lovage_portfolio_grid_shortcode($atts){
	   
	    extract( shortcode_atts( array(
	      'number'		   => 9,
	      'orderby'        => 'date',
	      'order'          => 'desc',
	      'pagination'	   => 0
	    ), $atts ) );

	        
	    static $loop;
		
		if( !isset( $loop ) ) {
		   $loop = 1;
		}else{ 
		   $loop ++;
		}

		$paging = 'paged-' . $loop;
		$paged = isset( $_GET[$paging] ) ? esc_attr( $_GET[$paging] ) : 1;
		$pagination_base = add_query_arg( $paging, '%#%' );

	    $params = array(
	      'posts_per_page' => esc_attr( $number ), 
	      'post_type' => 'lovage-portfolio',
	      'orderby'  => 'date',
	      'order' => 'desc',
	      'paged'   => esc_attr( $paged ),
	      'pagination' => esc_attr( $pagination )
	    );

	    $portfolio_query = new WP_Query( $params ); 
	    
	    ob_start();

	    do_action( 'lovage_portfolio_before_container' );
	    ?>

	    <div class="lovage-portfolio-shortcode lovage-portfolio-grid columns-3 <?php echo apply_filters( 'lovage_portfolio_grid_extra_class', '' );?>">
	    
	    <?php if ( $portfolio_query->have_posts() ) : ?>

			<?php
				while ( $portfolio_query->have_posts() ) : 
				
					$portfolio_query->the_post(); 
					
					/**
					 * Hooked Function: lovage_portfolio_grid_item
					 * @see includes/functions.php
					 */
					do_action( 'lovage_portfolio_grid_items' );
				
				endwhile;
				wp_reset_postdata(); 
			    
			    if( $pagination ):
  			?>
  				<div class="lovage-portfolio-pagenavi">
				   <?php 
					   echo paginate_links( array(
					      'type'      => '',
					      'base'      => $pagination_base,
					      'format'    => '?'. $paging .'=%#%',
					      'current'   => max( 1, $portfolio_query->get('paged') ),
					      'total'     => $portfolio_query->max_num_pages
					   ) ); 
				   ?>
			    </div>
  			<?php
				endif;
		    ?>

	    <?php else: ?>

	    	<p><?php esc_html_e( 'No project found.', 'lovage-portfolio' ); ?></p>

	    <?php endif;?>

		</div>
	<?php
	   do_action( 'lovage_portfolio_after_container' );
	   return ob_get_clean();
	}
}
add_shortcode( 'lovage_portfolio', 'lovage_portfolio_grid_shortcode' );